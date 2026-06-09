@extends('layouts.app')

@section('title', 'Blog | TodoKeys')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="flex items-center gap-2 text-sm text-text-muted mb-8">
        <a href="{{ route('home') }}" class="hover:text-primary-500">Inicio</a>
        <span>/</span>
        <span class="text-text-primary dark:text-text-dark">Blog</span>
    </nav>

    <h1 class="text-3xl font-bold text-text-primary dark:text-text-dark mb-8">Blog</h1>

    @if($posts->count())
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($posts as $post)
        <article class="card group">
            <div class="aspect-video bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-800/30 dark:to-primary-700/30 flex items-center justify-center">
                <svg class="w-12 h-12 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                </svg>
            </div>
            <div class="p-6">
                <div class="text-xs text-text-muted mb-2">{{ $post->published_at->format('d M Y') }}</div>
                <h2 class="font-semibold text-text-primary dark:text-text-dark mb-2 line-clamp-2">
                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-primary-500 transition-colors">{{ $post->title }}</a>
                </h2>
                <p class="text-sm text-text-secondary line-clamp-2 mb-4">{{ $post->excerpt }}</p>
                <a href="{{ route('blog.show', $post->slug) }}" class="text-sm font-medium text-primary-500 hover:text-primary-600">Leer más →</a>
            </div>
        </article>
        @endforeach
    </div>
    <div class="mt-10">
        {{ $posts->links() }}
    </div>
    @else
    <div class="text-center py-20">
        <h3 class="text-lg font-semibold text-text-primary dark:text-text-dark mb-2">No hay artículos</h3>
        <p class="text-text-secondary">Próximamente publicaremos contenido</p>
    </div>
    @endif
</div>
@endsection
