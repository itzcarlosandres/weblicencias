@extends('layouts.app')

@php
    $helpCenterJson = \App\Models\Setting::get('help_center_content', '[]');
    $helpCenter = json_decode($helpCenterJson, true);
    if (!is_array($helpCenter) || empty($helpCenter)) {
        $helpCenter = [
            [
                'category' => 'activation',
                'question' => '¿Cómo activo mi clave de producto Windows?',
                'answer' => '<p>Para activar Windows, realiza los siguientes pasos:</p><ol class="list-decimal pl-5 mt-2 space-y-1"><li>Ve a <strong>Inicio > Configuración > Sistema > Activación</strong>.</li><li>Haz clic en la opción <strong>"Cambiar la clave de producto"</strong>.</li><li>Copia e ingresa la clave de 25 caracteres enviada por correo.</li><li>Haz clic en <strong>Siguiente</strong> y luego en <strong>Activar</strong>. El proceso tardará unos segundos.</li></ol>'
            ],
            [
                'category' => 'activation',
                'question' => '¿Qué hago si la clave de Office da error?',
                'answer' => '<p>Para garantizar una activación correcta de Office, te recomendamos:</p><ul class="list-disc pl-5 mt-2 space-y-1"><li><strong>Desinstalar versiones previas</strong>: Elimina cualquier copia anterior de Office o Microsoft 365 que esté preinstalada en tu equipo.</li><li><strong>Canjear en la web oficial</strong>: Ve a <a href="https://setup.office.com" target="_blank" class="text-blue-600 font-bold hover:underline">setup.office.com</a>, inicia sesión con tu cuenta de Microsoft, canjea el código y descarga la versión correcta.</li><li><strong>Usa el asistente</strong>: Si persiste el error, toma una captura de pantalla y ábrenos un ticket para asistirte.</li></ul>'
            ],
            [
                'category' => 'activation',
                'question' => '¿Las licencias digitales expiran?',
                'answer' => '<p>No. Todas nuestras claves para sistemas operativos (Windows 10/11) y suites de Office (2019/2021) son <strong>perpetuas (Lifetime)</strong>. Esto significa que no tienen cargos recurrentes ni fecha de expiración.</p>'
            ],
            [
                'category' => 'delivery',
                'question' => '¿Cuánto tiempo tarda en llegar mi pedido?',
                'answer' => '<p>¡La entrega es <strong>100% instantánea y digital</strong>! El sistema te mostrará tu licencia directamente en la pantalla de confirmación y se enviará una copia automática a tu correo electrónico registrado.</p>'
            ],
            [
                'category' => 'delivery',
                'question' => 'No he recibido el correo con la clave, ¿qué debo hacer?',
                'answer' => '<p>Si no visualizas el correo electrónico en tu bandeja principal, revisa tus carpetas de <strong>Correo No Deseado (SPAM)</strong> o inicia sesión en TodoKeys e ingresa a tu panel en la sección <strong>Mis Pedidos</strong>.</p>'
            ],
            [
                'category' => 'payments',
                'question' => '¿Qué formas de pago tienen disponibles?',
                'answer' => '<p>Ofrecemos diferentes pasarelas de pago de alta seguridad: <strong>PayPal</strong>, <strong>Mercado Pago</strong> (PSE, tarjetas locales) y <strong>Wompi</strong>.</p>'
            ],
            [
                'category' => 'refunds',
                'question' => '¿Cómo funciona la política de garantía de licencias?',
                'answer' => '<p>Nuestra prioridad es que tengas un software funcional. Si una licencia arroja un fallo que no se pueda solucionar tras la asistencia de nuestro equipo, te daremos un <strong>reemplazo inmediato</strong> de la clave o un <strong>reembolso total</strong> de tu dinero.</p>'
            ]
        ];
    }
    
    $formattedArticles = [];
    foreach($helpCenter as $item) {
        $formattedArticles[] = [
            'category' => $item['category'],
            'q' => $item['question'],
            'a' => $item['answer']
        ];
    }
@endphp

@section('title', 'Centro de Ayuda | TodoKeys')
@section('description', 'Encuentra respuestas rápidas a preguntas frecuentes sobre activación de licencias de software, métodos de pago, entregas y políticas de garantía.')

