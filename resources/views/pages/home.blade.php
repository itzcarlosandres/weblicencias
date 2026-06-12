@extends('layouts.app')
@section('content')

<!-- Forzar tema claro en el body de esta vista (G2A Clone) -->
<style>
    body { background-color: #f5f5f5 !important; color: #333 !important; }
    
    /* Sliding Grid Animation */
    @keyframes gridSlide {
        0% { background-position: 0 0; }
        100% { background-position: 40px 40px; }
    }
    .animate-grid-slide {
        animation: gridSlide 3s linear infinite;
    }
</style>

<!-- Hero Section (Split Dark Matte) -->
<section class="relative bg-[#09090b] pt-16 pb-24 lg:pt-20 lg:pb-32 overflow-hidden hidden md:block border-b border-zinc-900">
    <!-- Grid Pattern Background -->
    <div class="absolute inset-0 opacity-[0.02] animate-grid-slide" style="background-image: linear-gradient(to right, #ffffff 1px, transparent 1px), linear-gradient(to bottom, #ffffff 1px, transparent 1px); background-size: 40px 40px;"></div>
    
    <div class="max-w-[1440px] mx-auto px-4 relative z-10">
        <div class="flex flex-col lg:flex-row gap-12 lg:gap-16 items-center">
            
            <!-- Text Side -->
            <div class="w-full lg:w-5/12 flex flex-col">
                <div class="inline-flex items-center gap-2 mb-6">
                    <span class="px-3 py-1.5 rounded-full bg-amber-500/10 text-amber-500 text-[11px] font-bold tracking-wider uppercase border border-amber-500/20 flex items-center gap-2">
                        <i class="fa-solid fa-bolt"></i> {{ App\Models\Setting::get('hero_badge', 'Entrega Instantánea') }}
                    </span>
                </div>
                <h2 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-6 leading-tight tracking-tight" style="font-family: 'Bricolage Grotesque', sans-serif;">
                    {{ App\Models\Setting::get('hero_title', 'Software original.') }}<br>
                    <span class="text-zinc-600">{{ App\Models\Setting::get('hero_subtitle', 'Fracción del precio.') }}</span>
                </h2>
                
                <p class="text-zinc-400 mb-8 text-lg font-light max-w-md leading-relaxed">
                    {{ App\Models\Setting::get('hero_description', 'Obtén la última versión de Windows, Office y otras herramientas con todas las características profesionales desbloqueadas.') }}
                </p>
                
                <ul class="space-y-4 mb-10 text-zinc-300">
                    <li class="flex items-center gap-3"><i class="fa-solid fa-circle-check text-amber-500"></i> {{ App\Models\Setting::get('hero_feature_1', 'Activación permanente') }}</li>
                    <li class="flex items-center gap-3"><i class="fa-solid fa-circle-check text-amber-500"></i> {{ App\Models\Setting::get('hero_feature_2', 'Claves 100% originales') }}</li>
                    <li class="flex items-center gap-3"><i class="fa-solid fa-circle-check text-amber-500"></i> {{ App\Models\Setting::get('hero_feature_3', 'Soporte garantizado') }}</li>
                </ul>
            </div>

            <!-- Featured Products Side -->
            <div class="w-full lg:w-7/12 relative">
                <!-- Background decoration for the grid -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-3/4 h-3/4 bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>
                
                <div class="grid grid-cols-2 gap-4 sm:gap-5 relative z-10">
                    @foreach($featuredProducts->take(4) as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="group relative bg-zinc-900/60 backdrop-blur-md border border-zinc-800/80 hover:border-amber-500/40 rounded-[20px] p-5 transition-all duration-500 flex flex-col hover:shadow-[0_10px_40px_rgba(245,158,11,0.08)] hover:-translate-y-1">
                        <div class="flex items-start gap-4">
                            <div class="w-20 h-20 shrink-0 bg-zinc-950 rounded-2xl overflow-hidden border border-zinc-800 relative shadow-inner">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-3xl">🎮</div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0 pt-0.5">
                                <span class="text-[10px] font-black text-amber-500 uppercase tracking-widest mb-1.5 block">Destacado</span>
                                <h3 class="text-zinc-100 font-bold text-sm sm:text-[15px] mb-2 line-clamp-2 leading-snug group-hover:text-amber-400 transition-colors">{{ $product->name }}</h3>
                                <div class="flex items-end gap-2 mt-auto">
                                    <span class="text-white font-black text-xl tracking-tight">{{ currency_format($product->discounted_price) }}</span>
                                    @if($product->has_discount)
                                        <span class="text-zinc-600 text-[11px] line-through font-medium mb-1">{{ currency_format($product->compare_price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Categories Strip (Marcas) - Floating Over Hero -->
<style>
    .brands-scroll::-webkit-scrollbar { height: 4px; }
    .brands-scroll::-webkit-scrollbar-track { background: #e5e7eb; border-radius: 99px; }
    .brands-scroll::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 99px; }
    @media (min-width: 768px) {
        .brands-scroll::-webkit-scrollbar { height: 0; }
    }
</style>
<div class="max-w-[1440px] mx-auto px-4 relative z-30 mt-6 md:-mt-16">
    <div class="relative">
        {{-- Gradient fade on right edge (mobile only) --}}
        <div class="absolute right-0 top-0 bottom-4 w-16 bg-gradient-to-l from-white/95 to-transparent z-10 rounded-r-3xl pointer-events-none md:hidden"></div>
        {{-- Swipe hint arrow --}}
        <div class="absolute right-3 top-1/2 -translate-y-1/2 z-20 flex items-center gap-1 text-blue-400 md:hidden" style="margin-top:-8px">
            <span class="text-[10px] font-bold uppercase tracking-wider opacity-70">ver</span>
            <svg class="w-4 h-4 animate-pulse" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        <div class="brands-scroll bg-white/80 backdrop-blur-xl rounded-3xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white flex items-center justify-between overflow-x-auto gap-8 px-6 py-6 sm:px-10 pb-5">
            @if(isset($brands) && $brands->count() > 0)
                @foreach($brands as $brand)
                <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="flex flex-col items-center gap-3 min-w-[80px] group">
                    <div class="w-16 h-16 sm:w-16 sm:h-16 rounded-2xl border border-gray-100 bg-white shadow-sm flex items-center justify-center p-3 sm:p-4 group-hover:border-blue-400 group-hover:shadow-[0_8px_25px_rgba(37,99,235,0.15)] group-hover:-translate-y-1 transition-all duration-300 relative overflow-hidden">
                        <div class="absolute inset-0 bg-blue-50 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                        @if($brand->icon)
                            <i class="{{ $brand->icon }} text-2xl text-blue-500 relative z-10 group-hover:scale-110 transition-transform duration-300"></i>
                        @elseif($brand->logo)
                            <img src="{{ asset('storage/' . $brand->logo) }}" class="w-full h-full object-contain relative z-10 group-hover:scale-110 transition-transform duration-300">
                        @else
                            <span class="text-sm font-black text-gray-500 relative z-10">{{ substr($brand->name, 0, 2) }}</span>
                        @endif
                    </div>
                    <span class="text-[11px] sm:text-[12px] font-black text-gray-800 uppercase tracking-wider group-hover:text-blue-600 transition-colors">{{ $brand->name }}</span>
                </a>
                @endforeach
            @else
                <!-- Placeholder if no brands exist -->
                <div class="w-full text-center text-gray-500 text-sm">No hay marcas configuradas.</div>
            @endif
        </div>
    </div>
</div>

<!-- Main Content Area -->
<div class="max-w-[1440px] mx-auto px-4 py-12 flex gap-8">
    
    <!-- Center Content -->
    <div class="flex-1 min-w-0">
        
        <!-- Flash Sales Banner -->
        @php
            $hasFlashSales = \App\Models\Product::where('is_active', true)->where('is_flash_sale', true)->whereNotNull('flash_sale_end')->where('flash_sale_end', '>', now())->exists();
        @endphp
        @if($hasFlashSales)
        <a href="{{ route('products.flash-sales') }}" class="block mb-10 rounded-2xl p-1 shadow-lg shadow-blue-500/20 hover:shadow-blue-500/40 hover:-translate-y-1 transition-all group overflow-hidden relative" style="background: linear-gradient(to right, #3b82f6, #2563eb, #1d4ed8);">
            <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20"></div>
            <div class="backdrop-blur-sm rounded-xl py-4 px-6 md:px-10 flex flex-col md:flex-row items-center justify-between gap-4 relative z-10" style="background-color: rgba(10, 10, 10, 0.95);">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-500/20 text-blue-400 rounded-full flex items-center justify-center text-xl shadow-inner border border-blue-500/30">
                        <i class="fa-solid fa-bolt animate-bounce" style="color: #60a5fa;"></i>
                    </div>
                    <div>
                        <h3 class="text-white font-black text-lg tracking-wide uppercase group-hover:text-blue-400 transition-colors">Ofertas Flash en Curso</h3>
                        <p class="text-sm" style="color: #9ca3af;">Descuentos extremos por tiempo limitado. ¡No te lo pierdas!</p>
                    </div>
                </div>
                <div class="flex-shrink-0 px-6 py-2 rounded-full font-black text-sm uppercase tracking-wider group-hover:scale-105 transition-all shadow-md" style="background-color: #2563eb; color: white;">
                    Ver Ofertas
                </div>
            </div>
        </a>
        @endif
        
        <!-- Section: Top Ofertas -->
        @if($topDeals->count() > 0)
        <div id="deals" class="mb-14 scroll-mt-24">
            <div class="flex items-center justify-between mb-5">
                <div class="flex items-center gap-3">
                    <h2 class="text-2xl font-black text-gray-900 tracking-tight">Top Ofertas</h2>
                    <span class="bg-red-500 text-white text-[10px] font-black uppercase tracking-wider px-2 py-0.5 rounded shadow-sm">Hasta 15% OFF</span>
                </div>
            </div>

            <!-- Top Deals Layout: Hero + Grid -->
            <div class="flex flex-col lg:flex-row gap-4">
                
                @if($topDeals->first())
                <!-- Small Hero (First Item) -->
                <div class="w-full lg:w-1/3 shrink-0">
                    <a href="{{ route('products.show', $topDeals->first()->slug) }}" class="block h-full bg-gradient-to-br from-gray-900 to-[#12141d] rounded-2xl p-6 relative overflow-hidden group hover:shadow-xl hover:shadow-blue-500/10 transition-all border border-gray-800">
                        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] opacity-20 group-hover:scale-105 transition-transform duration-700"></div>
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/20 blur-3xl rounded-full"></div>
                        
                        <div class="relative z-10 flex flex-col h-full">
                            <span class="inline-block bg-blue-600 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest w-fit mb-6">Promoción Estrella</span>
                            
                            <div class="w-32 h-32 mx-auto bg-white/5 rounded-2xl border border-white/10 flex items-center justify-center p-4 shadow-2xl mb-6 group-hover:-translate-y-2 transition-transform duration-500">
                                @if($topDeals->first()->image)
                                    <img src="{{ asset('storage/' . $topDeals->first()->image) }}" class="w-full h-full object-contain drop-shadow-xl">
                                @else
                                    <i class="fa-solid fa-fire text-5xl text-blue-500"></i>
                                @endif
                            </div>

                            <div class="mt-auto">
                                <h3 class="text-white font-bold text-lg leading-tight mb-3 line-clamp-2">{{ $topDeals->first()->name }}</h3>
                                <div class="flex items-end justify-between">
                                    <div>
                                        <div class="text-gray-400 text-xs line-through mb-0.5">{{ currency_format($topDeals->first()->price) }}</div>
                                        <div class="text-blue-400 font-black text-2xl">{{ currency_format($topDeals->first()->discounted_price) }}</div>
                                    </div>
                                    <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-white group-hover:bg-blue-600 transition-colors">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endif

                <!-- Small Grid for the rest -->
                <div class="flex-1 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach($topDeals->skip(1)->take(8) as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="bg-white rounded-xl border border-gray-200 hover:border-blue-300 hover:shadow-lg p-3 flex flex-col group transition-all relative overflow-hidden">
                        <!-- Discount Badge -->
                        @if($product->effective_discount > 0)
                        <div class="absolute top-2 left-2 bg-red-500 text-white text-[9px] font-black px-1.5 py-0.5 rounded shadow-sm z-10">
                            -{{ $product->effective_discount }}%
                        </div>
                        @endif

                        <div class="w-full aspect-square bg-gray-50 rounded-lg mb-3 flex items-center justify-center overflow-hidden">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            @else
                                <i class="fa-solid fa-box text-3xl text-gray-300"></i>
                            @endif
                        </div>
                        <div class="mt-auto">
                            <h4 class="text-xs font-bold text-gray-800 line-clamp-2 mb-2 group-hover:text-blue-600 transition-colors">{{ $product->name }}</h4>
                            <div class="flex items-center gap-1.5">
                                <span class="text-sm font-black text-gray-900">{{ currency_format($product->discounted_price) }}</span>
                                <span class="text-[9px] text-gray-400 line-through">{{ currency_format($product->price) }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

            </div>
        </div>
        @endif

        <!-- Section: Últimos descubiertos -->
        <div class="mb-14">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-xl font-bold text-gray-900">Últimos descubiertos</h2>
                <a href="{{ route('products.index') }}" class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-full hover:bg-blue-100 transition-colors">Mostrar más</a>
            </div>
            <div class="grid {{ $gridClass }} gap-3 sm:gap-4">
                @foreach($latestProducts as $product)
                <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>

        <!-- Section: Ofertas de paquetes exclusivos -->
        <div class="mb-14">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-xl font-bold text-gray-900">Ofertas de paquetes exclusivos</h2>
                <a href="{{ route('products.index') }}" class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-full hover:bg-blue-100 transition-colors">Mostrar más</a>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                @foreach($bundleProducts as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 flex gap-4 hover:shadow-lg transition-shadow cursor-pointer group">
                    <div class="w-24 h-24 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg flex-shrink-0 flex items-center justify-center text-white font-black text-3xl shadow-inner relative overflow-hidden">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                        @else
                            X5
                        @endif
                        <div class="absolute inset-0 bg-white/20 transform -skew-x-12 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
                    </div>
                    <div class="flex-1 flex flex-col justify-center">
                        <div class="text-[10px] font-bold text-purple-600 mb-1 uppercase tracking-wider bg-purple-50 inline-block px-2 py-0.5 rounded w-fit">Paquete</div>
                        <h3 class="text-sm font-bold text-gray-900 line-clamp-2 mb-2 group-hover:text-blue-600 transition-colors">{{ $product->name }}</h3>
                        <div class="flex items-center gap-2">
                            @if($product->has_discount && $product->effective_discount > 0)
                            <span class="bg-[#f48024] text-white text-[10px] font-bold px-1.5 py-0.5 rounded shadow-sm">-{{ round($product->effective_discount) }}%</span>
                            @endif
                            <div class="text-lg font-black text-gray-900">{{ currency_format($product->discounted_price) }}</div>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Section: Los más vendidos -->
        <div class="mb-14">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-xl font-bold text-gray-900">Los más vendidos</h2>
                <a href="{{ route('products.index', ['sort' => 'best_selling']) }}" class="text-xs font-bold text-blue-600 bg-blue-50 px-4 py-2 rounded-full hover:bg-blue-100 transition-colors">Mostrar más</a>
            </div>
            <div class="grid {{ $gridClass }} gap-3 sm:gap-4">
                @foreach($bestsellerProducts as $product)
                <x-product-card :product="$product" :badge="'#' . $loop->iteration . ' HOT'" />
                @endforeach
            </div>
        </div>

        <!-- Section: ¿Cuál es tu presupuesto? -->
        <div class="mb-14">
            <h2 class="text-xl font-bold text-gray-900 mb-5">¿Cuál es tu presupuesto?</h2>
            <div class="flex gap-4 overflow-x-auto hide-scrollbar pb-4">
                <a href="{{ route('products.index', ['max_price' => 5]) }}" class="min-w-[140px] flex-1 bg-white border-2 border-blue-500 rounded-xl px-6 py-4 text-center group hover:bg-blue-500 transition-colors shadow-sm">
                    <span class="text-blue-600 font-black text-lg group-hover:text-white transition-colors block">HASTA $5</span>
                </a>
                <a href="{{ route('products.index', ['max_price' => 10]) }}" class="min-w-[140px] flex-1 bg-white border-2 border-blue-500 rounded-xl px-6 py-4 text-center group hover:bg-blue-500 transition-colors shadow-sm">
                    <span class="text-blue-600 font-black text-lg group-hover:text-white transition-colors block">HASTA $10</span>
                </a>
                <a href="{{ route('products.index', ['max_price' => 15]) }}" class="min-w-[140px] flex-1 bg-white border-2 border-blue-500 rounded-xl px-6 py-4 text-center group hover:bg-blue-500 transition-colors shadow-sm">
                    <span class="text-blue-600 font-black text-lg group-hover:text-white transition-colors block">HASTA $15</span>
                </a>
                <a href="{{ route('products.index', ['max_price' => 20]) }}" class="min-w-[140px] flex-1 bg-white border-2 border-blue-500 rounded-xl px-6 py-4 text-center group hover:bg-blue-500 transition-colors shadow-sm">
                    <span class="text-blue-600 font-black text-lg group-hover:text-white transition-colors block">HASTA $20</span>
                </a>
                <a href="{{ route('products.index', ['min_price' => 20]) }}" class="min-w-[140px] flex-1 bg-white border-2 border-blue-500 rounded-xl px-6 py-4 text-center group hover:bg-blue-500 transition-colors shadow-sm">
                    <span class="text-blue-600 font-black text-lg group-hover:text-white transition-colors block">MÁS DE $20</span>
                </a>
            </div>
        </div>

    </div>



</div>




<!-- FAQ Section -->
<div class="bg-white py-20 border-t border-gray-200">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">FAQ</h2>
        <div class="space-y-4">
            @php
                $faqs = [
                    '¿Qué es TodoKeys y por qué lo necesito?' => 'TodoKeys es el marketplace líder en licencias de software y videojuegos digitales. Ofrecemos los mejores precios del mercado conectando vendedores verificados con compradores en todo el mundo.',
                    '¿Es seguro comprar claves de software aquí?' => 'Totalmente seguro. Todas nuestras transacciones están encriptadas y garantizamos que las claves provienen de fuentes legítimas. Además, contamos con una garantía de reembolso en caso de que la clave no funcione.',
                    '¿Cómo activo mi clave de producto tras la compra?' => 'Recibirás las instrucciones detalladas de activación junto con la clave en tu correo electrónico de confirmación, inmediatamente después de la compra. También puedes consultarlas en tu panel de usuario.',
                    '¿Qué pasa si mi clave no funciona?' => 'Nuestro soporte está disponible 24/7. Si una clave resulta ser defectuosa, te la reemplazaremos inmediatamente o procesaremos un reembolso.',
                    '¿Se aplican impuestos adicionales al precio final?' => 'No, todos los precios mostrados en el catálogo incluyen impuestos, por lo que el precio que ves es el precio final que pagarás.'
                ];
            @endphp
            @foreach($faqs as $question => $answer)
            <details class="group bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-xl cursor-pointer transition-colors">
                <summary class="flex justify-between items-center font-bold p-5 text-gray-800 list-none text-sm">
                    <span>{{ $question }}</span>
                    <span class="transition-transform duration-300 group-open:rotate-180 text-blue-600">
                        <svg fill="none" height="24" shape-rendering="geometricPrecision" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" width="24"><path d="M6 9l6 6 6-6"></path></svg>
                    </span>
                </summary>
                <div class="p-5 pt-0 text-sm text-gray-600 leading-relaxed border-t border-gray-200 mt-2">
                    {{ $answer }}
                </div>
            </details>
            @endforeach
        </div>
    </div>
</div>

@endsection
