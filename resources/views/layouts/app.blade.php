<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>
        @hasSection('title')
            @yield('title') | {{ \App\Models\Setting::get('meta_title') ?: config('app.name', 'TodoKeys') }}
        @else
            {{ \App\Models\Setting::get('meta_title') ?: config('app.name', 'TodoKeys') . ' - Licencias Digitales' }}
        @endif
    </title>
    <meta name="description" content="@yield('description', \App\Models\Setting::get('meta_description') ?: 'Compra licencias digitales, software, gift cards y claves de activación al mejor precio. Entrega instantánea y garantía incluida.')">
    @if($keywords = \App\Models\Setting::get('meta_keywords'))
    <meta name="keywords" content="{{ $keywords }}">
    @endif
    
    <!-- PWA -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#3b82f6">
    <link rel="apple-touch-icon" href="{{ asset('favicon.ico') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:ital,opsz,wght@0,9..144,300;0,9..144,400;0,9..144,500;1,9..144,300;1,9..144,400&display=swap" rel="stylesheet">
    <style>
        [x-cloak] { display: none !important; }
        /* Fix for sharp-duotone icons side-by-side issue */
        .fa-sharp-duotone { position: relative; }
        .fa-sharp-duotone::before { position: absolute; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome-pro/css/all.min.css') }}">
</head>
<body class="font-sans antialiased bg-[#f5f5f5] text-gray-900 transition-colors duration-300 pb-[60px] sm:pb-0">
    <div class="min-h-screen flex flex-col">
        @php
            $announcementEnabled = \App\Models\Setting::get('announcement_enabled', '0') === '1';
            $announcementMode = \App\Models\Setting::get('announcement_mode', 'top_bar');
            $announcementText = \App\Models\Setting::get('announcement_text', '');
            $announcementLink = \App\Models\Setting::get('announcement_link', '');
            $announcementColor = \App\Models\Setting::get('announcement_color', '#3b82f6');
        @endphp

        @if($announcementEnabled && !empty($announcementText) && $announcementMode === 'top_bar')
            <div x-data="{ show: true }" x-show="show" class="relative z-50 text-white px-4 py-2 text-center text-sm font-medium flex items-center justify-center gap-2" style="background-color: {{ $announcementColor }}">
                @if($announcementLink)
                    <a href="{{ $announcementLink }}" class="hover:underline flex-1 truncate">{{ $announcementText }}</a>
                @else
                    <span class="flex-1 truncate">{{ $announcementText }}</span>
                @endif
                <button @click="show = false" class="text-white/80 hover:text-white p-1 shrink-0" aria-label="Cerrar anuncio">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        @endif

        @include('layouts.partials.navbar')

        <main class="flex-1">
            @yield('content')
        </main>

        @include('layouts.partials.footer')
    </div>

    @if(isset($announcementEnabled) && $announcementEnabled && !empty($announcementText) && $announcementMode === 'floating')
        <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.300ms class="fixed bottom-20 sm:bottom-6 right-4 sm:right-6 z-[60] max-w-sm w-[calc(100%-2rem)] sm:w-auto shadow-2xl rounded-2xl overflow-hidden" style="background-color: {{ $announcementColor }}">
            <div class="px-5 py-4 text-white text-sm font-medium pr-12 relative shadow-inner">
                @if($announcementLink)
                    <a href="{{ $announcementLink }}" class="hover:underline block">{{ $announcementText }}</a>
                @else
                    <span class="block">{{ $announcementText }}</span>
                @endif
                <button @click="show = false" class="absolute right-3 top-1/2 -translate-y-1/2 text-white/80 hover:text-white p-1.5 hover:bg-white/10 rounded-full transition-colors" aria-label="Cerrar anuncio">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    @endif

    @livewireScripts
    @stack('scripts')
    
    <!-- PWA Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>

    @php
        $exitPopupEnabled = \App\Models\Setting::get('exit_intent_enabled', '1') === '1';
        $exitPopupTitle = \App\Models\Setting::get('exit_intent_title', '¡Espera! No te vayas todavía');
        $exitPopupText = \App\Models\Setting::get('exit_intent_text', 'Te regalamos un <strong>10% de descuento extra</strong> en tu primera compra si completas tu pedido ahora.');
        $exitPopupCoupon = \App\Models\Setting::get('exit_intent_coupon', 'FLASH10');
        $exitPopupTimer = (int)\App\Models\Setting::get('exit_intent_timer', '10');
    @endphp

    <!-- Exit-Intent Pop-up -->
    @guest
    @if($exitPopupEnabled)
    <div x-data="exitIntentPopup({{ $exitPopupTimer }})" 
         x-init="initPopup"
         x-show="show" 
         x-cloak 
         class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
         
        <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl relative" @click.away="close">
            <button @click="close" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 z-10 w-8 h-8 flex items-center justify-center bg-white/50 rounded-full backdrop-blur-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 p-8 text-center text-white relative overflow-hidden">
                <div class="absolute inset-0 bg-white/10 opacity-50 pattern-grid"></div>
                <h2 class="text-3xl font-black mb-2 relative z-10">{{ $exitPopupTitle }}</h2>
                <p class="text-blue-100 text-sm relative z-10">{!! $exitPopupText !!}</p>
            </div>
            <div class="p-8 text-center">
                <div class="text-xs text-gray-500 font-bold uppercase tracking-wider mb-2">Tu código de descuento exclusivo:</div>
                <div class="bg-gray-100 border-2 border-dashed border-gray-300 rounded-xl py-3 px-6 text-2xl font-black tracking-widest text-gray-800 inline-block mb-6 select-all cursor-pointer hover:border-blue-500 transition-colors" @click="navigator.clipboard.writeText('{{ $exitPopupCoupon }}'); alert('¡Código copiado!')">
                    {{ $exitPopupCoupon }}
                </div>
                <div class="flex items-center justify-center gap-4 mb-6">
                    <div class="text-center">
                        <div class="w-12 h-12 bg-red-100 text-red-600 font-black text-xl flex items-center justify-center rounded-lg" x-text="minutes">{{ sprintf('%02d', $exitPopupTimer) }}</div>
                        <div class="text-[10px] uppercase font-bold text-gray-400 mt-1">Minutos</div>
                    </div>
                    <div class="text-2xl font-black text-gray-300">:</div>
                    <div class="text-center">
                        <div class="w-12 h-12 bg-red-100 text-red-600 font-black text-xl flex items-center justify-center rounded-lg" x-text="seconds">00</div>
                        <div class="text-[10px] uppercase font-bold text-gray-400 mt-1">Segundos</div>
                    </div>
                </div>
                <button @click="close" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl transition-colors mb-3 shadow-lg shadow-blue-600/30">
                    ¡Lo quiero!
                </button>
                <button @click="close" class="text-sm text-gray-400 hover:text-gray-600 underline">
                    No, gracias. Prefiero pagar precio completo.
                </button>
            </div>
        </div>
    </div>
    @endif
    @endguest

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('exitIntentPopup', (initialMinutes) => ({
                show: false,
                hasTriggered: false,
                timeLeft: (initialMinutes || 10) * 60,
                timer: null,

                initPopup() {
                    if (localStorage.getItem('exit_intent_shown')) {
                        this.hasTriggered = true;
                        return;
                    }

                    // Trigger on mouse leave window (desktop)
                    document.addEventListener('mouseleave', (e) => {
                        if (e.clientY < 0 && !this.hasTriggered) {
                            this.triggerPopup();
                        }
                    });

                    // Trigger after 60s of inactivity (mobile/desktop fallback)
                    let timeout;
                    const resetTimer = () => {
                        clearTimeout(timeout);
                        if (!this.hasTriggered) {
                            timeout = setTimeout(() => this.triggerPopup(), 60000);
                        }
                    };
                    ['mousemove', 'scroll', 'touchstart', 'click'].forEach(evt => 
                        document.addEventListener(evt, resetTimer)
                    );
                    resetTimer();
                },

                triggerPopup() {
                    this.show = true;
                    this.hasTriggered = true;
                    localStorage.setItem('exit_intent_shown', 'true');
                    this.startTimer();
                },

                close() {
                    this.show = false;
                },

                startTimer() {
                    this.timer = setInterval(() => {
                        if (this.timeLeft > 0) {
                            this.timeLeft--;
                        } else {
                            clearInterval(this.timer);
                        }
                    }, 1000);
                },

                get minutes() {
                    return String(Math.floor(this.timeLeft / 60)).padStart(2, '0');
                },

                get seconds() {
                    return String(this.timeLeft % 60).padStart(2, '0');
                }
            }));
        });
    </script>

    <script>
        function addCardToCart(event, productId, btn) {
            event.preventDefault();
            event.stopPropagation();
            
            if (btn.disabled) return;
            
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-[10px]"></i>';
            btn.disabled = true;
            
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ product_id: productId, quantity: 1 })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (typeof Livewire !== 'undefined') {
                        Livewire.dispatch('cartUpdated');
                    }
                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.count } }));
                    
                    btn.innerHTML = '<i class="fa-solid fa-check text-[10px] text-emerald-500"></i>';
                    btn.classList.add('bg-emerald-50', 'border-emerald-200');
                    btn.classList.remove('bg-gray-50', 'border-gray-200/80');
                    
                    setTimeout(() => {
                        btn.innerHTML = originalContent;
                        btn.classList.remove('bg-emerald-50', 'border-emerald-200');
                        btn.classList.add('bg-gray-50', 'border-gray-200/80');
                        btn.disabled = false;
                    }, 2000);
                } else {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    alert(data.message || 'Error al agregar el producto');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalContent;
                btn.disabled = false;
                alert('Hubo un problema al agregar el producto al carrito.');
            });
        }
    </script>
</body>
</html>
