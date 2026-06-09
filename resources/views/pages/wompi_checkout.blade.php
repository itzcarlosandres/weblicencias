@extends('layouts.app')

@section('title', 'Pagar con Wompi - TodoKeys')

@section('content')
<div class="max-w-3xl mx-auto py-12 px-4">
    <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 p-8 text-center">
        <h2 class="text-2xl font-black text-gray-900 mb-4">Completar pago con Wompi</h2>
        <p class="text-gray-600 mb-8">Estás a punto de pagar la orden #{{ $order->order_number }} por un total de <strong>{{ number_format($amountInCents / 100, 0, ',', '.') }} COP</strong>.</p>
        
        <form action="https://checkout.wompi.co/p/" method="GET">
            <input type="hidden" name="public-key" value="{{ $publicKey }}" />
            <input type="hidden" name="currency" value="COP" />
            <input type="hidden" name="amount-in-cents" value="{{ $amountInCents }}" />
            <input type="hidden" name="reference" value="{{ $order->id }}" />
            <input type="hidden" name="signature:integrity" value="{{ $signature }}" />
            <input type="hidden" name="redirect-url" value="{{ route('wompi.callback') }}" />
            <input type="hidden" name="customer-data:email" value="{{ auth()->user()->email }}" />
            <input type="hidden" name="customer-data:full-name" value="{{ auth()->user()->name }}" />
            
            <button type="submit" class="bg-[#002DCC] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#0024A3] transition-colors">
                Pagar de forma segura con Wompi
            </button>
        </form>

        <div class="mt-8">
            <a href="{{ route('checkout.index') }}" class="text-blue-600 text-sm font-bold hover:underline">Volver al carrito</a>
        </div>
    </div>
</div>
@endsection
