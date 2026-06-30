@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard')

@section('content')
<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-primary-500 via-primary-600 to-primary-700 rounded-2xl p-6 mb-6 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/5 rounded-full -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/5 rounded-full translate-y-1/2 -translate-x-1/2"></div>
    <div class="relative z-10">
        <h2 class="text-xl font-bold text-white mb-1">Bienvenido, {{ auth()->user()->name }} 👋</h2>
        <p class="text-primary-100 text-sm">Aquí tienes un resumen de tu tienda hoy.</p>
    </div>
</div>

<!-- Stats Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- Revenue -->
    <div class="stat-card bg-white dark:bg-[#111827] rounded-2xl p-5 border border-gray-200/60 dark:border-gray-800/60 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-emerald-400/10 to-emerald-500/5 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-[12px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wide">Ingresos Totales</p>
                <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1.5">{{ currency_format($stats['total_revenue']) }}</p>
            </div>
            <div class="w-11 h-11 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <div class="mt-3 flex items-center gap-1.5 relative z-10">
            <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 px-1.5 py-0.5 rounded">Hoy</span>
            <span class="text-[11px] text-gray-400">{{ currency_format($stats['today_revenue']) }}</span>
        </div>
    </div>

    <!-- Orders -->
    <div class="stat-card bg-white dark:bg-[#111827] rounded-2xl p-5 border border-gray-200/60 dark:border-gray-800/60 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-blue-400/10 to-blue-500/5 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-[12px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wide">Total Órdenes</p>
                <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1.5">{{ number_format($stats['total_orders']) }}</p>
            </div>
            <div class="w-11 h-11 bg-blue-50 dark:bg-blue-900/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
        @if($stats['pending_orders'] > 0)
        <div class="mt-3 relative z-10">
            <span class="text-[11px] font-semibold text-amber-600 bg-amber-50 dark:bg-amber-900/20 px-1.5 py-0.5 rounded">{{ $stats['pending_orders'] }} pendientes</span>
        </div>
        @endif
    </div>

    <!-- Users -->
    <div class="stat-card bg-white dark:bg-[#111827] rounded-2xl p-5 border border-gray-200/60 dark:border-gray-800/60 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-violet-400/10 to-violet-500/5 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-[12px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wide">Usuarios</p>
                <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1.5">{{ number_format($stats['total_users']) }}</p>
            </div>
            <div class="w-11 h-11 bg-violet-50 dark:bg-violet-900/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
        </div>
    </div>

    <!-- Licenses -->
    <div class="stat-card bg-white dark:bg-[#111827] rounded-2xl p-5 border border-gray-200/60 dark:border-gray-800/60 relative overflow-hidden group">
        <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-amber-400/10 to-amber-500/5 rounded-full -translate-y-8 translate-x-8 group-hover:scale-150 transition-transform duration-500"></div>
        <div class="flex items-start justify-between relative z-10">
            <div>
                <p class="text-[12px] font-medium text-gray-400 dark:text-gray-500 uppercase tracking-wide">Licencias</p>
                <p class="text-2xl font-extrabold text-gray-900 dark:text-white mt-1.5">{{ number_format($stats['available_licenses']) }}</p>
            </div>
            <div class="w-11 h-11 bg-amber-50 dark:bg-amber-900/20 rounded-xl flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            </div>
        </div>
        <div class="mt-3 relative z-10">
            <span class="text-[11px] font-medium text-gray-400">{{ $stats['total_licenses'] }} total</span>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
    <a href="{{ route('admin.products.create') }}" class="flex items-center gap-3 bg-white dark:bg-[#111827] rounded-xl p-4 border border-gray-200/60 dark:border-gray-800/60 hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-md transition-all group">
        <div class="w-10 h-10 bg-primary-50 dark:bg-primary-900/20 rounded-lg flex items-center justify-center group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30 transition-colors">
            <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </div>
        <div>
            <div class="text-[13px] font-semibold text-gray-900 dark:text-white">Nuevo Producto</div>
            <div class="text-[11px] text-gray-400">Agregar al catálogo</div>
        </div>
    </a>
    <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}" class="flex items-center gap-3 bg-white dark:bg-[#111827] rounded-xl p-4 border border-gray-200/60 dark:border-gray-800/60 hover:border-amber-300 dark:hover:border-amber-700 hover:shadow-md transition-all group">
        <div class="w-10 h-10 bg-amber-50 dark:bg-amber-900/20 rounded-lg flex items-center justify-center group-hover:bg-amber-100 dark:group-hover:bg-amber-900/30 transition-colors">
            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="text-[13px] font-semibold text-gray-900 dark:text-white">Pendientes</div>
            <div class="text-[11px] text-gray-400">{{ $stats['pending_orders'] }} órdenes</div>
        </div>
    </a>
    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 bg-white dark:bg-[#111827] rounded-xl p-4 border border-gray-200/60 dark:border-gray-800/60 hover:border-emerald-300 dark:hover:border-emerald-700 hover:shadow-md transition-all group">
        <div class="w-10 h-10 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg flex items-center justify-center group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/30 transition-colors">
            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        </div>
        <div>
            <div class="text-[13px] font-semibold text-gray-900 dark:text-white">Productos</div>
            <div class="text-[11px] text-gray-400">{{ $stats['total_products'] }} activos</div>
        </div>
    </a>
    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 bg-white dark:bg-[#111827] rounded-xl p-4 border border-gray-200/60 dark:border-gray-800/60 hover:border-violet-300 dark:hover:border-violet-700 hover:shadow-md transition-all group">
        <div class="w-10 h-10 bg-violet-50 dark:bg-violet-900/20 rounded-lg flex items-center justify-center group-hover:bg-violet-100 dark:group-hover:bg-violet-900/30 transition-colors">
            <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div>
            <div class="text-[13px] font-semibold text-gray-900 dark:text-white">Ver Órdenes</div>
            <div class="text-[11px] text-gray-400">Historial completo</div>
        </div>
    </a>
</div>

<!-- Revenue Chart -->
<div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden mb-6 p-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Ingresos (Últimos 30 días)</h3>
            <p class="text-[12px] text-gray-400 mt-0.5">Evolución de ventas diarias</p>
        </div>
    </div>
    <div class="w-full h-72">
        <canvas id="revenueChart"></canvas>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Orders -->
    <div class="lg:col-span-2 bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800/60 flex items-center justify-between">
            <div>
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Órdenes Recientes</h3>
                <p class="text-[12px] text-gray-400 mt-0.5">Últimas 10 transacciones</p>
            </div>
            <a href="{{ route('admin.orders.index') }}" class="text-[12px] font-medium text-primary-500 hover:text-primary-600 transition-colors">Ver todas →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-gray-100 dark:border-gray-800/60">
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Pedido</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Cliente</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Estado</th>
                        <th class="px-6 py-3 text-left text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Fecha</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-gray-800/40">
                    @forelse($recentOrders as $order)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-3.5">
                            <a href="{{ route('admin.orders.show', $order) }}" class="text-[13px] font-semibold text-primary-500 hover:text-primary-600">#{{ $order->order_number }}</a>
                        </td>
                        <td class="px-6 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center text-[11px] font-bold text-gray-500 dark:text-gray-400">
                                    {{ substr($order->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-[13px] font-medium text-gray-900 dark:text-white">{{ $order->user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-3.5 text-[13px] font-semibold text-gray-900 dark:text-white">{{ currency_format($order->total) }}</td>
                        <td class="px-6 py-3.5">
                            @php
                                $statusColors = [
                                    'delivered' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400',
                                    'pending' => 'bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400',
                                    'processing' => 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400',
                                    'paid' => 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400',
                                    'cancelled' => 'bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400',
                                    'refunded' => 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400',
                                ];
                                $statusLabels = [
                                    'delivered' => 'Entregado',
                                    'pending' => 'Pendiente',
                                    'processing' => 'Procesando',
                                    'paid' => 'Pagado',
                                    'cancelled' => 'Cancelado',
                                    'refunded' => 'Reembolsado',
                                ];
                            @endphp
                            <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3.5 text-[12px] text-gray-400">{{ $order->created_at->format('d/m H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            </div>
                            <p class="text-[13px] text-gray-400">No hay órdenes recientes</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Products & Alerts -->
    <div class="space-y-6">
        <!-- Top Products -->
        <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800/60">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Top Productos</h3>
                <p class="text-[12px] text-gray-400 mt-0.5">Más vendidos</p>
            </div>
            <div class="divide-y divide-gray-50 dark:divide-gray-800/40">
                @forelse($topProducts as $index => $product)
                <div class="px-6 py-3.5 flex items-center gap-3 hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                    <span class="w-6 h-6 bg-gray-100 dark:bg-gray-800 rounded-md flex items-center justify-center text-[11px] font-bold text-gray-400">{{ $index + 1 }}</span>
                    <div class="w-9 h-9 bg-primary-50 dark:bg-primary-900/20 rounded-lg flex items-center justify-center text-lg shrink-0 text-primary-500">
                        @if($product->category && $product->category->icon)
                            <i class="{{ $product->category->icon }}"></i>
                        @else
                            <i class="fa-solid fa-box"></i>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[13px] font-medium text-gray-900 dark:text-white truncate">{{ $product->name }}</div>
                        <div class="text-[11px] text-gray-400">{{ $product->sold_count }} vendidos</div>
                    </div>
                    <div class="text-[13px] font-semibold text-gray-900 dark:text-white">{{ currency_format($product->discounted_price) }}</div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-[13px] text-gray-400">Sin datos</div>
                @endforelse
            </div>
        </div>

        <!-- Alerts -->
        <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
            <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-4">Alertas</h3>
            <div class="space-y-3">
                @if($stats['pending_orders'] > 0)
                <div class="flex items-start gap-3 p-3 bg-amber-50 dark:bg-amber-900/10 rounded-xl border border-amber-200/50 dark:border-amber-800/30">
                    <div class="w-8 h-8 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    </div>
                    <div>
                        <div class="text-[13px] font-semibold text-amber-700 dark:text-amber-400">{{ $stats['pending_orders'] }} órdenes pendientes</div>
                        <div class="text-[11px] text-amber-600/70 dark:text-amber-500/60 mt-0.5">Requieren procesamiento</div>
                    </div>
                </div>
                @endif

                @if($stats['available_licenses'] < 10)
                <div class="flex items-start gap-3 p-3 bg-red-50 dark:bg-red-900/10 rounded-xl border border-red-200/50 dark:border-red-800/30">
                    <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.618 5.984A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <div class="text-[13px] font-semibold text-red-700 dark:text-red-400">Stock bajo</div>
                        <div class="text-[11px] text-red-600/70 dark:text-red-500/60 mt-0.5">Solo {{ $stats['available_licenses'] }} licencias disponibles</div>
                    </div>
                </div>
                @endif

                @if($stats['open_tickets'] > 0)
                <div class="flex items-start gap-3 p-3 bg-blue-50 dark:bg-blue-900/10 rounded-xl border border-blue-200/50 dark:border-blue-800/30">
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-[13px] font-semibold text-blue-700 dark:text-blue-400">{{ $stats['open_tickets'] }} tickets abiertos</div>
                        <div class="text-[11px] text-blue-600/70 dark:text-blue-500/60 mt-0.5">Soporte pendiente</div>
                    </div>
                </div>
                @endif

                @if($stats['pending_orders'] == 0 && $stats['available_licenses'] >= 10 && $stats['open_tickets'] == 0)
                <div class="flex items-start gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/10 rounded-xl border border-emerald-200/50 dark:border-emerald-800/30">
                    <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center shrink-0 mt-0.5">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <div class="text-[13px] font-semibold text-emerald-700 dark:text-emerald-400">Todo en orden</div>
                        <div class="text-[11px] text-emerald-600/70 dark:text-emerald-500/60 mt-0.5">No hay alertas pendientes</div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const labels = @json($chartLabels);
        const data = @json($chartData);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Ingresos ($)',
                    data: data,
                    borderColor: '#10b981', // emerald-500
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#10b981',
                    pointBorderWidth: 2,
                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(17, 24, 39, 0.9)',
                        titleFont: { size: 13 },
                        bodyFont: { size: 14, weight: 'bold' },
                        padding: 10,
                        cornerRadius: 8,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return '$' + context.parsed.y.toFixed(2);
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 10,
                            color: '#9ca3af',
                            font: { size: 11 }
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(156, 163, 175, 0.1)',
                            drawBorder: false
                        },
                        ticks: {
                            color: '#9ca3af',
                            font: { size: 11 },
                            callback: function(value) {
                                return '$' + value;
                            }
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>
@endpush
