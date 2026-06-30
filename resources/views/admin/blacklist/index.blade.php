@extends('layouts.admin')

@section('title', 'Lista Negra (Blacklist)')
@section('header', 'Seguridad y Lista Negra')
@section('breadcrumb')
    <span>Lista Negra</span>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Formulario -->
    <div class="bg-white dark:bg-[#111827] rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Bloquear Nueva IP / País</h3>
        <p class="text-sm text-gray-500 mb-6">Bloquea el acceso a la tienda a direcciones IP fraudulentas o países enteros (el bloqueo de países aún está en desarrollo).</p>

        <form action="{{ route('admin.blacklist.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Bloqueo</label>
                <select name="type" required class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-primary-500 focus:border-primary-500 text-sm">
                    <option value="ip" class="dark:bg-gray-800 dark:text-white">Dirección IP</option>
                    <option value="country" class="dark:bg-gray-800 dark:text-white">País</option>
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor a Bloquear</label>
                <input type="text" name="value" placeholder="Ej: 192.168.1.1 o Colombia" required class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-primary-500 focus:border-primary-500 text-sm">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motivo (Opcional)</label>
                <input type="text" name="reason" placeholder="Ej: Intentos de fraude" class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-800 dark:text-white focus:ring-primary-500 focus:border-primary-500 text-sm">
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-4 rounded-lg transition-colors text-sm">
                <i class="fa-solid fa-ban mr-1"></i> Bloquear Ahora
            </button>
        </form>
    </div>

    <!-- Lista de Bloqueos -->
    <div class="lg:col-span-2 bg-white dark:bg-[#111827] rounded-xl shadow-sm border border-gray-200 dark:border-gray-800 overflow-hidden">
        <div class="p-6 border-b border-gray-200 dark:border-gray-800">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">IPs y Países Bloqueados</h3>
        </div>

        @if($blacklists->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800/50">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Tipo</th>
                        <th class="px-6 py-3 font-semibold">Valor Bloqueado</th>
                        <th class="px-6 py-3 font-semibold">Motivo</th>
                        <th class="px-6 py-3 font-semibold">Fecha</th>
                        <th class="px-6 py-3 font-semibold text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($blacklists as $item)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="px-6 py-4">
                            @if($item->type === 'ip')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">IP</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300">País</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $item->value }}</td>
                        <td class="px-6 py-4">{{ $item->reason ?: 'Sin motivo' }}</td>
                        <td class="px-6 py-4 text-xs">{{ $item->created_at->format('d M Y, H:i') }}</td>
                        <td class="px-6 py-4 text-right">
                            <form action="{{ route('admin.blacklist.destroy', $item) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas desbloquear esto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-medium text-xs bg-red-50 dark:bg-red-500/10 hover:bg-red-100 dark:hover:bg-red-500/20 px-3 py-1.5 rounded transition-colors">
                                    Desbloquear
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200 dark:border-gray-800">
            {{ $blacklists->links() }}
        </div>
        @else
        <div class="p-8 text-center text-gray-500">
            <i class="fa-solid fa-shield-check text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
            <p>No hay ninguna IP ni país en la lista negra actualmente.</p>
        </div>
        @endif
    </div>
</div>
@endsection
