@extends('emails.layouts.premium')

@section('title', 'Tu carrito te extraña - ' . $appName)

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <div style="width: 60px; height: 60px; background-color: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 30px; display: inline-block; text-align: center; line-height: 58px; font-size: 28px; margin-bottom: 15px;">🛒</div>
    <h1 style="margin: 0;">¡Tu carrito te extraña!</h1>
</div>

<p>¡Hola, <strong>{{ $cart->user->name }}</strong>! 👋</p>

<p>Notamos que dejaste algunos artículos increíbles en tu carrito. Las existencias de las licencias son limitadas y se agotan rápido, ¡así que te guardamos tus selecciones por un poco más de tiempo!</p>

<div style="background-color: #161D30; border: 1px solid #1E293B; border-radius: 12px; padding: 20px; margin-bottom: 25px;">
    @php
        $items = collect($cart->cart_data)->take(3);
        $totalItems = count($cart->cart_data);
    @endphp
    
    @foreach($items as $item)
        <div style="display: table; width: 100%; border-bottom: 1px solid #1E293B; padding: 12px 0; @if($loop->last && $totalItems <= 3) border-bottom: none; @endif">
            <div style="display: table-cell; vertical-align: middle;">
                <div style="font-weight: 600; font-size: 14px; color: #F8FAFC;">{{ $item['name'] ?? 'Licencia de Software' }}</div>
                <div style="font-size: 12px; color: #64748B; margin-top: 4px;">Cantidad: {{ $item['quantity'] ?? 1 }}</div>
            </div>
            <div style="display: table-cell; text-align: right; vertical-align: middle; font-weight: 700; color: #38BDF8; font-size: 15px;">
                {{ currency_format($item['price'] ?? 0) }}
            </div>
        </div>
    @endforeach
    
    @if($totalItems > 3)
        <div style="text-align: center; font-size: 12px; color: #64748B; margin-top: 12px; border-top: 1px solid #1E293B; padding-top: 12px;">
            + {{ $totalItems - 3 }} artículos más en tu carrito...
        </div>
    @endif
</div>

<p style="text-align: center; font-weight: 500; color: #F8FAFC; margin-top: 25px;">
    🎁 Vuelve ahora y finaliza tu compra antes de perder tus licencias.
</p>

<div class="btn-container">
    <a href="{{ route('checkout.index') }}" class="btn">Recuperar mi carrito</a>
</div>

<p style="font-size: 13px; text-align: center; margin-top: 30px; color: #64748B;">
    Si ya no deseas recibir estos recordatorios, puedes cambiar tus preferencias de correo en tu cuenta.
</p>
@endsection
