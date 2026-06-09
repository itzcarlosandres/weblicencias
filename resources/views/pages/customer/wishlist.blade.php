@extends('pages.customer.dashboard')

@section('title', 'Mi Lista de Deseos | TodoKeys')

@section('customer_content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="text-2xl font-extrabold text-text-primary ">Mi Lista de Deseos</h1>
        <p class="text-sm text-text-secondary mt-1">Productos guardados para comprar después</p>
    </div>
</div>

@if($wishlists->count())
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($wishlists as $wishlist)
        <div class="relative">
            <x-product-card :product="$wishlist->product" />
        </div>
    @endforeach
</div>
<div class="mt-8">{{ $wishlists->links() }}</div>
@else
<div class="card p-12 text-center">
    <div class="w-20 h-20 bg-primary-100 rounded-3xl flex items-center justify-center mx-auto mb-6 text-primary-400 text-3xl">
        <i class="fa-solid fa-heart"></i>
    </div>
    <h3 class="text-xl font-bold text-text-primary mb-2">Tu lista está vacía</h3>
    <p class="text-text-secondary mb-6">Explora nuestro catálogo y guarda los productos que más te gusten.</p>
    <a href="{{ route('products.index') }}" class="btn-primary inline-flex items-center gap-2">
        Explorar Productos
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
    </a>
</div>
@endif
@endsection
