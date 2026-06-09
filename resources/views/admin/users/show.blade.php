@extends('layouts.admin')

@section('title', 'Detalles de Usuario')
@section('header', 'Perfil de ' . $user->name)
@section('breadcrumb')
    <a href="{{ route('admin.users.index') }}" class="hover:text-primary-600 transition-colors">Usuarios</a>
    <svg class="w-3.5 h-3.5 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span>{{ $user->name }}</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    
    <!-- Columna Izquierda: Info y Puntos -->
    <div class="space-y-6">
        
        <!-- Perfil -->
        <div class="bg-white dark:bg-[#111827] rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <div class="flex items-center gap-4 mb-6">
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full object-cover bg-gray-100">
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h2>
                    <p class="text-sm text-gray-500">{{ $user->email }}</p>
                </div>
            </div>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between border-b border-gray-100 dark:border-gray-800 pb-2">
                    <span class="text-gray-500">Registro:</span>
                    <span class="font-medium text-gray-900 dark:text-gray-300">{{ $user->created_at->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-100 dark:border-gray-800 pb-2">
                    <span class="text-gray-500">Pedidos:</span>
                    <span class="font-medium text-gray-900 dark:text-gray-300">{{ $user->orders->count() }}</span>
                </div>
            </div>
        </div>

        <!-- Gestión de Puntos -->
        <div class="bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/10 dark:to-orange-900/10 rounded-xl shadow-sm border border-amber-200 dark:border-amber-800/50 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-amber-900 dark:text-amber-400 flex items-center gap-2">
                    <i class="fa-solid fa-coins"></i> TodoPuntos
                </h3>
                <span class="text-2xl font-black text-amber-600 dark:text-amber-500">{{ number_format($user->points) }}</span>
            </div>
            
            <p class="text-xs text-amber-700 dark:text-amber-500/80 mb-4">
                Añade o resta puntos a este usuario. Usa un valor negativo (ej: -500) para restar.
            </p>

            <form action="{{ route('admin.users.points', $user) }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-amber-900 dark:text-amber-500 mb-1">Cantidad (+ o -)</label>
                    <input type="number" name="amount" required class="w-full px-3 py-2 bg-white dark:bg-gray-800 border border-amber-300 dark:border-amber-700/50 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <div>
                    <label class="block text-xs font-bold text-amber-900 dark:text-amber-500 mb-1">Motivo / Descripción</label>
                    <input type="text" name="description" placeholder="Ej: Regalo por compra" required class="w-full px-3 py-2 bg-white dark:bg-gray-800 border border-amber-300 dark:border-amber-700/50 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-500">
                </div>
                <button type="submit" class="w-full mt-2 bg-amber-500 hover:bg-amber-600 text-white font-bold py-2.5 px-4 rounded-lg transition-colors shadow-sm text-sm">
                    Aplicar Puntos
                </button>
            </form>
        </div>

    </div>

    <!-- Columna Derecha: Órdenes e Historial -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Historial de Pedidos -->
        <div class="bg-white dark:bg-[#111827] rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Historial de Pedidos</h3>
            
            @if($user->orders->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase border-b border-gray-200 dark:border-gray-800">
                        <tr>
                            <th class="py-3 font-semibold">Orden</th>
                            <th class="py-3 font-semibold">Fecha</th>
                            <th class="py-3 font-semibold">Total</th>
                            <th class="py-3 font-semibold">Estado</th>
                            <th class="py-3 text-right font-semibold">Ver</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800/50">
                        @foreach($user->orders->sortByDesc('created_at') as $order)
                        <tr>
                            <td class="py-3 font-medium text-gray-900 dark:text-gray-300">#{{ $order->order_number }}</td>
                            <td class="py-3">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="py-3 font-bold">{{ currency_format($order->total) }}</td>
                            <td class="py-3">
                                @if($order->status === 'completed' || $order->status === 'paid')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 dark:bg-green-500/10 dark:text-green-400 rounded text-xs font-bold">Completado</span>
                                @elseif($order->status === 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 dark:bg-yellow-500/10 dark:text-yellow-400 rounded text-xs font-bold">Pendiente</span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400 rounded text-xs font-bold">{{ ucfirst($order->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3 text-right">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-primary-600 hover:text-primary-700 text-xs font-bold">
                                    Detalles
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="text-center py-8 text-gray-500">
                Este usuario no ha realizado ninguna compra todavía.
            </div>
            @endif
        </div>

        <!-- Historial de Puntos -->
        <div class="bg-white dark:bg-[#111827] rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Últimos Movimientos de Puntos</h3>
            
            @if($user->pointTransactions->count() > 0)
            <div class="space-y-3">
                @foreach($user->pointTransactions as $tx)
                <div class="flex items-center justify-between p-3 rounded-lg border border-gray-100 dark:border-gray-800 bg-gray-50/50 dark:bg-gray-800/20">
                    <div>
                        <div class="text-sm font-medium text-gray-900 dark:text-gray-300">{{ $tx->description }}</div>
                        <div class="text-xs text-gray-500">{{ $tx->created_at->format('d M Y, H:i') }}</div>
                    </div>
                    <div class="text-sm font-bold {{ $tx->type === 'earned' || $tx->points > 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                        {{ $tx->points > 0 ? '+' : '' }}{{ number_format($tx->points) }} pts
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-6 text-gray-500 text-sm">
                No hay movimientos de puntos.
            </div>
            @endif
        </div>

    </div>
</div>
@endsection
