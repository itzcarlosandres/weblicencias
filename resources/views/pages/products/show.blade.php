@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name . ' | TodoKeys')
@section('description', $product->meta_description ?: Str::limit(strip_tags($product->description), 160))

@section('content')



<div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-[11px] text-gray-500 mb-6 font-medium uppercase tracking-wider">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Inicio</a>
        <span>></span>
        <a href="{{ route('products.index') }}" class="hover:text-blue-600 transition-colors">Productos</a>
        <span>></span>
        <a href="{{ route('products.index', ['category' => $product->category->slug]) }}" class="hover:text-blue-600 transition-colors">{{ $product->category->name }}</a>
        <span>></span>
        <span class="text-gray-900">{{ $product->name }}</span>
    </nav>

    <!-- Main Header -->
    <div class="mb-6 flex justify-between items-start">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 leading-tight max-w-4xl">{{ $product->name }} - GLOBAL</h1>
            <div class="flex items-center gap-4 text-sm text-gray-600">
                <div class="flex items-center gap-1">
                    <div class="flex text-yellow-400">
                        @php
                            $avgRating = $product->average_rating ?? 0;
                            $reviewsCount = $product->reviews()->where('is_approved', true)->count();
                            
                            if ($avgRating >= 4.5) $ratingText = 'Excelente';
                            elseif ($avgRating >= 4.0) $ratingText = 'Muy Bueno';
                            elseif ($avgRating >= 3.0) $ratingText = 'Bueno';
                            elseif ($avgRating > 0) $ratingText = 'Regular';
                            else $ratingText = 'Sin Calificar';
                        @endphp
                        
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <span class="font-bold text-gray-900">{{ $avgRating > 0 ? number_format($avgRating, 1) : '0.0' }}</span>
                </div>
                <span>({{ $reviewsCount }} reseñas)</span>
                <span class="text-gray-300">|</span>
                <span>{{ $ratingText }}</span>
            </div>
        </div>
        <livewire:wishlist-button :product="$product" :key="'wishlist-'.$product->id" class="p-2 border border-gray-200 rounded-full hover:bg-gray-100 transition-colors text-gray-400 group" />
    </div>

    <!-- 3 Column Layout -->
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Col 1: Image -->        <div class="w-full lg:w-[320px] shrink-0">
            <div class="relative rounded-2xl overflow-hidden shadow-sm border border-gray-200 bg-white aspect-[3/4] flex items-center justify-center">
                @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover">
                @else
                    <!-- Mockup de portada -->
                    <div class="absolute inset-0 bg-gradient-to-br from-indigo-900 to-purple-900 flex flex-col items-center justify-center p-6 text-center">
                        @if($product->brand && $product->brand->logo)
                            <img src="{{ asset('storage/' . $product->brand->logo) }}" class="w-20 h-20 object-contain mb-4 filter drop-shadow-lg">
                        @else
                            <div class="w-24 h-24 mb-4 bg-white/10 rounded-full flex items-center justify-center text-5xl backdrop-blur-sm border border-white/20">
                                {{ $product->category->icon ?? '🎮' }}
                            </div>
                        @endif
                        <h2 class="text-white font-black text-2xl uppercase tracking-widest leading-tight text-shadow-sm">{{ $product->name }}</h2>
                        <div class="mt-4 text-[10px] font-bold text-white/70 uppercase tracking-[0.2em]">{{ $product->platform ?? 'PC / GLOBAL' }}</div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Col 2: Info (Middle) -->
        <div class="flex-1 min-w-0">
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm mb-6">
                <!-- Detalles de activación grid -->
                <div class="grid grid-cols-2 gap-y-6 gap-x-4">
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <div class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider">Plataforma</div>
                            <div class="text-sm font-bold text-gray-900">{{ $product->brand->name ?? 'PC' }}</div>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
                        </div>
                        <div>
                            <div class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider">Puede activarse en</div>
                            <div class="text-sm font-bold text-green-600 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                {{ $product->region ?? 'Global' }}
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </div>
                        <div>
                            <div class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider">Tipo</div>
                            <div class="text-sm font-bold text-gray-900">{{ $product->activation_method ?? 'Digital Key' }}</div>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider">Entrega</div>
                            <div class="text-sm font-bold text-gray-900">{{ $product->delivery_time ?? 'Inmediata' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100 text-xs text-gray-500">
                    <p class="mb-1"><strong>Aviso:</strong> Este producto se entregará de forma digital. No recibirás ningún artículo físico en tu domicilio.</p>
                    <a href="#" class="text-blue-600 hover:underline">Comprobar requisitos del sistema</a>
                </div>
            </div>

            <!-- Ofertas de paquetes exclusivos (Dynamic Bundle) -->
            @php
                $bundleProduct = isset($relatedProducts) && $relatedProducts->count() > 0 
                                ? $relatedProducts->random() 
                                : \App\Models\Product::where('id', '!=', $product->id)->inRandomOrder()->first();
            @endphp
            
            @if($bundleProduct)
            <div class="flex items-center gap-3 mb-4 mt-10">
                <h3 class="text-lg font-bold text-gray-900">Ofertas de paquetes exclusivos</h3>
                <span class="inline-flex items-center gap-1 bg-gradient-to-r from-[#ff5e00] to-[#ff9100] text-white text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider animate-bounce shadow-lg shadow-orange-500/30">
                    <i class="fa-solid fa-fire"></i> ¡Hot Deal!
                </span>
            </div>
            
            <div class="bg-gradient-to-br from-white to-blue-50/50 rounded-[20px] border border-blue-100 p-5 shadow-sm flex flex-col sm:flex-row items-center justify-between mb-8 gap-6 group hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
                
                <div class="flex items-center gap-4 relative z-10 w-full sm:w-auto">
                    <div class="w-20 h-24 sm:w-24 sm:h-28 bg-white rounded-2xl flex items-center justify-center shrink-0 overflow-hidden relative shadow-[0_4px_15px_-3px_rgba(0,0,0,0.1)] border border-gray-100 p-1">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <i class="fa-solid fa-gamepad text-gray-300 text-3xl"></i>
                        @endif
                    </div>
                    <div class="text-3xl text-blue-400 font-light">+</div>
                    <div class="w-20 h-24 sm:w-24 sm:h-28 bg-white rounded-2xl flex items-center justify-center shrink-0 overflow-hidden relative shadow-[0_4px_15px_-3px_rgba(0,0,0,0.1)] border border-gray-100 p-1">
                        @if($bundleProduct->image)
                            <img src="{{ asset('storage/' . $bundleProduct->image) }}" class="w-full h-full object-cover rounded-xl">
                        @else
                            <i class="fa-solid fa-gamepad text-gray-300 text-3xl"></i>
                        @endif
                    </div>
                    <div class="ml-4 flex-1">
                        <div class="text-sm font-bold text-gray-900 leading-tight mb-1">{{ $product->name }} <br><span class="text-blue-600">+ {{ $bundleProduct->name }}</span></div>
                        <div class="text-[10px] text-green-700 font-black bg-green-100 px-2 py-0.5 rounded inline-block border border-green-200 uppercase tracking-wide">Ahorras extra 10%</div>
                    </div>
                </div>
                
                <div class="text-center sm:text-right w-full sm:w-auto relative z-10 shrink-0 border-t sm:border-t-0 sm:border-l border-gray-100 pt-4 sm:pt-0 sm:pl-6">
                    @php
                        $combinedPrice = $product->discounted_price + $bundleProduct->discounted_price;
                        $bundlePrice = $combinedPrice * 0.90; // 10% discount for the bundle
                    @endphp
                    <div class="text-xs text-gray-400 line-through font-medium mb-0.5">{{ currency_format($combinedPrice) }}</div>
                    <div class="text-2xl font-black text-blue-600 tracking-tight">{{ currency_format($bundlePrice) }}</div>
                    <button onclick="addBundleToCart(this, {{ $product->id }}, {{ $bundleProduct->id }})" class="mt-3 w-full px-6 py-2.5 bg-blue-600 text-white text-sm font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-600/30 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-cart-plus"></i> Añadir paquete
                    </button>
                </div>
            </div>
            @endif
        </div>

        <!-- Col 3: Buy Box (Right side) -->
        <div class="w-full lg:w-[320px] shrink-0">
            <div class="bg-white rounded-2xl border border-blue-200 shadow-[0_8px_30px_rgb(0,0,0,0.08)] p-6 sticky top-24">
                <div class="flex items-start justify-between mb-2">
                    <span class="inline-flex items-center gap-1 bg-purple-100 text-purple-700 text-xs font-bold px-2 py-1 rounded">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        Oferta Destacada
                    </span>
                    <div class="flex items-center gap-1.5 text-[11px] font-bold text-gray-500 bg-gray-50 px-2.5 py-1 rounded-md border border-gray-100">
                        <i class="fa-regular fa-eye text-blue-500"></i>
                        <span class="text-red-500">{{ rand(1, 10) }}</span> viéndolo
                    </div>
                </div>
                
                <div class="mb-6">
                    <div class="flex items-baseline gap-2">
                        <span class="text-3xl font-black text-gray-900">{{ currency_format($product->discounted_price) }}</span>
                        @if($product->has_discount)
                        <span class="text-sm text-gray-400 line-through">{{ currency_format($product->compare_price) }}</span>
                        <span class="text-xs font-bold text-red-500 bg-red-50 px-1.5 py-0.5 rounded">-{{ $product->discount }}%</span>
                        @endif
                    </div>
                </div>

                <div class="space-y-3 mb-6">
                    @if($product->stock > 0)
                    <button onclick="addToCart(this, {{ $product->id }})" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm py-3.5 px-4 rounded-xl transition-colors shadow-sm shadow-blue-600/30 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Añadir al carrito
                    </button>
                    @else
                    <div class="bg-red-50 text-red-600 p-3 rounded-lg text-sm font-bold text-center border border-red-100 mb-3">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> Agotado temporalmente
                    </div>
                    @if(session('success'))
                    <div class="bg-green-50 text-green-700 p-3 rounded-lg text-sm font-medium border border-green-100 mb-3 flex items-start gap-2 shadow-sm">
                        <i class="fa-solid fa-circle-check mt-0.5"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                    @else
                    <form action="{{ route('waitlist.store') }}" method="POST" class="mt-2">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <p class="text-[11px] text-gray-500 mb-2 font-medium">Déjanos tu email y te avisaremos cuando haya stock disponible:</p>
                        <div class="flex flex-col gap-2">
                            <input type="email" name="email" required placeholder="tu@email.com" value="{{ auth()->check() ? auth()->user()->email : '' }}" class="w-full border-gray-200 rounded-lg text-sm px-3 py-2.5 focus:border-blue-500 focus:ring-blue-500 shadow-sm">
                            <button type="submit" class="w-full bg-gray-900 hover:bg-gray-800 text-white font-bold text-sm py-2.5 px-4 rounded-lg transition-colors flex items-center justify-center gap-2">
                                <i class="fa-regular fa-bell"></i> Notificarme
                            </button>
                        </div>
                    </form>
                    @endif
                    @endif
                </div>

                <div class="pt-4 border-t border-gray-100 flex items-center justify-center gap-2 text-xs text-gray-500">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Pagos seguros
                    <span class="px-1 text-gray-300">•</span>
                    Entrega instantánea
                </div>
            </div>
            
            @if(isset($pointsEarned) && $pointsEarned > 0)
            <!-- Points Earned Banner -->
            <div class="mt-4 bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl shadow-sm p-4 text-white flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                    <!-- Icono de regalo animado que rebota -->
                    <svg class="w-6 h-6 text-yellow-100 animate-[bounce_2s_infinite]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                </div>
                <div>
                    <div class="font-bold text-sm">Gana {{ $pointsEarned }} puntos</div>
                    <div class="text-xs text-white/90 font-medium">con esta compra</div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Artículos destacados (Carousel Mockup) -->
    <div class="mt-16 mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Quizás también te interese...</h3>
            <div class="flex gap-2">
                <button class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:text-blue-600 shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></button>
                <button class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-400 hover:text-blue-600 shadow-sm"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg></button>
            </div>
        </div>
        
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-4">
            @foreach($relatedProducts as $relatedProduct)
            <a href="{{ route('products.show', $relatedProduct->slug) }}" class="group flex flex-col items-center text-center">
                <div class="w-20 h-24 sm:w-24 sm:h-28 bg-white rounded-2xl flex items-center justify-center shrink-0 overflow-hidden relative shadow-[0_4px_15px_-3px_rgba(0,0,0,0.1)] border border-gray-100 p-1.5 mb-2 group-hover:-translate-y-1 group-hover:shadow-[0_8px_20px_-5px_rgba(0,0,0,0.15)] transition-all">
                    @if($relatedProduct->image)
                        <img src="{{ asset('storage/' . $relatedProduct->image) }}" class="w-full h-full object-cover rounded-xl">
                    @else
                        <i class="fa-solid fa-gamepad text-gray-300 text-3xl"></i>
                    @endif
                </div>
                <h4 class="text-[11px] sm:text-xs font-bold text-gray-800 line-clamp-2 leading-tight group-hover:text-blue-600 transition-colors w-full px-1">{{ $relatedProduct->name }}</h4>
                <div class="text-[11px] sm:text-xs font-black text-gray-900 mt-1">{{ currency_format($relatedProduct->discounted_price) }}</div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Sobre este producto -->
    <div class="mt-16 bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Sobre este producto</h2>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex gap-4 mb-8">
                <div class="mt-1">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Importante</h4>
                    <p class="text-sm text-gray-700">Este producto es una clave digital global. No requiere VPN para su activación. Revisa los requisitos de tu cuenta antes de comprar.</p>
                </div>
            </div>

            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                {!! $product->description !!}
            </div>
        </div>
        

    </div>

    <!-- Reseñas -->
    <div class="mt-8 bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Reseñas de Clientes</h2>
        
        <div class="flex flex-col md:flex-row gap-10">
            <!-- Columna Izquierda: Estadísticas y Formulario -->
            <div class="w-full md:w-1/3 shrink-0">
                <div class="text-center md:text-left mb-6">
                    <div class="text-5xl font-black text-gray-900 mb-2">{{ number_format($product->average_rating ?? 5.0, 1) }}</div>
                    <div class="flex text-yellow-400 justify-center md:justify-start mb-2">
                        @for($i = 1; $i <= 5; $i++)
                        <svg class="w-5 h-5 {{ $i <= round($product->average_rating ?? 5) ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        @endfor
                    </div>
                    <div class="text-sm text-gray-500 font-medium">{{ $product->reviews()->where('is_approved', true)->count() }} valoraciones en total</div>
                </div>

                @auth
                    @php
                        $userHasReviewed = \App\Models\Review::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                    @endphp
                    @if(!$userHasReviewed)
                        <div class="bg-gray-50 p-5 rounded-xl border border-gray-100">
                            <h3 class="font-bold text-gray-900 mb-4">Escribe tu opinión</h3>
                            <form action="{{ route('customer.reviews.store', $product) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tu calificación</label>
                                    <div class="flex gap-1" x-data="{ rating: 5, hoverRating: 0 }">
                                        <input type="hidden" name="rating" x-model="rating">
                                        @for($i = 1; $i <= 5; $i++)
                                        <button type="button" 
                                            @click="rating = {{ $i }}" 
                                            @mouseenter="hoverRating = {{ $i }}" 
                                            @mouseleave="hoverRating = 0"
                                            class="focus:outline-none text-2xl transition-colors"
                                            :class="(hoverRating >= {{ $i }} || (hoverRating == 0 && rating >= {{ $i }})) ? 'text-yellow-400' : 'text-gray-300'">
                                            ★
                                        </button>
                                        @endfor
                                    </div>
                                    @error('rating') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Tu comentario</label>
                                    <textarea name="comment" rows="3" class="w-full bg-white border border-gray-200 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="¿Qué te pareció este producto?..." required minlength="10"></textarea>
                                    @error('comment') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Adjuntar imagen (Opcional)</label>
                                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    @error('image') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                                </div>
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg transition-colors text-sm">Publicar Reseña</button>
                            </form>
                        </div>
                    @else
                        <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm font-medium border border-green-100 text-center">
                            ¡Ya has publicado una reseña para este producto!
                        </div>
                    @endif
                @else
                    <div class="bg-blue-50 p-5 rounded-xl border border-blue-100 text-center">
                        <h3 class="font-bold text-gray-900 mb-2">¿Ya lo probaste?</h3>
                        <p class="text-sm text-gray-600 mb-4">Inicia sesión para compartir tu experiencia con otros usuarios.</p>
                        <a href="{{ route('login') }}" class="inline-block bg-white border border-gray-200 text-gray-800 hover:bg-gray-50 font-bold py-2 px-6 rounded-lg transition-colors text-sm">Iniciar Sesión</a>
                    </div>
                @endauth
            </div>
            
            <!-- Columna Derecha: Lista de Reseñas -->
            <div class="flex-1 w-full space-y-6">
                @php
                    $approvedReviews = $product->reviews()->with('user')->where('is_approved', true)->latest()->get();
                @endphp

                @forelse($approvedReviews as $review)
                <div class="border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                    <div class="flex items-start justify-between mb-2">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 font-bold flex items-center justify-center rounded-full uppercase">
                                {{ substr($review->user->name, 0, 2) }}
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 text-sm flex items-center gap-2">
                                    {{ $review->user->name }}
                                    @if($review->is_verified)
                                    <span class="bg-green-100 text-green-700 text-[10px] px-1.5 py-0.5 rounded uppercase font-black"><i class="fa-solid fa-check-circle"></i> Compra Verificada</span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="flex text-yellow-400 text-sm">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-700 text-sm leading-relaxed mt-3 pl-13">
                        {{ $review->comment }}
                    </p>
                    @if($review->image)
                    <div class="mt-3 pl-13">
                        <img src="{{ asset('storage/' . $review->image) }}" class="rounded-xl object-cover max-h-48 cursor-pointer hover:opacity-90 transition-opacity" onclick="window.open(this.src, '_blank')">
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-10 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                    <div class="text-4xl mb-3">⭐</div>
                    <h3 class="font-bold text-gray-900 mb-1">Aún no hay reseñas</h3>
                    <p class="text-sm text-gray-500">Sé el primero en calificar este producto.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script>
function addToCart(btn, productId) {
    const originalText = btn.innerHTML;
    btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Añadiendo...';
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
            // Check if Livewire is defined, if not dispatch standard event
            if (typeof Livewire !== 'undefined') {
                Livewire.dispatch('cartUpdated');
            }
            window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.count } }));
            
            btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> ¡Añadido!';
            btn.classList.add('bg-green-600', 'hover:bg-green-700');
            btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            
            setTimeout(() => {
                btn.innerHTML = originalText;
                btn.classList.remove('bg-green-600', 'hover:bg-green-700');
                btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                btn.disabled = false;
                // Optional: redirect to cart
                // window.location.href = '{{ route("cart.index") }}';
            }, 2000);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        btn.innerHTML = originalText;
        btn.disabled = false;
        alert('Hubo un problema al agregar el producto al carrito.');
    });
}

