@extends('layouts.app')

@section('title', $post->title . ' | TodoKeys')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="flex items-center gap-2 text-sm text-text-muted mb-8">
        <a href="{{ route('home') }}" class="hover:text-primary-500">Inicio</a>
        <span>/</span>
        <a href="{{ route('blog.index') }}" class="hover:text-primary-500">Blog</a>
        <span>/</span>
        <span class="text-text-primary dark:text-text-dark">{{ Str::limit($post->title, 40) }}</span>
    </nav>

    <article>
        <div class="aspect-video bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-800/30 dark:to-primary-700/30 rounded-3xl flex items-center justify-center mb-8">
            <svg class="w-16 h-16 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
            </svg>
        </div>

        <div class="flex items-center gap-4 mb-4">
            <span class="text-sm text-text-muted">{{ $post->published_at->format('d \d\e F, Y') }}</span>
            <span class="text-sm text-text-muted">•</span>
            <span class="text-sm text-text-muted">{{ $post->author->name }}</span>
        </div>

        <h1 class="text-3xl sm:text-4xl font-bold text-text-primary dark:text-text-dark mb-6">{{ $post->title }}</h1>

        <div class="prose prose-lg max-w-none text-text-secondary dark:prose-invert prose-headings:text-text-primary dark:prose-headings:text-text-dark prose-a:text-primary-500">
            {!! $post->content !!}
        </div>
    </article>

    @if($relatedPosts->count())
    <div class="mt-16 pt-8 border-t border-gray-100 dark:border-primary-800/50">
        <h2 class="text-2xl font-bold text-text-primary dark:text-text-dark mb-6">Artículos Relacionados</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedPosts as $related)
            <a href="{{ route('blog.show', $related->slug) }}" class="card group">
                <div class="aspect-video bg-gradient-to-br from-primary-100 to-primary-200 dark:from-primary-800/30 dark:to-primary-700/30 flex items-center justify-center">
                    <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                    </svg>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark text-sm line-clamp-2 group-hover:text-primary-500 transition-colors">{{ $related->title }}</h3>
                    <div class="text-xs text-text-muted mt-2">{{ $related->published_at->format('d M Y') }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
