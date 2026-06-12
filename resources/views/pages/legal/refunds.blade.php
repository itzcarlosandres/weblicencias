@extends('layouts.app')
@section('content')
    <div class="pt-24 pb-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
                <div class="mb-10 text-center">
                    <h1 class="text-3xl font-black text-gray-900 mb-4">Política de Reembolso</h1>
                    <p class="text-gray-500">Última actualización: {{ date('d \d\e M, Y') }}</p>
                </div>

                <div class="prose prose-blue max-w-none text-gray-600">
                    <h2>1. Naturaleza de los Productos Digitales</h2>
                    <p>En TodoKeys vendemos productos intangibles y digitales (licencias de software, códigos de juegos y gift cards). Debido a la naturaleza de estos productos, una vez que una clave ha sido revelada o entregada, la venta se considera final.</p>

                    <h2>2. Condiciones para Reembolsos</h2>
                    <p>Otorgamos reembolsos bajo las siguientes circunstancias excepcionales:</p>
                    <ul>
                        <li>La clave de activación proporcionada es inválida o defectuosa (se requerirá prueba por medio de capturas de pantalla o soporte remoto).</li>
                        <li>El producto no ha sido revelado en la Bóveda del Cliente y se solicita el reembolso dentro de los 14 días posteriores a la compra.</li>
                        <li>Has comprado por error el mismo producto dos veces (transacción duplicada) y no has revelado la segunda clave.</li>
                    </ul>

                    <h2>3. Casos no Reembolsables</h2>
                    <p>No podemos ofrecer reembolsos si:</p>
                    <ul>
                        <li>Ya has revelado/visto la clave del producto y simplemente cambiaste de opinión.</li>
                        <li>Compraste una clave para la plataforma o región incorrecta (verifica siempre la región y plataforma antes de comprar).</li>
                        <li>Tu equipo no cumple con los requisitos mínimos del sistema para ejecutar el software o juego.</li>
                    </ul>

                    <h2>4. Proceso de Reembolso</h2>
                    <p>Para solicitar un reembolso, por favor abre un ticket de soporte en tu panel de cliente detallando el problema. Nuestro equipo evaluará tu solicitud y responderá en un plazo de 24 a 48 horas laborables. Si se aprueba, el reembolso se procesará al mismo método de pago utilizado en la compra original.</p>

                    <hr class="my-8">
                    <p class="text-sm">Si tienes problemas con una licencia, no dudes en contactarnos. Estamos comprometidos con garantizar el funcionamiento de todo lo que vendemos.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
