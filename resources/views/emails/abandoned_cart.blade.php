<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tu carrito te extraña</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9fafb;
            color: #111827;
            line-height: 1.5;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #2563eb;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .content {
            padding: 30px 20px;
        }
        .product-list {
            margin-top: 20px;
            margin-bottom: 20px;
            border-top: 1px solid #e5e7eb;
        }
        .product-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #e5e7eb;
        }
        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
            background-color: #f3f4f6;
            margin-right: 15px;
        }
        .product-details {
            flex-grow: 1;
        }
        .product-name {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 5px;
        }
        .product-price {
            color: #4b5563;
            font-weight: bold;
        }
        .button {
            display: block;
            width: max-content;
            margin: 30px auto;
            padding: 12px 24px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 8px;
            text-align: center;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #6b7280;
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 24px;">¡Hola {{ $user->name }}! 👋</h1>
            <p style="margin-top: 10px; opacity: 0.9;">Parece que dejaste algo importante en tu carrito.</p>
        </div>
        
        <div class="content">
            <p>Tus productos están a un solo clic de distancia. Hemos guardado tu carrito para que no tengas que volver a buscar tus licencias.</p>
            
            <div class="product-list">
                @foreach($cart->cart_data as $item)
                <div class="product-item">
                    <div class="product-details">
                        <div class="product-name">{{ $item['name'] }} (x{{ $item['quantity'] }})</div>
                        <div class="product-price">{{ currency_format($item['price']) }}</div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <a href="{{ route('cart.index') }}" class="button">Volver a mi carrito</a>
            
            <p style="margin-top: 30px; text-align: center; font-size: 14px; color: #4b5563;">
                <em>Las existencias de las licencias son limitadas. ¡No te quedes sin ellas!</em>
            </p>
        </div>
        
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.<br>
            Este es un correo automático, por favor no respondas a esta dirección.
        </div>
    </div>
</body>
</html>
