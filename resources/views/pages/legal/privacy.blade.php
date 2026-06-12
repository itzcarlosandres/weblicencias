@extends('layouts.app')
@section('content')
    <div class="pt-24 pb-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
                <div class="mb-10 text-center">
                    <h1 class="text-3xl font-black text-gray-900 mb-4">Política de Privacidad</h1>
                    <p class="text-gray-500">Última actualización: {{ date('d \d\e M, Y') }}</p>
                </div>

                <div class="prose prose-blue max-w-none text-gray-600">
                    <h2>1. Información que Recopilamos</h2>
                    <p>Recopilamos información cuando te registras en nuestro sitio, realizas un pedido o te suscribes a nuestro boletín. Esto incluye tu nombre, dirección de correo electrónico y detalles de la transacción.</p>

                    <h2>2. Uso de la Información</h2>
                    <p>La información recopilada se utiliza para:</p>
                    <ul>
                        <li>Procesar tus transacciones de forma segura.</li>
                        <li>Entregar tus claves de activación (licencias digitales).</li>
                        <li>Mejorar el servicio al cliente y tus consultas de soporte.</li>
                        <li>Administrar tu cuenta, el sistema de TodoPuntos y otras características del sitio.</li>
                    </ul>

                    <h2>3. Protección de Datos</h2>
                    <p>Implementamos una variedad de medidas de seguridad para mantener la seguridad de tu información personal. No almacenamos datos sensibles de tarjetas de crédito; todos los pagos son procesados a través de pasarelas seguras (PayPal, MercadoPago, etc.).</p>

                    <h2>4. Divulgación a Terceros</h2>
                    <p>No vendemos, intercambiamos ni transferimos a terceros tu información personal identificable. Esto no incluye a los terceros de confianza que nos asisten en operar nuestro sitio web o llevar a cabo nuestro negocio, siempre que esas partes acuerden mantener esta información confidencial.</p>

                    <hr class="my-8">
                    <p class="text-sm">Si tienes alguna pregunta sobre esta Política de Privacidad, por favor contáctanos a través de nuestro Centro de Ayuda.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
