<?php

namespace App\Services;

use App\Models\Order;

class DeliveryService
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function processOrder(Order $order): bool
    {
        try {
            // 1. Mark as processing
            $order->update(['status' => 'processing']);

            // 2. Assign licenses
            $this->orderService->deliverOrder($order);

            // 3. Send delivery email
            \Illuminate\Support\Facades\Mail::to($order->user->email)
                ->send(new \App\Mail\OrderDelivered($order));

            // 4. Log activity
            \App\Models\ActivityLog::log('order_delivered', $order, [
                'order_number' => $order->order_number,
                'total' => $order->total,
            ]);

            // 5. Award Cashback
            if ($order->total > 0 && $order->payment_method !== 'wallet' && $order->payment_method !== 'points') {
                $cashbackPercentage = (float) \App\Models\Setting::get('cashback_percentage', '3');
                
                if ($cashbackPercentage > 0) {
                    $cashback = $order->total * ($cashbackPercentage / 100);
                    $order->user->wallet_balance += $cashback;
                    $order->user->save();

                    \App\Models\WalletTransaction::create([
                        'user_id' => $order->user_id,
                        'type' => 'cashback',
                        'amount' => $cashback,
                        'description' => "Cashback ({$cashbackPercentage}%) por compra #{$order->order_number}",
                        'reference_id' => $order->id,
                    ]);
                }
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Delivery failed for order: ' . $order->order_number, [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
