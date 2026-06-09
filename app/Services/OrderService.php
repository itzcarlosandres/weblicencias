<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\License;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderService
{
    protected CartService $cartService;
    protected PointsService $pointsService;

    public function __construct(CartService $cartService, PointsService $pointsService)
    {
        $this->cartService = $cartService;
        $this->pointsService = $pointsService;
    }

    public function createOrder(\App\Models\User $user, array $paymentData = []): Order
    {
        return DB::transaction(function () use ($user, $paymentData) {
            $cart = $this->cartService->getCart();
            $subtotal = $this->cartService->getSubtotal();
            $discount = $this->cartService->getDiscount();
            $tax = $this->cartService->getTax();
            $total = $this->cartService->getTotal();

            $order = Order::create([
                'user_id' => $user->id,
                'coupon_id' => Session::get('coupon_id'),
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => $discount,
                'total' => $total,
                'payment_method' => $paymentData['method'] ?? 'paypal',
                'payment_id' => $paymentData['id'] ?? null,
                'payment_status' => $paymentData['status'] ?? 'pending',
                'status' => 'pending',
            ]);

            foreach ($cart as $item) {
                $product = Product::find($item['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_slug' => $product->slug,
                    'product_image' => $product->image,
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);
            }

            // Update coupon usage
            if ($couponId = Session::get('coupon_id')) {
                Coupon::where('id', $couponId)->increment('used_count');
            }

            return $order;
        });
    }

    public function deliverOrder(Order $order): void
    {
        foreach ($order->items as $item) {
            if (!$item->license_id) {
                $license = License::where('product_id', $item->product_id)
                    ->where('status', 'available')
                    ->first();

                if ($license) {
                    $license->markAsSold($order, $order->user);

                    $item->update(['license_id' => $license->id]);

                    $product = Product::find($item->product_id);
                    $product->decrement('stock', $item->quantity);
                    $product->increment('sold_count', $item->quantity);
                }
            }
        }

        $order->update(['status' => 'delivered']);

        // Award points for the order
        if ($this->pointsService->isEnabled()) {
            $points = $this->pointsService->calculatePointsForOrder($order->total);
            if ($points > 0) {
                $this->pointsService->awardPoints(
                    $order->user,
                    $points,
                    "Puntos por pedido #{$order->order_number}",
                    $order
                );
            }

            // Award points to referrer on first purchase
            if ($order->user->referred_by) {
                $isFirstOrder = Order::where('user_id', $order->user->id)
                    ->whereIn('status', ['paid', 'delivered'])
                    ->count() <= 1; // Since current order is just marked delivered

                if ($isFirstOrder) {
                    $referrer = $order->user->referrer;
                    if ($referrer) {
                        $rewardPoints = (int)\App\Models\Setting::get('referral_reward_points', '1000');
                        
                        if ($rewardPoints > 0) {
                            $this->pointsService->awardPoints(
                                $referrer,
                                $rewardPoints,
                                "Bono por primera compra de tu referido {$order->user->name}"
                            );
                            
                            \Illuminate\Support\Facades\Mail::to($referrer->email)->queue(new \App\Mail\ReferralRewardMail($referrer, $order->user, $rewardPoints));
                        }
                    }
                }
            }
        }
    }

    public function getOrderWithDetails(int $orderId): Order
    {
        return Order::with(['items.product', 'items.license', 'user', 'coupon'])
            ->findOrFail($orderId);
    }
}
