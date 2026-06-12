@extends('layouts.app')

@section('title', 'Productos | TodoKeys')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Breadcrumb -->
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-8">
        <a href="{{ route('home') }}" class="hover:text-primary-500">Inicio</a>
        <span>/</span>
        <span class="text-gray-900 ">Productos</span>
    </nav>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Sidebar Filters -->
        <aside class="w-full lg:w-64 shrink-0">
            <div class="bg-white rounded-2xl border border-gray-100 p-6 sticky top-24">
                <div class="flex items-center gap-2 mb-6 pb-4 border-b border-gray-100">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    <h3 class="text-lg font-black text-gray-900 uppercase tracking-wide">Filtros</h3>
                </div>

                <!-- Categories -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-600 mb-3">Categorías</h4>
                    <div class="space-y-2">
                        <a href="{{ route('products.index') }}" class="flex items-center gap-2 text-sm py-1 {{ !request('category') ? 'text-primary-500 font-bold' : 'text-gray-600 hover:text-primary-500' }}">
                            <div class="w-6 h-6 rounded-md flex items-center justify-center {{ !request('category') ? 'bg-primary-50 text-primary-500' : 'bg-gray-50 text-gray-400' }}">
                                <i class="fa-solid fa-list-ul text-xs"></i>
                            </div>
                            Todas
                        </a>
                        @foreach($categories as $category)
                        <a href="{{ route('products.index', ['category' => $category->slug, 'search' => request('search')]) }}" class="flex items-center justify-between group py-1 {{ request('category') == $category->slug ? 'text-primary-500 font-bold' : 'text-gray-600 hover:text-primary-500' }}">
                            <div class="flex items-center gap-2 text-sm">
                                <div class="w-6 h-6 rounded-md flex items-center justify-center transition-colors {{ request('category') == $category->slug ? 'bg-primary-50 text-primary-500' : 'bg-gray-50 text-gray-400 group-hover:bg-primary-50/50 group-hover:text-primary-400' }}">
                                    @if($category->icon)
                                    <i class="{{ $category->icon }} text-xs"></i>
                                    @else
                                    <i class="fa-solid fa-tag text-xs"></i>
                                    @endif
                                </div>
                                {{ $category->name }}
                            </div>
                            <span class="text-xs px-2 py-0.5 rounded-full font-medium transition-colors {{ request('category') == $category->slug ? 'bg-primary-100 text-primary-700' : 'bg-gray-100 text-gray-500 group-hover:bg-gray-200' }}">
                                {{ $category->products_count }}
                            </span>
                        </a>
                        @endforeach
                    </div>
                </div>

                <!-- Price Range -->
                <div class="mb-6">
                    <h4 class="text-sm font-medium text-gray-600 mb-3">Precio</h4>
                    <div class="flex gap-2">
                        <input type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}" class="w-1/2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-400/50">
                        <input type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}" class="w-1/2 px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-400/50">
                    </div>
                </div>

                <!-- Brands -->
                @if($brands->count())
                <div>
                    <h4 class="text-sm font-medium text-gray-600 mb-3">Marcas</h4>
                    <div class="space-y-2">
                        @foreach($brands as $brand)
                        <a href="{{ route('products.index', ['brand' => $brand->slug]) }}" class="flex items-center gap-2 group py-1 text-sm {{ request('brand') == $brand->slug ? 'text-primary-500 font-bold' : 'text-gray-600 hover:text-primary-500' }}">
                            <div class="w-6 h-6 rounded-md flex items-center justify-center transition-colors {{ request('brand') == $brand->slug ? 'bg-primary-50 text-primary-500' : 'bg-gray-50 text-gray-400 group-hover:bg-primary-50/50 group-hover:text-primary-400' }}">
                                @if($brand->icon)
                                <i class="{{ $brand->icon }} text-xs"></i>
                                @else
                                <i class="fa-solid fa-star text-xs"></i>
                                @endif
                            </div>
                            {{ $brand->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </aside>

        <!-- Products Grid -->
        <div class="flex-1">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 ">
                        @if(request('search'))
                            Resultados para "{{ request('search') }}"
                        @elseif(request('category'))
                            {{ $categories->where('slug', request('category'))->first()->name ?? 'Productos' }}
                        @else
                            Todos los Productos
                        @endif
                    </h1>
                    <p class="text-sm text-gray-500 mt-1">{{ $products->total() }} productos encontrados</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="hidden sm:flex items-center gap-1 bg-white border border-gray-200 rounded-xl p-1">
                        <a href="{{ request()->fullUrlWithQuery(['layout' => 'list']) }}" 
                           class="w-8 h-8 flex items-center justify-center rounded-lg transition-colors {{ $layout == 'list' ? 'bg-primary-50 text-primary-600' : 'text-gray-400 hover:text-gray-600 hover:bg-gray-50' }}"
                           title="Vista de lista">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['layout' => 'grid']) }}" 
                           class="w-8 h-8 flex items-center justify-center rounded-lg transition-colors {{ $layout == 'grid' ? 'bg-primary-50 text-primary-600' : 'text-gray-400 hover:text-gray-600 hover:bg-gray-50' }}"
                           title="Vista de cuadrícula">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        </a>
                    </div>
                    <select onchange="window.location.href=this.value" class="px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary-400/50">
                        <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'featured'])) }}" {{ request('sort', 'featured') == 'featured' ? 'selected' : '' }}>Destacados</option>
                        <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Menor Precio</option>
                        <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Mayor Precio</option>
                        <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'best_selling'])) }}" {{ request('sort') == 'best_selling' ? 'selected' : '' }}>Más Vendidos</option>
                        <option value="{{ route('products.index', array_merge(request()->query(), ['sort' => 'newest'])) }}" {{ request('sort') == 'newest' ? 'selected' : '' }}>Más Recientes</option>
                    </select>
                </div>
            </div>

            @if($products->count())
            <div class="grid {{ $layout == 'list' ? 'grid-cols-1' : $gridClass }} gap-5">
                @foreach($products as $product)
                <x-product-card :product="$product" :layout="$layout" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $products->links() }}
            </div>
            @else
            <div class="text-center py-20">
                <svg class="w-16 h-16 text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No se encontraron productos</h3>
                <p class="text-gray-600">Intenta con otros filtros o términos de búsqueda</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
function addToCart(productId) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Livewire.dispatch('cartUpdated');
            alert('Producto agregado al carrito');
        }
    });
}
</script>
@endpush
@endsection
