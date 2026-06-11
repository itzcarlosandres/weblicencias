@extends('layouts.admin')

@section('title', 'Configuración | Admin')
@section('header', 'Configuración')

@section('content')

@if(session('_settings_saved'))
<div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-xl flex items-center gap-3">
    <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/50 rounded-full flex items-center justify-center shrink-0">
        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    </div>
    <div>
        <p class="text-[13px] font-semibold text-emerald-700 dark:text-emerald-300">Cambios guardados correctamente</p>
    </div>
</div>
@endif

<div>
    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 mb-6 overflow-hidden">
        <div class="flex border-b border-gray-100 dark:border-gray-800/60 overflow-x-auto">
            @foreach(['general','branding','seo','emails','payment','points','ai','announcements','popups','referrals'] as $t)
            <a href="?tab={{ $t }}" class="flex items-center gap-2 px-5 py-3.5 text-[13px] font-medium border-b-2 transition-all whitespace-nowrap shrink-0 {{ $activeTab === $t ? 'text-primary-600 border-primary-500 bg-primary-50/50 dark:bg-primary-900/10' : 'text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 border-transparent' }}">
                @if($t === 'general')<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>@endif
                @if($t === 'branding')<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>@endif
                @if($t === 'seo')<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>@endif
                @if($t === 'emails')<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>@endif
                @if($t === 'payment')<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>@endif
                @if($t === 'points')<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>@endif
                @if($t === 'ai')<i class="fa-solid fa-wand-magic-sparkles w-4"></i>@endif
                @if($t === 'announcements')<i class="fa-solid fa-bullhorn w-4"></i>@endif
                @if($t === 'popups')<i class="fa-solid fa-message w-4"></i>@endif
                @if($t === 'referrals')<i class="fa-solid fa-users w-4"></i>@endif
                {{ ucfirst($t) }}
            </a>
            @endforeach
        </div>
    </div>

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
        @csrf
        <input type="hidden" name="tab" value="{{ $activeTab }}">

        @if($activeTab === 'general')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Información del Sitio</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nombre del sitio *</label>
                            <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'TodoKeys' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" required>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Lema / Tagline</label>
                            <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descripción del sitio</label>
                            <textarea name="site_description" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 resize-none">{{ $settings['site_description'] ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Contacto</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email de contacto</label>
                            <input type="email" name="contact_email" value="{{ $settings['contact_email'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Teléfono</label>
                            <input type="text" name="contact_phone" value="{{ $settings['contact_phone'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Sección Principal (Hero)</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Etiqueta (Badge)</label>
                            <input type="text" name="hero_badge" value="{{ $settings['hero_badge'] ?? 'Entrega Instantánea' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Título principal</label>
                                <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? 'Software original.' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Subtítulo</label>
                                <input type="text" name="hero_subtitle" value="{{ $settings['hero_subtitle'] ?? 'Fracción del precio.' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descripción</label>
                            <textarea name="hero_description" rows="2" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 resize-none">{{ $settings['hero_description'] ?? '' }}</textarea>
                        </div>
                        <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-3">Beneficios</label>
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                <input type="text" name="hero_feature_1" value="{{ $settings['hero_feature_1'] ?? 'Activación permanente' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                                <input type="text" name="hero_feature_2" value="{{ $settings['hero_feature_2'] ?? 'Claves 100% originales' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                                <input type="text" name="hero_feature_3" value="{{ $settings['hero_feature_3'] ?? 'Soporte garantizado' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="space-y-6">
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Moneda</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Moneda Base</label>
                            <select name="currency" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                                <option value="USD" {{ ($settings['currency'] ?? 'USD') === 'USD' ? 'selected' : '' }}>USD - Dólar Americano</option>
                                <option value="EUR" {{ ($settings['currency'] ?? '') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                                <option value="MXN" {{ ($settings['currency'] ?? '') === 'MXN' ? 'selected' : '' }}>MXN - Peso Mexicano</option>
                                <option value="COP" {{ ($settings['currency'] ?? '') === 'COP' ? 'selected' : '' }}>COP - Peso Colombiano</option>
                                <option value="ARS" {{ ($settings['currency'] ?? '') === 'ARS' ? 'selected' : '' }}>ARS - Peso Argentino</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Símbolo</label>
                            <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '$' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tasa USD → COP</label>
                            <div class="flex items-center gap-2">
                                <input type="number" step="0.01" name="exchange_rate_cop" value="{{ $settings['exchange_rate_cop'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" placeholder="Ej: 3569">
                            </div>
                            <p class="text-[10px] text-emerald-600 mt-1 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Al guardar con COP, se actualiza al rate actual automáticamente
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Diseño de Catálogo</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Columnas en Home</label>
                            <select name="home_grid_columns" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                                @for($i = 2; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ ($settings['home_grid_columns'] ?? 4) == $i ? 'selected' : '' }}>{{ $i }} columnas</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Productos Destacados</label>
                            <input type="number" name="home_featured_count" value="{{ $settings['home_featured_count'] ?? 8 }}" min="4" max="24" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Columnas en Catálogo</label>
                            <select name="catalog_grid_columns" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                                @for($i = 2; $i <= 6; $i++)
                                <option value="{{ $i }}" {{ ($settings['catalog_grid_columns'] ?? 3) == $i ? 'selected' : '' }}>{{ $i }} columnas</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                </div>
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Pie de Página</h3>
                    <textarea name="footer_text" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 resize-none">{{ $settings['footer_text'] ?? '' }}</textarea>
                </div>
            </div>
        </div>
        @endif

        @if($activeTab === 'branding')
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Logo del Sitio</h3>
                <p class="text-[12px] text-gray-400 mb-5">PNG o SVG, máximo 2MB</p>
                <div class="flex items-start gap-6">
                    <div class="shrink-0">
                        @if(!empty($settings['logo']))
                        <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('storage/settings/' . $settings['logo']) }}" alt="Logo" class="max-w-full max-h-full object-contain p-2">
                        </div>
                        @else
                        <div class="w-24 h-24 bg-gray-100 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block w-full cursor-pointer">
                            <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-4 text-center hover:border-primary-400 hover:bg-primary-50/30 transition-all">
                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <span class="text-[13px] font-medium text-gray-600 dark:text-gray-400">Seleccionar archivo</span>
                                <span class="block text-[11px] text-gray-400 mt-1">PNG, JPG o SVG</span>
                            </div>
                            <input type="file" name="logo" accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Favicon</h3>
                <p class="text-[12px] text-gray-400 mb-5">PNG o ICO, 32x32px</p>
                <div class="flex items-start gap-6">
                    <div class="shrink-0">
                        @if(!empty($settings['favicon']))
                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center overflow-hidden">
                            <img src="{{ asset('storage/settings/' . $settings['favicon']) }}" alt="Favicon" class="max-w-full max-h-full object-contain p-2">
                        </div>
                        @else
                        <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-2xl border-2 border-dashed border-gray-200 dark:border-gray-700 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        @endif
                    </div>
                    <div class="flex-1">
                        <label class="block w-full cursor-pointer">
                            <div class="border-2 border-dashed border-gray-200 dark:border-gray-700 rounded-xl p-4 text-center hover:border-primary-400 hover:bg-primary-50/30 transition-all">
                                <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <span class="text-[13px] font-medium text-gray-600 dark:text-gray-400">Seleccionar archivo</span>
                                <span class="block text-[11px] text-gray-400 mt-1">PNG, ICO</span>
                            </div>
                            <input type="file" name="favicon" accept="image/*" class="hidden">
                        </label>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Color Principal</h3>
                <div class="flex items-center gap-3">
                    <input type="color" name="primary_color" value="{{ $settings['primary_color'] ?? '#6B8FCC' }}" class="w-12 h-10 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer">
                    <input type="text" value="{{ $settings['primary_color'] ?? '#6B8FCC' }}" class="flex-1 px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] font-mono text-gray-900 dark:text-white" readonly>
                </div>
                <div class="flex gap-2 mt-4">
                    @foreach(['#6B8FCC','#10B981','#8B5CF6','#F59E0B','#EF4444','#EC4899','#06B6D4','#84CC16'] as $color)
                    <button type="button" onclick="this.parentElement.previousElementSibling.querySelector('input[type=color]').value='{{ $color }}'; this.parentElement.previousElementSibling.querySelector('input[type=text]').value='{{ $color }}'" class="w-8 h-8 rounded-lg border-2 border-white dark:border-gray-800 shadow-sm hover:scale-110 transition-transform" style="background-color: {{ $color }}"></button>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($activeTab === 'seo')
        <div class="max-w-3xl">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 space-y-4">
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Meta Title</label>
                    <input type="text" name="meta_title" value="{{ $settings['meta_title'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" placeholder="TodoKeys - Licencias Digitales">
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Meta Description</label>
                    <textarea name="meta_description" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 resize-none">{{ $settings['meta_description'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Meta Keywords</label>
                    <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400" placeholder="licencias, software, windows">
                </div>
            </div>
        </div>
        @endif

        @if($activeTab === 'emails')
        <div class="max-w-3xl">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Servidor SMTP</label>
                        <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Puerto</label>
                        <input type="number" name="mail_port" value="{{ $settings['mail_port'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Usuario SMTP</label>
                        <input type="text" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Contraseña SMTP</label>
                        <input type="password" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Encriptación</label>
                        <select name="mail_encryption" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                            <option value="tls" {{ ($settings['mail_encryption'] ?? '') === 'tls' ? 'selected' : '' }}>TLS</option>
                            <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Dirección "De"</label>
                        <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400">
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($activeTab === 'payment')
        <div class="max-w-4xl space-y-4">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 space-y-4">
                @foreach(['paypal' => 'PayPal', 'mercadopago' => 'Mercado Pago'] as $key => $label)
                <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50 rounded-xl border border-gray-200 dark:border-gray-800">
                    <div class="text-[13px] font-semibold text-gray-900 dark:text-white">{{ $label }}</div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="payment_{{ $key }}_enabled" value="0">
                        <input type="checkbox" name="payment_{{ $key }}_enabled" value="1" {{ ($settings['payment_' . $key . '_enabled'] ?? '0') == '1' ? 'checked' : '' }} class="peer sr-only">
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                    </label>
                </div>
                @endforeach

                <div class="border border-gray-200 dark:border-gray-800 rounded-xl overflow-hidden">
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-900/50">
                        <div>
                            <div class="text-[13px] font-semibold text-gray-900 dark:text-white">Wompi Colombia</div>
                            <div class="text-[11px] text-gray-400">PSE, Nequi, Tarjetas, Efectivo</div>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="payment_wompi_enabled" value="0">
                            <input type="checkbox" name="payment_wompi_enabled" value="1" {{ ($settings['payment_wompi_enabled'] ?? '0') == '1' ? 'checked' : '' }} class="peer sr-only" onchange="document.getElementById('wompi-creds').style.display = this.checked ? 'block' : 'none'">
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                        </label>
                    </div>
                    <div id="wompi-creds" class="p-4 bg-white dark:bg-[#111827] border-t border-gray-200 dark:border-gray-800 space-y-4 {{ ($settings['payment_wompi_enabled'] ?? '0') == '1' ? '' : 'hidden' }}">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Llave Pública (Public Key)</label>
                                <input type="text" name="wompi_public_key" value="{{ $settings['wompi_public_key'] ?? '' }}" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white" placeholder="pub_test_...">
                            </div>
                            <div>
                                <label class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Llave Privada (Private Key)</label>
                                <input type="password" name="wompi_private_key" value="{{ $settings['wompi_private_key'] ?? '' }}" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white" placeholder="prv_test_...">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[12px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Secreto de Eventos (Webhook Secret)</label>
                            <input type="password" name="wompi_events_secret" value="{{ $settings['wompi_events_secret'] ?? '' }}" class="w-full px-3 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white" placeholder="Eventos_...">
                            <p class="text-[11px] text-gray-500 mt-1">Tu URL de webhook: <code class="bg-gray-100 dark:bg-gray-800 px-1 py-0.5 rounded">{{ route('wompi.webhook') }}</code></p>
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
        @endif

        @if($activeTab === 'points')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Sistema de Puntos</h3>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="hidden" name="points_enabled" value="0">
                            <input type="checkbox" name="points_enabled" value="1" {{ ($settings['points_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                        </label>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[12px] font-medium text-gray-500 dark:text-gray-400 mb-1.5">Puntos por dólar</label>
                            <input type="number" name="points_per_dollar" value="{{ $settings['points_per_dollar'] ?? '1' }}" min="1" class="w-full px-3 py-2 bg-white dark:bg-[#111827] border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-medium text-gray-500 dark:text-gray-400 mb-1.5">Días para expirar</label>
                            <input type="number" name="points_expiry_days" value="{{ $settings['points_expiry_days'] ?? '365' }}" min="1" class="w-full px-3 py-2 bg-white dark:bg-[#111827] border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[12px] font-medium text-gray-500 dark:text-gray-400 mb-1.5">Puntos requeridos</label>
                            <input type="number" name="points_redemption_rate" value="{{ $settings['points_redemption_rate'] ?? '100' }}" min="1" class="w-full px-3 py-2 bg-white dark:bg-[#111827] border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-medium text-gray-500 dark:text-gray-400 mb-1.5">Descuento ($)</label>
                            <input type="number" name="points_discount_per_redemption" value="{{ $settings['points_discount_per_redemption'] ?? '1.00' }}" step="0.01" class="w-full px-3 py-2 bg-white dark:bg-[#111827] border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-[12px] font-medium text-gray-500 dark:text-gray-400 mb-1.5">Mínimo canjear</label>
                            <input type="number" name="points_min_redeem" value="{{ $settings['points_min_redeem'] ?? '100' }}" min="1" class="w-full px-3 py-2 bg-white dark:bg-[#111827] border border-gray-200 dark:border-gray-800 rounded-lg text-[13px] text-gray-900 dark:text-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if($activeTab === 'ai')
        <div class="max-w-3xl">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-2">Google Gemini API</h3>
                <p class="text-[12px] text-gray-400 mb-5">Obtén tu clave en <a href="https://aistudio.google.com/app/apikey" target="_blank" class="text-primary-500 hover:underline">aistudio.google.com</a></p>
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">API Key</label>
                    <input type="password" name="gemini_api_key" value="{{ $settings['gemini_api_key'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white" placeholder="AIzaSy...">
                </div>
            </div>
        </div>
        @endif

        @if($activeTab === 'announcements')
        <div class="max-w-3xl">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Barra de Anuncios</h3>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="announcement_enabled" value="0">
                        <input type="checkbox" name="announcement_enabled" value="1" {{ ($settings['announcement_enabled'] ?? '0') == '1' ? 'checked' : '' }} class="peer sr-only">
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                    </label>
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Estilo</label>
                    <select name="announcement_mode" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white">
                        <option value="top_bar" {{ ($settings['announcement_mode'] ?? 'top_bar') === 'top_bar' ? 'selected' : '' }}>Top Bar</option>
                        <option value="floating" {{ ($settings['announcement_mode'] ?? '') === 'floating' ? 'selected' : '' }}>Flotante</option>
                    </select>
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Texto</label>
                    <input type="text" name="announcement_text" value="{{ $settings['announcement_text'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Color</label>
                    <input type="color" name="announcement_color" value="{{ $settings['announcement_color'] ?? '#3b82f6' }}" class="w-12 h-10 rounded-lg border border-gray-200 dark:border-gray-700 cursor-pointer">
                </div>
            </div>
        </div>
        @endif

        @if($activeTab === 'popups')
        <div class="max-w-3xl">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Popup Exit-Intent</h3>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="exit_intent_enabled" value="0">
                        <input type="checkbox" name="exit_intent_enabled" value="1" {{ ($settings['exit_intent_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="peer sr-only">
                        <div class="w-11 h-6 bg-gray-200 dark:bg-gray-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                    </label>
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Título</label>
                    <input type="text" name="exit_intent_title" value="{{ $settings['exit_intent_title'] ?? '¡Espera! No te vayas todavía' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Mensaje</label>
                    <input type="text" name="exit_intent_text" value="{{ $settings['exit_intent_text'] ?? '' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white">
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Código de Cupón</label>
                    <input type="text" name="exit_intent_coupon" value="{{ $settings['exit_intent_coupon'] ?? 'FLASH10' }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] font-black tracking-widest uppercase">
                </div>
                <div>
                    <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Timer (min)</label>
                    <input type="number" name="exit_intent_timer" value="{{ $settings['exit_intent_timer'] ?? '10' }}" min="1" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white">
                </div>
            </div>
        </div>
        @endif

        @if($activeTab === 'referrals')
        <div class="max-w-3xl">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 space-y-4">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white">Programa de Referidos</h3>
                <div class="p-4 bg-primary-50/50 dark:bg-primary-900/10 rounded-xl border border-primary-100 dark:border-primary-900/30">
                    <label class="block text-[13px] font-semibold text-primary-700 dark:text-primary-300 mb-1.5">Bono de Bienvenida</label>
                    <input type="number" name="referral_welcome_points" value="{{ $settings['referral_welcome_points'] ?? '500' }}" min="0" class="w-32 px-4 py-2.5 bg-white dark:bg-gray-900/50 border border-primary-200 dark:border-primary-800 rounded-xl text-[13px] font-bold text-gray-900 dark:text-white">
                </div>
                <div class="p-4 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-xl border border-emerald-100 dark:border-emerald-900/30">
                    <label class="block text-[13px] font-semibold text-emerald-700 dark:text-emerald-300 mb-1.5">Recompensa por Compra</label>
                    <input type="number" name="referral_reward_points" value="{{ $settings['referral_reward_points'] ?? '1000' }}" min="0" class="w-32 px-4 py-2.5 bg-white dark:bg-gray-900/50 border border-emerald-200 dark:border-emerald-800 rounded-xl text-[13px] font-bold text-gray-900 dark:text-white">
                </div>
            </div>
        </div>
        @endif

        <div class="mt-8 flex items-center justify-end border-t border-gray-100 dark:border-gray-800/60 pt-6">
            <button type="submit" class="px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Guardar Configuración
            </button>
        </div>
    </form>
</div>

@endsection