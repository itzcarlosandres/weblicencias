@extends('layouts.app')

@section('title', 'Blog y Tutoriales | TodoKeys')
@section('meta_description', 'Descubre las mejores guías, tutoriales y noticias sobre software y licencias digitales.')

@section('content')
<div class="bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-4">Blog y Tutoriales</h1>
            <p class="text-lg text-gray-500">Aprende a sacar el máximo provecho de tu software con nuestras guías expertas.</p>
        </div>

        @if($posts->isEmpty())
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6 text-gray-400">
                    <i class="fa-solid fa-newspaper text-4xl"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-2">Próximamente</h3>
                <p class="text-gray-500">Estamos preparando contenido increíble para ti.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <article class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group flex flex-col">
                        <a href="{{ route('blog.show', $post->slug) }}" class="block relative overflow-hidden aspect-video bg-gray-100">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-300">
                                    <i class="fa-solid fa-image text-4xl"></i>
                                </div>
                            @endif
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                                <span class="text-white font-bold flex items-center gap-2">Leer artículo <i class="fa-solid fa-arrow-right"></i></span>
                            </div>
                        </a>
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center gap-4 text-xs font-semibold text-gray-500 mb-4 uppercase tracking-wider">
                                <span><i class="fa-regular fa-calendar mr-1.5"></i> {{ $post->published_at->format('d M, Y') }}</span>
                                <span><i class="fa-regular fa-eye mr-1.5"></i> {{ $post->views_count }}</span>
                            </div>
                            <h2 class="text-xl font-extrabold text-gray-900 mb-3 leading-tight group-hover:text-blue-600 transition-colors">
                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                            </h2>
                            <p class="text-gray-600 line-clamp-3 mb-6 flex-1">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 120) }}
                            </p>
                            <div class="flex items-center gap-3 mt-auto pt-4 border-t border-gray-100">
                                @if($post->author && $post->author->avatar)
                                    <img src="{{ $post->author->avatar_url }}" alt="{{ $post->author->name }}" class="w-8 h-8 rounded-full">
                                @else
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-xs font-bold">
                                        {{ substr($post->author->name ?? 'A', 0, 1) }}
                                    </div>
                                @endif
                                <span class="text-sm font-semibold text-gray-900">{{ $post->author->name ?? 'Equipo TodoKeys' }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($posts->hasPages())
                <div class="mt-16 flex justify-center">
                    {{ $posts->links() }}
                </div>
            @endif
        @endif
    </div>
</div>
@endsection
