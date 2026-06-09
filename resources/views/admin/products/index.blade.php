@extends('layouts.admin')

@section('title', 'Productos')
@section('header', 'Productos')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
        <p class="text-[13px] text-gray-400">Gestiona tu catálogo de productos</p>
    </div>
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nuevo Producto
    </a>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-4 mb-6">
    <form action="{{ route('admin.products.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
        <div class="flex-1 relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o SKU..." class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
        </div>
        <button type="submit" class="px-5 py-2.5 bg-gray-900 dark:bg-white text-white dark:text-gray-900 text-[13px] font-medium rounded-xl hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
            Buscar
        </button>
    </form>
</div>

<!-- Table -->
<div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800/60">
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Producto</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Categoría</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Precio</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Stock</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="text-right px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800/40">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors group">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-primary-50 dark:bg-primary-900/20 rounded-xl flex items-center justify-center text-lg shrink-0 group-hover:scale-110 transition-transform overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @elseif(isset($product->category->icon) && str_contains($product->category->icon, 'fa-'))
                                    <i class="{{ $product->category->icon }} text-primary-500"></i>
                                @else
                                    {{ $product->category->icon ?? '📦' }}
                                @endif
                            </div>
                            <div class="min-w-0">
                                <div class="text-[13px] font-semibold text-gray-900 dark:text-white truncate max-w-[200px]">{{ $product->name }}</div>
                                <div class="text-[11px] text-gray-400 font-mono">SKU: {{ $product->sku }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-medium bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400">
                            {{ $product->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-[13px] font-semibold text-gray-900 dark:text-white">{{ currency_format($product->price) }}</div>
                        @if($product->compare_price)
                        <div class="text-[11px] text-gray-400 line-through">{{ currency_format($product->compare_price) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($product->stock > 10)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400">{{ $product->stock }}</span>
                        @elseif($product->stock > 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-amber-50 text-amber-600 dark:bg-amber-900/20 dark:text-amber-400">{{ $product->stock }}</span>
                        @else
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[11px] font-semibold bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400">0</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        @if($product->is_active)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            Activo
                        </span>
                        @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-[11px] font-semibold bg-gray-100 text-gray-500 dark:bg-gray-800 dark:text-gray-400">
                            <span class="w-1.5 h-1.5 bg-gray-400 rounded-full"></span>
                            Inactivo
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex items-center justify-end gap-1">
                            <!-- Toggle Featured Form -->
                            <form action="{{ route('admin.products.toggle-featured', $product) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $product->is_featured ? 'text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20' : 'text-gray-400 hover:text-amber-500 hover:bg-amber-50 dark:hover:bg-amber-900/20' }} rounded-lg transition-all" title="{{ $product->is_featured ? 'Quitar destacado' : 'Destacar' }}">
                                    <svg class="w-4 h-4" fill="{{ $product->is_featured ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                </button>
                            </form>

                            <!-- Toggle Bundle Form -->
                            <form action="{{ route('admin.products.toggle-bundle', $product) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $product->is_bundle ? 'text-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20' : 'text-gray-400 hover:text-purple-500 hover:bg-purple-50 dark:hover:bg-purple-900/20' }} rounded-lg transition-all" title="{{ $product->is_bundle ? 'Quitar de Paquetes' : 'Añadir a Paquetes' }}">
                                    <svg class="w-4 h-4" fill="{{ $product->is_bundle ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                                </button>
                            </form>

                            <!-- Toggle BestSeller Form -->
                            <form action="{{ route('admin.products.toggle-bestseller', $product) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $product->is_bestseller ? 'text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20' : 'text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20' }} rounded-lg transition-all" title="{{ $product->is_bestseller ? 'Quitar de Más Vendidos' : 'Añadir a Más Vendidos' }}">
                                    <svg class="w-4 h-4" fill="{{ $product->is_bestseller ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                                </button>
                            </form>

                            <!-- Toggle Top Deal Form -->
                            <form action="{{ route('admin.products.toggle-topdeal', $product) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 {{ $product->is_top_deal ? 'text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20' : 'text-gray-400 hover:text-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/20' }} rounded-lg transition-all" title="{{ $product->is_top_deal ? 'Quitar de Top Ofertas' : 'Añadir a Top Ofertas' }}">
                                    <svg class="w-4 h-4" fill="{{ $product->is_top_deal ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"/></svg>
                                </button>
                            </form>

                            <a href="{{ route('admin.products.edit', $product) }}" class="p-2 text-gray-400 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-all" title="Editar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>

                            <!-- Delete Form -->
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all" title="Eliminar">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                        <p class="text-[14px] font-medium text-gray-500 dark:text-gray-400 mb-1">No hay productos</p>
                        <p class="text-[12px] text-gray-400 dark:text-gray-500">Crea tu primer producto para comenzar.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($products->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800/60">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection
