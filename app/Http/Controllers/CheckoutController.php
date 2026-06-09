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

        return view('pages.checkout', compact(
            'cart', 'subtotal', 'discount', 'tax', 'total', 'couponCode',
            'userPoints', 'pointsEnabled', 'maxRedeemable', 'pointsDiscount',
            'paypalEnabled', 'mercadopagoEnabled', 'wompiEnabled'
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
        ]);

        // Handle points redemption
        if ($this->pointsService->isEnabled() && $request->input('redeem_points')) {
            $pointsToRedeem = min(
                (int) $request->input('redeem_points', 0),
                $this->pointsService->getMaxRedeemablePoints(auth()->user(), $order->total)
            );

            if ($pointsToRedeem > 0) {
                $this->pointsService->redeemPoints(
                    auth()->user(),
                    $pointsToRedeem,
                    "Canje de {$pointsToRedeem} puntos en pedido #{$order->order_number}",
                    $order
                );

                $discountAmount = $this->pointsService->calculateDiscountForPoints($pointsToRedeem);
                $order->update([
                    'discount' => $order->discount + $discountAmount,
                    'total' => max(0, $order->total - $discountAmount),
                ]);
            }
        }

        $paymentMethod = $request->input('payment_method', 'paypal');

        // Si el total es 0 (por puntos o cupones), el pedido ya está pagado independientemente del método seleccionado
        if ($order->total <= 0) {
            $order->update([
                'method' => 'points', 
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

        $order->update(['method' => $paymentMethod]);

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

        $discountAmount = $this->pointsService->calculateDiscountForPoints($pointsToRedeem);

        return response()->json([
            'points' => $pointsToRedeem,
            'discount' => currency_format($discountAmount),
            'new_total' => currency_format(max(0, $total - $discountAmount)),
        ]);
    }
}
