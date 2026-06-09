<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\License;
use App\Models\Ticket;
use App\Services\PointsService;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard()
    {
        $user = auth()->user();
        $pointsService = app(PointsService::class);

        $stats = [
            'total_orders' => $user->orders()->count(),
            'total_licenses' => $user->licenses()->count(),
            'pending_orders' => $user->orders()->where('status', 'pending')->count(),
            'open_tickets' => $user->tickets()->where('status', 'open')->count(),
            'points' => $user->points ?? 0,
            'points_value' => $pointsService->calculateDiscountForPoints($user->points ?? 0),
        ];

        $recentOrders = $user->orders()
            ->with('items.product')
            ->latest()
            ->limit(5)
            ->get();

        $recentPoints = $pointsService->getTransactionHistory($user, 5);

        return view('pages.customer.dashboard', compact('stats', 'recentOrders', 'recentPoints'));
    }

    public function orders()
    {
        $orders = auth()->user()->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('pages.customer.orders', compact('orders'));
    }

    public function ordersShow(Order $order)
    {
        abort_unless($order->user_id === auth()->id(), 403);

        $order->load(['items.product', 'items.license', 'coupon']);

        return view('pages.customer.order-show', compact('order'));
    }

    public function licenses()
    {
        $licenses = auth()->user()->licenses()
            ->with('product')
            ->latest('sold_at')
            ->paginate(20);

        return view('pages.customer.licenses', compact('licenses'));
    }

    public function revealLicense(License $license)
    {
        abort_unless($license->buyer_id === auth()->id(), 403);

        if (!$license->is_revealed) {
            $license->update(['revealed_at' => now()]);
        }

        return response()->json([
            'success' => true,
            'key' => $license->key,
            'revealed_at' => $license->revealed_at->format('d/m/Y H:i:s')
        ]);
    }

    public function tickets()
    {
        $tickets = auth()->user()->tickets()
            ->latest()
            ->paginate(10);

        return view('pages.customer.tickets', compact('tickets'));
    }

    public function ticketsStore(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'order_id' => 'nullable|exists:orders,id',
        ]);

        $ticket = auth()->user()->tickets()->create([
            'subject' => $validated['subject'],
            'order_id' => $validated['order_id'] ?? null,
        ]);

        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        return redirect()->route('customer.tickets.show', $ticket)
            ->with('success', 'Ticket creado correctamente');
    }

    public function ticketsShow(Ticket $ticket)
    {
        abort_unless($ticket->user_id === auth()->id(), 403);

        $ticket->load('messages.user');

        return view('pages.customer.ticket-show', compact('ticket'));
    }

    public function ticketsReply(Request $request, Ticket $ticket)
    {
        abort_unless($ticket->user_id === auth()->id(), 403);

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        return back()->with('success', 'Respuesta enviada');
    }

    public function points()
    {
        $user = auth()->user();
        $pointsService = app(PointsService::class);

        $totalPoints = $user->points ?? 0;
        $pointsValue = $pointsService->calculateDiscountForPoints($totalPoints);
        $transactions = $pointsService->getTransactionHistory($user, 50);

        return view('pages.customer.points', compact('totalPoints', 'pointsValue', 'transactions'));
    }

    public function wishlist()
    {
        $wishlists = auth()->user()->wishlists()
            ->with('product.brand', 'product.badge')
            ->latest()
            ->paginate(12);

        return view('pages.customer.wishlist', compact('wishlists'));
    }
}
