@extends('layouts.app')

@section('title', 'Carrito de Compras | TodoKeys')

@section('content')
<style>
    body { background-color: #f5f5f5 !important; color: #333 !important; }
</style>

<div class="max-w-[1200px] mx-auto px-4 sm:px-6 py-10 lg:py-16">
    
    <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tight">Tu Carrito</h1>
        <p class="text-gray-500 mt-2">Revisa tus productos antes de finalizar la compra.</p>
    </div>

    @if(count($cart) > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($cart as $item)
            <div class="bg-white rounded-[20px] p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6 shadow-[0_2px_10px_rgb(0,0,0,0.02)] border border-gray-100 relative group">
                <div class="w-20 h-20 sm:w-24 sm:h-24 bg-blue-50/50 text-blue-500 rounded-2xl flex items-center justify-center text-3xl sm:text-4xl shrink-0 shadow-inner border border-blue-100/50">
                    <i class="fa-solid fa-box-open opacity-50"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex justify-between items-start mb-1">
                        <h3 class="font-bold text-gray-900 text-lg truncate pr-4">{{ $item['name'] }}</h3>
                        <button onclick="removeItem({{ $item['product_id'] }})" class="text-gray-300 hover:text-red-500 transition-colors" title="Eliminar">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3"><i class="fa-solid fa-key text-gray-300 mr-1"></i> {{ ucfirst($item['type']) }}</p>
                    
                    <div class="flex flex-wrap items-center justify-between gap-4">
                        <div class="flex items-baseline gap-2">
                            <span class="font-black text-2xl text-gray-900">{{ currency_format($item['price']) }}</span>
                            @if($item['original_price'] > $item['price'])
                            <span class="text-sm text-gray-400 line-through font-medium">{{ currency_format($item['original_price']) }}</span>
                            @endif
                        </div>
                        
                        <!-- Quantity Control -->
                        <div class="flex items-center bg-gray-50 rounded-xl p-1 border border-gray-200">
                            <button onclick="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] - 1 }})" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-white hover:shadow-sm hover:text-blue-600 transition-all">
                                <i class="fa-solid fa-minus text-xs"></i>
                            </button>
                            <span class="w-10 text-center font-bold text-gray-900">{{ $item['quantity'] }}</span>
                            <button onclick="updateQuantity({{ $item['product_id'] }}, {{ $item['quantity'] + 1 }})" class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-500 hover:bg-white hover:shadow-sm hover:text-blue-600 transition-all">
                                <i class="fa-solid fa-plus text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[20px] p-6 sm:p-8 shadow-[0_2px_10px_rgb(0,0,0,0.02)] border border-gray-100 sticky top-24">
                <h2 class="text-xl font-black text-gray-900 mb-6 uppercase tracking-tight">Resumen</h2>

                <!-- Coupon -->
                <div class="mb-6">
                    @if($couponCode)
                    <div class="flex items-center justify-between p-4 bg-green-50 rounded-xl border border-green-100">
                        <div class="flex items-center gap-2 text-green-600 font-bold">
                            <i class="fa-solid fa-tag"></i> {{ $couponCode }}
                        </div>
                        <button onclick="removeCoupon()" class="text-green-600 hover:text-red-500 transition-colors"><i class="fa-solid fa-times"></i></button>
                    </div>
                    @else
                    <div class="flex gap-2">
                        <input type="text" id="coupon-input" placeholder="Código de cupón" class="flex-1 px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                        <button onclick="applyCoupon()" class="px-5 py-3 bg-gray-900 hover:bg-blue-600 text-white text-sm font-bold rounded-xl transition-colors shadow-md">Aplicar</button>
                    </div>
                    @endif
                </div>

                <div class="space-y-4 border-t border-gray-100 pt-6">
                    <div class="flex justify-between text-gray-500 font-medium">
                        <span>Subtotal</span>
                        <span class="text-gray-900">{{ currency_format($subtotal) }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="flex justify-between text-green-600 font-bold">
                        <span>Descuento</span>
                        <span>-{{ currency_format($discount) }}</span>
                    </div>
                    @endif
                    @if($tax > 0)
                    <div class="flex justify-between text-gray-500 font-medium">
                        <span>Impuestos</span>
                        <span class="text-gray-900">{{ currency_format($tax) }}</span>
                    </div>
                    @endif
                    
                    <div class="flex justify-between items-center border-t border-gray-100 pt-6 mt-6">
                        <span class="text-lg font-medium text-gray-500">Total</span>
                        <span class="text-3xl font-black text-gray-900">{{ currency_format($total) }}</span>
                    </div>
                </div>

                <a href="{{ route('checkout.index') }}" class="block w-full mt-8 bg-blue-600 hover:bg-blue-700 text-white text-center py-4 rounded-xl font-bold text-lg shadow-lg shadow-blue-500/20 transition-all hover:-translate-y-1">
                    Continuar al Pago
                </a>

                <a href="{{ route('products.index') }}" class="block text-center mt-5 text-sm font-bold text-gray-400 hover:text-gray-900 transition-colors uppercase tracking-wider">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Seguir Comprando
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-[30px] p-12 text-center shadow-sm border border-gray-100 max-w-2xl mx-auto mt-10">
        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center text-4xl text-gray-300 mx-auto mb-6">
            <i class="fa-solid fa-cart-shopping"></i>
        </div>
        <h3 class="text-2xl font-black text-gray-900 mb-2 uppercase">Tu carrito está vacío</h3>
        <p class="text-gray-500 mb-8">Parece que aún no has añadido ningún producto fantástico.</p>
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-4 rounded-xl transition-all shadow-lg shadow-blue-500/20 hover:-translate-y-1">
            Explorar Catálogo <i class="fa-solid fa-arrow-right"></i>
        </a>
    </div>
    @endif
</div>

@push('scripts')
<script>
function updateQuantity(productId, quantity) {
    fetch('{{ route("cart.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ product_id: productId, quantity: quantity })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) location.reload();
    });
}

function removeItem(productId) {
    if (confirm('¿Eliminar este producto del carrito?')) {
        fetch('{{ route("cart.remove") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) location.reload();
        });
    }
}

function applyCoupon() {
    const code = document.getElementById('coupon-input').value;
    fetch('{{ route("cart.coupon") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ code: code })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert(data.message);
        }
    });
}

function removeCoupon() {
    fetch('{{ route("cart.coupon.remove") }}', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        }
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) location.reload();
    });
}
</script>
@endpush
@endsection
