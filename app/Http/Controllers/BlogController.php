<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('author')
            ->published()
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('pages.blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = BlogPost::with('author')
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Incrementar vistas
        $post->increment('views_count');

        $relatedPosts = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Productos aleatorios para el widget
        $featuredProducts = \App\Models\Product::active()
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('pages.blog.show', compact('post', 'relatedPosts', 'featuredProducts'));
    }
}
