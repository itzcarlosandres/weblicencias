<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminTicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with('user');
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('ticket_number', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }
        $tickets = $query->latest()->paginate(20)->withQueryString();
        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'order', 'messages.user']);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:open,answered,closed',
        ]);
        $ticket->update(['status' => $request->status]);
        return back()->with('success', 'Estado actualizado correctamente');
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);
        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);
        if ($ticket->status !== 'closed') {
            $ticket->update(['status' => 'answered']);
        }
        return back()->with('success', 'Respuesta enviada correctamente');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->messages()->delete();
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket eliminado correctamente');
    }
}
