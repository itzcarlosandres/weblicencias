@extends('layouts.admin')

@section('title', 'Ticket: ' . $ticket->ticket_number)
@section('header', 'Ticket ' . $ticket->ticket_number)

@section('content')
<div class="max-w-4xl">
    <!-- Ticket Info -->
    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">{{ $ticket->subject }}</h3>
                <div class="flex items-center gap-3 mt-2 text-[12px] text-gray-500">
                    <span class="flex items-center gap-1">
                        <div class="w-5 h-5 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                            <span class="text-[9px] font-bold text-primary-600 dark:text-primary-400">{{ strtoupper(substr($ticket->user->name, 0, 1)) }}</span>
                        </div>
                        {{ $ticket->user->name }}
                    </span>
                    <span>·</span>
                    <span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                    @if($ticket->order)
                    <span>·</span>
                    <a href="{{ route('admin.orders.show', $ticket->order) }}" class="text-primary-500 hover:underline">Pedido {{ $ticket->order->order_number }}</a>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                <form action="{{ route('admin.tickets.update-status', $ticket) }}" method="POST" class="flex items-center gap-2">
                    @csrf
                    <select name="status" onchange="this.form.submit()" class="px-3 py-1.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-lg text-[12px] text-gray-700 dark:text-gray-300 focus:outline-none focus:ring-2 focus:ring-primary-400/30">
                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Abierto</option>
                        <option value="answered" {{ $ticket->status === 'answered' ? 'selected' : '' }}>Respondido</option>
                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                </form>

                <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este ticket? Esta acción no se puede deshacer.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-3 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-900/20 dark:hover:bg-red-900/40 dark:text-red-400 text-[12px] font-medium rounded-lg transition-colors" title="Eliminar Ticket">
                        <i class="fa-solid fa-trash"></i> Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Messages -->
    <div class="space-y-4 mb-6">
        @foreach($ticket->messages as $message)
        <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-5 {{ $message->user_id === auth()->id() ? 'border-l-4 border-l-primary-500' : '' }}">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-7 h-7 {{ $message->user_id === $ticket->user_id ? 'bg-primary-100 dark:bg-primary-900/30' : 'bg-amber-100 dark:bg-amber-900/30' }} rounded-full flex items-center justify-center">
                    <span class="text-[10px] font-bold {{ $message->user_id === $ticket->user_id ? 'text-primary-600 dark:text-primary-400' : 'text-amber-600 dark:text-amber-400' }}">{{ strtoupper(substr($message->user->name, 0, 1)) }}</span>
                </div>
                <span class="text-[13px] font-semibold text-gray-900 dark:text-white">{{ $message->user->name }}</span>
                <span class="text-[11px] text-gray-400">· {{ $message->created_at->diffForHumans() }}</span>
                @if($message->user_id !== $ticket->user_id)
                <span class="text-[10px] font-medium text-amber-500 bg-amber-50 dark:bg-amber-900/20 px-1.5 py-0.5 rounded">Admin</span>
                @endif
            </div>
            <div class="text-[13px] text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap">{{ $message->message }}</div>
        </div>
        @endforeach
    </div>

    <!-- Reply Form -->
    @if($ticket->status !== 'closed')
    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-4">Responder</h3>
        <form action="{{ route('admin.tickets.reply', $ticket) }}" method="POST">
            @csrf
            <textarea name="message" rows="4" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all resize-none" placeholder="Escribe tu respuesta..." required></textarea>
            <div class="flex justify-end mt-4">
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Enviar Respuesta
                </button>
            </div>
        </form>
    </div>
    @else
    <div class="bg-gray-50 dark:bg-gray-900/30 rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 text-center">
        <div class="w-12 h-12 bg-gray-200 dark:bg-gray-800 rounded-xl flex items-center justify-center mx-auto mb-3">
            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        </div>
        <p class="text-[13px] font-medium text-gray-500 dark:text-gray-400">Este ticket está cerrado</p>
        <p class="text-[12px] text-gray-400 dark:text-gray-500 mt-1">Abre el ticket para poder responder.</p>
    </div>
    @endif
</div>
@endsection