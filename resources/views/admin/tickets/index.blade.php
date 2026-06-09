@extends('layouts.admin')

@section('title', 'Tickets de Soporte')
@section('header', 'Tickets de Soporte')

@section('content')
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
        <p class="text-[13px] text-gray-400">Gestiona los tickets de soporte de clientes</p>
    </div>
</div>

<div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-4 mb-6">
    <form action="{{ route('admin.tickets.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por número o asunto..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
        </div>
        <select name="status" class="px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
            <option value="">Todos los estados</option>
            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Abierto</option>
            <option value="answered" {{ request('status') == 'answered' ? 'selected' : '' }}>Respondido</option>
            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Cerrado</option>
        </select>
        <button type="submit" class="px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-[13px] font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">Buscar</button>
    </form>
</div>

<div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800/60">
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Ticket</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Asunto</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="text-right px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800/40">
                @forelse($tickets as $ticket)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-{{ $ticket->status === 'open' ? 'red' : ($ticket->status === 'answered' ? 'amber' : 'gray') }}-50 dark:bg-{{ $ticket->status === 'open' ? 'red' : ($ticket->status === 'answered' ? 'amber' : 'gray') }}-900/20 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5 text-{{ $ticket->status === 'open' ? 'red' : ($ticket->status === 'answered' ? 'amber' : 'gray') }}-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <span class="text-[13px] font-bold font-mono text-gray-900 dark:text-white">{{ $ticket->ticket_number }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center shrink-0">
                                <span class="text-[11px] font-bold text-primary-600 dark:text-primary-400">{{ strtoupper(substr($ticket->user->name, 0, 1)) }}</span>
                            </div>
                            <span class="text-[13px] text-gray-600 dark:text-gray-400">{{ $ticket->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[13px] font-medium text-gray-900 dark:text-white truncate max-w-[200px] block">{{ $ticket->subject }}</span>
                    </td>
                    <td class="px-6 py-4">
                        @if($ticket->status === 'open')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400">
                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span>
                            Abierto
                        </span>
                        @elseif($ticket->status === 'answered')
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400">
                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span>
                            Respondido
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                            Cerrado
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-[13px] text-gray-500 dark:text-gray-400">{{ $ticket->created_at->format('d/m/Y H:i') }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-[12px] font-medium rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/30 transition-colors">
                                Ver
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                            <form action="{{ route('admin.tickets.destroy', $ticket) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este ticket? Esta acción no se puede deshacer.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors" title="Eliminar Ticket">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <p class="text-[14px] font-medium text-gray-500 dark:text-gray-400 mb-1">No hay tickets</p>
                        <p class="text-[12px] text-gray-400 dark:text-gray-500">No hay tickets de soporte pendientes.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($tickets->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800/60">
        {{ $tickets->links() }}
    </div>
    @endif
</div>
@endsection