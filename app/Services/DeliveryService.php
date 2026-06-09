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

            return true;
        } catch (\Exception $e) {
            \Log::error('Delivery failed for order: ' . $order->order_number, [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
