@extends('layouts.app')

@section('title', $post->meta_title ?? $post->title . ' | TodoKeys')
@section('meta_description', $post->meta_description ?? Str::limit(strip_tags($post->content), 160))

@section('content')
<div class="bg-white">
    <!-- Hero Section -->
    <div class="relative bg-gray-900 py-20 lg:py-32">
        @if($post->image)
            <div class="absolute inset-0 overflow-hidden">
                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover opacity-30">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
            </div>
        @endif
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="flex items-center justify-center gap-4 text-sm font-semibold text-gray-300 mb-6 uppercase tracking-widest">
                <span><i class="fa-regular fa-calendar mr-2"></i> {{ $post->published_at->format('d M, Y') }}</span>
                <span><i class="fa-regular fa-eye mr-2"></i> {{ $post->views_count }}</span>
            </div>
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white tracking-tight mb-6 leading-tight">
                {{ $post->title }}
            </h1>
            @if($post->excerpt)
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">{{ $post->excerpt }}</p>
            @endif
            
            <div class="flex items-center justify-center gap-4 mt-10">
                @if($post->author && $post->author->avatar)
                    <img src="{{ $post->author->avatar_url }}" alt="{{ $post->author->name }}" class="w-12 h-12 rounded-full border-2 border-white/20">
                @else
                    <div class="w-12 h-12 rounded-full bg-blue-600 border-2 border-white/20 text-white flex items-center justify-center font-bold">
                        {{ substr($post->author->name ?? 'A', 0, 1) }}
                    </div>
                @endif
                <div class="text-left">
                    <div class="font-bold text-white">{{ $post->author->name ?? 'Equipo TodoKeys' }}</div>
                    <div class="text-sm text-gray-400">Autor</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16 lg:py-24">
        <article class="prose prose-lg prose-blue max-w-none prose-headings:font-extrabold prose-headings:tracking-tight prose-a:text-blue-600 prose-img:rounded-2xl prose-img:shadow-lg">
            {!! $post->content !!}
        </article>

        <!-- CTA Box -->
        <div class="mt-16 bg-gradient-to-br from-blue-50 to-blue-100 rounded-3xl p-8 sm:p-12 text-center border border-blue-200">
            <h3 class="text-2xl font-extrabold text-gray-900 mb-4">¿Necesitas una licencia para tu equipo?</h3>
            <p class="text-gray-600 mb-8 max-w-2xl mx-auto">En TodoKeys ofrecemos licencias 100% originales, con entrega inmediata y garantía de por vida. Optimiza tu PC hoy mismo.</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 px-8 rounded-full transition-all shadow-lg hover:-translate-y-1">
                Ver Catálogo de Software <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->isNotEmpty())
        <div class="bg-gray-50 py-16 lg:py-24 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-12 text-center">Artículos Relacionados</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedPosts as $related)
                        <article class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
                            <a href="{{ route('blog.show', $related->slug) }}" class="block relative overflow-hidden aspect-video bg-gray-100">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @endif
                            </a>
                            <div class="p-6 flex-1 flex flex-col">
                                <h3 class="text-lg font-extrabold text-gray-900 mb-2 leading-tight group-hover:text-blue-600 transition-colors">
                                    <a href="{{ route('blog.show', $related->slug) }}">{{ $related->title }}</a>
                                </h3>
                                <p class="text-sm text-gray-500 line-clamp-2">
                                    {{ $related->excerpt ?? Str::limit(strip_tags($related->content), 100) }}
                                </p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
