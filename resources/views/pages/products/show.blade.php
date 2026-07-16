@extends('layouts.app')

@section('title', $product->meta_title ?: $product->name . ' | TodoKeys')
@section('description', $product->meta_description ?: Str::limit(strip_tags($product->description), 160))

@section('content')



@php
    $pageMaxWidth = \App\Models\Setting::get('product_page_max_width', 'max-w-7xl');
    $collapseHeight = (int) \App\Models\Setting::get('product_description_collapse_height', '200');
    $isCollapseEnabled = $collapseHeight > 0;
@endphp

<div class="{{ $pageMaxWidth }} mx-auto px-4 sm:px-6 lg:px-8 py-6">
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
                            $reviewsCount = $product->reviews->count();
                            $avgRating = $reviewsCount > 0 ? round($product->reviews->avg('rating'), 1) : 0.0;
                            
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
                    @php
                        $platformsRaw = $product->platform ?? '';
                        $platformList = array_filter(array_map('trim', explode(',', $platformsRaw)));

                        $getPlatformIcon = function(string $p, string $size = 'w-5 h-5'): string {
                            $k = strtolower($p);
                            return match(true) {
                                str_contains($k, 'window') => '<svg viewBox="0 0 24 24" fill="currentColor" class="'.$size.' text-[#0078D4]" title="Windows"><path d="M0 3.449L9.75 2.1v9.451H0m10.949-9.602L24 0v11.4H10.949M0 12.6h9.75v9.451L0 20.699M10.949 12.6H24V24l-12.9-1.801"/></svg>',
                                str_contains($k, 'mac') || str_contains($k, 'apple') => '<svg viewBox="0 0 24 24" fill="currentColor" class="'.$size.' text-gray-700" title="macOS"><path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701"/></svg>',
                                str_contains($k, 'android') => '<svg viewBox="0 0 24 24" fill="currentColor" class="'.$size.' text-[#3DDC84]" title="Android"><path d="M17.523 15.341c-.523 0-.946-.425-.946-.95s.423-.95.946-.95c.525 0 .95.425.95.95s-.425.95-.95.95m-11.046 0c-.525 0-.95-.425-.95-.95s.425-.95.95-.95c.523 0 .946.425.946.95s-.423.95-.946.95m11.404-6.461l1.896-3.285c.105-.18.045-.41-.133-.516-.18-.106-.41-.046-.517.133l-1.92 3.324C15.49 7.67 13.8 7.193 12 7.193c-1.8 0-3.49.477-4.207 1.343L5.873 5.212c-.106-.179-.337-.239-.517-.133-.178.106-.238.336-.133.516l1.896 3.285C4.976 10.092 3.808 12.006 3.808 14.05h16.384c0-2.044-1.168-3.958-2.311-5.17"/></svg>',
                                str_contains($k, 'ios') || str_contains($k, 'iphone') => '<svg viewBox="0 0 24 24" fill="currentColor" class="'.$size.' text-gray-500" title="iOS"><path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701"/></svg>',
                                str_contains($k, 'steam') => '<svg viewBox="0 0 24 24" fill="currentColor" class="'.$size.' text-[#1b2838]" title="Steam"><path d="M11.979 0C5.678 0 .511 4.86.022 11.037l6.432 2.658c.545-.371 1.203-.59 1.912-.59.063 0 .125.004.188.006l2.861-4.142V8.91c0-2.495 2.028-4.524 4.524-4.524 2.494 0 4.524 2.031 4.524 4.527s-2.03 4.525-4.524 4.525h-.105l-4.076 2.911c0 .052.004.105.004.159 0 1.875-1.515 3.396-3.39 3.396-1.635 0-3.016-1.173-3.331-2.727L.436 15.27C1.862 20.307 6.486 24 11.979 24c6.627 0 11.999-5.373 11.999-12S18.606 0 11.979 0z"/></svg>',
                                str_contains($k, 'playstation') || str_contains($k, 'ps4') || str_contains($k, 'ps5') => '<svg viewBox="0 0 24 24" fill="currentColor" class="'.$size.' text-[#003087]" title="PlayStation"><path d="M8.984 2.596v14.477l3.921 1.237V6.237c0-.78.34-1.31.882-1.145.71.23.852 1.014.852 1.794v5.268c2.416 1.246 4.228-.155 4.228-3.498 0-3.44-1.197-4.98-4.625-6.06-1.147-.353-3.138-.82-4.258-1.001M2.187 17.037c-1.201.693-1.254 1.676-.12 2.195l3.401 1.517c1.135.505 2.986.398 4.12-.243l7.864-4.568c1.201-.694 1.253-1.677.12-2.196l-3.402-1.516c-1.134-.507-2.985-.399-4.12.242l-7.863 4.569z"/></svg>',
                                str_contains($k, 'xbox') => '<svg viewBox="0 0 24 24" fill="currentColor" class="'.$size.' text-[#107C10]" title="Xbox"><path d="M4.102 4.104C5.877 2.293 8.065 1.16 10.37.785c-.812 1.028-1.616 2.27-2.217 3.661-.603 1.395-.98 2.852-1.081 4.212C5.663 7.09 4.668 5.537 4.102 4.104M3.386 5.07C2.35 6.696 1.74 8.58 1.68 10.6c.15 2.078.835 3.998 1.957 5.598.068-2.074.432-3.95.97-5.463.537-1.51 1.23-2.634 1.94-3.16-.505-.87-1.485-1.773-3.16-2.505M2.24 17.49c1.386 2.134 3.492 3.73 5.95 4.448-1.035-1.31-1.97-2.943-2.636-4.74-.533-1.464-.834-2.965-.903-4.343-1.03.947-1.808 2.625-2.411 4.635m8.384 4.822c.45.034.907.053 1.368.053.461 0 .918-.019 1.368-.053-1.368-1.217-1.368-3.527 0-4.744-.45.034-.907.053-1.368.053-.461 0-.918-.019-1.368-.053 1.368 1.217 1.368 3.527 0 4.744m5.214-.374c2.458-.718 4.564-2.314 5.95-4.448-.603-2.01-1.381-3.688-2.411-4.635-.069 1.378-.37 2.879-.903 4.343-.666 1.797-1.601 3.43-2.636 4.74m2.922-7.427c-.07 2.074-.433 3.95-.971 5.463-.536 1.51-1.23 2.634-1.94 3.16.506.87 1.485 1.773 3.16 2.505 1.037-1.626 1.647-3.51 1.707-5.53-.15-2.078-.835-3.998-1.956-5.598m-1.362-9.407c-1.675.732-2.655 1.635-3.16 2.505.71.526 1.403 1.65 1.94 3.16.538 1.513.902 3.39.97 5.463 1.122-1.6 1.807-3.52 1.957-5.598-.1-1.36-.477-2.817-1.08-4.212-.602-1.391-1.405-2.633-2.217-3.661M9.63.785C7.325 1.16 5.137 2.293 3.362 4.104c-.566 1.433-1.56 2.986-2.97 4.554 1.675-.732 2.655-1.635 3.16-2.505.71.526 1.403 1.65 1.94 3.16.538 1.513.902 3.39.97 5.463-1.122-1.6-1.807-3.52-1.957-5.598.1-1.36.477-2.817 1.08-4.212.602-1.391 1.405-2.633 2.217-3.661"/></svg>',
                                str_contains($k, 'linux') => '<svg viewBox="0 0 24 24" fill="currentColor" class="'.$size.' text-gray-800" title="Linux"><path d="M12.504 0c-.155 0-.315.008-.48.021C7.576.336 3.76 3.55 3.02 7.85c-.01.05-.02.1-.03.15-.009.05-.02.1-.027.153a7.77 7.77 0 0 0-.09 1.173c0 3.29 1.663 6.184 4.166 7.892-.47.336-.87.8-1.065 1.43-.254.845.025 1.87.737 2.568.71.7 1.737.949 2.616.64.55-.196 1.008-.585 1.26-1.073.238-.462.28-1.006.116-1.52.17.033.336.062.508.087a7.57 7.57 0 0 0 .93.065 8.02 8.02 0 0 0 .882-.05c.14.476.402.88.752 1.163a2.33 2.33 0 0 0 1.4.484c.317 0 .636-.065.934-.196.64-.276 1.094-.813 1.27-1.5.176-.688.02-1.42-.422-1.942.98-.5 1.842-1.226 2.511-2.118.56.04 1.06-.227 1.347-.684.27-.43.31-.97.11-1.456-.13-.312-.35-.59-.64-.785-.32-.21-.7-.3-1.1-.245.11-.5.17-1.01.17-1.53 0-4.187-3.408-7.59-7.617-7.59"/></svg>',
                                str_contains($k, 'multi') || str_contains($k, 'multiplat') => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="'.$size.' text-violet-500" title="Multiplataforma"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>',
                                default => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="'.$size.' text-gray-500"><path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
                            };
                        };
                    @endphp

                    {{-- Plataforma: ícono genérico a la izquierda, iconos de plataforma debajo del label --}}
                    <div class="flex gap-3">
                        {{-- Círculo izquierdo: ícono genérico de monitor/plataforma --}}
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100">
                            <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        {{-- Lado derecho: label + iconos de plataforma --}}
                        <div>
                            <div class="text-[11px] text-gray-500 font-semibold uppercase tracking-wider mb-1.5">Plataforma</div>
                            <div class="flex items-center gap-2 flex-wrap">
                                @if(count($platformList) > 0)
                                    @foreach($platformList as $pl)
                                        <span title="{{ $pl }}">{!! $getPlatformIcon($pl, 'w-5 h-5') !!}</span>
                                    @endforeach
                                @else
                                    {!! $getPlatformIcon('pc', 'w-5 h-5') !!}
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex gap-3">
                        <div class="w-10 h-10 rounded-full bg-gray-50 flex items-center justify-center shrink-0 border border-gray-100">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418" />
                            </svg>
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
                    <a href="javascript:void(0)" onclick="scrollToRequirements()" class="text-blue-600 hover:underline">Comprobar requisitos del sistema</a>
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
            
            <div class="bg-gradient-to-br from-white to-blue-50/50 rounded-[20px] border border-blue-100 p-4 shadow-sm flex items-center justify-between mb-8 gap-3 group hover:shadow-md transition-shadow relative overflow-hidden">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-500/10 rounded-full blur-2xl"></div>
                
                <div class="flex items-center gap-2.5 shrink-0 relative z-10">
                    <div class="w-12 h-16 bg-white rounded-lg flex items-center justify-center shrink-0 overflow-hidden relative shadow-sm border border-gray-100 p-0.5">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover rounded-md">
                        @else
                            <i class="fa-solid fa-gamepad text-gray-300 text-lg"></i>
                        @endif
                    </div>
                    <span class="text-base text-blue-400 font-medium shrink-0">+</span>
                    <div class="w-12 h-16 bg-white rounded-lg flex items-center justify-center shrink-0 overflow-hidden relative shadow-sm border border-gray-100 p-0.5">
                        @if($bundleProduct->image)
                            <img src="{{ asset('storage/' . $bundleProduct->image) }}" class="w-full h-full object-cover rounded-md">
                        @else
                            <i class="fa-solid fa-gamepad text-gray-300 text-lg"></i>
                        @endif
                    </div>
                </div>
                
                <div class="min-w-0 flex-1 relative z-10 px-3">
                    <div class="text-[12px] sm:text-[13px] font-bold text-gray-900 leading-snug mb-1 line-clamp-2" title="{{ $product->name }} + {{ $bundleProduct->name }}">
                        {{ $product->name }} <span class="text-blue-600">+ {{ $bundleProduct->name }}</span>
                    </div>
                    <div class="text-[9px] text-green-700 font-black bg-green-50 px-1.5 py-0.5 rounded border border-green-150 uppercase tracking-wide inline-block">
                        Ahorras 15%
                    </div>
                </div>
                
                <div class="flex flex-col items-end gap-2 shrink-0 relative z-10 pl-4 border-l border-blue-100/60 min-w-[100px]">
                    @php
                        $combinedPrice = $product->discounted_price + $bundleProduct->discounted_price;
                        $bundlePrice = $combinedPrice * 0.85; // 15% discount for the bundle
                    @endphp
                    <div class="text-right shrink-0">
                        <div class="text-[10px] text-gray-400 line-through font-medium leading-none mb-0.5">{{ currency_format($combinedPrice) }}</div>
                        <div class="text-[17px] font-black text-blue-600 tracking-tight leading-none">{{ currency_format($bundlePrice) }}</div>
                    </div>
                    <button onclick="addBundleToCart(this, {{ $product->id }}, {{ $bundleProduct->id }})" class="w-full px-3.5 py-1.5 bg-blue-600 text-white text-[11px] font-bold rounded-lg hover:bg-blue-700 shadow-md shadow-blue-600/10 transition-all hover:-translate-y-0.5 flex items-center justify-center gap-1 shrink-0">
                        <i class="fa-solid fa-cart-plus text-[10px]"></i> <span>Añadir</span>
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
                        @php
                            $strikePrice = ($product->compare_price && $product->compare_price > $product->price)
                                ? $product->compare_price
                                : null;
                            $pct = $product->effective_discount;
                        @endphp
                        @if($strikePrice)
                        <span class="text-sm text-gray-400 line-through">{{ currency_format($strikePrice) }}</span>
                        @endif
                        @if($pct > 0)
                        <span class="text-xs font-bold text-red-500 bg-red-50 px-1.5 py-0.5 rounded">-{{ round($pct) }}%</span>
                        @endif
                        @endif
                    </div>
                    
                    @php
                        $cashbackPercentage = (float) \App\Models\Setting::get('cashback_percentage', '3');
                        $cashbackAmount = $product->discounted_price * ($cashbackPercentage / 100);
                    @endphp
                    @if($cashbackAmount > 0)
                    <div class="mt-3 flex items-center gap-2.5 text-[12px] font-medium text-emerald-700 bg-emerald-50 px-3 py-2.5 rounded-xl border border-emerald-200/60 shadow-sm">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-wallet text-emerald-500 animate-[bounce_2s_infinite]"></i>
                        </div>
                        <div class="leading-tight">
                            Compra y gana <strong class="text-emerald-800 text-[13px]">${{ number_format($cashbackAmount, 2) }}</strong> de Cashback <span class="opacity-70 text-[10px]">({{ $cashbackPercentage }}%)</span>
                        </div>
                    </div>
                    @endif
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
    <div class="mt-16 bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm" x-data="{ expanded: false }">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Sobre este producto</h2>
            
            <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex gap-4 mb-8">
                <div class="mt-1">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-sm mb-1">Importante</h4>
                    <div class="text-sm text-gray-700 prose prose-sm max-w-none">
                        @if($product->important_note)
                            {!! $product->important_note !!}
                        @else
                            <p>Este producto es una clave digital global. No requiere VPN para su activación. Revisa los requisitos de tu cuenta antes de comprar.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Contenedor colapsable -->
            @if($isCollapseEnabled)
                <div class="relative transition-all duration-500 overflow-hidden" 
                     style="max-height: {{ $collapseHeight }}px;"
                     :style="expanded ? 'max-height: 10000px' : 'max-height: {{ $collapseHeight }}px'">
                    <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                        {!! $product->description !!}
                    </div>
                    
                    <!-- Degradado de desvanecimiento (Solo visible al estar colapsado) -->
                    <div class="absolute bottom-0 left-0 right-0 h-24 bg-gradient-to-t from-white via-white/90 to-transparent pointer-events-none transition-opacity duration-300"
                         style="opacity: 1;"
                         :style="expanded ? 'opacity: 0;' : 'opacity: 1;'"></div>
                </div>

                <!-- Botón Leer más / Leer menos -->
                <div class="mt-6 flex justify-center border-t border-gray-100 pt-4">
                    <button @click="expanded = !expanded" class="flex items-center gap-1.5 text-blue-600 hover:text-blue-700 font-bold text-sm transition-colors focus:outline-none">
                        <span x-text="expanded ? 'Leer menos' : 'Leer más'">Leer más</span>
                        <svg class="w-4 h-4 transition-transform duration-300" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                </div>
            @else
                <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed">
                    {!! $product->description !!}
                </div>
            @endif
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
                    <div class="text-sm text-gray-500 font-medium">{{ $product->reviews->count() }} valoraciones en total</div>
                </div>

                @auth
                    @php
                        $userHasReviewed = \App\Models\Review::where('user_id', auth()->id())->where('product_id', $product->id)->exists();
                        $hasPurchased = \App\Models\Order::where('user_id', auth()->id())
                            ->whereIn('status', ['paid', 'delivered', 'completed'])
                            ->whereHas('items', function ($q) use ($product) {
                                $q->where('product_id', $product->id);
                            })->exists();
                    @endphp
                    @if($userHasReviewed)
                        <div class="bg-green-50 text-green-700 p-4 rounded-xl text-sm font-medium border border-green-100 text-center">
                            ¡Ya has publicado una reseña para este producto!
                        </div>
                    @elseif(!$hasPurchased)
                        <div class="bg-yellow-50 text-yellow-700 p-4 rounded-xl text-sm font-medium border border-yellow-200 text-center">
                            <i class="fa-solid fa-lock mb-2 text-xl block"></i>
                            Solo los clientes que han comprado este producto pueden dejar una reseña.
                        </div>
                    @else
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
                    $approvedReviews = $product->reviews;
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

    <!-- Mobile Floating Add to Cart Bar -->
    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white/90 backdrop-blur-md border-t border-gray-200/80 shadow-[0_-8px_30px_rgba(0,0,0,0.08)] p-4 pb-[calc(1rem+env(safe-area-inset-bottom,0px))] z-50">
        <div class="flex items-center justify-between gap-4 max-w-7xl mx-auto">
            <div class="shrink-0">
                <div class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mb-0.5">Precio</div>
                <div class="text-xl font-black text-blue-600 leading-none">{{ currency_format($product->discounted_price) }}</div>
            </div>
            
            @if($product->stock > 0)
            <button onclick="addToCart(this, {{ $product->id }})" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold text-[15px] py-3.5 px-4 rounded-xl transition-all shadow-lg shadow-blue-600/20 flex items-center justify-center gap-2 active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Añadir al carrito
            </button>
            @else
            <div class="flex-1 bg-red-50 text-red-600 py-3.5 px-4 rounded-xl text-sm font-bold text-center border border-red-100">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i> Agotado
            </div>
            @endif
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

function scrollToRequirements() {
    let target = document.getElementById('requisitos-sistema') || document.getElementById('requisitos');
    
    if (!target) {
        const proseElements = document.querySelectorAll('.prose h2, .prose h3, .prose h4, .prose strong, .prose p');
        for (let el of proseElements) {
            if (el.textContent.toLowerCase().includes('requisitos')) {
                target = el;
                break;
            }
        }
    }
    
    if (!target) {
        target = document.querySelector('.prose');
    }
    
    if (target) {
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}
</script>
@endpush
@endsection
