@extends('layouts.app')
@section('title', 'Ofertas Flash')
@section('meta_description', 'Aprovecha nuestras Ofertas Flash con descuentos increíbles. ¡Tiempo limitado!')

@section('content')
<!-- Hero Section (Neon & Urgency) -->
<div class="relative bg-zinc-950 overflow-hidden py-16 sm:py-24 border-b border-zinc-800">
    <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
    <div class="absolute left-1/2 top-0 -translate-x-1/2 w-[800px] h-[300px] bg-amber-500/20 blur-[100px] rounded-full pointer-events-none"></div>
    
    <div class="max-w-[1440px] mx-auto px-4 relative z-10 text-center">
        <div class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-amber-500/10 border border-amber-500/30 rounded-full mb-6">
            <span class="relative flex h-3 w-3">
              <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
              <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
            </span>
            <span class="text-amber-500 font-bold text-sm tracking-wider uppercase">Tiempo Limitado</span>
        </div>
        
        <h1 class="text-4xl md:text-6xl font-black text-white tracking-tight mb-4 drop-shadow-lg">
            Ofertas <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 to-orange-500">Flash</span>
        </h1>
        <p class="text-zinc-400 max-w-2xl mx-auto text-lg">
            Descuentos extremos en licencias de software y juegos. Aprovecha antes de que el contador llegue a cero.
        </p>
    </div>
</div>

<!-- Main Content Grid -->
<div class="max-w-[1440px] mx-auto px-4 py-12">
    @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            @foreach($products as $product)
                <div class="relative group bg-white dark:bg-[#111827] rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden shadow-sm hover:shadow-xl transition-all">
                    
                    <!-- Flash Sale Timer Banner -->
                    <div class="absolute top-0 inset-x-0 z-20 bg-gradient-to-r from-amber-500 to-orange-600 text-white text-center py-1.5 shadow-md flex items-center justify-center gap-2"
                         x-data="countdown('{{ $product->flash_sale_end->toIso8601String() }}')">
                        <i class="fa-solid fa-clock animate-pulse"></i>
                        <span class="font-black text-sm tracking-wider" x-text="time">Calculando...</span>
                    </div>

                    <!-- Add padding top so the image isn't covered by the timer -->
                    <div class="pt-8 relative z-10">
                        <!-- Discount Badge -->
                        @if($product->effective_discount > 0)
                            <div class="absolute top-10 left-3 bg-red-500 text-white text-xs font-black px-2 py-1 rounded shadow-md z-30">
                                -{{ $product->effective_discount }}%
                            </div>
                        @endif

                        <!-- Product Image -->
                        <a href="{{ route('products.show', $product->slug) }}" class="block p-4">
                            <div class="w-full aspect-square bg-gray-50 dark:bg-zinc-900 rounded-xl overflow-hidden flex items-center justify-center relative">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <i class="fa-solid fa-box text-5xl text-gray-300 dark:text-gray-700"></i>
                                @endif
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors"></div>
                            </div>
                        </a>

                        <!-- Product Info -->
                        <div class="px-4 pb-5">
                            <div class="text-[11px] font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest mb-1">
                                {{ $product->category->name ?? 'Software' }}
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}">
                                <h3 class="text-[15px] font-bold text-gray-900 dark:text-white line-clamp-2 leading-tight mb-3 group-hover:text-amber-500 transition-colors">
                                    {{ $product->name }}
                                </h3>
                            </a>
                            
                            <div class="flex items-end justify-between mt-auto">
                                <div>
                                    @if($product->has_discount)
                                        <div class="text-[11px] text-gray-400 dark:text-gray-500 line-through mb-0.5">
                                            {{ currency_format($product->price) }}
                                        </div>
                                    @endif
                                    <div class="text-xl font-black text-gray-900 dark:text-white">
                                        {{ currency_format($product->discounted_price) }}
                                    </div>
                                </div>
                                <a href="{{ route('products.show', $product->slug) }}" class="w-10 h-10 rounded-full bg-gray-100 dark:bg-zinc-800 flex items-center justify-center text-gray-600 dark:text-gray-300 group-hover:bg-amber-500 group-hover:text-white transition-all shadow-sm">
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 flex justify-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-20 bg-white dark:bg-[#111827] rounded-3xl border border-gray-200 dark:border-gray-800 shadow-sm">
            <div class="w-24 h-24 bg-gray-100 dark:bg-zinc-900 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-solid fa-bolt text-4xl text-gray-300 dark:text-gray-700"></i>
            </div>
            <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-2">No hay Ofertas Flash activas</h2>
            <p class="text-gray-500 dark:text-gray-400 mb-8 max-w-md mx-auto">Vuelve más tarde para descubrir descuentos extremos por tiempo limitado.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-blue-500/30">
                Explorar Catálogo
            </a>
        </div>
    @endif
</div>

<!-- Alpine.js script for the countdown timer -->
@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('countdown', (endTime) => ({
        end: new Date(endTime).getTime(),
        time: '',
        interval: null,

        init() {
            this.update();
            this.interval = setInterval(() => this.update(), 1000);
        },

        update() {
            const now = new Date().getTime();
            const distance = this.end - now;

            if (distance < 0) {
                clearInterval(this.interval);
                this.time = 'EXPIRADO';
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            if (days > 0) {
                this.time = `${days}d ${hours}h ${minutes}m ${seconds}s`;
            } else {
                this.time = `${hours}h ${minutes}m ${seconds}s`;
            }
        }
    }));
});
</script>
@endpush
@endsection
