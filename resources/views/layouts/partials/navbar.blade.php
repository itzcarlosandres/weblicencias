@php
    $siteName = \App\Models\Setting::get('site_name', 'TodoKeys');
    $siteLogo = \App\Models\Setting::get('logo');
    $menuCategories = \App\Models\Category::roots()->active()->orderBy('order')->get();
@endphp
<nav x-data="{ mobileOpen: false, searchOpen: false }" class="bg-[#12141d] text-white z-50">
    <!-- Top Bar -->
    <div class="max-w-[1440px] mx-auto px-4">
        <div class="flex items-center justify-between h-[72px] gap-4 md:gap-8">
            
            <!-- Mobile Menu Toggle & Logo Wrapper (Left) -->
            <div class="flex items-center justify-start gap-4 lg:w-1/4 xl:w-[300px]">
                <button @click="mobileOpen = !mobileOpen" class="lg:hidden p-2 text-gray-300 hover:text-white transition-colors flex-shrink-0">
                    <svg x-cloak x-show="!mobileOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-cloak x-show="mobileOpen" class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center gap-2 group">
                    @if($siteLogo)
                    <img src="{{ asset('storage/settings/' . $siteLogo) }}" alt="{{ $siteName }}" fetchpriority="high" class="h-8 w-auto object-contain">
                    @else
                    <div class="w-10 h-10 bg-blue-600 rounded flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                    </div>
                    <span class="text-2xl font-black tracking-tight text-white hidden sm:block">{{ $siteName }}</span>
                    @endif
                </a>
            </div>

            <!-- Center Search Bar Wrapper -->
            <div class="flex-1 max-w-2xl hidden md:flex items-center justify-center relative">
                <div x-data="liveSearch()" class="w-full relative">
                    <form action="{{ route('products.index') }}" method="GET" class="relative flex items-center w-full h-[44px] bg-white rounded-md overflow-hidden shadow-inner group">
                        <div class="pl-4 pr-2 text-gray-400 group-focus-within:text-blue-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" x-model="query" @input.debounce.300ms="fetchResults" @focus="open = true" @click.away="open = false" autocomplete="off" placeholder="Busca en TodoKeys..." class="w-full h-full text-sm text-gray-900 focus:outline-none placeholder-gray-500 bg-transparent">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white h-full px-6 font-bold text-sm transition-colors flex-shrink-0">
                            Buscar
                        </button>
                    </form>

                    <!-- Live Search Dropdown -->
                    <div x-cloak x-show="open && results.length > 0" x-transition style="display:none;" class="absolute top-full left-0 right-0 mt-1 bg-white rounded-lg shadow-2xl border border-gray-100 overflow-hidden z-50">
                        <template x-for="product in results" :key="product.id">
                            <a :href="product.url" class="flex items-center gap-3 p-3 hover:bg-gray-50 border-b border-gray-50 transition-colors">
                                <img :src="product.image_url" class="w-10 h-10 object-cover rounded bg-gray-100">
                                <div class="flex-1">
                                    <div class="text-[13px] font-bold text-gray-900 line-clamp-1" x-text="product.name"></div>
                                    <div class="text-xs font-bold text-blue-600 mt-0.5">
                                        $<span x-text="product.formatted_price"></span>
                                        <template x-if="product.formatted_compare">
                                            <span class="text-gray-400 line-through font-normal ml-1">$<span x-text="product.formatted_compare"></span></span>
                                        </template>
                                    </div>
                                </div>
                            </a>
                        </template>
                        <!-- View all results link -->
                        <a :href="'{{ route('products.index') }}?search=' + encodeURIComponent(query)" class="block w-full p-3 text-center text-xs font-bold text-blue-600 hover:bg-blue-50 transition-colors">
                            Ver todos los resultados para "<span x-text="query"></span>"
                        </a>
                    </div>
                </div>
            </div>

            <!-- Alpine Component Script for Live Search -->
            <script>
            function liveSearch() {
                return {
                    query: '',
                    results: [],
                    open: false,
                    async fetchResults() {
                        if (this.query.length < 2) {
                            this.results = [];
                            return;
                        }
                        try {
                            let res = await fetch('/search/live?q=' + encodeURIComponent(this.query));
                            this.results = await res.json();
                            this.open = true;
                        } catch (e) {
                            this.results = [];
                        }
                    }
                }
            }
            </script>

            <!-- Right Icons Wrapper -->
            <div class="flex items-center justify-end gap-6 sm:gap-8 lg:w-1/4 xl:w-[300px]">
                
                <!-- Mobile Search Toggle -->
                <button @click="searchOpen = !searchOpen" class="md:hidden flex flex-col items-center justify-center gap-1 text-gray-300 hover:text-white transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </button>

                <!-- Currency Switcher -->
                @php
                    $activeCurrency = session('currency', 'USD');
                    $currencyCodes = [
                        'USD' => 'us',
                        'COP' => 'co',
                        'MXN' => 'mx',
                        'EUR' => 'eu',
                    ];
                    $activeCode = $currencyCodes[$activeCurrency] ?? 'us';
                @endphp
                <div x-data="{ open: false }" class="relative hidden sm:block">
                    <button @click="open = !open" class="flex flex-col items-center justify-center gap-1.5 text-gray-300 hover:text-blue-500 transition-colors group">
                        <img src="https://flagcdn.com/w20/{{ $activeCode }}.png" width="18" class="rounded-[2px] shadow-sm select-none" alt="{{ $activeCurrency }}">
                        <span class="text-[10px] font-bold tracking-wider uppercase group-hover:text-blue-500 transition-colors">{{ $activeCurrency }}</span>
                    </button>
                    <!-- Dropdown Content -->
                    <div x-cloak x-show="open" @click.away="open = false" style="display:none;" x-transition class="absolute right-0 mt-4 w-40 bg-white rounded-lg shadow-2xl border border-gray-100 py-2 z-50 text-gray-800">
                        <a href="?currency=USD" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors {{ $activeCurrency === 'USD' ? 'font-bold text-blue-600 bg-blue-50' : '' }}">
                            <span class="flex items-center gap-2.5">
                                <img src="https://flagcdn.com/w20/us.png" width="18" class="rounded-[2px] shadow-sm" alt="USD">
                                <span>USD ($)</span>
                            </span>
                            @if($activeCurrency === 'USD')
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </a>
                        <a href="?currency=COP" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors {{ $activeCurrency === 'COP' ? 'font-bold text-blue-600 bg-blue-50' : '' }}">
                            <span class="flex items-center gap-2.5">
                                <img src="https://flagcdn.com/w20/co.png" width="18" class="rounded-[2px] shadow-sm" alt="COP">
                                <span>COP</span>
                            </span>
                            @if($activeCurrency === 'COP')
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </a>
                        <a href="?currency=MXN" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors {{ $activeCurrency === 'MXN' ? 'font-bold text-blue-600 bg-blue-50' : '' }}">
                            <span class="flex items-center gap-2.5">
                                <img src="https://flagcdn.com/w20/mx.png" width="18" class="rounded-[2px] shadow-sm" alt="MXN">
                                <span>MXN ($)</span>
                            </span>
                            @if($activeCurrency === 'MXN')
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </a>
                        <a href="?currency=EUR" class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors {{ $activeCurrency === 'EUR' ? 'font-bold text-blue-600 bg-blue-50' : '' }}">
                            <span class="flex items-center gap-2.5">
                                <img src="https://flagcdn.com/w20/eu.png" width="18" class="rounded-[2px] shadow-sm" alt="EUR">
                                <span>EUR (€)</span>
                            </span>
                            @if($activeCurrency === 'EUR')
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </a>
                    </div>
                </div>

                <!-- User Account -->
                @auth
                <div x-data="{ open: false }" class="relative hidden sm:block">
                    <button @click="open = !open" class="flex flex-col items-center justify-center gap-1.5 text-gray-300 hover:text-blue-500 transition-colors group">
                        <div class="w-7 h-7 rounded-full overflow-hidden border border-white/20 bg-gray-800 shrink-0">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                        </div>
                        <span class="text-[10px] font-bold tracking-wider uppercase group-hover:text-blue-500 transition-colors">Mi Cuenta</span>
                    </button>
                    <!-- Dropdown Content -->
                    <div x-cloak x-show="open" @click.away="open = false" style="display:none;" x-transition class="absolute right-0 mt-4 w-64 bg-white rounded-lg shadow-2xl border border-gray-100 py-2 z-50 text-gray-800">
                        <div class="px-5 py-3 border-b border-gray-100 bg-gray-50/50">
                            <p class="text-sm font-bold text-gray-900 line-clamp-1">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-gray-500 line-clamp-1">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Panel de Control
                        </a>
                        <a href="{{ route('customer.profile') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Mi Perfil
                        </a>
                        <a href="{{ route('customer.orders') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            Mis Pedidos
                        </a>
                        <a href="{{ route('customer.wishlist') }}" class="flex items-center gap-3 px-5 py-3 text-sm text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            Lista de Deseos
                        </a>
                        <div class="border-t border-gray-100 my-1"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-5 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <a href="{{ route('login') }}" class="hidden sm:flex flex-col items-center justify-center gap-1 text-gray-300 hover:text-blue-500 transition-colors group">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span class="text-[10px] font-bold tracking-wider uppercase group-hover:text-blue-500 transition-colors">Ingresar</span>
                </a>
                @endauth

                <!-- Cart Component -->
                <div class="hidden sm:block">
                    <livewire:layout.cart-dropdown />
                </div>

            </div>
        </div>
    </div>

    <!-- Sub Navigation Bar (Categories) -->
    <div class="bg-[#1a1d29] border-t border-white/5 hidden lg:block shadow-sm">
        <div class="max-w-[1440px] mx-auto px-4 flex items-center h-[52px] gap-8 overflow-x-auto whitespace-nowrap [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
            @foreach($menuCategories as $category)
            <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="flex items-center gap-2 text-[13px] font-bold text-gray-300 hover:text-white transition-colors h-full border-b-[3px] border-transparent hover:border-blue-500 shrink-0">
                @if(Str::startsWith($category->icon, 'fa-'))
                    <i class="{{ $category->icon }} opacity-80 text-[16px]"></i>
                @else
                    <span class="opacity-80 text-[16px]">{{ $category->icon ?? '📁' }}</span>
                @endif
                {{ $category->name }}
            </a>
            @endforeach
            <a href="{{ url('/') }}#deals" class="flex items-center gap-2 text-[13px] font-bold text-[#f48024] hover:text-[#ff9845] transition-colors h-full border-b-[3px] border-transparent hover:border-[#f48024] ml-auto shrink-0">
                <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Top Ofertas
            </a>
            <a href="{{ route('blog.index') }}" class="flex items-center gap-2 text-[13px] font-bold text-gray-300 hover:text-white transition-colors h-full border-b-[3px] border-transparent hover:border-blue-500 shrink-0 ml-4">
                <i class="fa-solid fa-newspaper opacity-80 text-[16px]"></i>
                Blog
            </a>
        </div>
    </div>

    <!-- Mobile Search Dropdown -->
    <div x-show="searchOpen" x-transition class="md:hidden bg-[#1a1d29] p-3 border-t border-white/10" style="display: none;">
        <form action="{{ route('products.index') }}" method="GET" class="relative flex items-center w-full h-[44px] bg-white rounded overflow-hidden shadow-inner">
            <input type="text" name="search" placeholder="Busca en TodoKeys..." class="w-full h-full text-sm text-gray-900 focus:outline-none pl-4 placeholder-gray-500 bg-transparent">
            <button type="submit" class="bg-blue-600 text-white h-full px-5 font-bold text-sm">
                Buscar
            </button>
        </form>
    </div>

    <!-- Mobile Sidebar Menu -->
    <div x-show="mobileOpen" class="fixed inset-0 z-[100] lg:hidden" style="display: none;">
        <!-- Backdrop -->
        <div x-show="mobileOpen" x-transition.opacity class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="mobileOpen = false"></div>
        
        <!-- Sidebar -->
        <div x-show="mobileOpen" 
             x-transition:enter="transition ease-out duration-300 transform" 
             x-transition:enter-start="-translate-x-full" 
             x-transition:enter-end="translate-x-0" 
             x-transition:leave="transition ease-in duration-300 transform" 
             x-transition:leave-start="translate-x-0" 
             x-transition:leave-end="-translate-x-full" 
             class="fixed inset-y-0 left-0 w-[280px] sm:w-[320px] bg-[#12141d] shadow-2xl flex flex-col border-r border-white/10">
            
            <div class="p-5 flex items-center justify-between border-b border-white/10 shrink-0">
                @if($siteLogo)
                    <img src="{{ asset('storage/settings/' . $siteLogo) }}" alt="{{ $siteName }}" class="h-6 w-auto object-contain">
                @else
                    <span class="text-xl font-black text-white tracking-tight">{{ $siteName }}</span>
                @endif
                <button @click="mobileOpen = false" class="p-2 text-gray-400 hover:text-white transition-colors bg-white/5 rounded-full">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            
            <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1">
                <div class="px-3 mb-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Categorías</div>
                @php
                    $colors = ['blue', 'purple', 'green', 'yellow', 'red', 'indigo', 'pink', 'teal'];
                @endphp
                @foreach($menuCategories as $index => $category)
                @php $color = $colors[$index % count($colors)]; @endphp
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="flex items-center gap-4 px-3 py-3.5 text-[15px] font-bold text-gray-300 hover:text-white hover:bg-{{ $color }}-600/10 rounded-xl transition-colors">
                    <div class="w-9 h-9 rounded-lg bg-{{ $color }}-600/20 text-{{ $color }}-400 flex items-center justify-center text-lg">
                        @if(Str::startsWith($category->icon, 'fa-'))
                            <i class="{{ $category->icon }}"></i>
                        @else
                            {{ $category->icon ?? '📁' }}
                        @endif
                    </div>
                    {{ $category->name }}
                </a>
                @endforeach

                <div class="my-6 border-t border-white/5 mx-3"></div>

                <a href="{{ route('blog.index') }}" class="flex items-center gap-4 px-3 py-3.5 text-[15px] font-bold text-gray-300 hover:text-white hover:bg-white/5 rounded-xl transition-colors">
                    <div class="w-9 h-9 rounded-lg bg-blue-600/20 text-blue-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-newspaper"></i>
                    </div>
                    Blog y Tutoriales
                </a>

                <div class="my-6 border-t border-white/5 mx-3"></div>

                <div class="px-3 mb-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Moneda</div>
                <div class="grid grid-cols-2 gap-2 px-3 mb-6">
                    <a href="?currency=USD" class="flex items-center justify-center gap-2 py-2 text-sm font-bold rounded-lg transition-colors {{ $activeCurrency === 'USD' ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">
                        <img src="https://flagcdn.com/w20/us.png" width="16" class="rounded-sm shadow-sm" alt="USD">
                        USD
                    </a>
                    <a href="?currency=COP" class="flex items-center justify-center gap-2 py-2 text-sm font-bold rounded-lg transition-colors {{ $activeCurrency === 'COP' ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">
                        <img src="https://flagcdn.com/w20/co.png" width="16" class="rounded-sm shadow-sm" alt="COP">
                        COP
                    </a>
                    <a href="?currency=MXN" class="flex items-center justify-center gap-2 py-2 text-sm font-bold rounded-lg transition-colors {{ $activeCurrency === 'MXN' ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">
                        <img src="https://flagcdn.com/w20/mx.png" width="16" class="rounded-sm shadow-sm" alt="MXN">
                        MXN
                    </a>
                    <a href="?currency=EUR" class="flex items-center justify-center gap-2 py-2 text-sm font-bold rounded-lg transition-colors {{ $activeCurrency === 'EUR' ? 'bg-blue-600 text-white' : 'bg-gray-800 text-gray-400 hover:text-white' }}">
                        <img src="https://flagcdn.com/w20/eu.png" width="16" class="rounded-sm shadow-sm" alt="EUR">
                        EUR
                    </a>
                </div>

                <div class="px-3 mb-3 text-xs font-bold text-gray-500 uppercase tracking-wider">Mi Cuenta</div>
                @auth
                    <a href="{{ route('customer.dashboard') }}" class="flex items-center gap-4 px-3 py-3.5 text-[15px] font-bold text-gray-300 hover:text-white hover:bg-white/5 rounded-xl transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-gray-800 text-gray-400 flex items-center justify-center text-lg"><i class="fa-duotone fa-user"></i></div>
                        Panel de Control
                    </a>
                    <a href="{{ route('customer.profile') }}" class="flex items-center gap-4 px-3 py-3.5 text-[15px] font-bold text-gray-300 hover:text-white hover:bg-white/5 rounded-xl transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-gray-800 text-gray-400 flex items-center justify-center text-lg"><i class="fa-solid fa-user-gear"></i></div>
                        Mi Perfil
                    </a>
                    <a href="{{ route('customer.orders') }}" class="flex items-center gap-4 px-3 py-3.5 text-[15px] font-bold text-gray-300 hover:text-white hover:bg-white/5 rounded-xl transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-gray-800 text-gray-400 flex items-center justify-center text-lg"><i class="fa-duotone fa-box-open"></i></div>
                        Mis Pedidos
                    </a>
                    <a href="{{ route('customer.wishlist') }}" class="flex items-center gap-4 px-3 py-3.5 text-[15px] font-bold text-gray-300 hover:text-white hover:bg-white/5 rounded-xl transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-gray-800 text-gray-400 flex items-center justify-center text-lg"><i class="fa-duotone fa-heart"></i></div>
                        Lista de Deseos
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-4 px-3 py-3.5 text-[15px] font-bold text-red-400 hover:text-red-300 hover:bg-red-500/10 rounded-xl transition-colors">
                            <div class="w-9 h-9 rounded-lg bg-red-500/10 flex items-center justify-center text-lg"><i class="fa-duotone fa-right-from-bracket"></i></div>
                            Cerrar Sesión
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex items-center gap-4 px-3 py-3.5 text-[15px] font-bold text-gray-300 hover:text-white hover:bg-white/5 rounded-xl transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-gray-800 text-gray-400 flex items-center justify-center text-lg"><i class="fa-duotone fa-arrow-right-to-bracket"></i></div>
                        Iniciar Sesión
                    </a>
                    <a href="{{ route('register') }}" class="flex items-center gap-4 px-3 py-3.5 text-[15px] font-bold text-blue-400 hover:text-blue-300 hover:bg-blue-600/10 rounded-xl transition-colors">
                        <div class="w-9 h-9 rounded-lg bg-blue-600/20 text-blue-400 flex items-center justify-center text-lg"><i class="fa-duotone fa-user-plus"></i></div>
                        Registrarse
                    </a>
                @endauth
            </div>
            
            <div class="p-5 border-t border-white/10 bg-[#1a1d29] shrink-0 mb-[68px] sm:mb-0">
                <a href="{{ url('/') }}#deals" @click="mobileOpen = false" class="flex items-center justify-center gap-2 w-full py-4 bg-gradient-to-r from-[#f48024] to-[#ff9845] text-white text-[15px] font-bold rounded-xl shadow-[0_4px_14px_0_rgba(244,128,36,0.39)] hover:shadow-[0_6px_20px_rgba(244,128,36,0.23)] hover:scale-[1.02] transition-all">
                    <i class="fa-duotone fa-fire"></i> Top Ofertas
                </a>
            </div>
        </div>
    </div>

    <!-- Floating Bottom Navigation (Mobile Only) -->
    <div class="sm:hidden fixed bottom-0 left-0 right-0 bg-[#12141d]/95 backdrop-blur-md border-t border-white/10 z-[60] px-6 py-2.5 flex items-center justify-between pb-safe shadow-[0_-8px_20px_-5px_rgba(0,0,0,0.3)]">
        <a href="{{ route('home') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('home') ? 'text-blue-500' : 'text-gray-400 hover:text-gray-200' }} transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            <span class="text-[9px] font-bold tracking-wide">INICIO</span>
        </a>
        <button @click="searchOpen = !searchOpen" class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-200 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <span class="text-[9px] font-bold tracking-wide">BUSCAR</span>
        </button>
        <a href="{{ route('cart.index') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('cart.*') ? 'text-blue-500' : 'text-gray-400 hover:text-gray-200' }} transition-colors relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <livewire:layout.cart-count />
            <span class="text-[9px] font-bold tracking-wide">CARRITO</span>
        </a>
        @auth
        <a href="{{ route('customer.dashboard') }}" class="flex flex-col items-center gap-1 {{ request()->routeIs('customer.*') ? 'text-blue-500' : 'text-gray-400 hover:text-gray-200' }} transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span class="text-[9px] font-bold tracking-wide">CUENTA</span>
        </a>
        @else
        <a href="{{ route('login') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-gray-200 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            <span class="text-[9px] font-bold tracking-wide">INGRESAR</span>
        </a>
        @endauth
    </div>
</nav>
