<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>¡Has ganado TodoPuntos!</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9fafb; color: #111827; line-height: 1.5; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); }
        .header { background-color: #8b5cf6; color: white; padding: 30px 20px; text-align: center; }
        .content { padding: 30px 20px; text-align: center; }
        .points { font-size: 36px; font-weight: bold; color: #8b5cf6; margin: 10px 0; }
        .button { display: inline-block; padding: 12px 24px; background-color: #8b5cf6; color: white; text-decoration: none; font-weight: bold; border-radius: 8px; margin-top: 20px; }
        .footer { text-align: center; padding: 20px; font-size: 12px; color: #6b7280; background-color: #f9fafb; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 24px;">¡Felicidades, {{ $referrer->name }}! 🎉</h1>
        </div>
        <div class="content">
            <p>¡Tu amigo/a <strong>{{ $referredUser->name }}</strong> acaba de realizar su primera compra gracias a tu recomendación!</p>
            <p>Como agradecimiento por ayudarnos a crecer, hemos añadido puntos a tu cuenta:</p>
            <div class="points">+{{ number_format($points) }} TodoPuntos</div>
            <p>Puedes usarlos como dinero en tu próxima compra.</p>
            <a href="{{ route('customer.dashboard') }}" class="button">Ver mi balance</a>
        </div>
        <div class="footer">
            Sigue compartiendo tu enlace de referidos para ganar más.<br><br>
            © {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
