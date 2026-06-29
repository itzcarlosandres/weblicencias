<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'items.license', 'coupon']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,paid,delivered,cancelled,refunded',
        ]);

        $order->update(['status' => $request->status]);

        if (in_array($request->status, ['paid', 'delivered'])) {
            $deliveryService = app(\App\Services\DeliveryService::class);
            $deliveryService->processOrder($order);
        }

        return back()->with('success', 'Estado actualizado correctamente');
    }

    public function removeItem(Request $request, Order $order, $itemId)
    {
        $item = $order->items()->findOrFail($itemId);

        // Calculate amount to deduct from order total
        $amountToDeduct = $item->price * $item->quantity;

        // If this item was linked to a license, release it back to inventory
        if ($item->license_id) {
            $license = \App\Models\License::find($item->license_id);
            if ($license) {
                $license->update([
                    'buyer_id' => null,
                    'order_id' => null,
                    'sold_at' => null,
                    'status' => 'available'
                ]);
            }
        }

        // Delete the item
        $item->delete();

        // Update order total
        $order->update([
            'total' => max(0, $order->total - $amountToDeduct)
        ]);

        return back()->with('success', 'Producto removido de la orden correctamente y el total ha sido recalculado.');
    }

    public function destroy(Order $order)
    {
        // Opcionalmente: liberar licencias asociadas
        foreach ($order->items as $item) {
            if ($item->license_id) {
                $license = \App\Models\License::find($item->license_id);
                if ($license) {
                    $license->update([
                        'buyer_id' => null,
                        'order_id' => null,
                        'sold_at' => null,
                        'status' => 'available'
                    ]);
                }
            }
        }

        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Orden eliminada correctamente.');
    }

    public function sendReminder(Order $order)
    {
        if ($order->status !== 'pending') {
            return back()->with('error', 'Solo se pueden enviar recordatorios a órdenes pendientes.');
        }

        \Illuminate\Support\Facades\Mail::to($order->user->email)->send(new \App\Mail\PendingOrderReminder($order));

        return back()->with('success', 'Recordatorio enviado correctamente al cliente.');
    }
}
