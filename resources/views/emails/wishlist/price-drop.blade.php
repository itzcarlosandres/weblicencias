@extends('emails.layouts.premium')

@section('title', '¡Baja de precio en tu lista de deseos! - ' . \App\Models\Setting::get('site_name', 'TodoKeys'))

@section('content')
<div style="text-align: center; margin-bottom: 30px;">
    <div style="width: 60px; height: 60px; background-color: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.25); border-radius: 30px; display: inline-block; text-align: center; line-height: 58px; font-size: 28px; margin-bottom: 15px;">🔥</div>
    <h1 style="margin: 0;">¡Excelente noticia!</h1>
</div>

<p>El siguiente producto que guardaste en tu <strong>Lista de Deseos</strong> acaba de bajar de precio:</p>

<div class="premium-block" style="text-align: center;">
    <div class="premium-block-title">Oferta Especial</div>
    <div style="color: #FFFFFF; font-size: 18px; font-weight: 700; margin: 10px 0;">
        {{ $productName }}
    </div>
    
    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <tr>
            <td style="padding: 8px 0; border-bottom: 1px solid #1E293B; color: #64748B; font-size: 14px; text-align: left;">Precio anterior</td>
            <td style="padding: 8px 0; border-bottom: 1px solid #1E293B; text-align: right; color: #94A3B8; text-decoration: line-through; font-size: 14px;">
                {{ currency_format($oldPrice) }}
            </td>
        </tr>
        <tr>
            <td style="padding: 8px 0; color: #64748B; font-size: 14px; text-align: left;">Nuevo precio</td>
            <td style="padding: 8px 0; text-align: right; color: #10B981; font-weight: bold; font-size: 18px;">
                {{ currency_format($newPrice) }}
            </td>
        </tr>
    </table>
</div>

<p style="text-align: center; margin-top: 25px;">Aprovecha esta oferta antes de que se agote o el precio vuelva a subir.</p>

<div class="btn-container">
    <a href="{{ $url }}" class="btn">Ver Producto</a>
</div>
@endsection
