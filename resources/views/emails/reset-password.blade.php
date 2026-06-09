@extends('emails.layouts.premium')

@section('title', 'Restablecer contraseña')

@section('content')
<h1>Hola{{ isset($user) && $user->name ? ', ' . $user->name : '' }},</h1>

<p>Recibes este correo electrónico porque hemos recibido una solicitud de restablecimiento de contraseña para tu cuenta.</p>

<p>Haz clic en el siguiente botón para restablecer tu contraseña. Este enlace de restablecimiento de contraseña caducará en 60 minutos.</p>

<div class="btn-container">
    <a href="{{ $url }}" class="btn">Restablecer Contraseña</a>
</div>

<p>Si no solicitaste un restablecimiento de contraseña, no es necesario realizar ninguna otra acción y puedes ignorar este correo con seguridad.</p>

<div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #374151;">
    <p style="font-size: 13px; color: #9CA3AF;">
        Si tienes problemas para hacer clic en el botón "Restablecer Contraseña", copia y pega la siguiente URL en tu navegador web:<br>
        <span style="word-break: break-all; color: #3B82F6;">{{ $url }}</span>
    </p>
</div>
@endsection
