@extends('layouts.admin')

@section('title', 'Crear Producto')
@section('header', 'Crear Producto')

@section('content')
<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Información del Producto</h3>
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300">Nombre del producto *</label>
                            <button type="button" onclick="generateAI()" id="btn-ai" class="text-[11px] font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-500 to-pink-500 hover:opacity-80 flex items-center gap-1 transition-opacity">
                                <i class="fa-solid fa-wand-magic-sparkles"></i> Generar contenido con IA
                            </button>
                        </div>
                        <input type="text" name="name" id="product_name" value="{{ old('name') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required placeholder="Ej: Windows 11 Pro">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Imagen Principal</label>
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        <p class="text-[11px] text-gray-400 mt-1">Formatos recomendados: JPG, PNG, WEBP (Ratio 3:4 o 1:1)</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Categoría *</label>
                            <select name="category_id" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required>
                                <option value="">Seleccionar</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Marca</label>
                            <select name="brand_id" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                <option value="">Sin marca</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tipo *</label>
                            <select name="type" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required>
                                <option value="license" {{ old('type') == 'license' ? 'selected' : '' }}>Licencia</option>
                                <option value="software" {{ old('type') == 'software' ? 'selected' : '' }}>Software</option>
                                <option value="giftcard" {{ old('type') == 'giftcard' ? 'selected' : '' }}>Gift Card</option>
                                <option value="subscription" {{ old('type') == 'subscription' ? 'selected' : '' }}>Suscripción</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">SKU</label>
                            <input type="text" name="sku" value="{{ old('sku') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Auto-generado si está vacío">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descripción</label>
                        <textarea name="description" id="product_description" rows="4" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all resize-none" placeholder="Describe el producto...">{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Pricing -->
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Precios y Stock</h3>
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5" title="Este es el precio que el cliente pagará.">Precio de venta final *</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[13px]">$</span>
                                <input type="number" name="price" value="{{ old('price') }}" step="0.01" class="w-full pl-8 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required placeholder="0.00">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5" title="Precio antiguo más alto, aparecerá tachado para mostrar el descuento.">Precio original (tachado)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[13px]">$</span>
                                <input type="number" name="compare_price" value="{{ old('compare_price') }}" step="0.01" class="w-full pl-8 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Stock *</label>
                            <input type="number" name="stock" value="{{ old('stock', 0) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Garantía (días)</label>
                            <input type="number" name="warranty_days" value="{{ old('warranty_days', 30) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Entrega</label>
                            <input type="text" name="delivery_time" value="{{ old('delivery_time', 'Instantánea') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        </div>
                    </div>
                    {{-- Platform Chip Selector --}}
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-2">Plataforma</label>
                        <input type="hidden" name="platform" id="create_platform_value" value="{{ old('platform') }}">
                        @php
                        $createPlatforms = [
                            ['value' => 'Windows',        'label' => 'Windows',  'icon' => 'windows'],
                            ['value' => 'macOS',          'label' => 'macOS',    'icon' => 'apple'],
                            ['value' => 'Android',        'label' => 'Android',  'icon' => 'android'],
                            ['value' => 'Steam',          'label' => 'Steam',    'icon' => 'steam'],
                            ['value' => 'PlayStation',    'label' => 'PS',       'icon' => 'ps'],
                            ['value' => 'Xbox',           'label' => 'Xbox',     'icon' => 'xbox'],
                            ['value' => 'Multiplataforma','label' => 'Multi',    'icon' => 'multi'],
                        ];
                        @endphp
                        <div class="flex flex-wrap gap-2 mb-2">
                            @foreach($createPlatforms as $cp)
                            <button type="button"
                                data-platform="{{ $cp['value'] }}"
                                onclick="createSelectPlatform(this)"
                                title="{{ $cp['value'] }}"
                                class="create-platform-chip group flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-[12px] font-semibold transition-all duration-150 bg-gray-50 dark:bg-gray-900/50 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-primary-400 hover:text-primary-600 dark:hover:text-primary-400">
                                @if($cp['icon'] === 'windows')
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-[#0078D4]"><path d="M0 3.449L9.75 2.1v9.451H0m10.949-9.602L24 0v11.4H10.949M0 12.6h9.75v9.451L0 20.699M10.949 12.6H24V24l-12.9-1.801"/></svg>
                                @elseif($cp['icon'] === 'apple')
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4" style="color:#555"><path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.039 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09zM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.559-1.701"/></svg>
                                @elseif($cp['icon'] === 'android')
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-[#3DDC84]"><path d="M17.523 15.341c-.523 0-.946-.425-.946-.95s.423-.95.946-.95c.525 0 .95.425.95.95s-.425.95-.95.95m-11.046 0c-.525 0-.95-.425-.95-.95s.425-.95.95-.95c.523 0 .946.425.946.95s-.423.95-.946.95m11.404-6.461l1.896-3.285c.105-.18.045-.41-.133-.516-.18-.106-.41-.046-.517.133l-1.92 3.324C15.49 7.67 13.8 7.193 12 7.193c-1.8 0-3.49.477-4.207 1.343L5.873 5.212c-.106-.179-.337-.239-.517-.133-.178.106-.238.336-.133.516l1.896 3.285C4.976 10.092 3.808 12.006 3.808 14.05h16.384c0-2.044-1.168-3.958-2.311-5.17"/></svg>
                                @elseif($cp['icon'] === 'steam')
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-[#1b2838]"><path d="M11.979 0C5.678 0 .511 4.86.022 11.037l6.432 2.658c.545-.371 1.203-.59 1.912-.59.063 0 .125.004.188.006l2.861-4.142V8.91c0-2.495 2.028-4.524 4.524-4.524 2.494 0 4.524 2.031 4.524 4.527s-2.03 4.525-4.524 4.525h-.105l-4.076 2.911c0 .052.004.105.004.159 0 1.875-1.515 3.396-3.39 3.396-1.635 0-3.016-1.173-3.331-2.727L.436 15.27C1.862 20.307 6.486 24 11.979 24c6.627 0 11.999-5.373 11.999-12S18.606 0 11.979 0z"/></svg>
                                @elseif($cp['icon'] === 'ps')
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-[#003087]"><path d="M8.984 2.596v14.477l3.921 1.237V6.237c0-.78.34-1.31.882-1.145.71.23.852 1.014.852 1.794v5.268c2.416 1.246 4.228-.155 4.228-3.498 0-3.44-1.197-4.98-4.625-6.06-1.147-.353-3.138-.82-4.258-1.001M2.187 17.037c-1.201.693-1.254 1.676-.12 2.195l3.401 1.517c1.135.505 2.986.398 4.12-.243l7.864-4.568c1.201-.694 1.253-1.677.12-2.196l-3.402-1.516c-1.134-.507-2.985-.399-4.12.242l-7.863 4.569z"/></svg>
                                @elseif($cp['icon'] === 'xbox')
                                    <svg viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 text-[#107C10]"><path d="M4.102 4.104C5.877 2.293 8.065 1.16 10.37.785c-.812 1.028-1.616 2.27-2.217 3.661-.603 1.395-.98 2.852-1.081 4.212C5.663 7.09 4.668 5.537 4.102 4.104M3.386 5.07C2.35 6.696 1.74 8.58 1.68 10.6c.15 2.078.835 3.998 1.957 5.598.068-2.074.432-3.95.97-5.463.537-1.51 1.23-2.634 1.94-3.16-.505-.87-1.485-1.773-3.16-2.505M2.24 17.49c1.386 2.134 3.492 3.73 5.95 4.448-1.035-1.31-1.97-2.943-2.636-4.74-.533-1.464-.834-2.965-.903-4.343-1.03.947-1.808 2.625-2.411 4.635m8.384 4.822c.45.034.907.053 1.368.053.461 0 .918-.019 1.368-.053-1.368-1.217-1.368-3.527 0-4.744-.45.034-.907.053-1.368.053-.461 0-.918-.019-1.368-.053 1.368 1.217 1.368 3.527 0 4.744m5.214-.374c2.458-.718 4.564-2.314 5.95-4.448-.603-2.01-1.381-3.688-2.411-4.635-.069 1.378-.37 2.879-.903 4.343-.666 1.797-1.601 3.43-2.636 4.74m2.922-7.427c-.07 2.074-.433 3.95-.971 5.463-.536 1.51-1.23 2.634-1.94 3.16.506.87 1.485 1.773 3.16 2.505 1.037-1.626 1.647-3.51 1.707-5.53-.15-2.078-.835-3.998-1.956-5.598m-1.362-9.407c-1.675.732-2.655 1.635-3.16 2.505.71.526 1.403 1.65 1.94 3.16.538 1.513.902 3.39.97 5.463 1.122-1.6 1.807-3.52 1.957-5.598-.1-1.36-.477-2.817-1.08-4.212-.602-1.391-1.405-2.633-2.217-3.661M9.63.785C7.325 1.16 5.137 2.293 3.362 4.104c-.566 1.433-1.56 2.986-2.97 4.554 1.675-.732 2.655-1.635 3.16-2.505.71.526 1.403 1.65 1.94 3.16.538 1.513.902 3.39.97 5.463-1.122-1.6-1.807-3.52-1.957-5.598.1-1.36.477-2.817 1.08-4.212.602-1.391 1.405-2.633 2.217-3.661"/></svg>
                                @elseif($cp['icon'] === 'multi')
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="w-4 h-4 text-violet-500"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                                @endif
                                {{ $cp['label'] }}
                            </button>
                            @endforeach
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="text-[11px] text-gray-400">Otro:</span>
                            <input type="text" id="create_platform_custom"
                                placeholder="Nintendo Switch, etc."
                                oninput="document.getElementById('create_platform_value').value=this.value; document.querySelectorAll('.create-platform-chip').forEach(c=>{c.classList.remove('bg-primary-500','border-primary-500','text-white','shadow-sm'); c.classList.add('bg-gray-50','border-gray-200','text-gray-600')})"
                                class="w-44 px-3 py-1.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-[12px] text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-primary-400/40 focus:border-primary-400">
                        </div>
                    </div>
                    <script>
                    (function() {
                        var selected = [];
                        function renderCreateChips() {
                            document.querySelectorAll('.create-platform-chip').forEach(function(btn) {
                                var val = btn.dataset.platform;
                                var isOn = selected.includes(val);
                                btn.classList.toggle('bg-primary-500', isOn);
                                btn.classList.toggle('border-primary-500', isOn);
                                btn.classList.toggle('text-white', isOn);
                                btn.classList.toggle('shadow-sm', isOn);
                                btn.classList.toggle('shadow-primary-500/20', isOn);
                                btn.classList.toggle('bg-gray-50', !isOn);
                                btn.classList.toggle('border-gray-200', !isOn);
                                btn.classList.toggle('text-gray-600', !isOn);
                            });
                            document.getElementById('create_platform_value').value = selected.join(', ');
                        }
                        window.createSelectPlatform = function(btn) {
                            var val = btn.dataset.platform;
                            if (selected.includes(val)) {
                                selected = selected.filter(function(v){ return v !== val; });
                            } else {
                                selected.push(val);
                            }
                            var custom = document.getElementById('create_platform_custom');
                            if(custom) custom.value = '';
                            renderCreateChips();
                        };
                        // Pre-fill if old() value exists (form validation re-render)
                        var oldVal = document.getElementById('create_platform_value').value;
                        if (oldVal) {
                            selected = oldVal.split(',').map(function(s){ return s.trim(); }).filter(Boolean);
                            renderCreateChips();
                        }
                    })();
                    </script>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Región</label>
                        <input type="text" name="region" value="{{ old('region') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Ej: Global, Latinoamérica">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Método de activación</label>
                        <input type="text" name="activation_method" value="{{ old('activation_method') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Ej: Online, por teléfono">
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Status -->
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Estado</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Activo</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Destacado</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_bundle" value="1" {{ old('is_bundle') ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-purple-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Es Paquete</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_top_deal" value="1" {{ old('is_top_deal') ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-blue-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Top Oferta (Aplica 15%)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group" x-data="{ flash: {{ old('is_flash_sale') ? 'true' : 'false' }} }">
                        <div class="relative">
                            <input type="checkbox" name="is_flash_sale" value="1" x-model="flash" class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-amber-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Oferta Flash</span>
                    </label>
                    <div x-data="{ flash: {{ old('is_flash_sale') ? 'true' : 'false' }} }" x-show="document.querySelector('input[name=is_flash_sale]').checked || flash" @change.document="flash = document.querySelector('input[name=is_flash_sale]').checked" class="mt-2" style="display: none;">
                        <label class="block text-[11px] font-medium text-gray-500 mb-1">Finaliza el:</label>
                        <input type="datetime-local" name="flash_sale_end" value="{{ old('flash_sale_end') }}" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs">
                    </div>
                </div>
            </div>

            <!-- Badge -->
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Etiqueta</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Seleccionar Etiqueta</label>
                        <select name="badge_id" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                            <option value="">Ninguna</option>
                            @foreach($badges as $badge)
                                <option value="{{ $badge->id }}" {{ old('badge_id') == $badge->id ? 'selected' : '' }}>
                                    {{ $badge->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- SEO -->
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">SEO</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Meta Title</label>
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Título para SEO">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all resize-none" placeholder="Descripción para buscadores...">{{ old('meta_description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <div class="space-y-3">
                    <button type="submit" class="w-full px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20">
                        Crear Producto
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-[13px] font-medium rounded-xl transition-colors text-center block">
                        Cancelar
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
function generateAI() {
    const productName = document.getElementById('product_name').value;
    const btn = document.getElementById('btn-ai');
    
    if (!productName) {
        alert('Por favor escribe el nombre del producto primero.');
        return;
    }

    // Cambiar estado del botón
    const originalText = btn.innerHTML;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Generando...';
    btn.disabled = true;
    btn.classList.add('opacity-50');

    fetch('{{ route('admin.ai.generate-product') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ product_name: productName })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('product_description').value = data.data.description || '';
            document.getElementById('meta_title').value = data.data.meta_title || '';
            document.getElementById('meta_description').value = data.data.meta_description || '';
        } else {
            alert(data.message || 'Hubo un error al generar el contenido.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Hubo un error de conexión con el servidor.');
    })
    .finally(() => {
        // Restaurar estado del botón
        btn.innerHTML = originalText;
        btn.disabled = false;
        btn.classList.remove('opacity-50');
    });
}
</script>
@endsection
