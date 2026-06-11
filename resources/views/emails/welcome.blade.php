@extends('emails.layouts.premium')

@section('title', '¡Bienvenido a TodoKeys!')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <div style="width: 60px; height: 60px; background-color: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 30px; display: inline-block; text-align: center; line-height: 58px; font-size: 28px; margin-bottom: 15px;">👋</div>
    <h1 style="margin: 0;">¡Te damos la bienvenida!</h1>
</div>

<p>Hola <strong>{{ $user->name }}</strong>,</p>

<p>Te damos la bienvenida oficial a <strong>TodoKeys</strong>. Estamos muy emocionados de tenerte con nosotros.</p>

<p>A partir de ahora, tendrás acceso inmediato a las mejores licencias de software, sistemas operativos y herramientas digitales al mejor precio del mercado.</p>

<div class="premium-block" style="text-align: center;">
    <div class="premium-block-title">Tu cuenta registrada</div>
    <div class="premium-block-value" style="font-size: 16px; letter-spacing: 0;">
        {{ $user->email }}
    </div>
    <div style="font-size: 11px; color: #64748B; margin-top: 12px;">
        Usa esta dirección de correo electrónico para acceder a tu panel de control.
    </div>
</div>

<p>Puedes ingresar en cualquier momento para ver tu historial de pedidos, descargar tus claves de activación adquiridas o gestionar tus TodoPuntos acumulados.</p>

<div class="btn-container">
    <a href="{{ route('login') }}" class="btn">Ir a mi Panel de Control</a>
</div>

<p style="font-size: 13px; text-align: center; margin-top: 30px; color: #64748B;">
    Si tienes alguna consulta o necesitas ayuda, responde a este correo y nuestro equipo de soporte te atenderá encantado.
</p>
@endsection
