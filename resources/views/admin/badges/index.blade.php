@extends('layouts.admin')

@section('title', 'Etiquetas')
@section('header', 'Etiquetas (Badges)')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Gestión de Etiquetas</h2>
        <p class="text-sm text-gray-500 mt-1">Crea y administra etiquetas para destacar tus productos.</p>
    </div>
    <a href="{{ route('admin.badges.create') }}" class="px-4 py-2 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-lg transition-colors shadow-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nueva Etiqueta
    </a>
</div>

<div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden shadow-sm">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-50/50 dark:bg-gray-800/30 border-b border-gray-200/60 dark:border-gray-800/60">
                <th class="px-6 py-4 text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Etiqueta</th>
                <th class="px-6 py-4 text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Preview</th>
                <th class="px-6 py-4 text-[11px] font-semibold text-gray-500 uppercase tracking-wider">Estado</th>
                <th class="px-6 py-4 text-[11px] font-semibold text-gray-500 uppercase tracking-wider text-right">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200/60 dark:divide-gray-800/60">
            @forelse($badges as $badge)
            <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/20 transition-colors">
                <td class="px-6 py-4">
                    <div class="text-[14px] font-medium text-gray-900 dark:text-white">{{ $badge->name }}</div>
                </td>
                <td class="px-6 py-4">
                    @php
                        $badgeColorClass = match($badge->color) {
                            'red' => 'bg-red-600 text-white',
                            'green' => 'bg-green-600 text-white',
                            'blue' => 'bg-blue-600 text-white',
                            'yellow' => 'bg-yellow-500 text-gray-900',
                            'purple' => 'bg-purple-600 text-white',
                            'orange' => 'bg-orange-500 text-white',
                            default => 'bg-blue-600 text-white',
                        };
                    @endphp
                    <div class="inline-flex {{ $badgeColorClass }} text-[10px] font-black tracking-wider px-2 py-1 rounded-lg shadow-sm items-center gap-1.5 uppercase">
                        @if($badge->icon)<i class="{{ $badge->icon }}"></i>@endif
                        <span>{{ $badge->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @if($badge->is_active)
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 text-xs font-medium border border-emerald-100 dark:border-emerald-800/30">Activo</span>
                    @else
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-gray-50 dark:bg-gray-800 text-gray-600 dark:text-gray-400 text-xs font-medium border border-gray-200 dark:border-gray-700">Inactivo</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.badges.edit', $badge) }}" class="p-1.5 text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-lg transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form action="{{ route('admin.badges.destroy', $badge) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Seguro que deseas eliminar esta etiqueta?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-12 text-center">
                    <div class="w-16 h-16 bg-gray-50 dark:bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <h3 class="text-[15px] font-medium text-gray-900 dark:text-white mb-1">No hay etiquetas</h3>
                    <p class="text-[13px] text-gray-500 mb-4">Aún no has creado ninguna etiqueta.</p>
                    <a href="{{ route('admin.badges.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 text-[13px] font-medium rounded-lg hover:bg-primary-100 dark:hover:bg-primary-900/40 transition-colors">
                        Crear primera etiqueta
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
