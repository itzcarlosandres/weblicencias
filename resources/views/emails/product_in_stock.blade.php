@extends('emails.layouts.premium')

@section('title', '¡Vuelve a estar en stock! - ' . \App\Models\Setting::get('site_name', 'TodoKeys'))

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <div style="width: 60px; height: 60px; background-color: rgba(34, 197, 94, 0.15); border: 1px solid rgba(34, 197, 94, 0.25); border-radius: 30px; display: inline-block; text-align: center; line-height: 58px; font-size: 28px; margin-bottom: 15px;">🎉</div>
    <h1 style="margin: 0;">¡Buenas noticias!</h1>
</div>

<p style="text-align: center;">Te apuntaste a la lista de espera y lo prometido es deuda. El siguiente producto ya está disponible nuevamente:</p>

<div class="premium-block" style="text-align: center;">
    <div class="premium-block-title">Producto de nuevo en stock</div>
    <div style="color: #FFFFFF; font-size: 18px; font-weight: 700; margin: 10px 0;">
        {{ $product->name }}
    </div>
    <div style="font-size: 13px; color: #38BDF8; font-weight: 600; margin-top: 8px;">
        Precio: {{ currency_format($product->price) }}
    </div>
</div>

<p style="text-align: center;">¡Acabamos de reponer stock! Recuerda que las unidades son limitadas, así que te recomendamos darte prisa antes de que se vuelvan a agotar.</p>

<div class="btn-container">
    <a href="{{ route('products.show', $product->slug) }}" class="btn">Comprar Ahora</a>
</div>
@endsection
