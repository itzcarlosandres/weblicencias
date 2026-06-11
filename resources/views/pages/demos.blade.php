@extends('layouts.app')

@section('content')

<div class="bg-black py-8 text-center border-b-4 border-yellow-400">
    <h1 class="text-3xl font-black text-white uppercase tracking-widest">Laboratorio de Diseño - Ofertas Destacadas</h1>
    <p class="text-yellow-400 mt-2 font-mono">8 variaciones no genéricas de UI</p>
</div>

<!-- VARIATION 1: CYBERPUNK EDGY -->
<section id="demo-1" class="py-24 bg-black relative border-b-8 border-yellow-400 overflow-hidden">
    <div class="max-w-[1600px] mx-auto px-4 relative z-10">
        <h2 class="text-4xl font-black text-white mb-12 uppercase tracking-tighter border-l-8 border-yellow-400 pl-6">Opción 1: Cyberpunk Edgy<br><span class="text-sm text-yellow-400 font-mono font-normal tracking-widest">Angles / Noise / Neon Glow</span></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts->take(4) as $product)
            <div class="group relative bg-[#0f0f0f] transition-all duration-300 hover:z-10" style="clip-path: polygon(10% 0, 100% 0, 100% 90%, 90% 100%, 0 100%, 0 10%);">
                <div class="absolute inset-0 bg-gradient-to-br from-yellow-400 to-red-600 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                <div class="absolute inset-[2px] bg-[#0f0f0f]" style="clip-path: polygon(10% 0, 100% 0, 100% 90%, 90% 100%, 0 100%, 0 10%);">
                    <div class="relative aspect-square overflow-hidden grayscale group-hover:grayscale-0 transition-all duration-500 mix-blend-luminosity group-hover:mix-blend-normal opacity-70 group-hover:opacity-100">
                        @if($product->image) <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover"> @else <div class="w-full h-full bg-slate-800 flex items-center justify-center text-4xl">🎮</div> @endif
                        <!-- Tech noise overlay -->
                        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0IiBoZWlnaHQ9IjQiPjxyZWN0IHdpZHRoPSI0IiBoZWlnaHQ9IjQiIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==')] pointer-events-none mix-blend-overlay"></div>
                    </div>
                    <div class="p-6 relative">
                        @if($product->has_discount && $product->effective_discount > 0)
                        <div class="absolute -top-4 right-4 bg-yellow-400 text-black font-black text-xs px-3 py-1 transform skew-x-12">
                            <span class="block transform -skew-x-12">-{{ round($product->effective_discount) }}%</span>
                        </div>
                        @endif
                        <h3 class="font-bold text-white uppercase tracking-wider mb-2 font-mono text-lg line-clamp-1">{{ $product->name }}</h3>
                        <div class="text-3xl font-black text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-red-500">{{ currency_format($product->discounted_price) }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- VARIATION 2: BRUTALIST E-SPORTS -->
<section id="demo-2" class="py-24 bg-white relative overflow-hidden border-b-8 border-black">
    <!-- Marquee -->
    <div class="absolute top-0 left-0 w-full overflow-hidden bg-[#ff4500] py-2 border-b-8 border-black z-10 flex space-x-8 whitespace-nowrap">
        @for($i=0; $i<10; $i++) <span class="text-black font-black uppercase text-2xl tracking-tighter">🔥 RAW DEALS // DROP ZONE 🔥</span> @endfor
    </div>
    <div class="max-w-[1600px] mx-auto px-4 mt-16">
        <h2 class="text-6xl lg:text-8xl font-black text-black mb-12 uppercase tracking-tighter leading-none">Opción 2:<br>Brutalist</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-0 border-8 border-black bg-black">
            @foreach($featuredProducts->take(3) as $product)
            <div class="group relative bg-white border-4 border-black hover:bg-[#ff4500] transition-colors duration-0 p-8 flex flex-col justify-between aspect-[4/5]">
                <div class="flex justify-between items-start mb-4">
                    <span class="text-black font-black text-6xl tracking-tighter block leading-none">0{{ $loop->iteration }}</span>
                    @if($product->has_discount && $product->effective_discount > 0)
                    <div class="border-4 border-black rounded-full px-4 py-2 text-black font-black transform -rotate-12 group-hover:bg-white text-xl">-{{ round($product->effective_discount) }}%</div>
                    @endif
                </div>
                <div class="w-full h-1/2 border-8 border-black bg-slate-100 overflow-hidden relative mb-6">
                    @if($product->image) <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover filter contrast-125 grayscale group-hover:grayscale-0 transition-all"> @else <div class="w-full h-full flex items-center justify-center text-6xl">🎮</div> @endif
                </div>
                <div>
                    <h3 class="font-black text-black text-4xl uppercase leading-none tracking-tighter line-clamp-2 mb-2">{{ $product->name }}</h3>
                    <div class="text-6xl font-black text-black">{{ currency_format($product->discounted_price) }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- VARIATION 3: HOLOGRAPHIC 3D -->
<style>
    .perspective-1000 { perspective: 1000px; }
    .preserve-3d { transform-style: preserve-3d; }
    .translate-z-12 { transform: translateZ(40px); }
</style>
<section id="demo-3" class="py-32 bg-[#050510] relative perspective-1000 overflow-hidden">
    <!-- Abstract Orbs -->
    <div class="absolute top-1/4 left-1/4 w-[500px] h-[500px] bg-blue-600/20 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-1/4 right-1/4 w-[400px] h-[400px] bg-purple-600/20 rounded-full blur-[100px]"></div>

    <div class="max-w-[1600px] mx-auto px-4 relative z-10">
        <h2 class="text-4xl font-light text-white mb-16 tracking-[0.2em] opacity-80 text-center">OPCIÓN 3: HOLOGRAPHIC 3D<br><span class="text-sm tracking-widest text-blue-400">Glassmorphism / Z-axis depth / Soft glows</span></h2>
        
        <div class="flex gap-8 overflow-x-auto pb-16 snap-x pt-8 px-8" style="scroll-snap-type: x mandatory;">
            @foreach($featuredProducts as $product)
            <div class="snap-center shrink-0 w-[320px] aspect-[2/3] group relative preserve-3d transition-transform duration-700 hover:-translate-y-8" style="transform: rotateY(10deg); cursor: pointer;" onmouseover="this.style.transform='rotateY(0deg) scale(1.05)'" onmouseout="this.style.transform='rotateY(10deg) scale(1)'">
                <!-- Glowing Aura -->
                <div class="absolute inset-0 bg-blue-500 rounded-[2.5rem] blur-[40px] opacity-0 group-hover:opacity-50 transition-opacity duration-700"></div>
                <!-- Glass Card -->
                <div class="absolute inset-0 bg-white/5 backdrop-blur-xl rounded-[2.5rem] border border-white/20 overflow-hidden preserve-3d shadow-[inset_0_0_20px_rgba(255,255,255,0.1)]">
                    @if($product->image) 
                        <img src="{{ asset('storage/' . $product->image) }}" class="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:opacity-100 transition-opacity duration-500"> 
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-[#050510] via-[#050510]/50 to-transparent"></div>
                    
                    <!-- Floating Content (Translates in Z-axis) -->
                    <div class="absolute bottom-0 left-0 w-full p-8 translate-z-12 transform transition-transform duration-500">
                        <div class="w-12 h-1 bg-blue-500 mb-6 rounded-full shadow-[0_0_15px_#3b82f6]"></div>
                        <h3 class="text-2xl font-bold text-white mb-2 leading-tight drop-shadow-xl">{{ $product->name }}</h3>
                        <div class="text-4xl font-light text-white drop-shadow-[0_0_15px_rgba(255,255,255,0.8)]">{{ currency_format($product->discounted_price) }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- VARIATION 4: HIGH-TECH HUD -->
<section id="demo-4" class="py-24 bg-[#0a0a0a] relative overflow-hidden font-mono border-y border-green-900/30">
    <div class="absolute inset-0 opacity-20" style="background-image: linear-gradient(rgba(0, 255, 0, 0.2) 1px, transparent 1px), linear-gradient(90deg, rgba(0, 255, 0, 0.2) 1px, transparent 1px); background-size: 40px 40px;"></div>
    <div class="max-w-[1600px] mx-auto px-4 relative z-10">
        <h2 class="text-3xl font-bold text-green-500 mb-12 tracking-widest uppercase flex flex-col gap-2">
            <span class="flex items-center gap-4"><span class="w-4 h-4 bg-green-500 animate-pulse"></span> Opción 4: HUD System</span>
            <span class="text-sm font-normal text-green-800 ml-8">System override / Terminal / Hacker aesthetic</span>
        </h2>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($featuredProducts->take(4) as $product)
            <div class="group relative bg-black/80 border border-green-900 hover:border-green-500 p-1 transition-colors duration-300 backdrop-blur-sm flex h-48">
                <div class="absolute top-0 left-0 w-3 h-3 border-t-2 border-l-2 border-green-500"></div>
                <div class="absolute bottom-0 right-0 w-3 h-3 border-b-2 border-r-2 border-green-500"></div>
                
                <div class="w-1/3 h-full relative overflow-hidden border-r border-green-900">
                    @if($product->image) <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover filter brightness-50 contrast-150 sepia-[.5] hue-rotate-[120deg] saturate-200 group-hover:brightness-100 transition-all duration-500"> @endif
                    <div class="absolute inset-0 bg-green-500/20 group-hover:bg-transparent transition-colors"></div>
                    <div class="absolute bottom-2 left-2 text-[10px] text-green-500">IMG_SYS.{{ rand(100,999) }}</div>
                </div>
                <div class="w-2/3 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs text-green-700 uppercase tracking-widest">[ID: {{ strtoupper(substr(md5($product->id), 0, 8)) }}]</span>
                            @if($product->has_discount && $product->effective_discount > 0)
                            <span class="text-xs bg-green-900/50 text-green-400 px-2 py-0.5 border border-green-700">-{{ round($product->effective_discount) }}%</span>
                            @endif
                        </div>
                        <h3 class="text-xl font-bold text-green-200 group-hover:text-green-400 transition-colors uppercase line-clamp-1">{{ $product->name }}</h3>
                    </div>
                    <div class="flex justify-between items-end">
                        <div class="text-3xl font-bold text-green-500">>{{ currency_format($product->discounted_price) }}<span class="animate-pulse">_</span></div>
                        <button class="text-xs uppercase tracking-widest border border-green-500 text-green-500 px-4 py-2 hover:bg-green-500 hover:text-black transition-colors">Ejecutar</button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- VARIATION 5: CINEMATIC LANDSCAPE -->
<section id="demo-5" class="py-24 bg-[#141414] relative">
    <div class="max-w-[1600px] mx-auto px-4">
        <h2 class="text-4xl font-bold text-white mb-12 border-l-4 border-red-600 pl-4">Opción 5: Cinematic Landscape<br><span class="text-sm font-normal text-slate-400">Estilo Netflix / Consola UI / Widescreen</span></h2>
        <div class="flex gap-6 overflow-x-auto pb-12 snap-x px-4" style="scroll-snap-type: x mandatory;">
            @foreach($featuredProducts as $product)
            <div class="snap-start shrink-0 w-[85vw] md:w-[600px] aspect-video group relative rounded-xl overflow-hidden cursor-pointer transform transition-transform duration-500 hover:scale-[1.02] hover:z-20 shadow-lg hover:shadow-2xl">
                @if($product->image) <img src="{{ asset('storage/' . $product->image) }}" class="absolute inset-0 w-full h-full object-cover"> @else <div class="absolute inset-0 bg-slate-800 flex items-center justify-center text-6xl">🎮</div> @endif
                <div class="absolute inset-0 bg-gradient-to-t from-[#141414] via-[#141414]/50 to-transparent opacity-90"></div>
                
                <div class="absolute bottom-0 left-0 right-0 p-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
                    <div class="w-full md:w-2/3">
                        <span class="px-2.5 py-1 bg-red-600 text-white text-[10px] font-bold rounded-sm mb-4 inline-block uppercase tracking-wider">Top Seller</span>
                        <h3 class="text-2xl lg:text-3xl font-bold text-white leading-tight drop-shadow-lg line-clamp-2">{{ $product->name }}</h3>
                    </div>
                    <div class="text-left md:text-right">
                        @if($product->has_discount)
                        <div class="text-sm text-slate-400 line-through">{{ currency_format($product->compare_price) }}</div>
                        @endif
                        <div class="text-3xl lg:text-4xl font-black text-white">{{ currency_format($product->discounted_price) }}</div>
                    </div>
                </div>

                <!-- Hover Play/Add Overlay -->
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-sm">
                    <div class="flex flex-col items-center transform translate-y-4 group-hover:translate-y-0 transition-transform duration-300 delay-100">
                        <div class="w-20 h-20 rounded-full bg-white text-black flex items-center justify-center mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <span class="text-white font-bold tracking-widest uppercase">Añadir al carrito</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- VARIATION 6: NEON GRID SYNTHWAVE -->
<section id="demo-6" class="py-24 bg-[#2b0f4c] relative overflow-hidden border-t-4 border-pink-500">
    <div class="absolute inset-0 bg-[linear-gradient(transparent_95%,rgba(255,0,255,0.3)_100%)] bg-[length:100%_40px]"></div>
    <div class="max-w-[1600px] mx-auto px-4 relative z-10">
        <h2 class="text-4xl font-black text-pink-500 mb-12 uppercase tracking-widest drop-shadow-[0_0_10px_rgba(236,72,153,0.8)]">Opción 6: Synthwave 80s<br><span class="text-sm font-normal text-cyan-400">Retro / Vaporwave / Wireframes</span></h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($featuredProducts->take(4) as $product)
            <div class="group relative bg-[#1a0b2e] border-2 border-pink-500 hover:border-cyan-400 p-4 transition-colors duration-300 shadow-[0_0_15px_rgba(236,72,153,0.5)] hover:shadow-[0_0_25px_rgba(34,211,238,0.8)]">
                <div class="aspect-square bg-black border border-pink-900 overflow-hidden relative mb-4">
                    @if($product->image) <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover mix-blend-screen opacity-80 group-hover:opacity-100 filter contrast-150 saturate-200 hue-rotate-30"> @endif
                </div>
                <h3 class="text-lg font-bold text-cyan-400 uppercase tracking-widest mb-2 line-clamp-1 drop-shadow-[0_0_5px_rgba(34,211,238,0.8)]">{{ $product->name }}</h3>
                <div class="text-2xl font-black text-yellow-400 drop-shadow-[0_0_10px_rgba(250,204,21,0.5)]">{{ currency_format($product->discounted_price) }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- VARIATION 7: STEALTH ULTRA-MINIMAL -->
<section id="demo-7" class="py-32 bg-[#050505] relative border-t border-[#111]">
    <div class="max-w-[1600px] mx-auto px-4 flex flex-col md:flex-row gap-16">
        <div class="w-full md:w-1/4">
            <h2 class="text-2xl font-normal text-white mb-4 tracking-[0.3em] uppercase">Opción 7<br>Stealth Ultra</h2>
            <p class="text-slate-600 text-sm tracking-widest leading-loose">Diseño extremadamente minimalista. Alto contraste. Tipografía elegante. Enfoque absoluto en la portada del producto. High-end fashion vibe.</p>
        </div>
        <div class="w-full md:w-3/4 grid grid-cols-1 md:grid-cols-3 gap-[1px] bg-white/10 border border-white/10">
            @foreach($featuredProducts->take(3) as $product)
            <div class="bg-[#050505] group p-8 hover:bg-[#0a0a0a] transition-colors duration-500">
                <div class="aspect-[3/4] overflow-hidden mb-8 opacity-60 group-hover:opacity-100 transition-opacity duration-500 filter grayscale group-hover:grayscale-0">
                    @if($product->image) <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover"> @else <div class="w-full h-full bg-[#111]"></div> @endif
                </div>
                <h3 class="text-white font-normal tracking-widest text-sm mb-4 line-clamp-2 uppercase">{{ $product->name }}</h3>
                <div class="flex justify-between items-center border-t border-white/10 pt-4">
                    <span class="text-slate-500 text-xs tracking-widest">USD</span>
                    <span class="text-white font-light text-xl">{{ currency_format($product->discounted_price) }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- VARIATION 8: URBAN / STREET ART -->
<section id="demo-8" class="py-32 bg-yellow-400 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] pointer-events-none"></div>
    <div class="max-w-[1600px] mx-auto px-4 relative z-10">
        <h2 class="text-5xl md:text-8xl font-black text-black mb-16 transform -rotate-2 origin-left inline-block bg-white px-8 py-2 border-4 border-black shadow-[8px_8px_0_#000]">OPCIÓN 8:<br>URBAN / STREET</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 pt-8">
            @foreach($featuredProducts->take(4) as $product)
            <div class="group relative transform hover:-translate-y-4 hover:rotate-3 transition-transform duration-300">
                <!-- Shadow block -->
                <div class="absolute inset-0 bg-black transform translate-x-4 translate-y-4"></div>
                <!-- Main card -->
                <div class="relative bg-white border-4 border-black p-4 h-full flex flex-col">
                    <div class="relative aspect-square border-4 border-black mb-4 overflow-hidden bg-fuchsia-500">
                        @if($product->image) <img src="{{ asset('storage/' . $product->image) }}" class="w-full h-full object-cover filter contrast-125 saturate-150 mix-blend-multiply group-hover:mix-blend-normal transition-all"> @endif
                        @if($product->has_discount && $product->effective_discount > 0)
                        <div class="absolute -right-6 top-6 bg-cyan-400 text-black font-black text-xl px-12 py-2 transform rotate-45 border-y-4 border-black shadow-[0_4px_0_#000]">
                            -{{ round($product->effective_discount) }}%
                        </div>
                        @endif
                    </div>
                    <h3 class="text-xl lg:text-2xl font-black text-black uppercase leading-tight mb-4 line-clamp-2">{{ $product->name }}</h3>
                    <div class="mt-auto pt-4 border-t-4 border-black flex justify-between items-center">
                        <span class="text-3xl lg:text-4xl font-black text-fuchsia-600 drop-shadow-[2px_2px_0_#000]">{{ currency_format($product->discounted_price) }}</span>
                        <div class="w-12 h-12 bg-black text-yellow-400 flex items-center justify-center rounded-full hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
