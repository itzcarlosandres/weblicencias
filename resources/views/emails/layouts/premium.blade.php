<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TodoKeys')</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&family=JetBrains+Mono:wght@700&display=swap');

        /* Estilos Base para Clientes de Correo */
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }
        img { border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
        table { border-collapse: collapse !important; }
        
        body { 
            height: 100% !important; 
            margin: 0 !important; 
            padding: 0 !important; 
            width: 100% !important; 
            background-color: #080C14; 
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
            color: #E2E8F0;
        }
        
        /* Clases Utilitarias */
        .wrapper { width: 100%; background-color: #080C14; padding: 40px 0; }
        .main-container { max-width: 580px; margin: 0 auto; background-color: #0F1524; border-radius: 20px; overflow: hidden; border: 1px solid #1E293B; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4); }
        .accent-bar { height: 4px; background: linear-gradient(90deg, #3B82F6 0%, #6366F1 50%, #8B5CF6 100%); }
        
        .header { padding: 45px 40px 20px 40px; text-align: center; }
        .logo { width: 130px; max-width: 100%; height: auto; margin-bottom: 10px; }
        .header-title { color: #ffffff; font-size: 26px; font-weight: 800; margin: 0; letter-spacing: 1px; text-shadow: 0 0 20px rgba(59, 130, 246, 0.2); text-transform: uppercase; }
        
        .content { padding: 20px 40px 40px 40px; color: #94A3B8; font-size: 15px; line-height: 1.6; }
        .content h1 { color: #ffffff; font-size: 24px; font-weight: 800; margin-top: 0; margin-bottom: 25px; letter-spacing: -0.5px; text-align: center; }
        .content h2 { color: #F8FAFC; font-size: 16px; font-weight: 700; margin-top: 35px; margin-bottom: 15px; letter-spacing: -0.2px; border-bottom: 1px solid #1E293B; padding-bottom: 8px; }
        .content p { margin-top: 0; margin-bottom: 20px; }
        .content a { color: #3B82F6; text-decoration: none; font-weight: 500; }
        
        /* Bloques de Licencias/Datos */
        .premium-block { background: linear-gradient(145deg, #161D30 0%, #1A243F 100%); border: 1px dashed rgba(56, 189, 248, 0.4); border-radius: 14px; padding: 24px; margin-bottom: 25px; box-shadow: inset 0 2px 4px rgba(255, 255, 255, 0.05); }
        .premium-block-title { background-color: rgba(56, 189, 248, 0.15); color: #38BDF8; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 6px; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block; margin-bottom: 12px; }
        .premium-block-value { display: block; background-color: #0A0F1D; border: 1px solid #1E293B; border-radius: 8px; padding: 16px; text-align: center; color: #60A5FA; font-size: 20px; font-weight: 700; font-family: 'JetBrains Mono', 'Courier New', monospace; letter-spacing: 2px; word-break: break-all; }
        
        /* Botones */
        .btn-container { text-align: center; margin: 35px 0 20px 0; }
        .btn { display: inline-block; background: linear-gradient(90deg, #3B82F6 0%, #6366F1 100%); color: #ffffff !important; font-weight: 700; font-size: 15px; text-decoration: none; padding: 15px 35px; border-radius: 10px; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3); text-align: center; }
        
        .footer { padding: 35px 40px; text-align: center; background-color: #0A0F1D; color: #475569; font-size: 12px; border-top: 1px solid #1E293B; line-height: 1.7; }
        .footer p { margin: 0 0 10px 0; }
        
        @media screen and (max-width: 600px) {
            .main-container { width: 100% !important; border-radius: 0 !important; border-left: none !important; border-right: none !important; }
            .content { padding: 25px 20px !important; }
            .header { padding: 35px 20px 15px 20px !important; }
            .footer { padding: 25px 20px !important; }
        }
    </style>
</head>
<body>
    <table border="0" cellpadding="0" cellspacing="0" class="wrapper">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" class="main-container">
                    <!-- Accent Bar -->
                    <tr>
                        <td class="accent-bar"></td>
                    </tr>

                    <!-- Header -->
                    <tr>
                        <td class="header">
                            @php
                                $siteName = \App\Models\Setting::get('site_name', 'TodoKeys');
                                $siteLogo = \App\Models\Setting::get('logo');
                            @endphp
                            @if($siteLogo)
                                <img src="{{ url('storage/settings/' . $siteLogo) }}" alt="{{ $siteName }}" class="logo" style="max-height: 50px; object-fit: contain; filter: brightness(0) invert(1);">
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
                            <div style="font-weight: 700; color: #64748B; font-size: 13px; margin-bottom: 10px; letter-spacing: 0.5px; text-transform: uppercase;">{{ $siteName }}.com</div>
                            <p>&copy; {{ date('Y') }} {{ $siteName }}. Todos los derechos reservados.</p>
                            @hasSection('unsubscribe')
                                <p style="font-size: 11px; margin-top: 15px; color: #475569;">
                                    Estás recibiendo este correo porque aceptaste recibir comunicaciones de marketing.<br>
                                    <a href="@yield('unsubscribe')" style="color: #64748B; text-decoration: underline;">Date de baja aquí</a>
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
