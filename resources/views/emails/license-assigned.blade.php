<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tu Licencia Asignada</title>
    <style>
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background-color: #f3f4f6; color: #1f2937; margin: 0; padding: 0; -webkit-font-smoothing: antialiased; }
        .email-wrapper { width: 100%; table-layout: fixed; background-color: #f3f4f6; padding-bottom: 40px; }
        .email-content { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01); margin-top: 40px; }
        
        .header { background: linear-gradient(135deg, #111827 0%, #1f2937 100%); padding: 35px 40px; text-align: center; }
        .header img { max-height: 50px; max-width: 200px; object-fit: contain; }
        .header h1 { color: #ffffff; margin: 0; font-size: 22px; font-weight: 600; letter-spacing: -0.025em; }
        
        .body { padding: 40px; }
        .body p { margin-top: 0; margin-bottom: 20px; line-height: 1.6; color: #4b5563; font-size: 15px; }
        .greeting { font-size: 18px; font-weight: 600; color: #111827; margin-bottom: 15px; }
        
        .product-card { background-color: #f9fafb; border: 1px solid #f3f4f6; border-radius: 8px; padding: 20px; margin-bottom: 25px; text-align: center; }
        .product-label { text-transform: uppercase; font-size: 11px; font-weight: 700; color: #6b7280; letter-spacing: 0.05em; margin-bottom: 8px; }
        .product-name { font-size: 18px; font-weight: 700; color: #f59e0b; margin: 0; }
        
        .key-container { margin: 30px 0; text-align: center; }
        .key-label { font-size: 13px; font-weight: 600; color: #6b7280; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 10px; display: block; }
        .key-box { display: inline-block; background-color: #f0fdf4; border: 2px dashed #86efac; border-radius: 8px; padding: 15px 25px; font-family: 'Courier New', Courier, monospace; font-size: 20px; color: #166534; font-weight: 700; letter-spacing: 2px; word-break: break-all; }
        
        .instructions { background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 15px 20px; border-radius: 0 8px 8px 0; margin-bottom: 30px; }
        .instructions p { margin-bottom: 0; color: #1e3a8a; font-size: 14px; }
        
        .btn-container { text-align: center; margin-top: 35px; margin-bottom: 15px; }
        .btn { display: inline-block; background-color: #3b82f6; color: #ffffff; text-decoration: none; font-weight: 600; font-size: 15px; padding: 12px 28px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3); transition: background-color 0.2s; }
        
        .footer { padding: 30px 40px; background-color: #f9fafb; text-align: center; border-top: 1px solid #f3f4f6; }
        .footer p { margin: 0 0 10px 0; font-size: 13px; color: #9ca3af; line-height: 1.5; }
        .social-links { margin-top: 15px; }
        .social-links a { display: inline-block; margin: 0 5px; color: #9ca3af; text-decoration: none; font-weight: 600; font-size: 13px; }
    </style>
</head>
<body>
    @php
        $logo = \App\Models\Setting::get('logo');
        $siteName = \App\Models\Setting::get('site_name', config('app.name', 'TodoKeys'));
    @endphp

    <div class="email-wrapper">
        <div class="email-content">
            
            <!-- Header -->
            <div class="header">
                @if($logo)
                    <img src="{{ asset('storage/' . $logo) }}" alt="{{ $siteName }}">
                @else
                    <h1>{{ $siteName }}</h1>
                @endif
            </div>
            
            <!-- Body -->
            <div class="body">
                <p class="greeting">¡Hola!</p>
                
                <p>Nos complace informarte que se te ha asignado una nueva licencia de producto. Hemos preparado todo para que puedas empezar a disfrutarlo inmediatamente.</p>
                
                <div class="product-card">
                    <div class="product-label">Producto Adquirido</div>
                    <h2 class="product-name">{{ $license->product->name }}</h2>
                </div>
                
                <div class="key-container">
                    <span class="key-label">Tu Clave de Activación</span>
                    <div class="key-box">
                        {{ $license->key }}
                    </div>
                </div>
                
                <div class="instructions">
                    <p><strong>Nota importante:</strong> Por favor, guarda esta clave en un lugar seguro. Si tienes instrucciones específicas de instalación, las encontrarás en la página del producto o contactando con nuestro soporte.</p>
                </div>
                
                <p>Si tienes alguna pregunta, inconveniente o necesitas asistencia durante la activación, nuestro equipo de soporte técnico está listo para ayudarte en todo momento.</p>
                
                <div class="btn-container">
                    <a href="{{ url('/') }}" class="btn">Visitar la Tienda</a>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="footer">
                <p>Este es un mensaje automático generado por <strong>{{ $siteName }}</strong>. Por favor, no respondas directamente a este correo.</p>
                <p>&copy; {{ date('Y') }} {{ $siteName }}. Todos los derechos reservados.</p>
            </div>
            
        </div>
    </div>
</body>
</html>
