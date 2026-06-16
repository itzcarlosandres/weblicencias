@extends('layouts.app')

@section('title', 'Mi Cuenta | TodoKeys')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar -->
        <aside class="w-full lg:w-64 shrink-0 lg:sticky lg:top-36 h-max">
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-center gap-3 mb-6 pb-6 border-b border-gray-100 ">
                    <div class="w-12 h-12 rounded-full overflow-hidden border border-gray-100 bg-gray-50 shrink-0">
                        <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                    </div>
                    <div class="min-w-0">
                        <div class="font-semibold text-text-primary truncate">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-text-muted truncate">{{ auth()->user()->email }}</div>
                    </div>
                </div>
                <nav class="space-y-1">
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl {{ request()->routeIs('customer.dashboard') ? 'bg-primary-50 text-primary-600' : 'text-text-secondary hover:bg-gray-50 ' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl {{ request()->routeIs('customer.profile') ? 'bg-primary-50 text-primary-600' : 'text-text-secondary hover:bg-gray-50 ' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Mi Perfil
                    </a>
                    <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl {{ request()->routeIs('customer.orders*') ? 'bg-primary-50 text-primary-600' : 'text-text-secondary hover:bg-gray-50 ' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Mis Pedidos
                    </a>
                    <a href="{{ route('customer.licenses') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl {{ request()->routeIs('customer.licenses') ? 'bg-primary-50 text-primary-600' : 'text-text-secondary hover:bg-gray-50 ' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        Mis Licencias
                    </a>
                    <a href="{{ route('customer.tickets') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl {{ request()->routeIs('customer.tickets*') ? 'bg-primary-50 text-primary-600' : 'text-text-secondary hover:bg-gray-50 ' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Tickets de Soporte
                    </a>

                    <a href="{{ route('customer.wallet') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl {{ request()->routeIs('customer.wallet') ? 'bg-primary-50 text-primary-600' : 'text-text-secondary hover:bg-gray-50 ' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        Mi Monedero
                    </a>
                    <a href="{{ route('customer.wishlist') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-xl {{ request()->routeIs('customer.wishlist') ? 'bg-primary-50 text-primary-600' : 'text-text-secondary hover:bg-gray-50 ' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        Lista de Deseos
                    </a>
                </nav>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl text-green-700 text-sm">
                {{ session('success') }}
            </div>
            @endif

            @hasSection('customer_content')
            @yield('customer_content')
            @else

            <!-- Welcome -->
            <div class="mb-6">
                <h1 class="text-2xl font-extrabold text-text-primary ">Dashboard</h1>
                <p class="text-sm text-text-secondary mt-1">Resumen de tu cuenta</p>
            </div>

            <!-- Stats -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <div class="text-[11px] font-medium text-text-muted uppercase tracking-wide">Pedidos</div>
                    <div class="text-2xl font-extrabold text-text-primary mt-1">{{ $stats['total_orders'] }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <div class="text-[11px] font-medium text-text-muted uppercase tracking-wide">Licencias</div>
                    <div class="text-2xl font-extrabold text-text-primary mt-1">{{ $stats['total_licenses'] }}</div>
                </div>
                <div class="bg-white rounded-2xl border border-gray-100 p-5">
                    <div class="text-[11px] font-medium text-text-muted uppercase tracking-wide">Pendientes</div>
                    <div class="text-2xl font-extrabold text-text-primary mt-1">{{ $stats['pending_orders'] }}</div>
                </div>

                <div class="bg-gray-900 rounded-2xl p-5 text-white relative overflow-hidden mt-4 lg:mt-0 col-span-2 lg:col-span-4 border border-gray-800">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 rounded-full -translate-y-8 translate-x-8"></div>
                    <div class="flex items-center justify-between relative z-10">
                        <div>
                            <div class="text-[11px] font-medium text-gray-300 uppercase tracking-wide flex items-center gap-1.5"><i class="fa-solid fa-wallet"></i> Mi Monedero</div>
                            <div class="text-2xl font-extrabold mt-1 text-white">${{ number_format(auth()->user()->wallet_balance, 2) }}</div>
                            <div class="text-[11px] text-gray-400 mt-0.5">Saldo disponible para comprar</div>
                        </div>
                        <a href="{{ route('customer.wallet') }}" class="px-4 py-2 bg-white/10 border border-white/10 hover:bg-white/20 rounded-xl text-[12px] font-bold backdrop-blur-sm transition-colors text-white">
                            Ver historial
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Orders -->
                <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="font-bold text-text-primary text-sm">Pedidos Recientes</h3>
                        <a href="{{ route('customer.orders') }}" class="text-xs font-medium text-primary-500 hover:text-primary-600">Ver todos →</a>
                    </div>
                    <div class="divide-y divide-gray-50 ">
                        @forelse($recentOrders as $order)
                        <a href="{{ route('customer.orders.show', $order) }}" class="flex items-center justify-between px-6 py-3 hover:bg-gray-50 transition-colors">
                            <div>
                                <div class="text-[13px] font-semibold text-text-primary ">{{ $order->order_number }}</div>
                                <div class="text-[11px] text-text-muted">{{ $order->created_at->diffForHumans() }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-[13px] font-bold text-primary-500">{{ currency_format($order->total) }}</div>
                                <span class="badge text-[10px] {{ $order->status === 'delivered' ? 'badge-success' : 'badge-warning' }}">{{ ucfirst($order->status) }}</span>
                            </div>
                        </a>
                        @empty
                        <div class="px-6 py-8 text-center text-[13px] text-text-muted">Sin pedidos aún</div>
                        @endforelse
                    </div>
                </div>


            @endif

            <!-- Referral Link -->
            @if(auth()->user()->referral_code)
            <div class="mt-6 bg-gradient-to-r from-blue-50 to-blue-100/50 rounded-2xl border border-blue-200/50 p-6">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shrink-0">
                        <i class="fa-solid fa-user-plus text-white text-xl"></i>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-[15px] font-bold text-blue-700">Invita y Gana</h4>
                        <p class="text-[13px] text-blue-600/70 mt-1">Comparte tu enlace de referido. Cuando tu amigo haga su primera compra, ¡ganarás 1,000 TodoPuntos adicionales!</p>
                        <div class="mt-4 flex flex-col sm:flex-row gap-2">
                            <input type="text" readonly value="{{ route('register', ['ref' => auth()->user()->referral_code]) }}" class="flex-1 px-3 py-2 bg-white border border-blue-200 rounded-lg text-[13px] font-mono text-gray-600 focus:outline-none" onclick="this.select()">
                            <button onclick="navigator.clipboard.writeText('{{ route('register', ['ref' => auth()->user()->referral_code]) }}'); alert('¡Enlace copiado al portapapeles!');" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[12px] font-bold rounded-lg transition-colors whitespace-nowrap">
                                Copiar Enlace
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
