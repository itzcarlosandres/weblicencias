@extends('emails.layouts.premium')

@section('title', '¡Bienvenido a TodoKeys!')

@section('content')
<h1>¡Hola, {{ $user->name }}! 🎉</h1>

<p>Te damos la bienvenida oficial a nuestra plataforma. Estamos muy emocionados de tenerte con nosotros.</p>

<p>A partir de ahora, podrás acceder a las mejores ofertas en videojuegos, software y tarjetas de regalo, con entrega inmediata y soporte prioritario.</p>

<div class="premium-block" style="text-align: center;">
    <div class="premium-block-title">Tu correo de acceso</div>
    <div class="premium-block-value" style="font-size: 16px;">{{ $user->email }}</div>
</div>

<p>Puedes acceder a tu panel de control para ver tu historial de pedidos, lista de deseos y gestionar tus preferencias en cualquier momento.</p>

<div class="btn-container">
    <a href="{{ route('login') }}" class="btn">Ir a mi Panel de Control</a>
</div>

<p>Si tienes alguna pregunta, no dudes en contactar a nuestro equipo de soporte.</p>

<p>¡Disfruta tus compras!</p>
@endsection
