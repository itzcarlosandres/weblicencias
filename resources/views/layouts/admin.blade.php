<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - TodoKeys</title>
    <link rel="apple-touch-icon" href="{{ \App\Models\Setting::get('favicon') ? asset('storage/settings/' . \App\Models\Setting::get('favicon')) : asset('favicon.ico') }}">
    <link rel="icon" type="image/x-icon" href="{{ \App\Models\Setting::get('favicon') ? asset('storage/settings/' . \App\Models\Setting::get('favicon')) : asset('favicon.ico') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-pro/css/all.min.css') }}">
    <style>
        .admin-sidebar { scrollbar-width: thin; scrollbar-color: rgba(107,143,204,0.3) transparent; }
        .admin-sidebar::-webkit-scrollbar { width: 4px; }
        .admin-sidebar::-webkit-scrollbar-thumb { background: rgba(107,143,204,0.3); border-radius: 4px; }
        .stat-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .stat-card:hover { transform: translateY(-2px); box-shadow: 0 20px 40px -12px rgba(0,0,0,0.1); }
        .sidebar-item { transition: all 0.2s ease; position: relative; }
        .sidebar-item::before { content: ''; position: absolute; left: 0; top: 50%; transform: translateY(-50%); width: 3px; height: 0; background: var(--color-primary-400); border-radius: 0 4px 4px 0; transition: height 0.2s ease; }
        .sidebar-item:hover::before, .sidebar-item.active::before { height: 60%; }
        /* Fix for sharp-duotone icons side-by-side issue */
        .fa-sharp-duotone { position: relative; }
        .fa-sharp-duotone::before { position: absolute; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F0F4F8] dark:bg-[#0B1120]">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <aside class="w-[260px] bg-white dark:bg-[#111827] border-r border-gray-200/80 dark:border-gray-800/60 flex flex-col shrink-0 fixed h-full z-30">
            <!-- Logo -->
            <div class="px-5 h-16 flex items-center gap-3 border-b border-gray-200/80 dark:border-gray-800/60">
                <div class="w-9 h-9 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <div>
                    <span class="text-[15px] font-bold text-gray-900 dark:text-white tracking-tight">TodoKeys</span>
                    <span class="block text-[10px] font-medium text-gray-400 dark:text-gray-500 -mt-0.5">Panel de Administración</span>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 overflow-y-auto admin-sidebar py-4 px-3">
                <div class="mb-6">
                    <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-600">Principal</div>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Usuarios
                    </a>
                </div>

                <div class="mb-6">
                    <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-600">Catálogo</div>
                    <a href="{{ route('admin.products.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.products.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        Productos
                        @if(isset($stats['total_products']))
                        <span class="ml-auto text-[10px] font-semibold bg-gray-100 dark:bg-gray-800 text-gray-500 dark:text-gray-400 px-1.5 py-0.5 rounded-md">{{ $stats['total_products'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.categories.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        Categorías
                    </a>
                    <a href="{{ route('admin.brands.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.brands.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Marcas
                    </a>
                    <a href="{{ route('admin.badges.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.badges.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        Etiquetas
                    </a>
                    <a href="{{ route('admin.licenses.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.licenses.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <i class="fa-solid fa-key w-5 text-center"></i>
                        <span>Licencias</span>
                    </a>
                    <a href="{{ route('admin.reviews.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.reviews.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <i class="fa-solid fa-star w-5 text-center"></i>
                        <span>Reseñas</span>
                    </a>
                </div>

                <div class="mb-6">
                    <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-600">Ventas</div>
                    <a href="{{ route('admin.orders.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.orders.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                        Órdenes
                        @if(isset($stats['pending_orders']) && $stats['pending_orders'] > 0)
                        <span class="ml-auto text-[10px] font-semibold bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 px-1.5 py-0.5 rounded-md">{{ $stats['pending_orders'] }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.coupons.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.coupons.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        Cupones
                    </a>
                </div>

                <div class="mb-6">
                    <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-600">Soporte</div>
                    <a href="{{ route('admin.tickets.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.tickets.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        Tickets
                    </a>
                </div>

                <div class="mb-6">
                    <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-600">Marketing & SEO</div>
                    <a href="{{ route('admin.referrals.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.referrals.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <i class="fa-solid fa-users-viewfinder w-5 text-center"></i>
                        <span>Referidos</span>
                    </a>
                    <a href="{{ route('admin.marketing.create') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.marketing.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <i class="fa-solid fa-bullhorn w-5 text-center"></i>
                        <span>Email Marketing</span>
                    </a>
                    <a href="{{ route('admin.blog.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.blog.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <i class="fa-solid fa-newspaper w-5 text-center"></i>
                        <span>Blog y Tutoriales</span>
                    </a>
                </div>

                <div class="mb-6">
                    <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-600">Sistema</div>
                    <a href="{{ route('admin.settings.index') }}" class="sidebar-item flex items-center gap-3 px-3 py-2.5 text-[13px] font-medium rounded-lg {{ request()->routeIs('admin.settings.*') ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 active' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-gray-900 dark:hover:text-white' }}">
                        <svg class="w-[18px] h-[18px]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Configuración
                    </a>
                </div>
            </nav>

            <!-- User Section -->
            <div class="p-3 border-t border-gray-200/80 dark:border-gray-800/60">
                <div class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-50 dark:hover:bg-white/5 transition-colors cursor-pointer group" onclick="document.getElementById('user-dropdown').classList.toggle('hidden')">
                    <div class="w-8 h-8 bg-gradient-to-br from-primary-400 to-primary-600 rounded-lg flex items-center justify-center text-white text-xs font-bold shadow-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-[13px] font-medium text-gray-900 dark:text-white truncate">{{ auth()->user()->name }}</div>
                        <div class="text-[11px] text-gray-400 dark:text-gray-500 truncate">Administrador</div>
                    </div>
                    <svg class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/></svg>
                </div>
                <div id="user-dropdown" class="hidden mt-1 mx-1 bg-white dark:bg-gray-800 rounded-lg shadow-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 px-3 py-2 text-[13px] text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        Ver sitio web
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 text-[13px] text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 ml-[260px] flex flex-col min-w-0">
            <!-- Top Bar -->
            <header class="h-16 bg-white/80 dark:bg-[#111827]/80 backdrop-blur-xl border-b border-gray-200/80 dark:border-gray-800/60 flex items-center justify-between px-6 shrink-0 sticky top-0 z-20">
                <div class="flex items-center gap-4">
                    <h1 class="text-[15px] font-semibold text-gray-900 dark:text-white">@yield('header', 'Dashboard')</h1>
                    @hasSection('breadcrumb')
                    <div class="flex items-center gap-1.5 text-[12px] text-gray-400">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        @yield('breadcrumb')
                    </div>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <!-- Notifications -->
                    <button class="relative p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if(isset($stats['pending_orders']) && $stats['pending_orders'] > 0)
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white dark:ring-[#111827]"></span>
                        @endif
                    </button>
                    <!-- Quick Actions -->
                    <a href="{{ route('admin.products.create') }}" class="hidden sm:flex items-center gap-2 px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-lg transition-colors shadow-sm shadow-primary-500/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Nuevo Producto
                    </a>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 p-6 overflow-auto">
                @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/10 border border-emerald-200 dark:border-emerald-800/30 rounded-xl flex items-center gap-3">
                    <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <span class="text-sm text-emerald-700 dark:text-emerald-400 font-medium">{{ session('success') }}</span>
                </div>
                @endif
                @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/30 rounded-xl flex items-center gap-3">
                    <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <span class="text-sm text-red-700 dark:text-red-400 font-medium">{{ session('error') }}</span>
                </div>
                @endif
                
                @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800/30 rounded-xl">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="w-8 h-8 bg-red-100 dark:bg-red-900/30 rounded-lg flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <span class="text-sm text-red-700 dark:text-red-400 font-bold">Por favor corrige los siguientes errores:</span>
                    </div>
                    <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 ml-11">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('user-dropdown');
            if (dropdown && !dropdown.contains(e.target) && !e.target.closest('[onclick*="user-dropdown"]')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
    @livewireScripts
    @yield('scripts')
</body>
</html>
