<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::with('author')->latest()->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data = $request->except('image');
        $data['author_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);
        $data['is_published'] = $request->has('is_published');
        if ($data['is_published'] && !$request->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        BlogPost::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Artículo creado exitosamente.');
    }

    public function edit(BlogPost $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, BlogPost $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);
        $data['is_published'] = $request->has('is_published');
        if ($data['is_published'] && !$blog->published_at) {
            $data['published_at'] = now();
        }

        if ($request->hasFile('image')) {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $data['image'] = $request->file('image')->store('blog', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Artículo actualizado exitosamente.');
    }

    public function destroy(BlogPost $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Artículo eliminado.');
    }
}
