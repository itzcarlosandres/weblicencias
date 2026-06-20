@extends('layouts.app')

@section('title', 'Contacto | TodoKeys')
@section('description', 'Ponte en contacto con el equipo de soporte de TodoKeys. Estamos disponibles para ayudarte con tus licencias de software, dudas o soporte técnico.')

@section('content')
<style>
    body { background-color: #f5f5f5 !important; color: #333 !important; }
    
    /* Input float label and transitions */
    .form-input-container {
        position: relative;
    }
    .form-input {
        transition: all 0.3s ease;
    }
    .form-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.1);
    }
    
    /* Sliding Grid Animation for Hero */
    @keyframes gridSlide {
        0% { background-position: 0 0; }
        100% { background-position: 40px 40px; }
    }
    .animate-grid-slide {
        animation: gridSlide 4s linear infinite;
    }
</style>

<!-- Hero Section (Estilo Dark Matte premium coordinado con la Home) -->
<section class="relative bg-[#09090b] pt-16 pb-20 overflow-hidden border-b border-zinc-900">
    <!-- Grid Pattern Background -->
    <div class="absolute inset-0 opacity-[0.02] animate-grid-slide" style="background-image: linear-gradient(to right, #ffffff 1px, transparent 1px), linear-gradient(to bottom, #ffffff 1px, transparent 1px); background-size: 40px 40px;"></div>
    
    <!-- Decorative glow -->
    <div class="absolute top-1/2 left-1/4 -translate-y-1/2 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-[1200px] mx-auto px-4 relative z-10 text-center md:text-left">
        <!-- Breadcrumbs -->
        <nav class="flex justify-center md:justify-start items-center gap-2 mb-6 text-xs font-bold uppercase tracking-wider text-zinc-500">
            <a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors">Inicio</a>
            <span>/</span>
            <span class="text-blue-500">Contacto</span>
        </nav>
        
        <div class="max-w-3xl">
            <span class="px-3 py-1.5 rounded-full bg-blue-500/10 text-blue-400 text-[10px] font-black tracking-wider uppercase border border-blue-500/20 inline-flex items-center gap-2 mb-4">
                <i class="fa-solid fa-headset animate-pulse"></i> SOPORTE GLOBAL 24/7
            </span>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight mb-4" style="font-family: 'Bricolage Grotesque', sans-serif;">
                ¿Cómo podemos <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400">ayudarte hoy?</span>
            </h1>
            <p class="text-zinc-400 text-base sm:text-lg font-light leading-relaxed max-w-2xl">
                Nuestro equipo técnico y de atención al cliente está siempre listo para resolver tus dudas sobre activación de licencias, facturación o soporte post-venta.
            </p>
        </div>
    </div>
</section>

