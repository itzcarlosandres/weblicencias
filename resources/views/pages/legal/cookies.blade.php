@extends('layouts.app')
@section('content')
    <div class="pt-24 pb-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
                <div class="mb-10 text-center">
                    <h1 class="text-3xl font-black text-gray-900 mb-4">Política de Cookies</h1>
                    <p class="text-gray-500">Última actualización: {{ date('d \d\e M, Y') }}</p>
                </div>

                <div class="prose prose-blue max-w-none text-gray-600">
                    <h2>1. ¿Qué son las Cookies?</h2>
                    <p>Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo (ordenador, tableta o móvil) cuando visitas un sitio web. Se utilizan ampliamente para hacer que los sitios funcionen, o funcionen de manera más eficiente, así como para proporcionar información a los propietarios del sitio.</p>

                    <h2>2. Cómo usamos las Cookies</h2>
                    <p>En TodoKeys utilizamos cookies para varios propósitos importantes:</p>
                    <ul>
                        <li><strong>Cookies Esenciales:</strong> Son necesarias para que el sitio funcione correctamente, permitiéndote navegar por la página, mantener tu sesión iniciada y gestionar tu carrito de compras de forma segura.</li>
                        <li><strong>Cookies Funcionales:</strong> Nos permiten recordar tus preferencias (como la moneda seleccionada, USD, COP, EUR, etc.) para que no tengas que configurarla cada vez que nos visitas.</li>
                        <li><strong>Cookies de Rendimiento:</strong> Nos ayudan a entender cómo los visitantes interactúan con nuestro sitio, recopilando y reportando información de forma anónima para mejorar la experiencia de usuario.</li>
                    </ul>

                    <h2>3. Cookies de Terceros</h2>
                    <p>Además de nuestras propias cookies, también podemos utilizar diversas cookies de terceros (como Google Analytics o proveedores de pago) para informar estadísticas de uso del sitio web y garantizar la seguridad de las transacciones.</p>

                    <h2>4. Gestión de tus Cookies</h2>
                    <p>Puedes configurar tu navegador para rechazar todas o algunas de las cookies, o para que te avise cuando los sitios web configuren o accedan a las cookies. Si desactivas o rechazas las cookies, ten en cuenta que algunas partes de este sitio web (como el carrito de compras o tu inicio de sesión) pueden volverse inaccesibles o no funcionar correctamente.</p>

                    <hr class="my-8">
                    <p class="text-sm">Al continuar utilizando nuestro sitio web, aceptas el uso de cookies como se describe en esta política.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
