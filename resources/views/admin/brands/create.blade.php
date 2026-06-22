@extends('layouts.admin')

@section('title', 'Crear Marca')
@section('header', 'Crear Marca')

@section('content')
<form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl">
    @csrf
    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
        <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Información de la Marca</h3>
        <div class="space-y-4">
            <div>
                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nombre *</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required placeholder="Ej: Microsoft">
            </div>
            <div>
                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Icono (FontAwesome)</label>
                <input type="text" name="icon" value="{{ old('icon') }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" placeholder="Ej: fa-brands fa-microsoft">
                <p class="text-xs text-gray-500 mt-1">Opcional. Introduce la clase de FontAwesome para mostrar en lugar del logo (ej. fa-brands fa-apple).</p>
            </div>
            <div>
                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Logo (Imagen)</label>
                <input type="file" name="logo" accept="image/*" class="w-full px-4 py-2 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
            </div>
            <div class="flex flex-col sm:flex-row gap-6">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="peer sr-only">
                        <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                    </div>
                    <span class="text-[13px] text-gray-700 dark:text-gray-300">Activo</span>
                </label>

                <label class="flex items-center gap-3 cursor-pointer group">
                    <div class="relative">
                        <input type="checkbox" name="show_on_home" value="1" {{ old('show_on_home', true) ? 'checked' : '' }} class="peer sr-only">
                        <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                    </div>
                    <span class="text-[13px] text-gray-700 dark:text-gray-300">Mostrar en la página de inicio</span>
                </label>
            </div>
        </div>
    </div>
    <div class="flex gap-3 mt-6">
        <button type="submit" class="px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20">Crear Marca</button>
        <a href="{{ route('admin.brands.index') }}" class="px-6 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-[13px] font-medium rounded-xl transition-colors">Cancelar</a>
    </div>
</form>
@endsection