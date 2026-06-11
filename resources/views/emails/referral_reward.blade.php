@extends('emails.layouts.premium')

@section('title', '¡Has ganado TodoPuntos! - ' . \App\Models\Setting::get('site_name', 'TodoKeys'))

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <div style="width: 60px; height: 60px; background-color: rgba(139, 92, 246, 0.15); border: 1px solid rgba(139, 92, 246, 0.25); border-radius: 30px; display: inline-block; text-align: center; line-height: 58px; font-size: 28px; margin-bottom: 15px;">💎</div>
    <h1 style="margin: 0;">¡Felicidades, {{ $referrer->name }}!</h1>
</div>

<p style="text-align: center;">¡Tu amigo/a <strong>{{ $referredUser->name }}</strong> acaba de realizar su primera compra en nuestra tienda gracias a tu recomendación!</p>

<p style="text-align: center;">Como agradecimiento por ayudarnos a crecer, hemos añadido la siguiente recompensa a tu cuenta:</p>

<div class="premium-block" style="text-align: center; background: linear-gradient(145deg, #2D1B4E 0%, #1A1235 100%); border-color: rgba(139, 92, 246, 0.45);">
    <div class="premium-block-title" style="background-color: rgba(139, 92, 246, 0.2); color: #C084FC;">Puntos Recibidos</div>
    <div style="font-size: 38px; font-weight: 800; color: #A855F7; margin: 15px 0; text-shadow: 0 0 20px rgba(139, 92, 246, 0.4); letter-spacing: 0.5px;">
        +{{ number_format($points) }} TodoPuntos
    </div>
    <div style="font-size: 12px; color: #94A3B8;">
        ¡Puedes utilizar estos puntos como saldo para pagar tu próxima compra!
    </div>
</div>

<p style="text-align: center;">Sigue compartiendo tu enlace personalizado de referidos desde tu panel para continuar ganando premios.</p>

<div class="btn-container">
    <a href="{{ route('customer.dashboard') }}" class="btn" style="background: linear-gradient(90deg, #8B5CF6 0%, #6366F1 100%); box-shadow: 0 8px 20px rgba(139, 92, 246, 0.3);">Ver mi balance</a>
</div>
@endsection
