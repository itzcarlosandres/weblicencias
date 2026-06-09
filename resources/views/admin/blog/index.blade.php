@extends('layouts.admin')

@section('title', 'Blog | Panel de Administración')

@section('header')
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Blog y Tutoriales</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gestiona los artículos y tutoriales SEO de la tienda.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.blog.create') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-5 rounded-xl transition-all shadow-sm">
                <i class="fa-solid fa-plus"></i> Nuevo Artículo
            </a>
        </div>
    </div>
@endsection

@section('content')
<div class="bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50/50 dark:bg-gray-700/50 border-b border-gray-200 dark:border-gray-700">
                <tr>
                    <th scope="col" class="px-6 py-4 font-bold">Artículo</th>
                    <th scope="col" class="px-6 py-4 font-bold">Estado</th>
                    <th scope="col" class="px-6 py-4 font-bold">Vistas</th>
                    <th scope="col" class="px-6 py-4 font-bold text-right">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($posts as $post)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-4">
                                @if($post->image)
                                    <img src="{{ asset('storage/' . $post->image) }}" class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-400 dark:text-gray-500">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                @endif
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $post->title }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $post->created_at->format('d M, Y') }} por {{ $post->author->name ?? 'Admin' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @if($post->is_published)
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400"></span> Publicado
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 dark:bg-amber-400"></span> Borrador
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                            {{ $post->views_count }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-gray-400 dark:text-gray-500 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors" title="Ver Artículo">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.blog.edit', $post) }}" class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-gray-400 dark:text-gray-500 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-amber-50 dark:hover:bg-amber-900/30 transition-colors" title="Editar">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de querer eliminar este artículo?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 inline-flex items-center justify-center rounded-lg text-gray-400 dark:text-gray-500 hover:text-red-600 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-colors" title="Eliminar">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mx-auto mb-3">
                                <i class="fa-solid fa-pen-nib text-2xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <p class="font-medium text-gray-900 dark:text-white mb-1">Aún no hay artículos</p>
                            <p class="text-sm">Escribe tu primer tutorial para mejorar el SEO.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
