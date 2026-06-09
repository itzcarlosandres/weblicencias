@extends('layouts.admin')

@section('title', 'Editar Artículo | Panel de Administración')

@section('header')
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.blog.index') }}" class="w-10 h-10 bg-white border border-gray-200 rounded-xl flex items-center justify-center text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-colors">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 tracking-tight">Editar Artículo</h1>
        </div>
    </div>
@endsection

@section('content')
<form action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Título del Artículo *</label>
                    <input type="text" name="title" id="post-title" value="{{ old('title', $blog->title) }}" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Extracto Corto</label>
                    <textarea name="excerpt" id="post-excerpt" rows="2" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5">{{ old('excerpt', $blog->excerpt) }}</textarea>
                    @error('excerpt') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Contenido (HTML) *</label>
                    <textarea name="content" id="post-content" rows="15" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3.5 font-mono">{{ old('content', $blog->content) }}</textarea>
                    @error('content') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="space-y-6">
            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Publicación</h3>
                
                <label class="relative inline-flex items-center cursor-pointer mb-6">
                    <input type="checkbox" name="is_published" class="sr-only peer" {{ $blog->is_published ? 'checked' : '' }}>
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    <span class="ml-3 text-sm font-medium text-gray-700">Publicado</span>
                </label>

                <div class="w-full h-px bg-gray-100 my-4"></div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md flex items-center justify-center gap-2">
                    <i class="fa-solid fa-floppy-disk"></i> Actualizar Artículo
                </button>
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Imagen Destacada</h3>
                @if($blog->image)
                    <div class="mb-4">
                        <img src="{{ asset('storage/' . $blog->image) }}" class="w-full rounded-lg">
                    </div>
                @endif
                <input type="file" name="image" class="w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 mb-2">
                @error('image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white border border-gray-200 rounded-2xl p-6 shadow-sm">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Optimización SEO</h3>
                
                <div class="mb-4">
                    <label class="block text-xs font-bold text-gray-700 mb-2">Meta Título</label>
                    <input type="text" name="meta_title" id="post-meta-title" value="{{ old('meta_title', $blog->meta_title) }}" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-2">Meta Descripción</label>
                    <textarea name="meta_description" id="post-meta-description" rows="3" class="w-full bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-3">{{ old('meta_description', $blog->meta_description) }}</textarea>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
