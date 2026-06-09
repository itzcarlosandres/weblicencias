@extends('pages.customer.dashboard')

@section('title', 'Tickets de Soporte | TodoKeys')

@section('customer_content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-extrabold text-text-primary ">Tickets de Soporte</h1>
        <p class="text-sm text-text-secondary mt-1">Centro de ayuda y soporte técnico</p>
    </div>
    <button onclick="document.getElementById('new-ticket-modal').classList.remove('hidden')" class="btn-primary text-sm">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo Ticket
        </span>
    </button>
</div>

@if($tickets->count())
<div class="space-y-4">
    @foreach($tickets as $ticket)
    <a href="{{ route('customer.tickets.show', $ticket) }}" class="block card p-6 hover:shadow-lg transition-all duration-300">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0
                    {{ $ticket->status === 'open' ? 'bg-green-100 text-green-600' : '' }}
                    {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-500' : '' }}
                    {{ $ticket->status === 'pending' ? 'bg-yellow-100 text-yellow-600' : '' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <div>
                    <div class="font-bold text-text-primary text-sm">{{ $ticket->subject }}</div>
                    <div class="text-xs text-text-muted mt-0.5">
                        #{{ $ticket->id }} · {{ $ticket->created_at->diffForHumans() }}
                        @if($ticket->order_id) · Pedido #{{ $ticket->order_id }} @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <div class="text-xs text-text-muted">{{ $ticket->messages->count() }} mensajes</div>
                </div>
                <span class="badge
                    {{ $ticket->status === 'open' ? 'badge-success' : '' }}
                    {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-600' : '' }}
                    {{ $ticket->status === 'pending' ? 'badge-warning' : '' }}">
                    @if($ticket->status === 'open') Abierto
                    @elseif($ticket->status === 'closed') Cerrado
                    @elseif($ticket->status === 'pending') Pendiente
                    @else {{ ucfirst($ticket->status) }}
                    @endif
                </span>
                <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </div>
    </a>
    @endforeach
</div>
<div class="mt-8">{{ $tickets->links() }}</div>
@else
<div class="card p-12 text-center">
    <div class="w-20 h-20 bg-primary-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
    </div>
    <h3 class="text-xl font-bold text-text-primary mb-2">Sin tickets</h3>
    <p class="text-text-secondary mb-6">¿Necesitas ayuda? Crea un ticket de soporte.</p>
    <button onclick="document.getElementById('new-ticket-modal').classList.remove('hidden')" class="btn-primary inline-flex items-center gap-2">
        Crear Ticket
    </button>
</div>
@endif

<!-- New Ticket Modal -->
<div id="new-ticket-modal" class="hidden fixed inset-0 z-50 overflow-y-auto">
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="document.getElementById('new-ticket-modal').classList.add('hidden')"></div>
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative bg-white rounded-2xl shadow-2xl max-w-lg w-full p-8">
            <button onclick="document.getElementById('new-ticket-modal').classList.add('hidden')" class="absolute top-4 right-4 text-text-muted hover:text-text-primary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <h2 class="text-xl font-bold text-text-primary mb-6">Nuevo Ticket de Soporte</h2>
            <form action="{{ route('customer.tickets.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-1.5">Asunto</label>
                        <input type="text" name="subject" required class="input-field" placeholder="Describe brevemente tu problema">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-1.5">Pedido relacionado (opcional)</label>
                        <select name="order_id" class="input-field">
                            <option value="">Ninguno</option>
                            @auth
                            @foreach(auth()->user()->orders()->latest()->limit(10)->get() as $order)
                            <option value="{{ $order->id }}">{{ $order->order_number }} - {{ currency_format($order->total) }}</option>
                            @endforeach
                            @endauth
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-primary mb-1.5">Mensaje</label>
                        <textarea name="message" required rows="5" class="input-field" placeholder="Explica tu problema en detalle..."></textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 mt-6">
                    <button type="button" onclick="document.getElementById('new-ticket-modal').classList.add('hidden')" class="btn-secondary">Cancelar</button>
                    <button type="submit" class="btn-primary">Enviar Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
