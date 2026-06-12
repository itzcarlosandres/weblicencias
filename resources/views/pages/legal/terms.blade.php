@extends('layouts.app')
@section('content')
    <div class="pt-24 pb-16 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 md:p-12">
                <div class="mb-10 text-center">
                    <h1 class="text-3xl font-black text-gray-900 mb-4">Términos de Servicio</h1>
                    <p class="text-gray-500">Última actualización: {{ date('d \d\e M, Y') }}</p>
                </div>

                <div class="prose prose-blue max-w-none text-gray-600">
                    <h2>1. Aceptación de los Términos</h2>
                    <p>Al acceder y utilizar TodoKeys, aceptas estar sujeto a estos términos y condiciones. Si no estás de acuerdo con alguna parte de los términos, no podrás acceder a nuestros servicios.</p>

                    <h2>2. Licencias y Productos Digitales</h2>
                    <p>Todas las licencias de software, juegos y gift cards vendidas en TodoKeys son productos digitales. Al completar tu compra, recibirás la clave de activación directamente en tu Bóveda de Cliente.</p>

                    <h2>3. Uso de la Cuenta</h2>
                    <p>Eres responsable de mantener la confidencialidad de tu cuenta y contraseña. TodoKeys no se hace responsable por accesos no autorizados debidos a negligencia del usuario.</p>

                    <h2>4. Política de Pagos</h2>
                    <p>Aceptamos diversos métodos de pago. Al procesar una transacción, garantizas que tienes el derecho legal de utilizar el método de pago seleccionado.</p>

                    <h2>5. Modificaciones del Servicio</h2>
                    <p>Nos reservamos el derecho de modificar o discontinuar cualquier producto o servicio sin previo aviso en cualquier momento.</p>

                    <hr class="my-8">
                    <p class="text-sm">Si tienes alguna pregunta sobre estos Términos, por favor contáctanos a través de nuestro Centro de Ayuda.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
