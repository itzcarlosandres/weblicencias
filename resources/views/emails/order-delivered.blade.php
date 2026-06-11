@extends('emails.layouts.premium')

@section('title', '¡Tu orden ha sido entregada! - ' . \App\Models\Setting::get('site_name', 'TodoKeys'))

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <div style="width: 60px; height: 60px; background-color: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.25); border-radius: 30px; display: inline-block; text-align: center; line-height: 58px; font-size: 28px; margin-bottom: 15px;">🎉</div>
    <h1 style="margin: 0;">¡Tu orden ha sido entregada!</h1>
</div>

<p>Hola <strong>{{ $order->user->name }}</strong>,</p>

<p>Tu orden <strong>{{ $order->order_number }}</strong> ha sido procesada con éxito. Tus licencias digitales y claves de activación ya están disponibles:</p>

@foreach($items as $item)
<div class="premium-block">
    <div class="premium-block-title">{{ $item->product_name }}</div>
    <div class="premium-block-value">
        {{ $item->license?->key ?? 'Procesando o no aplica clave' }}
    </div>
    <div style="font-size: 11px; color: #64748B; margin-top: 12px; text-align: center;">
        Copia esta clave de activación e ingrésala en el software oficial.
    </div>
</div>
@endforeach

<h2>Resumen del Pedido</h2>
<table style="width: 100%; border-collapse: collapse; margin: 15px 0;">
    <tr>
        <td style="padding: 12px 0; border-bottom: 1px solid #1E293B; color: #64748B; font-size: 14px;">Número de orden</td>
        <td style="padding: 12px 0; border-bottom: 1px solid #1E293B; text-align: right; color: #F8FAFC; font-weight: 600; font-size: 14px;">{{ $order->order_number }}</td>
    </tr>
    <tr>
        <td style="padding: 12px 0; border-bottom: 1px solid #1E293B; color: #64748B; font-size: 14px;">Total pagado</td>
        <td style="padding: 12px 0; border-bottom: 1px solid #1E293B; text-align: right; color: #38BDF8; font-weight: 800; font-size: 16px;">${{ number_format($order->total, 2) }}</td>
    </tr>
    <tr>
        <td style="padding: 12px 0; border-bottom: 1px solid #1E293B; color: #64748B; font-size: 14px;">Fecha</td>
        <td style="padding: 12px 0; border-bottom: 1px solid #1E293B; text-align: right; color: #F8FAFC; font-weight: 600; font-size: 14px;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>

<div class="btn-container">
    <a href="{{ route('customer.orders.show', $order) }}" class="btn">Ver detalles de la orden</a>
</div>

<p style="font-size: 13px; text-align: center; margin-top: 30px; color: #64748B;">
    ¿Necesitas ayuda para activar tu clave? Nuestro equipo de soporte está disponible para ayudarte.
</p>
@endsection
