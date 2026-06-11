@extends('emails.layouts.premium')

@section('title', 'Tu Licencia Asignada - ' . \App\Models\Setting::get('site_name', 'TodoKeys'))

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <div style="width: 60px; height: 60px; background-color: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 30px; display: inline-block; text-align: center; line-height: 58px; font-size: 28px; margin-bottom: 15px;">🔑</div>
    <h1 style="margin: 0;">¡Tu licencia está lista!</h1>
</div>

<p>¡Hola!</p>

<p>Nos complace informarte que se te ha asignado una nueva licencia de producto. Hemos preparado todo para que puedas empezar a disfrutarlo inmediatamente:</p>

<div class="premium-block">
    <div class="premium-block-title">{{ $license->product->name }}</div>
    <div class="premium-block-value">
        {{ $license->key }}
    </div>
    <div style="font-size: 11px; color: #64748B; margin-top: 12px; text-align: center;">
        Copia esta clave de activación e ingrésala en el software oficial.
    </div>
</div>

<div style="background-color: rgba(59, 130, 246, 0.05); border-left: 3px solid #3B82F6; padding: 15px 20px; border-radius: 0 8px 8px 0; margin-bottom: 25px; margin-top: 25px;">
    <p style="margin: 0; color: #60A5FA; font-size: 14px; font-weight: 500;">
        <strong>Nota importante:</strong> Por favor, guarda esta clave en un lugar seguro. Si tienes instrucciones específicas de instalación, las encontrarás en la página del producto o contactando con nuestro equipo de soporte.
    </p>
</div>

<p>Si tienes alguna pregunta, inconveniente o necesitas asistencia durante la activación, nuestro equipo de soporte técnico está disponible para ayudarte en todo momento.</p>

<div class="btn-container">
    <a href="{{ url('/') }}" class="btn">Visitar la Tienda</a>
</div>
@endsection
