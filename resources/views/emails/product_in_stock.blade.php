<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>¡Vuelve a estar en stock!</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9fafb; color: #111827; line-height: 1.5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { background-color: #22c55e; color: white; padding: 30px 20px; text-align: center; }
        .content { padding: 30px 20px; text-align: center; }
        .product-name { font-size: 20px; font-weight: bold; color: #111827; margin: 20px 0; }
        .button { display: inline-block; padding: 12px 24px; background-color: #2563eb; color: white; text-decoration: none; font-weight: bold; border-radius: 8px; margin-top: 20px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #6b7280; background-color: #f9fafb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 24px;">¡Buenas noticias! 🎉</h1>
        </div>
        <div class="content">
            <p>Te apuntaste a la lista de espera y lo prometido es deuda:</p>
            <div class="product-name">{{ $product->name }}</div>
            <p>¡Acabamos de reponer stock! Las unidades son limitadas, así que date prisa antes de que se vuelvan a agotar.</p>
            <a href="{{ route('products.show', $product->slug) }}" class="button">Comprar Ahora</a>
        </div>
        <div class="footer">
            © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
