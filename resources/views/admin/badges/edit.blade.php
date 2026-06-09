@extends('layouts.admin')

@section('title', 'Editar Etiqueta')
@section('header', 'Editar Etiqueta')
@section('breadcrumb')
<a href="{{ route('admin.badges.index') }}" class="hover:text-gray-600 dark:hover:text-gray-300 transition-colors">Etiquetas</a>
<svg class="w-3.5 h-3.5 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
<span class="text-gray-900 dark:text-white font-medium">Editar</span>
@endsection

@section('content')
<form action="{{ route('admin.badges.update', $badge) }}" method="POST" class="max-w-2xl mx-auto">
    @csrf
    @method('PUT')

    <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6 space-y-6">
        <div>
            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nombre (Texto)</label>
            <input type="text" name="name" value="{{ old('name', $badge->name) }}" required maxlength="20" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
            @error('name') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Color</label>
                <select name="color" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                    <option value="blue" {{ old('color', $badge->color) == 'blue' ? 'selected' : '' }}>Azul</option>
                    <option value="red" {{ old('color', $badge->color) == 'red' ? 'selected' : '' }}>Rojo</option>
                    <option value="green" {{ old('color', $badge->color) == 'green' ? 'selected' : '' }}>Verde</option>
                    <option value="yellow" {{ old('color', $badge->color) == 'yellow' ? 'selected' : '' }}>Amarillo</option>
                    <option value="purple" {{ old('color', $badge->color) == 'purple' ? 'selected' : '' }}>Morado</option>
                    <option value="orange" {{ old('color', $badge->color) == 'orange' ? 'selected' : '' }}>Naranja</option>
                </select>
                @error('color') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Ícono (FontAwesome)</label>
                <select name="icon" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all font-mono">
                    <option value="">Ninguno</option>
                    <option value="fa-solid fa-fire" {{ old('icon', $badge->icon) == 'fa-solid fa-fire' ? 'selected' : '' }}>🔥 fa-fire</option>
                    <option value="fa-solid fa-star" {{ old('icon', $badge->icon) == 'fa-solid fa-star' ? 'selected' : '' }}>⭐ fa-star</option>
                    <option value="fa-solid fa-tag" {{ old('icon', $badge->icon) == 'fa-solid fa-tag' ? 'selected' : '' }}>🏷️ fa-tag</option>
                    <option value="fa-solid fa-bolt" {{ old('icon', $badge->icon) == 'fa-solid fa-bolt' ? 'selected' : '' }}>⚡ fa-bolt</option>
                    <option value="fa-solid fa-sparkles" {{ old('icon', $badge->icon) == 'fa-solid fa-sparkles' ? 'selected' : '' }}>✨ fa-sparkles</option>
                    <option value="fa-solid fa-crown" {{ old('icon', $badge->icon) == 'fa-solid fa-crown' ? 'selected' : '' }}>👑 fa-crown</option>
                    <option value="fa-solid fa-clock" {{ old('icon', $badge->icon) == 'fa-solid fa-clock' ? 'selected' : '' }}>🕒 fa-clock</option>
                </select>
                @error('icon') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="flex items-center gap-3 cursor-pointer group">
                <div class="relative">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $badge->is_active) ? 'checked' : '' }} class="peer sr-only">
                    <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                </div>
                <span class="text-[13px] text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">Activo</span>
            </label>
        </div>

        <div class="flex gap-3 pt-4 border-t border-gray-200/60 dark:border-gray-800/60">
            <button type="submit" class="px-6 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20">
                Guardar Cambios
            </button>
            <a href="{{ route('admin.badges.index') }}" class="px-6 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-[13px] font-medium rounded-xl transition-colors">
                Cancelar
            </a>
        </div>
    </div>
</form>
@endsection
