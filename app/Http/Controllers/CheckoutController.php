<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use App\Services\CartService;
use App\Services\PointsService;
use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected OrderService $orderService;
    protected CartService $cartService;
    protected PointsService $pointsService;

    public function __construct(OrderService $orderService, CartService $cartService, PointsService $pointsService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
        $this->pointsService = $pointsService;
    }

    public function index()
    {
        $cart = $this->cartService->getCart();

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $subtotal = $this->cartService->getSubtotal();
        $discount = $this->cartService->getDiscount();
        $tax = $this->cartService->getTax();
        $total = $this->cartService->getTotal();
        $couponCode = $this->cartService->getCouponCode();

        $user = auth()->user();
        $userPoints = $user->points ?? 0;
        $pointsEnabled = $this->pointsService->isEnabled();
        $maxRedeemable = $this->pointsService->getMaxRedeemablePoints($user, $total);
        $pointsDiscount = 0;

        $paypalEnabled = \App\Models\Setting::get('payment_paypal_enabled', '1') == '1';
        $mercadopagoEnabled = \App\Models\Setting::get('payment_mercadopago_enabled', '0') == '1';
        $wompiEnabled = \App\Models\Setting::get('payment_wompi_enabled', '0') == '1';

        $cartProductIds = collect($cart)->pluck('product_id')->toArray();
        $upsellProducts = \App\Models\Product::whereNotIn('id', $cartProductIds)
            ->where('stock', '>', 0)
            ->where('price', '<=', 50) // Suggest low-cost items if possible, or just random
            ->inRandomOrder()
            ->take(3)
            ->get();
            
        if ($upsellProducts->isEmpty()) {
            $upsellProducts = \App\Models\Product::whereNotIn('id', $cartProductIds)
                ->where('stock', '>', 0)
                ->inRandomOrder()
                ->take(3)
                ->get();
        }

        return view('pages.checkout', compact(
            'cart', 'subtotal', 'discount', 'tax', 'total', 'couponCode',
            'userPoints', 'pointsEnabled', 'maxRedeemable', 'pointsDiscount',
            'paypalEnabled', 'mercadopagoEnabled', 'wompiEnabled', 'upsellProducts'
        ));
    }

    public function process(Request $request)
    {
        $cart = $this->cartService->getCart();

        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $order = $this->orderService->createOrder(auth()->user(), [
            'method' => 'paypal',
            'status' => 'pending',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        $paymentMethod = $request->input('payment_method', 'paypal');

        // Handle points redemption
        $pointsToRedeemInput = (int) $request->input('redeem_points', 0);
        
        // Si el usuario seleccionó pagar 100% con puntos, forzamos el canje total necesario
        if ($paymentMethod === 'points') {
            $redemptionRate = $this->pointsService->getRedemptionRate();
            $discountPerRedemption = $this->pointsService->getDiscountPerRedemption();
            // Calculate how many points are needed to cover 100% of the total
            $pointsNeeded = ceil($order->total / $discountPerRedemption) * $redemptionRate;
            
            if (auth()->user()->points >= $pointsNeeded) {
                $pointsToRedeemInput = $pointsNeeded;
            } else {
                return back()->with('error', 'No tienes suficientes TodoPuntos para pagar esta orden.');
            }
        }

        if ($this->pointsService->isEnabled() && $pointsToRedeemInput > 0) {
            if ($paymentMethod === 'points') {
                $pointsToRedeem = $pointsToRedeemInput; // Bypass limits for 100% payment
            } else {
                $pointsToRedeem = min(
                    $pointsToRedeemInput,
                    $this->pointsService->getMaxRedeemablePoints(auth()->user(), $order->total)
                );
            }

            // Ajustar a múltiplos de la tasa de canje
            $redemptionRate = $this->pointsService->getRedemptionRate();
            $usablePoints = floor($pointsToRedeem / $redemptionRate) * $redemptionRate;

            if ($usablePoints > 0) {
                $this->pointsService->redeemPoints(
                    auth()->user(),
                    $usablePoints,
                    "Canje de {$usablePoints} puntos en pedido #{$order->order_number}",
                    $order
                );

                $discountAmount = $this->pointsService->calculateDiscountForPoints($usablePoints);
                $order->update([
                    'discount' => $order->discount + $discountAmount,
                    'total' => max(0, $order->total - $discountAmount),
                ]);
            }
        }

        // Si el total es 0 (por puntos o cupones), el pedido ya está pagado independientemente del método seleccionado
        if ($order->total <= 0) {
            $order->update([
                'payment_method' => 'points', 
                'status' => 'paid', 
                'payment_status' => 'completed',
                'payment_id' => 'POINTS_' . time()
            ]);
            
            // Auto-deliver (entregar licencias inmediatamente)
            $deliveryService = app(\App\Services\DeliveryService::class);
            $deliveryService->processOrder($order);

            $this->cartService->clear();
            return redirect()->route('customer.orders.show', $order->id)->with('success', 'Pedido pagado exitosamente con TodoPuntos');
        }

        if ($paymentMethod === 'wallet') {
            if (auth()->user()->wallet_balance >= $order->total) {
                auth()->user()->wallet_balance -= $order->total;
                auth()->user()->save();

                \App\Models\WalletTransaction::create([
                    'user_id' => auth()->id(),
                    'type' => 'purchase',
                    'amount' => -$order->total,
                    'description' => "Pago de pedido #{$order->order_number}",
                    'reference_id' => $order->id,
                ]);

                $order->update([
                    'payment_method' => 'wallet', 
                    'status' => 'paid', 
                    'payment_status' => 'completed',
                    'payment_id' => 'WALLET_' . time()
                ]);
                
                $deliveryService = app(\App\Services\DeliveryService::class);
                $deliveryService->processOrder($order);

                $this->cartService->clear();
                return redirect()->route('customer.orders.show', $order->id)->with('success', 'Pedido pagado exitosamente con Monedero');
            } else {
                return back()->with('error', 'No tienes suficiente saldo en tu monedero.');
            }
        }

        $order->update(['payment_method' => $paymentMethod]);

        if ($paymentMethod === 'mercadopago') {
            return redirect()->route('checkout.mercadopago', ['order' => $order->id]);
        }

        if ($paymentMethod === 'wompi') {
            return redirect()->route('checkout.wompi', ['order' => $order->id]);
        }

        return redirect()->route('checkout.paypal', ['order' => $order->id]);
    }

    public function applyPoints(Request $request)
    {
        $request->validate([
            'points' => 'required|integer|min:0',
        ]);

        $user = auth()->user();
        $cart = $this->cartService->getCart();
        $total = $this->cartService->getTotal();

        $pointsToRedeem = min(
            (int) $request->input('points', 0),
            $this->pointsService->getMaxRedeemablePoints($user, $total)
        );

        // Ajustar a múltiplos de la tasa de canje
        $redemptionRate = $this->pointsService->getRedemptionRate();
        $usablePoints = floor($pointsToRedeem / $redemptionRate) * $redemptionRate;

        $discountAmount = $this->pointsService->calculateDiscountForPoints($usablePoints);

        return response()->json([
            'success' => true,
            'discount' => number_format($discountAmount, 2),
            'new_total' => currency_format($total - $discountAmount)
        ]);
    }
}