function addBundleToCart(btn, prod1, prod2) {
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Añadiendo...';
    btn.disabled = true;

    fetch('{{ route("cart.addBundle") }}', {
        method: 'POST',
        headers: { 
            'Content-Type': 'application/json', 
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, 
            'Accept': 'application/json', 
            'X-Requested-With': 'XMLHttpRequest' 
        },
        body: JSON.stringify({ product_id_1: prod1, product_id_2: prod2 })
    })
    .then(res => res.json())
    .then(data => {
        if (typeof Livewire !== 'undefined') Livewire.dispatch('cartUpdated');
        window.dispatchEvent(new CustomEvent('cart-updated', { detail: { count: data.count } }));
        
        btn.innerHTML = '<i class="fa-solid fa-check"></i> ¡Paquete Añadido!';
        btn.classList.add('bg-green-600', 'hover:bg-green-700');
        btn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
        
        setTimeout(() => {
            btn.innerHTML = originalText;
            btn.classList.remove('bg-green-600', 'hover:bg-green-700');
            btn.classList.add('bg-blue-600', 'hover:bg-blue-700');
            btn.disabled = false;
        }, 2000);
    }).catch(error => {
        console.error(error);
        btn.innerHTML = originalText;
        btn.disabled = false;
        alert('Hubo un problema al agregar el paquete al carrito.');
    });
}
</script>
@endpush
@endsection
