@extends('layouts.admin')

@section('title', 'Editar: ' . $product->name)
@section('header', 'Editar Producto')

@section('content')
<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="max-w-5xl">
    @csrf
    @method('PUT')

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
                        <input type="text" name="name" id="product_name" value="{{ old('name', $product->name) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required placeholder="Ej: Windows 11 Pro">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Imagen Principal</label>
                        @if($product->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $product->image) }}" class="w-24 h-24 object-cover rounded-xl border border-gray-200 dark:border-gray-700">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        <p class="text-[11px] text-gray-400 mt-1">Formatos recomendados: JPG, PNG, WEBP (Ratio 3:4 o 1:1). Dejar vacío para mantener la imagen actual.</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Categoría *</label>
                            <select name="category_id" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Marca</label>
                            <select name="brand_id" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                                <option value="">Sin marca</option>
                                @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id) == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="type" value="{{ old('type', $product->type ?? 'license') }}">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">SKU</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descripción</label>
                        <textarea name="description" id="product_description" rows="4" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all resize-none" placeholder="Describe el producto...">{{ old('description', $product->description) }}</textarea>
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
                                <input type="number" name="price" value="{{ old('price', $product->price) }}" step="0.01" class="w-full pl-8 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required placeholder="0.00">
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5" title="Precio antiguo más alto, aparecerá tachado para mostrar el descuento.">Precio original (tachado)</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-[13px]">$</span>
                                <input type="number" name="compare_price" value="{{ old('compare_price', $product->compare_price) }}" step="0.01" class="w-full pl-8 pr-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Stock *</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Garantía (días)</label>
                            <input type="number" name="warranty_days" value="{{ old('warranty_days', $product->warranty_days) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Entrega</label>
                            <input type="text" name="delivery_time" value="{{ old('delivery_time', $product->delivery_time) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        </div>
                    </div>
                    <div class="space-y-4">
                        <!-- Platform Chip Selector -->
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-2">Plataforma</label>
                            <input type="hidden" name="platform" id="edit_platform_value" value="{{ old('platform', $product->platform) }}">
                            @php
                             $editCurrentPlatform = old('platform', $product->platform);
                             $editPlatformValues = $platforms->pluck('value')->map(function($val) { return strtolower($val); })->toArray();
                             $editSelectedPlatforms = array_map('trim', explode(',', strtolower($editCurrentPlatform ?? '')));
                             
                             // Check if there's a custom platform not in the DB
                             $customPlatformValue = '';
                             foreach(array_map('trim', explode(',', $editCurrentPlatform ?? '')) as $cpVal) {
                                 if ($cpVal && !in_array(strtolower($cpVal), $editPlatformValues)) {
                                     $customPlatformValue = $cpVal;
                                     break;
                                 }
                             }
                            @endphp
                            <div class="flex flex-wrap gap-2 mb-2">
                                @foreach($platforms as $ep)
                                @php $isSelected = in_array(strtolower($ep->value), $editSelectedPlatforms); @endphp
                                <button type="button"
                                    data-platform="{{ $ep->value }}"
                                    onclick="editSelectPlatform(this)"
                                    title="{{ $ep->value }}"
                                    class="edit-platform-chip group flex items-center gap-1.5 px-3 py-1.5 rounded-xl border text-[12px] font-semibold transition-all duration-150 {{ $isSelected ? 'bg-primary-500 border-primary-500 text-white shadow-sm shadow-primary-500/20' : 'bg-gray-50 dark:bg-gray-900/50 border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-300 hover:border-primary-400 hover:text-primary-600 dark:hover:text-primary-400' }}">
                                    @if($ep->image)
                                        <img src="{{ asset('storage/' . $ep->image) }}" class="w-4 h-4 object-contain {{ $isSelected ? 'brightness-0 invert' : '' }}">
                                    @elseif($ep->icon)
                                        <i class="{{ $ep->icon }} text-[#555] w-4 text-center {{ $isSelected ? 'text-white' : '' }}"></i>
                                    @endif
                                    {{ $ep->value }}
                                </button>
                                @endforeach
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-[11px] text-gray-400">Otro:</span>
                                <input type="text" id="edit_platform_custom"
                                    placeholder="Nintendo Switch, etc."
                                    value="{{ $customPlatformValue }}"
                                    oninput="document.getElementById('edit_platform_value').value=this.value; document.querySelectorAll('.edit-platform-chip').forEach(c=>{c.classList.remove('bg-primary-500','border-primary-500','text-white','shadow-sm'); c.classList.add('bg-gray-50','border-gray-200','text-gray-600')})"
                                    class="w-44 px-3 py-1.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl text-[12px] text-gray-900 dark:text-white focus:outline-none focus:ring-1 focus:ring-primary-400/40 focus:border-primary-400">
                            </div>
                        </div>
                        <!-- Region -->
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Región</label>
                            <input list="regions-list-edit" name="region" value="{{ old('region', $product->region) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Ej: Global, Latinoamérica" autocomplete="off">
                            <datalist id="regions-list-edit">
                                @foreach($regions as $r)
                                    <option value="{{ $r->value }}"></option>
                                @endforeach
                            </datalist>
                        </div>
                    </div>
                    <script>
                    (function() {
                        // Parse current platforms as array
                        var currentRaw = document.getElementById('edit_platform_value').value || '';
                        var selected = currentRaw.split(',').map(function(s){ return s.trim(); }).filter(Boolean);

                        function renderChips() {
                            document.querySelectorAll('.edit-platform-chip').forEach(function(btn) {
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
                            document.getElementById('edit_platform_value').value = selected.join(', ');
                        }

                        function editSelectPlatform(btn) {
                            var val = btn.dataset.platform;
                            if (selected.includes(val)) {
                                selected = selected.filter(function(v){ return v !== val; });
                            } else {
                                selected.push(val);
                            }
                            // Clear custom input when using chips
                            var custom = document.getElementById('edit_platform_custom');
                            if(custom) custom.value = '';
                            renderChips();
                        }

                        // Expose globally
                        window.editSelectPlatform = editSelectPlatform;

                        // Init on load
                        renderChips();
                    })();
                    </script>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Método de activación</label>
                        <input list="activation-methods-list-edit" name="activation_method" value="{{ old('activation_method', $product->activation_method) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Ej: Online, por teléfono" autocomplete="off">
                        <datalist id="activation-methods-list-edit">
                            @foreach($activationMethods as $am)
                                <option value="{{ $am->value }}"></option>
                            @endforeach
                        </datalist>
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
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Activo</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Destacado</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_bundle" value="1" {{ old('is_bundle', $product->is_bundle) ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-purple-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-purple-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Es Paquete</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_top_deal" value="1" {{ old('is_top_deal', $product->is_top_deal) ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-blue-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-blue-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Top Oferta (Aplica 15%)</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group" x-data="{ flash: {{ old('is_flash_sale', $product->is_flash_sale) ? 'true' : 'false' }} }">
                        <div class="relative">
                            <input type="checkbox" name="is_flash_sale" value="1" x-model="flash" class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-amber-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-amber-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Oferta Flash</span>
                    </label>
                    <div x-data="{ flash: {{ old('is_flash_sale', $product->is_flash_sale) ? 'true' : 'false' }} }" x-show="document.querySelector('input[name=is_flash_sale]').checked || flash" @change.document="flash = document.querySelector('input[name=is_flash_sale]').checked" class="mt-2" style="display: none;">
                        <label class="block text-[11px] font-medium text-gray-500 mb-1">Finaliza el:</label>
                        <input type="datetime-local" name="flash_sale_end" value="{{ old('flash_sale_end', $product->flash_sale_end ? $product->flash_sale_end->format('Y-m-d\TH:i') : '') }}" class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-xs">
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
                                <option value="{{ $badge->id }}" {{ old('badge_id', $product->badge_id) == $badge->id ? 'selected' : '' }}>
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
                        <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $product->meta_title) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Título para SEO">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Meta Description</label>
                        <textarea name="meta_description" id="meta_description" rows="3" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all resize-none" placeholder="Descripción para buscadores...">{{ old('meta_description', $product->meta_description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <div class="space-y-3">
                    <button type="submit" class="w-full px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20">
                        Guardar Cambios
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
