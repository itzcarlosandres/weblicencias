@extends('layouts.admin')

@section('title', 'Pedido ' . $order->order_number . ' | Admin')
@section('header', 'Detalle de Pedido')

@section('content')
<!-- Back Button -->
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-[13px] text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Volver a Órdenes
    </a>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-primary-50 dark:bg-primary-900/20 rounded-xl flex items-center justify-center">
            <svg class="w-6 h-6 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $order->order_number }}</h2>
            <p class="text-[13px] text-gray-400">{{ $order->created_at->format('d \d\e M \d\e Y, H:i') }}</p>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="flex items-center gap-2">
            @csrf
            @php
                $statusColors = [
                    'delivered' => 'bg-emerald-50 text-emerald-600 border-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/30',
                    'pending' => 'bg-amber-50 text-amber-600 border-amber-200 dark:bg-amber-900/20 dark:text-amber-400 dark:border-amber-800/30',
                    'processing' => 'bg-blue-50 text-blue-600 border-blue-200 dark:bg-blue-900/20 dark:text-blue-400 dark:border-blue-800/30',
                    'paid' => 'bg-primary-50 text-primary-600 border-primary-200 dark:bg-primary-900/20 dark:text-primary-400 dark:border-primary-800/30',
                    'cancelled' => 'bg-red-50 text-red-600 border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800/30',
                    'refunded' => 'bg-gray-100 text-gray-600 border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-700',
                ];
            @endphp
            <select name="status" class="px-3 py-2 bg-white dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] font-medium text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all {{ $statusColors[$order->status] ?? '' }}">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Procesando</option>
                <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Pagado</option>
                <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelado</option>
                <option value="refunded" {{ $order->status === 'refunded' ? 'selected' : '' }}>Reembolsado</option>
            </select>
            <button type="submit" class="px-4 py-2 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-[13px] font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                Actualizar
            </button>
        </form>

        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta orden? Esta acción no se puede deshacer.');">
            @csrf
            @method('DELETE')
            <button type="submit" class="px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 dark:bg-red-900/20 dark:hover:bg-red-900/40 dark:text-red-400 text-[13px] font-medium rounded-xl transition-colors" title="Eliminar Orden">
                <i class="fa-solid fa-trash"></i> Eliminar
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Items -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Products -->
        <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800/60">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Productos</h3>
            </div>
            <div class="divide-y divide-gray-50 dark:divide-gray-800/40">
                @foreach($order->items as $item)
                <div class="px-6 py-4 flex items-center gap-4">
                    <div class="w-12 h-12 bg-primary-50 dark:bg-primary-900/20 rounded-xl flex items-center justify-center text-xl shrink-0">
                        {{ $item->product->category->icon ?? '📦' }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[13px] font-semibold text-gray-900 dark:text-white truncate">{{ $item->product->name }}</div>
                        <div class="text-[11px] text-gray-400 mt-0.5">Cantidad: {{ $item->quantity }} · {{ currency_format($item->price) }} c/u</div>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="text-[14px] font-bold text-gray-900 dark:text-white">{{ currency_format($item->price * $item->quantity) }}</div>
                        @if($item->license)
                        <div class="mt-1">
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 rounded text-[10px] font-medium">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Licencia entregada
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    <div class="shrink-0 ml-4">
                        <form action="{{ route('admin.orders.remove-item', [$order, $item]) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este producto de la orden? Si tenía una licencia, se devolverá al stock y se recalculará el total.');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/40 p-2 rounded-lg transition-colors" title="Remover producto">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Licenses -->
        @if($order->items->where('license')->count())
        <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800/60 flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Licencias Entregadas</h3>
            </div>
            <div class="p-6 space-y-3">
                @foreach($order->items->where('license') as $item)
                <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-4 border border-gray-100 dark:border-gray-800/60">
                    <div class="text-[11px] text-gray-400 mb-2">{{ $item->product->name }}</div>
                    <div class="font-mono text-[13px] font-bold text-gray-900 dark:text-white bg-white dark:bg-[#111827] px-4 py-2.5 rounded-lg border border-gray-200 dark:border-gray-800 select-all">
                        {{ $item->license->key }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Customer -->
        <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
            <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-4">Cliente</h3>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center">
                    <span class="font-bold text-primary-600 dark:text-primary-400 text-[13px]">{{ substr($order->user->name, 0, 1) }}</span>
                </div>
                <div class="min-w-0">
                    <div class="text-[13px] font-semibold text-gray-900 dark:text-white truncate">{{ $order->user->name }}</div>
                    <div class="text-[11px] text-gray-400 truncate">{{ $order->user->email }}</div>
                </div>
            </div>
        </div>

        <!-- Summary -->
        <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
            <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-4">Resumen</h3>
            <div class="space-y-3 text-[13px]">
                <div class="flex justify-between">
                    <span class="text-gray-400">Subtotal</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ currency_format($order->subtotal) }}</span>
                </div>
                @if($order->discount > 0)
                <div class="flex justify-between text-emerald-600">
                    <span>Descuento {{ $order->coupon ? '(' . $order->coupon->code . ')' : '' }}</span>
                    <span class="font-medium">-{{ currency_format($order->discount) }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-gray-400">Impuestos</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ currency_format($order->tax) }}</span>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-100 dark:border-gray-800/60">
                    <span class="font-bold text-gray-900 dark:text-white">Total</span>
                    <span class="font-extrabold text-lg text-primary-500">{{ currency_format($order->total) }}</span>
                </div>
            </div>
        </div>

        <!-- Payment -->
        <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
            <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-4">Pago</h3>
            <div class="space-y-3 text-[13px]">
                <div class="flex justify-between">
                    <span class="text-gray-400">Método</span>
                    <span class="font-medium text-gray-900 dark:text-white flex items-center gap-1.5">
                        @if($order->payment_method === 'paypal')
                            <i class="fa-brands fa-paypal text-blue-600"></i> PayPal
                        @elseif($order->payment_method === 'mercadopago')
                            <i class="fa-solid fa-handshake text-[#009ee3]"></i> Mercado Pago
                        @elseif($order->payment_method === 'wompi')
                            <i class="fa-solid fa-building-columns text-indigo-600"></i> Wompi
                        @elseif($order->payment_method === 'points')
                            <i class="fa-solid fa-coins text-amber-500"></i> TodoPuntos
                        @else
                            {{ ucfirst($order->payment_method) }}
                        @endif
                    </span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-gray-400">Estado</span>
                    @php
                        $badgeColors = [
                            'delivered' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400',
                            'pending' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400',
                            'cancelled' => 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $badgeColors[$order->status] ?? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400' }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-400">Fecha</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>

            @if($order->status === 'pending' || $order->status === 'processing')
            <div class="mt-5 pt-5 border-t border-gray-100 dark:border-gray-800">
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="completed">
                    <button type="submit" class="w-full flex justify-center items-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-3 px-4 rounded-xl transition-all shadow-sm shadow-emerald-500/20 hover:-translate-y-0.5 text-[14px]">
                        <i class="fa-solid fa-circle-check text-lg"></i>
                        Confirmar Pago
                    </button>
                </form>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
