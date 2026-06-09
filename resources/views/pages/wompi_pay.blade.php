@extends('layouts.app')

@section('title', 'Pagar con Wompi | TodoKeys')

@section('content')
<div class="max-w-[600px] mx-auto px-4 py-20 min-h-[60vh] flex flex-col items-center justify-center text-center">
    
    <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 text-3xl mb-6 shadow-sm">
        <i class="fa-solid fa-building-columns"></i>
    </div>

    <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">Pagar con Wompi</h1>
    <p class="text-gray-500 mb-8 max-w-md">Estás a un paso de obtener tus licencias. Haz clic en el botón de abajo para abrir la ventana de pagos seguros de Wompi.</p>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 w-full mb-8 flex justify-between items-center">
        <div class="text-left">
            <div class="text-[13px] text-gray-500 font-medium">Total a Pagar</div>
            <div class="text-2xl font-black text-gray-900">{{ currency_format($order->total) }}</div>
        </div>
        <div class="text-right">
            <div class="text-[13px] text-gray-500 font-medium">Nº Pedido</div>
            <div class="text-lg font-bold text-gray-900">#{{ $order->order_number }}</div>
        </div>
    </div>

    <!-- Wompi Widget Form -->
    <form>
        <script
            src="https://checkout.wompi.co/widget.js"
            data-environment="{{ $environment }}"
            data-public-key="{{ $publicKey }}"
            data-currency="COP"
            data-amount-in-cents="{{ $amountInCents }}"
            data-reference="{{ $reference }}"
            data-redirect-url="{{ route('wompi.callback') }}"
            >
        </script>
    </form>

    <a href="{{ route('checkout.index') }}" class="mt-8 text-[14px] font-semibold text-gray-400 hover:text-gray-600 transition-colors">
        <i class="fa-solid fa-arrow-left mr-2"></i> Volver a métodos de pago
    </a>
</div>

<!-- Estilos adicionales para personalizar el botón de Wompi si es necesario -->
<style>
    .wompi-button {
        width: 100%;
        background-color: #4f46e5 !important;
        color: white !important;
        font-weight: bold !important;
        padding: 1rem 1.5rem !important;
        border-radius: 0.75rem !important;
        font-size: 16px !important;
        transition: all 0.2s !important;
    }
    .wompi-button:hover {
        background-color: #4338ca !important;
        transform: translateY(-2px);
    }
</style>
@endsection
