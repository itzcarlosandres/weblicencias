@extends('layouts.admin')

@section('title', 'Email Marketing')
@section('header', 'Campañas de Email')

@section('content')
<div class="max-w-4xl">
    <div class="mb-6">
        <h2 class="text-[18px] font-bold text-gray-900 dark:text-white">Crear Nueva Campaña</h2>
        <p class="text-[13px] text-gray-500">Envía correos con promociones a todos tus usuarios registrados usando el nuevo diseño Premium.</p>
    </div>

    <form action="{{ route('admin.marketing.send') }}" method="POST" class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 space-y-5">
        @csrf

        <div>
            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Asunto del correo *</label>
            <input type="text" name="subject" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" placeholder="Ej: ¡Ofertas de Verano: 50% de descuento!">
        </div>

        <div>
            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Título principal (Dentro del correo) *</label>
            <input type="text" name="title" required class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" placeholder="Ej: ¡No te pierdas las mejores ofertas del año!">
        </div>

        <div>
            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Contenido del correo *</label>
            <textarea name="content" required rows="6" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 resize-none" placeholder="Escribe el mensaje para tus clientes aquí..."></textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
            <div>
                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Texto del botón (Opcional)</label>
                <input type="text" name="button_text" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" placeholder="Ej: Ver Ofertas">
            </div>
            <div>
                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">URL del botón (Opcional)</label>
                <input type="url" name="button_url" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" placeholder="Ej: https://tusitio.com/ofertas">
            </div>
        </div>

        <div class="pt-4 border-t border-gray-200 dark:border-gray-800/60 mt-6">
            <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-bold rounded-xl transition-colors shadow-lg shadow-primary-500/20 flex items-center justify-center gap-2" onclick="return confirm('¿Estás seguro de enviar esta campaña a TODOS tus usuarios registrados?');">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                Enviar Campaña a Todos
            </button>
        </div>
    </form>
</div>
@endsection
