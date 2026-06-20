@extends('emails.layouts.premium')

@section('title', 'Nuevo Mensaje de Contacto')

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <div style="width: 60px; height: 60px; background-color: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.25); border-radius: 30px; display: inline-block; text-align: center; line-height: 58px; font-size: 28px; margin-bottom: 15px;">✉️</div>
    <h1 style="margin: 0;">¡Nuevo Mensaje Recibido!</h1>
    <p style="color: #64748B; font-size: 14px; margin-top: 5px;">Se ha recibido una nueva consulta a través del formulario de contacto.</p>
</div>

<p>Hola Administrador,</p>

<p>Se ha enviado un mensaje desde el sitio web con los siguientes detalles:</p>

<div class="premium-block" style="text-align: left; background: #161D30; border: 1px solid #1E293B;">
    <div class="premium-block-title" style="background-color: rgba(99, 102, 241, 0.15); color: #818CF8;">Información del Remitente</div>
    
    <table border="0" cellpadding="0" cellspacing="0" style="width: 100%; margin-top: 10px; color: #E2E8F0; font-size: 14px;">
        <tr>
            <td style="padding: 6px 0; font-weight: bold; width: 80px; color: #94A3B8;">Nombre:</td>
            <td style="padding: 6px 0;">{{ $name }}</td>
        </tr>
        <tr>
            <td style="padding: 6px 0; font-weight: bold; color: #94A3B8;">Correo:</td>
            <td style="padding: 6px 0;"><a href="mailto:{{ $email }}" style="color: #38BDF8; text-decoration: none;">{{ $email }}</a></td>
        </tr>
        <tr>
            <td style="padding: 6px 0; font-weight: bold; color: #94A3B8;">Asunto:</td>
            <td style="padding: 6px 0;">{{ $subject }}</td>
        </tr>
    </table>
</div>

<h2 style="font-size: 15px; color: #F8FAFC; margin-top: 25px;">Contenido del Mensaje</h2>
<div style="background-color: #0A0F1D; border: 1px solid #1E293B; border-radius: 10px; padding: 20px; color: #E2E8F0; font-size: 14px; line-height: 1.6; white-space: pre-wrap; font-family: sans-serif;">{{ $messageText }}</div>

<div class="btn-container">
    <a href="mailto:{{ $email }}?subject=RE: {{ rawurlencode($subject) }}" class="btn">Responder al Remitente</a>
</div>

<p style="font-size: 12px; text-align: center; margin-top: 30px; color: #64748B;">
    Este correo electrónico fue generado automáticamente por el sistema de contacto de {{ \App\Models\Setting::get('site_name', 'TodoKeys') }}.
</p>
@endsection
