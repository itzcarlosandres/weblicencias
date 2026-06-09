@extends('layouts.admin')

@section('title', 'Configuración | Admin')
@section('header', 'Configuración')

@section('content')
<div x-data="{ activeTab: '{{ session('active_tab', 'general') }}' }">
    <!-- Tabs -->
    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 mb-6 overflow-hidden">
        <div class="flex border-b border-gray-100 dark:border-gray-800/60 overflow-x-auto">
            <button @click="activeTab = 'general'" :class="activeTab === 'general' ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                General
            </button>
            <button @click="activeTab = 'branding'" :class="activeTab === 'branding' ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                Logo & Favicon
            </button>
            <button @click="activeTab = 'seo'" :class="activeTab === 'seo' ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                SEO
            </button>
            <button @click="activeTab = 'emails'" :class="activeTab === 'emails' ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Emails
            </button>
            <button @click="activeTab = 'payment'" :class="activeTab === 'payment' ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                Pagos
            </button>
            <button @click="activeTab = 'points'" :class="activeTab === 'points' ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Puntos & Recompensas
            </button>
            <button @click="activeTab = 'ai'" :class="activeTab === 'ai' ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0">
                <i class="fa-solid fa-wand-magic-sparkles w-4"></i>
                Inteligencia Artificial
            </button>
            <button @click="activeTab = 'announcements'" :class="activeTab === 'announcements' ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0">
                <i class="fa-solid fa-bullhorn w-4"></i>
                Anuncios
            </button>
            <button @click="activeTab = 'popups'" :class="activeTab === 'popups' ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0">
                <i class="fa-solid fa-message w-4"></i>
                Popups (Exit-Intent)
            </button>
            <button @click="activeTab = 'referrals'" :class="activeTab === 'referrals' ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300'" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0">
                <i class="fa-solid fa-users w-4"></i>
                Referidos
            </button>
        </div>
    </div>

    <form id="main-settings-form" action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <input type="hidden" name="active_tab" :value="activeTab">

        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/10 border border-red-200 dark:border-red-800 rounded-xl text-red-600 dark:text-red-400 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- General Tab -->
        <div x-show="activeTab === 'general'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Información del Sitio</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nombre del sitio *</label>
                                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'TodoKeys' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required>
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Lema / Tagline</label>
                                <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Ej: Las mejores licencias al mejor precio">
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descripción del sitio</label>
                                <textarea name="site_description" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all resize-none" placeholder="Breve descripción de tu tienda...">{{ $settings['site_description'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Contacto</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email de contacto</label>
                                <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="admin@todokeys.com">
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Teléfono</label>
                                <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="+1 234 567 890">
                            </div>
                        </div>
                    </div>
                    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Sección Principal (Hero)</h3>
                        <p class="text-[12px] text-gray-400 mb-5">Personaliza los textos principales de la página de inicio.</p>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Etiqueta (Badge)</label>
                                <input type="text" name="hero_badge" value="{{ $settings['hero_badge'] ?? 'Entrega Instantánea' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                            </div>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Título principal</label>
                                    <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Software original.' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                </div>
                                <div>
                                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Subtítulo (texto gris)</label>
                                    <input type="text" name="hero_subtitle" value="{{ $settings['hero_subtitle'] ?? 'Fracción del precio.' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                </div>
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descripción</label>
                                <textarea name="hero_description" rows="2" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all resize-none">{{ $settings['hero_description'] ?? 'Obtén la última versión de Windows, Office y otras herramientas con todas las características profesionales desbloqueadas.' }}</textarea>
                            </div>
                            <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-3">Beneficios (Checkmarks)</label>
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                    <input type="text" name="hero_feature_1" value="{{ $settings['hero_feature_1'] ?? 'Activación permanente' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Beneficio 1">
                                    <input type="text" name="hero_feature_2" value="{{ $settings['hero_feature_2'] ?? 'Claves 100% originales' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Beneficio 2">
                                    <input type="text" name="hero_feature_3" value="{{ $settings['hero_feature_3'] ?? 'Soporte garantizado' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Beneficio 3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Moneda y Conversión</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Moneda Base</label>
                                <select name="currency" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                    <option value="USD" {{ ($settings['currency'] ?? 'USD') === 'USD' ? 'selected' : '' }}>USD - Dólar Americano</option>
                                    <option value="EUR" {{ ($settings['currency'] ?? '') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                    <option value="MXN" {{ ($settings['currency'] ?? '') === 'MXN' ? 'selected' : '' }}>MXN - Peso Mexicano</option>
                                    <option value="COP" {{ ($settings['currency'] ?? '') === 'COP' ? 'selected' : '' }}>COP - Peso Colombiano</option>
                                    <option value="ARS" {{ ($settings['currency'] ?? '') === 'ARS' ? 'selected' : '' }}>ARS - Peso Argentino</option>
                                    <option value="CLP" {{ ($settings['currency'] ?? '') === 'CLP' ? 'selected' : '' }}>CLP - Peso Chileno</option>
                                    <option value="PEN" {{ ($settings['currency'] ?? '') === 'PEN' ? 'selected' : '' }}>PEN - Sol Peruano</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Símbolo de moneda</label>
                                <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '$' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                            </div>
                            <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tasa de Cambio Manual (USD a COP)</label>
                                <input type="number" step="0.01" name="exchange_rate_cop" value="{{ $settings['exchange_rate_cop'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Ej: 4000">
                                <p class="text-[11px] text-gray-400 mt-1.5">Si dejas este campo vacío, el sistema descargará la tasa real del mercado automáticamente todos los días.</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Diseño de Catálogo</h3>
                        <p class="text-[11px] text-gray-400 mb-5">Configura cómo se muestran los productos en la página principal y el catálogo.</p>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Columnas en Home (destacados)</label>
                                <div class="grid grid-cols-5 gap-1.5" x-data="{ cols: {{ $settings['home_grid_columns'] ?? 4 }} }">
                                    <template x-for="n in 5" :key="n">
                                        <button type="button" @click="cols = n + 1" class="py-2.5 text-[12px] font-semibold rounded-lg border transition-all" :class="cols === n + 1 ? 'bg-primary-500 text-white border-primary-500 shadow-sm shadow-primary-500/20' : 'bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-gray-800 hover:border-primary-400'" x-text="n + 1"></button>
                                    </template>
                                    <input type="hidden" name="home_grid_columns" :value="cols">
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1.5">Cantidad de productos por fila en "Ofertas Destacadas"</p>
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Productos destacados (Home)</label>
                                <input type="number" name="home_featured_count" value="{{ $settings['home_featured_count'] ?? 8 }}" min="4" max="24" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                <p class="text-[10px] text-gray-400 mt-1.5">Número total de productos destacados a mostrar (4-24)</p>
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Columnas en Catálogo</label>
                                <div class="grid grid-cols-5 gap-1.5" x-data="{ cols: {{ $settings['catalog_grid_columns'] ?? 3 }} }">
                                    <template x-for="n in 5" :key="n">
                                        <button type="button" @click="cols = n + 1" class="py-2.5 text-[12px] font-semibold rounded-lg border transition-all" :class="cols === n + 1 ? 'bg-primary-500 text-white border-primary-500 shadow-sm shadow-primary-500/20' : 'bg-gray-50 dark:bg-gray-900/50 text-gray-600 dark:text-gray-400 border-gray-200 dark:border-gray-800 hover:border-primary-400'" x-text="n + 1"></button>
                                    </template>
                                    <input type="hidden" name="catalog_grid_columns" :value="cols">
                                </div>
                                <p class="text-[10px] text-gray-400 mt-1.5">Cantidad de productos por fila en /productos</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Pie de Página</h3>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Texto del footer</label>
                            <textarea name="footer_text" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all resize-none" placeholder="© 2026 TodoKeys. Todos los derechos reservados.">{{ $settings['footer_text'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </form><!-- End main form before branding -->

        <div x-show="activeTab === 'branding'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Logo -->
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Logo del Sitio</h3>
                    <p class="text-[12px] text-gray-400 mb-5">Se mostrará en la barra de navegación y en el footer. Formato recomendado: PNG o SVG, máximo 2MB.</p>

                    <div class="flex items-start gap-6">
                        <div class="shrink-0">
                            @if(isset($settings['logo']) && $settings['logo'])
                            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('storage/settings/' . $settings['logo']) }}" alt="Logo actual" class="max-w-full max-h-full object-contain p-2">
                            </div>
                            @else
                            <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block w-full cursor-pointer">
                                <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-4 text-center hover:border-primary-400 dark:hover:border-primary-600 hover:bg-primary-50/30 dark:hover:bg-primary-900/10 transition-all group">
                                    <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mx-auto mb-2 group-hover:text-primary-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <span class="text-[13px] font-medium text-gray-600 dark:text-gray-400 group-hover:text-primary-500 transition-colors">Seleccionar archivo</span>
                                    <span class="block text-[11px] text-gray-400 mt-1">PNG, JPG o SVG (max. 2MB)</span>
                                </div>
                                <input type="file" name="logo" accept="image/*" class="hidden" onchange="this.closest('label').querySelector('span:first-of-type').textContent = this.files[0]?.name || 'Seleccionar archivo'">
                            </label>
                            @if(isset($settings['logo']) && $settings['logo'])
                            <p class="text-[11px] text-gray-400 mt-2">Actual: {{ $settings['logo'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Favicon -->
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Favicon</h3>
                    <p class="text-[12px] text-gray-400 mb-5">Icono que se muestra en la pestaña del navegador. Formato recomendado: PNG o ICO, 32x32px o 64x64px.</p>

                    <div class="flex items-start gap-6">
                        <div class="shrink-0">
                            @if(isset($settings['favicon']) && $settings['favicon'])
                            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('storage/settings/' . $settings['favicon']) }}" alt="Favicon actual" class="max-w-full max-h-full object-contain p-2">
                            </div>
                            @else
                            <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <label class="block w-full cursor-pointer">
                                <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-4 text-center hover:border-primary-400 dark:hover:border-primary-600 hover:bg-primary-50/30 dark:hover:bg-primary-900/10 transition-all group">
                                    <svg class="w-8 h-8 text-gray-300 dark:text-gray-600 mx-auto mb-2 group-hover:text-primary-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                    <span class="text-[13px] font-medium text-gray-600 dark:text-gray-400 group-hover:text-primary-500 transition-colors">Seleccionar archivo</span>
                                    <span class="block text-[11px] text-gray-400 mt-1">PNG, ICO o SVG (max. 1MB)</span>
                                </div>
                                <input type="file" name="favicon" accept="image/*" class="hidden" onchange="this.closest('label').querySelector('span:first-of-type').textContent = this.files[0]?.name || 'Seleccionar archivo'">
                            </label>
                            @if(isset($settings['favicon']) && $settings['favicon'])
                            <p class="text-[11px] text-gray-400 mt-2">Actual: {{ $settings['favicon'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Colors -->
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Colores</h3>
                    <p class="text-[12px] text-gray-400 mb-5">Personaliza el color principal de tu tienda.</p>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Color principal</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="primary_color" value="{{ $settings['primary_color'] ?? '#6B8FCC' }}" class="w-12 h-10 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer">
                                <input type="text" value="{{ $settings['primary_color'] ?? '#6B8FCC' }}" class="flex-1 px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] font-mono text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" readonly>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            @foreach(['#6B8FCC', '#10B981', '#8B5CF6', '#F59E0B', '#EF4444', '#EC4899', '#06B6D4', '#84CC16'] as $color)
                            <button type="button" onclick="this.closest('.space-y-4').querySelector('input[type=color]').value='{{ $color }}'; this.closest('.space-y-4').querySelectorAll('input[type=text]')[0].value='{{ $color }}'" class="w-8 h-8 rounded-lg border-2 border-white dark:border-gray-800 shadow-sm hover:scale-110 transition-transform" style="background-color: {{ $color }}"></button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 flex justify-end">
            <button type="submit" class="px-5 py-2 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Guardar Logo & Favicon
            </button>
        </div>
        </form><!-- End branding form -->

    <form id="main-settings-form-2" action="{{ route('admin.settings.update') }}" method="POST">
    @csrf
    <input type="hidden" name="active_tab" :value="activeTab">

        <!-- SEO Tab -->
        <div x-show="activeTab === 'seo'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="max-w-3xl">
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">SEO Global</h3>
                    <p class="text-[12px] text-gray-400 mb-5">Configuración de SEO para todas las páginas.</p>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Meta Title por defecto</label>
                            <input type="text" name="meta_title" value="{{ $settings['meta_title'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="TodoKeys - Licencias Digitales al Mejor Precio">
                            <p class="text-[11px] text-gray-400 mt-1.5">Recomendado: 50-60 caracteres</p>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Meta Description por defecto</label>
                            <textarea name="meta_description" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all resize-none" placeholder="Vende licencias originales, software y gift cards con entrega instantánea y garantía incluida.">{{ $settings['meta_description'] ?? '' }}</textarea>
                            <p class="text-[11px] text-gray-400 mt-1.5">Recomendado: 150-160 caracteres</p>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Meta Keywords</label>
                            <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="licencias, software, windows, office, antivirus, gift cards">
                            <p class="text-[11px] text-gray-400 mt-1.5">Separados por comas</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emails Tab -->
        <div x-show="activeTab === 'emails'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="max-w-3xl">
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Configuración SMTP</h3>
                    <p class="text-[12px] text-gray-400 mb-5">Configura el servidor de correo para enviar notificaciones y marketing.</p>
                    
                    <div class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Servidor SMTP (Host)</label>
                                <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? env('MAIL_HOST', 'smtp.mailgun.org') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Puerto</label>
                                <input type="number" name="mail_port" value="{{ $settings['mail_port'] ?? env('MAIL_PORT', 587) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Usuario SMTP</label>
                                <input type="text" name="mail_username" value="{{ $settings['mail_username'] ?? env('MAIL_USERNAME') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Contraseña SMTP</label>
                                <input type="password" name="mail_password" value="{{ $settings['mail_password'] ?? env('MAIL_PASSWORD') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Encriptación</label>
                                <select name="mail_encryption" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                    <option value="tls" {{ ($settings['mail_encryption'] ?? env('MAIL_ENCRYPTION')) == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ ($settings['mail_encryption'] ?? env('MAIL_ENCRYPTION')) == 'ssl' ? 'selected' : '' }}>SSL</option>
                                    <option value="" {{ empty($settings['mail_encryption']) && empty(env('MAIL_ENCRYPTION')) ? 'selected' : '' }}>Ninguna</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Dirección "De" (Remitente)</label>
                                <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? env('MAIL_FROM_ADDRESS') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="ejemplo@midominio.com">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Tab -->
        <div x-show="activeTab === 'payment'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="max-w-3xl">
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Métodos de Pago</h3>
                    <p class="text-[12px] text-gray-400 mb-5">Configura los proveedores de pago.</p>
                    <div class="space-y-4">
                        <!-- PayPal -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><path d="M7.076 21.337H2.47a.641.641 0 0 1-.633-.74L4.944.901C5.026.382 5.474 0 5.998 0h7.46c2.57 0 4.578.543 5.69 1.81 1.01 1.15 1.304 2.42 1.012 4.287-.023.143-.047.288-.077.437-.983 5.05-4.349 6.797-8.647 6.797h-2.19c-.524 0-.968.382-1.05.9l-1.12 7.106z"/></svg>
                                </div>
                                <div>
                                    <div class="text-[13px] font-semibold text-gray-900 dark:text-white">PayPal</div>
                                    <div class="text-[11px] text-gray-400">Pagos internacionales</div>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="payment_paypal_enabled" value="0">
                                <input type="checkbox" name="payment_paypal_enabled" value="1" {{ ($settings['payment_paypal_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="peer sr-only">
                                <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                            </label>
                        </div>
                    <!-- Mercado Pago -->
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-sky-100 dark:bg-sky-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-5 h-5 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                </div>
                                <div>
                                    <div class="text-[13px] font-semibold text-gray-900 dark:text-white">Mercado Pago</div>
                                    <div class="text-[11px] text-gray-400">Pagos en Latinoamérica</div>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="payment_mercadopago_enabled" value="0">
                                <input type="checkbox" name="payment_mercadopago_enabled" value="1" {{ ($settings['payment_mercadopago_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="peer sr-only">
                                <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                            </label>
                        </div>
                        
                        <!-- Wompi -->
                        <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden" x-data="{ wompiEnabled: {{ ($settings['payment_wompi_enabled'] ?? '0') == '1' ? 'true' : 'false' }} }">
                            <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div>
                                        <div class="text-[13px] font-semibold text-gray-900 dark:text-white">Wompi Colombia</div>
                                        <div class="text-[11px] text-gray-400">PSE, Nequi, Tarjetas, Efectivo</div>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="hidden" name="payment_wompi_enabled" value="0">
                                    <input type="checkbox" name="payment_wompi_enabled" value="1" x-model="wompiEnabled" class="peer sr-only">
                                    <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                                </label>
                            </div>
                            
                            <div x-show="wompiEnabled" x-collapse class="p-4 bg-white dark:bg-[#111827] border-t border-gray-200 dark:border-gray-800 space-y-4">
                                <div>
                                    <label class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Llave Pública (Public Key)</label>
                                    <input type="text" name="wompi_public_key" value="{{ $settings['wompi_public_key'] ?? '' }}" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" placeholder="pub_test_...">
                                </div>
                                <div>
                                    <label class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Llave Privada (Private Key)</label>
                                    <input type="password" name="wompi_private_key" value="{{ $settings['wompi_private_key'] ?? '' }}" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" placeholder="prv_test_...">
                                </div>
                                <div>
                                    <label class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Secreto de Eventos (Webhooks)</label>
                                    <input type="password" name="wompi_events_secret" value="{{ $settings['wompi_events_secret'] ?? '' }}" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" placeholder="Secreto para validación de Webhooks">
                                    <p class="text-[11px] text-gray-500 mt-1">Lo encuentras en: Secretos para integración técnica > Eventos. (Tu URL de eventos es: <code>{{ route('wompi.webhook') }}</code>)</p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <input type="hidden" name="wompi_sandbox_mode" value="0">
                                    <input type="checkbox" name="wompi_sandbox_mode" id="wompi_sandbox" value="1" {{ ($settings['wompi_sandbox_mode'] ?? '1') == '1' ? 'checked' : '' }} class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                                    <label for="wompi_sandbox" class="text-[12px] font-medium text-gray-700 dark:text-gray-300">Modo Pruebas (Sandbox)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Points Tab -->
        <div x-show="activeTab === 'points'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="lg:col-span-2 space-y-6">
                    <!-- Points System -->
                    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div>
                                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Sistema de Puntos</h3>
                                <p class="text-[12px] text-gray-400 mt-0.5">Configura cómo los clientes ganan y canjean puntos</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="points_enabled" value="1" {{ ($settings['points_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="peer sr-only">
                                <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                            </label>
                        </div>

                        <div class="space-y-5">
                            <!-- Earning -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <span class="text-[13px] font-semibold text-gray-900 dark:text-white">Acumulación de Puntos</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[12px] font-medium text-gray-500 dark:text-gray-400 mb-1.5">Puntos por dólar gastado</label>
                                        <input type="number" name="points_per_dollar" value="{{ $settings['points_per_dollar'] ?? '1' }}" min="1" max="100" class="w-full px-3 py-2 bg-white dark:bg-[#111827] border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                        <p class="text-[10px] text-gray-400 mt-1">Ej: 1 punto por cada $1 gastado</p>
                                    </div>
                                    <div>
                                        <label class="block text-[12px] font-medium text-gray-500 dark:text-gray-400 mb-1.5">Días para expirar</label>
                                        <input type="number" name="points_expiry_days" value="{{ $settings['points_expiry_days'] ?? '365' }}" min="1" max="3650" class="w-full px-3 py-2 bg-white dark:bg-[#111827] border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                        <p class="text-[10px] text-gray-400 mt-1">Cuántos días antes de que expiren</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Redemption -->
                            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800">
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                    </div>
                                    <span class="text-[13px] font-semibold text-gray-900 dark:text-white">Canje de Puntos</span>
                                </div>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-[12px] font-medium text-gray-500 dark:text-gray-400 mb-1.5">Puntos requeridos</label>
                                        <input type="number" name="points_redemption_rate" value="{{ $settings['points_redemption_rate'] ?? '100' }}" min="1" max="10000" class="w-full px-3 py-2 bg-white dark:bg-[#111827] border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                        <p class="text-[10px] text-gray-400 mt-1">Puntos para 1 descuento</p>
                                    </div>
                                    <div>
                                        <label class="block text-[12px] font-medium text-gray-500 dark:text-gray-400 mb-1.5">Descuento por canje</label>
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-[12px]">$</span>
                                            <input type="number" name="points_discount_per_redemption" value="{{ $settings['points_discount_per_redemption'] ?? '1.00' }}" step="0.01" min="0.01" max="100" class="w-full pl-7 pr-3 py-2 bg-white dark:bg-[#111827] border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                        </div>
                                        <p class="text-[10px] text-gray-400 mt-1">Descuento en dólares</p>
                                    </div>
                                    <div>
                                        <label class="block text-[12px] font-medium text-gray-500 dark:text-gray-400 mb-1.5">Mínimo para canjear</label>
                                        <input type="number" name="points_min_redeem" value="{{ $settings['points_min_redeem'] ?? '100' }}" min="1" max="10000" class="w-full px-3 py-2 bg-white dark:bg-[#111827] border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                        <p class="text-[10px] text-gray-400 mt-1">Mínimo de puntos</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Preview -->
                <div class="space-y-6">
                    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-4">Vista Previa</h3>
                        <div class="space-y-4">
                            <div class="p-4 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl text-white">
                                <div class="text-[11px] font-medium opacity-80 mb-1">Ejemplo: Cliente gasta $50</div>
                                <div class="text-2xl font-extrabold">{{ ($settings['points_per_dollar'] ?? 1) * 50 }} puntos</div>
                                <div class="text-[11px] opacity-70 mt-1">ganados en esta compra</div>
                            </div>
                            <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800">
                                <div class="text-[11px] font-medium text-gray-500 dark:text-gray-400 mb-2">Ejemplo: Canjear puntos</div>
                                <div class="space-y-2 text-[12px]">
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">{{ $settings['points_redemption_rate'] ?? 100 }} puntos</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">= {{ currency_format($settings['points_discount_per_redemption'] ?? 1.00) }} descuento</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">{{ ($settings['points_redemption_rate'] ?? 100) * 2 }} puntos</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">= {{ currency_format(($settings['points_discount_per_redemption'] ?? 1.00) * 2) }} descuento</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-400">{{ ($settings['points_redemption_rate'] ?? 100) * 5 }} puntos</span>
                                        <span class="font-semibold text-gray-900 dark:text-white">= {{ currency_format(($settings['points_discount_per_redemption'] ?? 1.00) * 5) }} descuento</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-3">¿Cómo funciona?</h3>
                        <div class="space-y-3 text-[12px] text-gray-500 dark:text-gray-400">
                            <div class="flex items-start gap-2">
                                <span class="w-5 h-5 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center text-[10px] font-bold text-primary-600 shrink-0 mt-0.5">1</span>
                                <span>El cliente compra y acumula puntos automáticamente</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-5 h-5 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center text-[10px] font-bold text-primary-600 shrink-0 mt-0.5">2</span>
                                <span>Los puntos se acreditan al entregar el pedido</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-5 h-5 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center text-[10px] font-bold text-primary-600 shrink-0 mt-0.5">3</span>
                                <span>El cliente puede canjearlos en el checkout</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="w-5 h-5 bg-primary-100 dark:bg-primary-900/30 rounded-full flex items-center justify-center text-[10px] font-bold text-primary-600 shrink-0 mt-0.5">4</span>
                                <span>Máximo 50% del pedido puede ser pagado con puntos</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Tab -->
        <div x-show="activeTab === 'ai'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="max-w-3xl">
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Google Gemini API</h3>
                    <p class="text-[12px] text-gray-400 mb-5">Configura tu clave de API para generar descripciones de productos y SEO automáticamente. <a href="https://aistudio.google.com/app/apikey" target="_blank" class="text-primary-500 hover:underline">Obtener clave gratuita aquí</a>.</p>
                    
                    <div class="space-y-4" x-data="{ showKey: false, apiKey: '{{ $settings['gemini_api_key'] ?? '' }}' }">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">API Key de Gemini</label>
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <input :type="showKey ? 'text' : 'password'" 
                                           name="gemini_api_key" 
                                           x-model="apiKey"
                                           class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all pr-10" 
                                           placeholder="AIzaSyA...">
                                    <button type="button" @click="showKey = !showKey" class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        <svg x-show="!showKey" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <svg x-show="showKey" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                                    </button>
                                </div>
                                <button type="button" @click="apiKey = ''" class="px-3 py-2.5 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 text-[12px] font-medium rounded-xl hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors whitespace-nowrap">
                                    🗑 Eliminar key
                                </button>
                            </div>
                            <div class="flex items-center gap-2 mt-2">
                                <span x-show="apiKey.length > 0" class="inline-flex items-center gap-1 text-[11px] text-emerald-600 dark:text-emerald-400">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    API Key configurada
                                </span>
                                <span x-show="apiKey.length === 0" class="text-[11px] text-gray-400">Sin API Key — la IA no funcionará</span>
                            </div>
                            <p class="text-[11px] text-gray-400 mt-1">Mantenla segura. Se usará internamente para conectarse al modelo de lenguaje.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

              <!-- Announcements Tab -->
        <div x-show="activeTab === 'announcements'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="max-w-3xl">
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Barra de Anuncios</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Muestra mensajes importantes, ofertas o descuentos a tus clientes.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="announcement_enabled" value="0">
                            <input type="checkbox" name="announcement_enabled" value="1" {{ ($settings['announcement_enabled'] ?? '0') == '1' ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Estilo de Anuncio</label>
                            <select name="announcement_mode" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                <option value="top_bar" {{ ($settings['announcement_mode'] ?? 'top_bar') == 'top_bar' ? 'selected' : '' }}>Top Bar (Barra Superior Fija)</option>
                                <option value="floating" {{ ($settings['announcement_mode'] ?? '') == 'floating' ? 'selected' : '' }}>Flotante (Esquina Inferior)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Texto del Anuncio</label>
                            <input type="text" name="announcement_text" value="{{ $settings['announcement_text'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Ej: 🔥 Usa el cupón VERANO25 para un 25% OFF">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Enlace (Opcional)</label>
                            <input type="text" name="announcement_link" value="{{ $settings['announcement_link'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Ej: /productos o https://ejemplo.com">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Color de Fondo</label>
                            <div class="flex items-center gap-3">
                                <input type="color" name="announcement_color" value="{{ $settings['announcement_color'] ?? '#3b82f6' }}" class="w-12 h-10 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer">
                                <input type="text" value="{{ $settings['announcement_color'] ?? '#3b82f6' }}" class="flex-1 px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] font-mono text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popups Tab -->
        <div x-show="activeTab === 'popups'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="max-w-3xl">
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Popup de Salida (Exit-Intent)</h3>
                            <p class="text-[12px] text-gray-400 mt-0.5">Captura la atención de los clientes justo cuando van a abandonar la página.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="exit_intent_enabled" value="0">
                            <input type="checkbox" name="exit_intent_enabled" value="1" {{ ($settings['exit_intent_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                        </label>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Título del Popup</label>
                            <input type="text" name="exit_intent_title" value="{{ $settings['exit_intent_title'] ?? '¡Espera! No te vayas todavía' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Mensaje (puede incluir HTML básico)</label>
                            <input type="text" name="exit_intent_text" value="{{ $settings['exit_intent_text'] ?? 'Te regalamos un <strong>10% de descuento extra</strong> en tu primera compra si completas tu pedido ahora.' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Código de Cupón</label>
                            <input type="text" name="exit_intent_coupon" value="{{ $settings['exit_intent_coupon'] ?? 'FLASH10' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] font-black tracking-widest text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all uppercase">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tiempo del contador (Minutos)</label>
                            <input type="number" name="exit_intent_timer" value="{{ $settings['exit_intent_timer'] ?? '10' }}" min="1" max="60" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Referrals Tab -->
        <div x-show="activeTab === 'referrals'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0">
            <div class="max-w-3xl">
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Programa de Referidos</h3>
                    <p class="text-[12px] text-gray-400 mb-5">Configura cuántos TodoPuntos se reparten cuando los usuarios invitan a sus amigos a la plataforma.</p>
                    
                    <div class="space-y-4">
                        <div class="p-4 bg-primary-50/50 dark:bg-primary-900/10 rounded-xl border border-primary-100 dark:border-primary-900/30">
                            <label class="block text-[13px] font-semibold text-primary-700 dark:text-primary-300 mb-1.5">Recompensa para el usuario INVITADO (Bono de Bienvenida)</label>
                            <div class="flex items-center gap-3">
                                <input type="number" name="referral_welcome_points" value="{{ $settings['referral_welcome_points'] ?? '500' }}" min="0" step="50" class="w-32 px-4 py-2.5 bg-white dark:bg-gray-900/50 border border-primary-200 dark:border-primary-800 rounded-xl text-[13px] font-bold text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">TodoPuntos al registrarse</span>
                            </div>
                        </div>
                        
                        <div class="p-4 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-xl border border-emerald-100 dark:border-emerald-900/30">
                            <label class="block text-[13px] font-semibold text-emerald-700 dark:text-emerald-300 mb-1.5">Recompensa para el REFERIDOR (Por cada amigo que compra)</label>
                            <div class="flex items-center gap-3">
                                <input type="number" name="referral_reward_points" value="{{ $settings['referral_reward_points'] ?? '1000' }}" min="0" step="50" class="w-32 px-4 py-2.5 bg-white dark:bg-gray-900/50 border border-emerald-200 dark:border-emerald-800 rounded-xl text-[13px] font-bold text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-emerald-400/30 focus:border-emerald-400 transition-all">
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-400">TodoPuntos tras la 1ra compra del amigo</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="mt-8 flex items-center justify-end border-t border-gray-100 dark:border-gray-800/60 pt-6">
            <button type="submit" class="px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Guardar Configuración
            </button>
        </div>
    </form>
</div>
@endsection
