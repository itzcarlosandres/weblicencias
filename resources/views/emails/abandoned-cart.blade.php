<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu carrito te extraña</title>
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0; color: #111827; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { background-color: {{ $primaryColor }}; padding: 32px 24px; text-align: center; color: #ffffff; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 800; letter-spacing: -0.025em; }
        .content { padding: 32px 24px; }
        .greeting { font-size: 18px; font-weight: 600; margin-bottom: 16px; }
        .message { font-size: 15px; line-height: 1.6; color: #4b5563; margin-bottom: 24px; }
        .cart-items { background-color: #f3f4f6; border-radius: 12px; padding: 16px; margin-bottom: 24px; }
        .cart-item { display: flex; align-items: center; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #e5e7eb; }
        .cart-item:last-child { margin-bottom: 0; padding-bottom: 0; border-bottom: none; }
        .item-details { flex: 1; }
        .item-name { font-weight: 600; font-size: 14px; color: #111827; }
        .item-price { font-size: 14px; font-weight: 700; color: {{ $primaryColor }}; margin-top: 4px; }
        .button-wrapper { text-align: center; margin-top: 32px; }
        .button { display: inline-block; background-color: {{ $primaryColor }}; color: #ffffff; padding: 14px 28px; border-radius: 9999px; font-weight: 600; font-size: 15px; text-decoration: none; box-shadow: 0 4px 14px 0 rgba(0,0,0,0.1); transition: transform 0.2s; }
        .footer { background-color: #f9fafb; padding: 24px; text-align: center; font-size: 13px; color: #6b7280; border-top: 1px solid #f3f4f6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $appName }}</h1>
        </div>
        <div class="content">
            <div class="greeting">¡Hola, {{ $cart->user->name }}! 👋</div>
            <div class="message">
                Notamos que dejaste algunos artículos increíbles en tu carrito. Las licencias se agotan rápido, ¡así que te guardamos tus selecciones por un poco más de tiempo!
            </div>
            
            <div class="cart-items">
                @php
                    $items = collect($cart->cart_data)->take(3);
                    $totalItems = count($cart->cart_data);
                @endphp
                
                @foreach($items as $item)
                    <div class="cart-item">
                        <div class="item-details">
                            <div class="item-name">{{ $item['name'] ?? 'Licencia de Software' }} x {{ $item['quantity'] ?? 1 }}</div>
                            <div class="item-price">{{ currency_format($item['price'] ?? 0) }}</div>
                        </div>
                    </div>
                @endforeach
                
                @if($totalItems > 3)
                    <div style="text-align: center; font-size: 12px; color: #6b7280; margin-top: 8px;">
                        + {{ $totalItems - 3 }} artículos más...
                    </div>
                @endif
            </div>

            <div class="message" style="text-align: center; font-weight: 500; color: #111827;">
                🎁 Vuelve ahora y finaliza tu compra.
            </div>

            <div class="button-wrapper">
                <a href="{{ route('checkout.index') }}" class="button">Recuperar mi carrito</a>
            </div>
        </div>
        <div class="footer">
            © {{ date('Y') }} {{ $appName }}. Todos los derechos reservados.<br>
            Si ya no deseas recibir estos correos, puedes cambiar tus preferencias en tu cuenta.
        </div>
    </div>
</body>
</html>