<!-- Main Container -->
<div class="max-w-[1200px] mx-auto px-4 py-12 -mt-10 sm:-mt-14 relative z-20">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Column: Support Cards & FAQ -->
        <div class="lg:col-span-5 space-y-6">
            
            <!-- Cards Grid -->
            <div class="grid grid-cols-1 gap-4">
                
                <!-- Email Support Card -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] hover:shadow-[0_12px_40px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold shadow-sm shrink-0" style="background-color: rgba(37, 99, 235, 0.12);">
                            <i class="fa-solid fa-envelope-open-text text-xl" style="color: #2563eb;"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Correo Electrónico</h3>
                            <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'soporte@todokeys.co') }}" class="block font-bold text-gray-800 text-lg hover:text-blue-600 transition-colors truncate mt-0.5">
                                {{ \App\Models\Setting::get('contact_email', 'soporte@todokeys.co') }}
                            </a>
                            <p class="text-xs text-gray-500 mt-1">Respuestas en menos de 24 horas hábiles.</p>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp Support Card -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] hover:shadow-[0_12px_40px_rgba(0,0,0,0.04)] hover:-translate-y-1 transition-all duration-300 group">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold shadow-sm shrink-0" style="background-color: rgba(37, 211, 102, 0.12);">
                            <i class="fa-brands fa-whatsapp text-2xl" style="color: #128c7e;"></i>
                        </div>
                        <div class="min-w-0">
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">WhatsApp Directo</h3>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('contact_whatsapp', '573236861025')) }}" target="_blank" class="block font-bold text-gray-800 text-lg hover:text-green-600 transition-colors truncate mt-0.5">
                                {{ \App\Models\Setting::get('contact_phone', '+57 323 686 1025') }}
                            </a>
                            <p class="text-xs text-gray-500 mt-1">Chatea con un asesor de soporte técnico.</p>
                        </div>
                    </div>
                </div>

                <!-- Business Hours Card -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold shadow-sm shrink-0" style="background-color: rgba(245, 158, 11, 0.12);">
                            <i class="fa-solid fa-clock-three text-xl" style="color: #d97706;"></i>
                        </div>
                        <div>
                            <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Horario de Soporte</h3>
                            <p class="font-bold text-gray-800 text-md mt-0.5">Lunes a Sábado: 8:00 AM - 8:00 PM</p>
                            <p class="text-xs text-gray-500 mt-1">Zona Horaria: UTC-5 (Bogotá/Lima/CDMX).</p>
                        </div>
                    </div>
                </div>
                
            </div>

            <!-- Mini FAQ section specific to Contact -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-question text-blue-500"></i> Preguntas Rápidas
                </h3>
                <div class="space-y-3">
                    <details class="group cursor-pointer">
                        <summary class="flex justify-between items-center font-bold text-gray-700 list-none text-xs py-2 border-b border-gray-100">
                            <span>¿Cuándo recibiré mi clave de producto?</span>
                            <span class="transition-transform duration-300 group-open:rotate-180 text-blue-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </span>
                        </summary>
                        <p class="text-xs text-gray-500 leading-relaxed py-2 pl-1 bg-gray-50/50 rounded-lg mt-1">
                            ¡De manera inmediata! Tras verificar tu pago, el sistema envía automáticamente tu clave y las instrucciones a tu correo electrónico registrado y a tu sección de compras.
                        </p>
                    </details>

                    <details class="group cursor-pointer">
                        <summary class="flex justify-between items-center font-bold text-gray-700 list-none text-xs py-2 border-b border-gray-100">
                            <span>¿Las licencias tienen garantía?</span>
                            <span class="transition-transform duration-300 group-open:rotate-180 text-blue-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </span>
                        </summary>
                        <p class="text-xs text-gray-500 leading-relaxed py-2 pl-1 bg-gray-50/50 rounded-lg mt-1">
                            Sí, todas nuestras licencias digitales cuentan con garantía total de activación. Si surge algún inconveniente, te asistiremos para reemplazar la clave de forma gratuita.
                        </p>
                    </details>

                    <details class="group cursor-pointer">
                        <summary class="flex justify-between items-center font-bold text-gray-700 list-none text-xs py-2">
                            <span>¿Qué métodos de pago aceptan?</span>
                            <span class="transition-transform duration-300 group-open:rotate-180 text-blue-500">
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </span>
                        </summary>
                        <p class="text-xs text-gray-500 leading-relaxed py-2 pl-1 bg-gray-50/50 rounded-lg mt-1">
                            Aceptamos pagos a través de PayPal, Mercado Pago (Tarjetas de crédito/débito, transferencias bancarias locales) y Wompi. Todos los pagos son procesados de forma 100% segura.
                        </p>
                    </details>
                </div>
            </div>

        </div>

        <!-- Right Column: Interactive Form -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.02)]">
                
                <!-- Status Alerts -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3 transition-all">
                        <div class="w-8 h-8 bg-green-500/10 text-green-600 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-check"></i>
                        </div>
                        <div>
                            <p class="font-bold text-sm">¡Mensaje enviado!</p>
                            <p class="text-xs opacity-90">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3 transition-all">
                        <div class="w-8 h-8 bg-red-500/10 text-red-600 rounded-full flex items-center justify-center shrink-0">
                            <i class="fa-solid fa-circle-xmark"></i>
                        </div>
                        <div>
                            <p class="font-bold text-sm">Error al enviar</p>
                            <p class="text-xs opacity-90">{{ session('error') }}</p>
                        </div>
                    </div>
                @endif

                <div class="mb-6">
                    <h2 class="text-xl font-black text-gray-900 uppercase tracking-tight">Envíanos un mensaje</h2>
                    <p class="text-sm text-gray-500 mt-1">Completa el formulario y te daremos respuesta rápida.</p>
                </div>

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-5" x-data="{ sending: false }" @submit="sending = true">
                    @csrf
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <!-- Name input -->
                        <div class="form-input-container">
                            <label for="name" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Nombre Completo</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="Ej. Carlos Andrés" required
                                       class="form-input w-full pl-11 pr-4 py-3 bg-gray-50/50 border @error('name') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm font-medium text-gray-900 focus:outline-none placeholder-gray-400">
                            </div>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email input -->
                        <div class="form-input-container">
                            <label for="email" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Correo Electrónico</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                    <i class="fa-solid fa-envelope"></i>
                                </span>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="ejemplo@correo.com" required
                                       class="form-input w-full pl-11 pr-4 py-3 bg-gray-50/50 border @error('email') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm font-medium text-gray-900 focus:outline-none placeholder-gray-400">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Subject input -->
                    <div class="form-input-container">
                        <label for="subject" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Asunto del Mensaje</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400">
                                <i class="fa-solid fa-circle-info"></i>
                            </span>
                            <input type="text" name="subject" id="subject" value="{{ old('subject') }}" placeholder="¿En qué podemos ayudarte?" required
                                   class="form-input w-full pl-11 pr-4 py-3 bg-gray-50/50 border @error('subject') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm font-medium text-gray-900 focus:outline-none placeholder-gray-400">
                        </div>
                        @error('subject')
                            <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Message textarea -->
                    <div class="form-input-container">
                        <label for="message" class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Mensaje o Consulta</label>
                        <div class="relative">
                            <span class="absolute left-4 top-4 text-gray-400">
                                <i class="fa-solid fa-comment-dots"></i>
                            </span>
                            <textarea name="message" id="message" rows="5" placeholder="Escribe tu mensaje con detalles (mínimo 10 caracteres)..." required
                                      class="form-input w-full pl-11 pr-4 py-3 bg-gray-50/50 border @error('message') border-red-400 @else border-gray-200 @enderror rounded-xl text-sm font-medium text-gray-900 focus:outline-none placeholder-gray-400 resize-y min-h-[120px]">{{ old('message') }}</textarea>
                        </div>
                        @error('message')
                            <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Button -->
                    <button type="submit" 
                            x-bind:disabled="sending"
                            class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 disabled:bg-blue-400 text-white py-4 rounded-xl font-bold text-sm shadow-lg shadow-blue-500/20 hover:shadow-blue-500/35 transition-all duration-300 transform hover:-translate-y-0.5">
                        <span x-show="!sending" class="flex items-center gap-2">
                            <span>Enviar Mensaje</span>
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                        </span>
                        <span x-show="sending" x-cloak class="flex items-center gap-2" style="display: none;">
                            <svg class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span>Enviando mensaje...</span>
                        </span>
                    </button>
                </form>
                
            </div>
        </div>

    </div>


</div>
@endsection
