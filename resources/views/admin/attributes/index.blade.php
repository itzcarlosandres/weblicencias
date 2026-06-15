@extends('layouts.admin')

@section('title', 'Atributos de Producto')
@section('header', 'Atributos de Producto')

@section('content')
<!-- Header -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <div>
        <p class="text-[13px] text-gray-400">Gestiona las regiones y métodos de activación predeterminados para facilitar la creación de productos.</p>
    </div>
</div>

@if(session('success'))
<div class="mb-4 bg-emerald-50 text-emerald-600 border border-emerald-200 p-4 rounded-xl text-sm font-medium">
    {{ session('success') }}
</div>
@endif

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- REGIONS -->
    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800/60 bg-gray-50/50 dark:bg-gray-800/20">
            <h3 class="text-[14px] font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-globe text-primary-500"></i> Regiones Predeterminadas
            </h3>
        </div>
        
        <div class="p-6 border-b border-gray-100 dark:border-gray-800/60">
            <form action="{{ route('admin.attributes.store') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="hidden" name="type" value="region">
                <input type="text" name="value" placeholder="Ej. Global, LATAM, Europa..." required class="flex-1 px-4 py-2 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                <button type="submit" class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20">
                    Añadir
                </button>
            </form>
            @error('value')
                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex-1 p-6 bg-gray-50/30 dark:bg-gray-900/10">
            <div class="flex flex-wrap gap-2">
                @forelse($regions as $region)
                    <div class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-3 py-1.5 rounded-lg text-[12px] font-medium text-gray-700 dark:text-gray-300 shadow-sm group">
                        {{ $region->value }}
                        <form action="{{ route('admin.attributes.destroy', $region) }}" method="POST" class="inline-flex" onsubmit="return confirm('¿Eliminar esta región?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-gray-500 italic w-full text-center py-4">No hay regiones predeterminadas. Escribe en el campo de arriba (no es necesario guardar los productos existentes).</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- ACTIVATION METHODS -->
    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden flex flex-col">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800/60 bg-gray-50/50 dark:bg-gray-800/20">
            <h3 class="text-[14px] font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-key text-primary-500"></i> Métodos de Activación Predeterminados
            </h3>
        </div>
        
        <div class="p-6 border-b border-gray-100 dark:border-gray-800/60">
            <form action="{{ route('admin.attributes.store') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="hidden" name="type" value="activation_method">
                <input type="text" name="value" placeholder="Ej. Steam Key, Cuenta, Epic Games..." required class="flex-1 px-4 py-2 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                <button type="submit" class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20">
                    Añadir
                </button>
            </form>
            @error('value')
                <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex-1 p-6 bg-gray-50/30 dark:bg-gray-900/10">
            <div class="flex flex-wrap gap-2">
                @forelse($activationMethods as $method)
                    <div class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-3 py-1.5 rounded-lg text-[12px] font-medium text-gray-700 dark:text-gray-300 shadow-sm group">
                        {{ $method->value }}
                        <form action="{{ route('admin.attributes.destroy', $method) }}" method="POST" class="inline-flex" onsubmit="return confirm('¿Eliminar este método de activación?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-gray-500 italic w-full text-center py-4">No hay métodos predeterminados. Agrega uno arriba.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- PLATFORMS -->
    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden flex flex-col md:col-span-2">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800/60 bg-gray-50/50 dark:bg-gray-800/20">
            <h3 class="text-[14px] font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-gamepad text-primary-500"></i> Plataformas Predeterminadas
            </h3>
        </div>
        
        <div class="p-6 border-b border-gray-100 dark:border-gray-800/60">
            <form action="{{ route('admin.attributes.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row gap-3">
                @csrf
                <input type="hidden" name="type" value="platform">
                
                <div class="flex-1">
                    <input type="text" name="value" placeholder="Nombre (Ej: PlayStation)" required class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                </div>
                
                <div class="flex-1">
                    <input type="text" name="icon" placeholder="Clase FontAwesome (Ej: fa-brands fa-playstation)" class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                </div>
                
                <div class="flex-1 relative">
                    <input type="file" name="image" accept="image/*" class="w-full px-2 py-1.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[12px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-[11px] file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                </div>
                
                <button type="submit" class="px-5 py-2 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20 whitespace-nowrap">
                    Añadir Plataforma
                </button>
            </form>
            @error('value') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
            @error('image') <p class="mt-2 text-xs text-red-500">{{ $message }}</p> @enderror
        </div>

        <div class="flex-1 p-6 bg-gray-50/30 dark:bg-gray-900/10">
            <div class="flex flex-wrap gap-3">
                @forelse($platforms as $platform)
                    <div class="inline-flex items-center gap-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 px-3 py-2 rounded-xl shadow-sm group">
                        @if($platform->image)
                            <img src="{{ asset('storage/' . $platform->image) }}" class="w-5 h-5 object-contain">
                        @elseif($platform->icon)
                            <i class="{{ $platform->icon }} text-lg w-5 text-center text-gray-600 dark:text-gray-300"></i>
                        @endif
                        <span class="text-[13px] font-semibold text-gray-700 dark:text-gray-300">{{ $platform->value }}</span>
                        
                        <form action="{{ route('admin.attributes.destroy', $platform) }}" method="POST" class="inline-flex ml-2" onsubmit="return confirm('¿Eliminar esta plataforma?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-gray-500 italic w-full text-center py-4">No hay plataformas predeterminadas. Agrega una arriba.</p>
                @endforelse
            </div>
        </div>
    </div>

</div>
@endsection
