@extends('pages.customer.dashboard')

@section('title', 'Ticket #' . $ticket->id . ' | TodoKeys')

@section('customer_content')
<div class="mb-8">
    <a href="{{ route('customer.tickets') }}" class="inline-flex items-center gap-2 text-sm text-text-secondary hover:text-primary-500 transition-colors mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Volver a Tickets
    </a>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-text-primary ">{{ $ticket->subject }}</h1>
            <p class="text-sm text-text-secondary mt-1">
                Ticket #{{ $ticket->id }} · Creado {{ $ticket->created_at->diffForHumans() }}
                @if($ticket->order_id) · <a href="{{ route('customer.orders.show', $ticket->order_id) }}" class="text-primary-500 hover:underline">Pedido #{{ $ticket->order_id }}</a> @endif
            </p>
        </div>
        <span class="badge text-sm px-4 py-1.5
            {{ $ticket->status === 'open' ? 'badge-success' : '' }}
            {{ $ticket->status === 'closed' ? 'bg-gray-100 text-gray-600' : '' }}
            {{ $ticket->status === 'pending' ? 'badge-warning' : '' }}">
            @if($ticket->status === 'open') Abierto
            @elseif($ticket->status === 'closed') Cerrado
            @elseif($ticket->status === 'pending') Pendiente
            @endif
        </span>
    </div>
</div>

<!-- Messages -->
<div class="space-y-4 mb-8">
    @foreach($ticket->messages as $message)
    <div class="card p-6 {{ $message->user_id === auth()->id() ? 'border-l-4 border-l-primary-400' : 'border-l-4 border-l-green-400' }}">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                {{ $message->user_id === auth()->id() ? 'bg-primary-100 text-primary-600' : 'bg-green-100 text-green-600' }}">
                {{ substr($message->user->name, 0, 1) }}
            </div>
            <div>
                <span class="font-semibold text-sm text-text-primary ">{{ $message->user->name }}</span>
                @if($message->user_id !== auth()->id())
                <span class="badge text-[10px] ml-1 bg-green-100 text-green-700">Soporte</span>
                @endif
            </div>
            <span class="text-xs text-text-muted ml-auto">{{ $message->created_at->diffForHumans() }}</span>
        </div>
        <div class="text-sm text-text-secondary leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
    </div>
    @endforeach
</div>

@if($ticket->status !== 'closed')
<div class="card p-6">
    <h3 class="font-bold text-text-primary mb-4">Responder</h3>
    <form action="{{ route('customer.tickets.reply', $ticket) }}" method="POST">
        @csrf
        <textarea name="message" required rows="4" class="input-field mb-4" placeholder="Escribe tu respuesta..."></textarea>
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">
                <span class="flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Enviar Respuesta
                </span>
            </button>
        </div>
    </form>
</div>
@else
<div class="card p-6 text-center">
    <p class="text-text-secondary">Este ticket está cerrado.</p>
</div>
@endif
@endsection
