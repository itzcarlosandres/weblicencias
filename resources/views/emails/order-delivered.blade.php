@extends('emails.layouts.premium')

@section('title', '¡Tu orden ha sido entregada! - ' . \App\Models\Setting::get('site_name', 'TodoKeys'))

@section('content')
<h1>¡Tu orden ha sido entregada! 🎉</h1>

<p>Hola <strong>{{ $order->user->name }}</strong>,</p>

<p>Tu orden <strong>{{ $order->order_number }}</strong> ha sido procesada y tus productos ya están disponibles. A continuación encontrarás las licencias o claves de tus productos:</p>

@foreach($items as $item)
<div class="premium-block">
    <div class="premium-block-title">{{ $item->product_name }}</div>
    <div class="premium-block-value" style="color: #60A5FA; letter-spacing: 2px;">
        {{ $item->license?->key ?? 'Procesando o no aplica clave' }}
    </div>
</div>
@endforeach

<h2>Resumen de la orden</h2>
<table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
    <tr>
        <td style="padding: 10px 0; border-bottom: 1px solid #374151; color: #9CA3AF;">Número de orden</td>
        <td style="padding: 10px 0; border-bottom: 1px solid #374151; text-align: right; color: #ffffff; font-weight: bold;">{{ $order->order_number }}</td>
    </tr>
    <tr>
        <td style="padding: 10px 0; border-bottom: 1px solid #374151; color: #9CA3AF;">Total pagado</td>
        <td style="padding: 10px 0; border-bottom: 1px solid #374151; text-align: right; color: #ffffff; font-weight: bold;">${{ number_format($order->total, 2) }}</td>
    </tr>
    <tr>
        <td style="padding: 10px 0; border-bottom: 1px solid #374151; color: #9CA3AF;">Fecha</td>
        <td style="padding: 10px 0; border-bottom: 1px solid #374151; text-align: right; color: #ffffff; font-weight: bold;">{{ $order->created_at->format('d/m/Y H:i') }}</td>
    </tr>
</table>

<div class="btn-container">
    <a href="{{ route('customer.orders.show', $order) }}" class="btn">Ver detalles de la orden</a>
</div>

<p>Si tienes alguna consulta sobre tu pedido o necesitas ayuda para activar tu clave, no dudes en contactarnos.</p>
@endsection
