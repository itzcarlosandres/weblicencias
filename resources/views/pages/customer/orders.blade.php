@extends('pages.customer.dashboard')

@section('title', 'Mis Pedidos | TodoKeys')

@section('customer_content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-extrabold text-text-primary ">Mis Pedidos</h1>
        <p class="text-sm text-text-secondary mt-1">Historial de todas tus compras</p>
    </div>
    <a href="{{ route('products.index') }}" class="btn-primary text-sm">
        <span class="flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nueva Compra
        </span>
    </a>
</div>

@if($orders->count())
<div class="space-y-4">
    @foreach($orders as $order)
    <a href="{{ route('customer.orders.show', $order) }}" class="block card p-6 hover:shadow-lg transition-all duration-300">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0
                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-600 ' : '' }}
                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-600 ' : '' }}
                    {{ $order->status === 'processing' ? 'bg-blue-100 text-blue-600 ' : '' }}
                    {{ $order->status === 'paid' ? 'bg-primary-100 text-primary-600 ' : '' }}
                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-600 ' : '' }}">
                    @if($order->status === 'delivered')
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    @elseif($order->status === 'pending')
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    @else
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    @endif
                </div>
                <div>
                    <div class="font-bold text-text-primary ">{{ $order->order_number }}</div>
                    <div class="text-sm text-text-secondary">{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="text-right">
                    <div class="text-sm text-text-secondary">{{ $order->items->count() }} {{ Str::plural('producto', $order->items->count()) }}</div>
                    <div class="font-extrabold text-lg text-primary-500">{{ currency_format($order->total) }}</div>
                </div>
                <span class="badge
                    {{ $order->status === 'delivered' ? 'badge-success' : '' }}
                    {{ $order->status === 'pending' ? 'badge-warning' : '' }}
                    {{ $order->status === 'cancelled' ? 'badge-danger' : '' }}
                    {{ !in_array($order->status, ['delivered', 'pending', 'cancelled']) ? 'bg-primary-100 text-primary-700' : '' }}">
                    @if($order->status === 'delivered') Entregado
                    @elseif($order->status === 'pending') Pendiente
                    @elseif($order->status === 'processing') Procesando
                    @elseif($order->status === 'paid') Pagado
                    @elseif($order->status === 'cancelled') Cancelado
                    @elseif($order->status === 'refunded') Reembolsado
                    @else {{ ucfirst($order->status) }}
                    @endif
                </span>
                <svg class="w-5 h-5 text-text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </div>
        </div>
    </a>
    @endforeach
</div>
<div class="mt-8">{{ $orders->links() }}</div>
@else
<div class="card p-12 text-center">
    <div class="w-20 h-20 bg-primary-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    </div>
    <h3 class="text-xl font-bold text-text-primary mb-2">Sin pedidos aún</h3>
    <p class="text-text-secondary mb-6">Cuando realices una compra, tus pedidos aparecerán aquí.</p>
    <a href="{{ route('products.index') }}" class="btn-primary inline-flex items-center gap-2">
        Explorar Productos
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
    </a>
</div>
@endif
@endsection
