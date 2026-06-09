@extends('layouts.admin')

@section('title', 'Gestor de Licencias')
@section('header', 'Gestor de Licencias y Keys')

@section('content')
<div x-data="{ showAssignModal: false, assignLicenseId: null, assignLicenseKey: '' }">
<div class="mb-6 flex flex-col sm:flex-row items-center justify-between gap-4">
    <div class="flex-1 w-full">
        <form action="{{ route('admin.licenses.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por código..." class="input-field max-w-xs">
            
            <select name="product_id" class="input-field max-w-xs">
                <option value="">Todos los productos</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="input-field max-w-[150px]">
                <option value="">Cualquier estado</option>
                <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Disponible</option>
                <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Vendido</option>
                <option value="used" {{ request('status') == 'used' ? 'selected' : '' }}>Usado</option>
            </select>
            
            <button type="submit" class="btn-primary w-full sm:w-auto">Filtrar</button>
            @if(request()->anyFilled(['search', 'product_id', 'status']))
                <a href="{{ route('admin.licenses.index') }}" class="btn-secondary text-center w-full sm:w-auto">Limpiar</a>
            @endif
        </form>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('admin.licenses.export', request()->all()) }}" class="btn-secondary">
            <i class="fa-solid fa-file-export mr-2"></i> Exportar
        </a>
        <a href="{{ route('admin.licenses.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus mr-2"></i> Agregar Licencias
        </a>
    </div>
</div>

<div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-100 dark:border-gray-800/60">
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Producto</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Código / Key</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Comprador</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Fecha Venta</th>
                    <th class="text-left px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Revelada</th>
                    <th class="text-right px-6 py-3.5 text-[11px] font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 dark:divide-gray-800/40">
                @forelse($licenses as $license)
                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.02] transition-colors">
                    <td class="px-6 py-4">
                        @if($license->product)
                        <a href="{{ route('admin.products.edit', $license->product) }}" class="font-medium text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400">
                            {{ $license->product->name }}
                        </a>
                        @else
                        <span class="text-gray-500">Producto Eliminado</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-mono text-gray-600 dark:text-gray-300">
                        {{ $license->key }}
                    </td>
                    <td class="px-6 py-4">
                        @if($license->status === 'available')
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400">
                                Disponible
                            </span>
                        @elseif($license->status === 'sold')
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                Vendido
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400">
                                Usado
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500">
                        @if($license->buyer)
                            <a href="{{ route('admin.users.show', $license->buyer) }}" class="hover:text-primary-600">{{ $license->buyer->name }}</a>
                        @else
                            -
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-sm">
                        {{ $license->sold_at ? $license->sold_at->format('d/m/Y H:i') : '-' }}
                    </td>
                    <td class="px-6 py-4">
                        @if($license->status === 'sold')
                            @if($license->is_revealed)
                                <div class="flex flex-col">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400 w-max">
                                        Revelada
                                    </span>
                                    <span class="text-[10px] text-gray-400 mt-1">{{ $license->revealed_at->format('d/m/Y H:i') }}</span>
                                </div>
                            @else
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400 w-max">
                                    Oculta
                                </span>
                            @endif
                        @else
                            <span class="text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        @if($license->status === 'available')
                            <button @click="showAssignModal = true; assignLicenseId = {{ $license->id }}; assignLicenseKey = '{{ $license->key }}'" class="p-2 text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors" title="Asignar / Enviar Manualmente">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                            <form action="{{ route('admin.licenses.destroy', $license) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de eliminar esta licencia permanentemente?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-600 dark:hover:text-red-400 transition-colors" title="Eliminar Licencia">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-16 text-center">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mx-auto mb-4">
                            <svg class="w-8 h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                        </div>
                        <p class="text-[14px] font-medium text-gray-500 dark:text-gray-400 mb-1">No hay licencias</p>
                        <p class="text-[12px] text-gray-400 dark:text-gray-500">Importa licencias para comenzar a vender.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($licenses->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-800">
        {{ $licenses->links() }}
    </div>
    @endif
</div>

    <!-- Modal de Asignación Manual -->
    <div x-show="showAssignModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div x-show="showAssignModal" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" 
             class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" 
             @click="showAssignModal = false" aria-hidden="true"></div>

        <!-- Panel -->
        <div x-show="showAssignModal" 
             x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100" 
             x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" 
             class="relative bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-800 rounded-2xl shadow-2xl transform transition-all max-w-sm w-full overflow-hidden flex flex-col">
            
            <!-- Cabecera decorativa -->
            <div class="bg-gradient-to-r from-primary-600 to-primary-500 h-2 w-full"></div>

            <form :action="`/admin/licenses/${assignLicenseId}/assign`" method="POST">
                @csrf
                <div class="px-6 pt-6 pb-4">
                    <!-- Icono y Título (Centrados) -->
                    <div class="flex flex-col items-center mb-6">
                        <div class="flex items-center justify-center h-12 w-12 rounded-full bg-primary-50 dark:bg-primary-500/10 mb-4">
                            <i class="fa-solid fa-paper-plane text-xl text-primary-600 dark:text-primary-400"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white" id="modal-title">
                            Asignar Licencia
                        </h3>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                            Clave: <span class="font-mono font-medium text-gray-800 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 px-1.5 py-0.5 rounded" x-text="assignLicenseKey"></span>
                        </p>
                    </div>

                    <!-- Campos del formulario -->
                    <div class="space-y-4">
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-700 dark:text-gray-300 mb-1">Correo Electrónico</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-regular fa-envelope text-gray-400"></i>
                                </div>
                                <input type="email" name="email" id="email" required 
                                       class="w-full pl-10 pr-3 py-2.5 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-sm text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all outline-none" 
                                       placeholder="cliente@correo.com">
                            </div>
                        </div>

                        <div class="flex items-center bg-gray-50 dark:bg-gray-800 p-3 rounded-xl border border-gray-100 dark:border-gray-700">
                            <div class="flex items-center h-5">
                                <input id="send_email" name="send_email" type="checkbox" value="1" checked 
                                       class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded cursor-pointer">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="send_email" class="font-medium text-gray-700 dark:text-gray-300 cursor-pointer">
                                    Enviar por correo
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-800 border-t border-gray-100 dark:border-gray-700 flex gap-3">
                    <button type="button" @click="showAssignModal = false" 
                            class="flex-1 px-4 py-2 bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-xl text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-gray-600">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="flex-1 px-4 py-2 bg-primary-600 text-white rounded-xl text-sm font-medium hover:bg-primary-700 shadow-sm shadow-primary-500/30 transition-all focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
