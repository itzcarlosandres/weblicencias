<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TodoKeys')</title>
    <style>
        /* Estilos Base para Clientes de Correo */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        body { height: 100% !important; margin: 0 !important; padding: 0 !important; width: 100% !important; background-color: #0B1120; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        
        /* Clases Utilitarias */
        .wrapper { width: 100%; background-color: #0B1120; padding: 40px 0; }
        .main-container { max-width: 600px; margin: 0 auto; background-color: #111827; border-radius: 16px; overflow: hidden; border: 1px solid #1F2937; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        .header { background: linear-gradient(135deg, #1E3A8A 0%, #3B82F6 100%); padding: 30px; text-align: center; }
        .logo { width: 150px; max-width: 100%; height: auto; margin-bottom: 15px; }
        .header-title { color: #ffffff; font-size: 24px; font-weight: 800; margin: 0; letter-spacing: -0.5px; }
        
        .content { padding: 40px 30px; color: #D1D5DB; font-size: 16px; line-height: 1.6; }
        .content h1 { color: #ffffff; font-size: 22px; font-weight: 700; margin-top: 0; margin-bottom: 20px; }
        .content h2 { color: #F3F4F6; font-size: 18px; font-weight: 600; margin-top: 30px; margin-bottom: 15px; }
        .content p { margin-top: 0; margin-bottom: 20px; }
        .content a { color: #3B82F6; text-decoration: none; font-weight: 500; }
        
        /* Bloques de Licencias/Datos */
        .premium-block { background-color: #1F2937; border-left: 4px solid #3B82F6; border-radius: 8px; padding: 20px; margin-bottom: 25px; }
        .premium-block-title { color: #9CA3AF; font-size: 12px; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px; font-weight: 600; }
        .premium-block-value { color: #ffffff; font-size: 18px; font-weight: 700; font-family: monospace; letter-spacing: 1px; word-break: break-all; }
        
        /* Botones */
        .btn-container { text-align: center; margin: 35px 0; }
        .btn { display: inline-block; background: linear-gradient(to right, #3B82F6, #2563EB); color: #ffffff !important; font-weight: 600; font-size: 16px; text-decoration: none; padding: 14px 30px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.3); }
        
        .footer { padding: 30px; text-align: center; background-color: #0B1120; color: #6B7280; font-size: 13px; border-top: 1px solid #1F2937; }
        .social-icons { margin-bottom: 15px; }
        .social-icons img { width: 24px; margin: 0 5px; opacity: 0.7; }
        
        @media screen and (max-width: 600px) {
            .main-container { width: 100% !important; border-radius: 0 !important; }
            .content { padding: 30px 20px !important; }
        }
    </style>
</head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" class="wrapper">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" class="main-container">
                    <!-- Header -->
                    <tr>
                        <td class="header">
                            @php
                                $siteName = \App\Models\Setting::get('site_name', 'TodoKeys');
                                $siteLogo = \App\Models\Setting::get('logo');
                            @endphp
                            @if($siteLogo)
                                <img src="{{ url('storage/settings/' . $siteLogo) }}" alt="{{ $siteName }}" class="logo" style="width:120px; height:auto; object-fit:contain; filter: brightness(0) invert(1);">
                            @else
                                <h1 class="header-title">{{ $siteName }}</h1>
                            @endif
                        </td>
                    </tr>
                    
                    <!-- Content -->
                    <tr>
                        <td class="content">
                            @yield('content')
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td class="footer">
                            <p style="margin-bottom: 10px;">&copy; {{ date('Y') }} {{ $siteName }}. Todos los derechos reservados.</p>
                            @hasSection('unsubscribe')
                                <p style="font-size: 11px; margin-top: 15px;">
                                    Estás recibiendo este correo porque aceptaste recibir comunicaciones de marketing.<br>
                                    <a href="@yield('unsubscribe')" style="color: #6B7280; text-decoration: underline;">Date de baja aquí</a>
                                </p>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