@section('content')
<style>
    body { background-color: #f5f5f5 !important; color: #333 !important; }
    
    /* Sliding Grid Animation for Hero */
    @keyframes gridSlide {
        0% { background-position: 0 0; }
        100% { background-position: 40px 40px; }
    }
    .animate-grid-slide {
        animation: gridSlide 4s linear infinite;
    }
</style>

<!-- Help Center Wrapper with Alpine.js state -->
<div x-data="helpCenterComponent()" class="w-full">

    <!-- Hero Search Section -->
    <section class="relative bg-[#09090b] pt-16 pb-24 overflow-hidden border-b border-zinc-900">
        <!-- Grid Pattern Background -->
        <div class="absolute inset-0 opacity-[0.02] animate-grid-slide" style="background-image: linear-gradient(to right, #ffffff 1px, transparent 1px), linear-gradient(to bottom, #ffffff 1px, transparent 1px); background-size: 40px 40px;"></div>
        
        <!-- Glow Backdrops -->
        <div class="absolute top-1/2 left-1/4 -translate-y-1/2 w-80 h-80 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-80 h-80 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-[1200px] mx-auto px-4 relative z-10">
            <!-- Breadcrumbs -->
            <nav class="flex items-center gap-2 mb-6 text-xs font-bold uppercase tracking-wider text-zinc-500">
                <a href="{{ route('home') }}" class="hover:text-blue-400 transition-colors">Inicio</a>
                <span>/</span>
                <span class="text-blue-500">Centro de Ayuda</span>
            </nav>

            <div class="text-center max-w-2xl mx-auto">
                <span class="px-3 py-1.5 rounded-full bg-blue-500/10 text-blue-400 text-[10px] font-black tracking-wider uppercase border border-blue-500/20 inline-flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-circle-question"></i> BASE DE CONOCIMIENTO
                </span>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-white tracking-tight mb-6" style="font-family: 'Bricolage Grotesque', sans-serif;">
                    ¿En qué podemos <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 via-indigo-400 to-purple-400">ayudarte?</span>
                </h1>
                
                <!-- Instant Search Bar -->
                <div class="relative max-w-xl mx-auto shadow-2xl rounded-2xl overflow-hidden bg-white/10 backdrop-blur-md p-1.5 border border-white/10">
                    <div class="flex items-center bg-white rounded-xl overflow-hidden shadow-inner pl-4">
                        <span class="text-gray-400 shrink-0">
                            <i class="fa-solid fa-magnifying-glass text-lg"></i>
                        </span>
                        <input 
                            type="text" 
                            x-model="search" 
                            placeholder="Escribe tu duda (ej. Office, pago, reembolso)..." 
                            class="w-full px-3 py-4 text-sm text-gray-900 focus:outline-none placeholder-gray-400 bg-transparent font-medium"
                        >
                        <button 
                            @click="search = ''" 
                            x-show="search !== ''" 
                            class="p-4 text-gray-400 hover:text-gray-600 transition-colors shrink-0"
                            style="display: none;"
                        >
                            <i class="fa-solid fa-xmark"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content Area -->
    <div class="max-w-[1200px] mx-auto px-4 py-12 -mt-10 sm:-mt-14 relative z-20">
        
        <!-- Category Filter Cards -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10">
            <!-- All Categories button -->
            <button 
                @click="activeCategory = 'all'" 
                :class="activeCategory === 'all' ? 'border-blue-500 shadow-md scale-[1.02]' : 'border-gray-100 hover:border-gray-300 hover:scale-[1.01]'"
                class="bg-white rounded-2xl p-5 border text-center transition-all duration-300 flex flex-col items-center justify-center gap-3 group cursor-pointer"
            >
                <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold shadow-sm transition-all"
                     :style="activeCategory === 'all' ? 'background-color: #2563eb; color: #fff;' : 'background-color: rgba(100,116,139,0.1); color: #64748b;'">
                    <i class="fa-solid fa-list text-lg"></i>
                </div>
                <span class="text-xs font-bold uppercase tracking-wider text-gray-800">Todos</span>
            </button>

            <!-- Loop Categories -->
            <template x-for="cat in categories" :key="cat.id">
                <button 
                    @click="activeCategory = cat.id" 
                    :class="activeCategory === cat.id ? 'border-blue-500 shadow-md scale-[1.02]' : 'border-gray-100 hover:border-gray-300 hover:scale-[1.01]'"
                    class="bg-white rounded-2xl p-5 border text-center transition-all duration-300 flex flex-col items-center justify-center gap-3 group cursor-pointer"
                >
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold shadow-sm transition-all"
                         :style="activeCategory === cat.id ? 'background-color: ' + cat.color + '; color: #fff;' : 'background-color: ' + cat.bg + '; color: ' + cat.color + ';'">
                        <i :class="'fa-solid ' + cat.icon + ' text-lg'"></i>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-800" x-text="cat.name"></span>
                </button>
            </template>
        </div>

        <!-- FAQs Accordion Section -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Side: Category indicators & quick tips -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Tip Card -->
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)]">
                    <h3 class="font-black text-gray-900 text-sm uppercase tracking-wider mb-4 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-blue-500"></i> Consejos de Soporte
                    </h3>
                    <ul class="space-y-3.5 text-xs text-gray-500 leading-relaxed">
                        <li class="flex gap-2.5">
                            <span class="text-blue-500"><i class="fa-solid fa-circle text-[8px] mt-1.5"></i></span>
                            <span>Siempre ten tu **ID de pedido** a la mano si necesitas ayuda con alguna clave adquirida.</span>
                        </li>
                        <li class="flex gap-2.5">
                            <span class="text-blue-500"><i class="fa-solid fa-circle text-[8px] mt-1.5"></i></span>
                            <span>Las guías de activación se adjuntan en tu correo de compra y en tu panel.</span>
                        </li>
                        <li class="flex gap-2.5">
                            <span class="text-blue-500"><i class="fa-solid fa-circle text-[8px] mt-1.5"></i></span>
                            <span>Para fallos de Office, desinstala completamente las versiones previas antes de canjear.</span>
                        </li>
                    </ul>
                </div>

                <!-- Guarantee Card -->
                <div class="rounded-2xl p-6 text-white overflow-hidden relative shadow-[0_8px_30px_rgba(37,99,235,0.15)]" style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%);">
                    <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-blue-500/10 blur-xl rounded-full"></div>
                    <div class="relative z-10">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 flex items-center justify-center text-blue-300 mb-4 border border-blue-500/30">
                            <i class="fa-solid fa-shield-halved text-lg"></i>
                        </div>
                        <h4 class="font-extrabold text-sm uppercase tracking-wide mb-1">Garantía Total</h4>
                        <p class="text-[11px] text-gray-300 leading-relaxed">
                            Todas tus compras están protegidas por nuestra garantía de activación permanente. Si una licencia falla, la cambiamos sin costo.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side: Accordion Lists -->
            <div class="lg:col-span-8 space-y-4">
                
                <!-- Loop through articles -->
                <template x-for="(art, index) in filteredArticles" :key="index">
                    <div x-data="{ open: false }" class="bg-white rounded-2xl border border-gray-100 shadow-[0_4px_20px_rgb(0,0,0,0.01)] transition-all overflow-hidden">
                        <!-- Accordion Header -->
                        <button 
                            @click="open = !open" 
                            class="w-full flex items-center justify-between p-5 text-left font-bold text-gray-800 hover:text-blue-600 transition-colors cursor-pointer"
                        >
                            <span class="text-sm sm:text-base pr-4" x-text="art.q"></span>
                            <span 
                                class="w-6 h-6 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center transition-all duration-300"
                                :class="open ? 'rotate-180 bg-blue-50 text-blue-600' : ''"
                            >
                                <i class="fa-solid fa-chevron-down text-[10px]"></i>
                            </span>
                        </button>
                        
                        <!-- Accordion Body -->
                        <div 
                            x-show="open" 
                            x-transition.opacity.duration.300ms 
                            class="px-5 pb-5 pt-0 text-sm text-gray-500 border-t border-gray-50 leading-relaxed bg-gray-50/20"
                            style="display: none;"
                        >
                            <div class="pt-4" x-html="art.a"></div>
                        </div>
                    </div>
                </template>

                <!-- No Results State -->
                <div 
                    x-show="filteredArticles.length === 0" 
                    x-cloak 
                    class="bg-white rounded-3xl p-10 text-center border border-gray-100 shadow-sm max-w-xl mx-auto"
                    style="display: none;"
                >
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-2xl text-gray-300 mx-auto mb-5">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="text-lg font-black text-gray-900 uppercase">Sin Resultados</h3>
                    <p class="text-xs text-gray-500 mt-2 max-w-sm mx-auto">
                        No pudimos encontrar respuestas para "<span x-text="search" class="font-bold text-blue-600"></span>". Intenta con otras palabras o escríbenos directamente.
                    </p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs uppercase px-6 py-3 rounded-xl transition-all shadow-md mt-6">
                        Contactar Soporte <i class="fa-solid fa-paper-plane text-[10px]"></i>
                    </a>
                </div>

            </div>

        </div>

        <!-- CTA Callout Block -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-16">
            <!-- Card 1: Public Contact -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col sm:flex-row items-start gap-6 group hover:shadow-[0_12px_45px_rgba(0,0,0,0.03)] hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(37, 99, 235, 0.12);">
                    <i class="fa-solid fa-paper-plane text-2xl" style="color: #2563eb;"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-black text-gray-900 text-lg uppercase tracking-tight">¿Tienes dudas comerciales?</h4>
                    <p class="text-xs text-gray-500 leading-relaxed mt-2 mb-6">
                        Ponte en contacto para consultas sobre compras corporativas, licencias por volumen o cotizaciones de software.
                    </p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 font-black text-xs uppercase tracking-wider text-blue-600 hover:text-blue-700 group-hover:translate-x-1 transition-all">
                        Escríbenos Ahora <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>

            <!-- Card 2: User Tickets Support -->
            <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-[0_8px_30px_rgb(0,0,0,0.015)] flex flex-col sm:flex-row items-start gap-6 group hover:shadow-[0_12px_45px_rgba(0,0,0,0.03)] hover:-translate-y-1 transition-all duration-300">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center shrink-0" style="background-color: rgba(16, 185, 129, 0.12);">
                    <i class="fa-solid fa-ticket text-2xl" style="color: #10b981;"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="font-black text-gray-900 text-lg uppercase tracking-tight">¿Alguna clave no funciona?</h4>
                    <p class="text-xs text-gray-500 leading-relaxed mt-2 mb-6">
                        Abre un ticket de soporte técnico. Nuestro equipo revisará tu caso y gestionará el reemplazo bajo garantía.
                    </p>
                    <a href="{{ route('customer.tickets') }}" class="inline-flex items-center gap-2 font-black text-xs uppercase tracking-wider text-green-600 hover:text-green-700 group-hover:translate-x-1 transition-all">
                        Abrir un Ticket <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                </div>
            </div>
        </div>

    </div>

</div>

<!-- Component data and filtering script -->
<script>
function helpCenterComponent() {
    return {
        search: '',
        activeCategory: 'all',
        categories: [
            { id: 'activation', name: 'Activación', icon: 'fa-key', color: '#3b82f6', bg: 'rgba(59,130,246,0.1)' },
            { id: 'delivery', name: 'Entregas', icon: 'fa-bolt', color: '#f59e0b', bg: 'rgba(245,158,11,0.1)' },
            { id: 'payments', name: 'Pagos', icon: 'fa-credit-card', color: '#10b981', bg: 'rgba(16,185,129,0.1)' },
            { id: 'refunds', name: 'Reembolsos', icon: 'fa-shield-halved', color: '#ef4444', bg: 'rgba(239,68,68,0.1)' }
        ],
        articles: @json($formattedArticles),
        get filteredArticles() {
            return this.articles.filter(art => {
                const matchesSearch = this.search === '' || 
                    art.q.toLowerCase().includes(this.search.toLowerCase()) || 
                    art.a.toLowerCase().includes(this.search.toLowerCase());
                const matchesCategory = this.activeCategory === 'all' || art.category === this.activeCategory;
                return matchesSearch && matchesCategory;
            });
        }
    }
}
</script>
@endsection
