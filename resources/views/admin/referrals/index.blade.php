@extends('layouts.admin')

@section('title', 'Programa de Referidos')
@section('header', 'Programa de Referidos')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Estadísticas de Referidos</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Usuarios que han invitado a otros y han completado compras.</p>
    </div>
</div>

<div class="bg-white dark:bg-[#111827] rounded-xl shadow-sm border border-gray-200 dark:border-gray-800">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800/50">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Usuario</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Código</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Referidos Totales</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-center">Puntos Acumulados</th>
                    <th scope="col" class="px-6 py-4 font-semibold text-right">Registrado</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                @forelse($referrers as $referrer)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 text-gray-500 flex items-center justify-center font-bold text-sm">
                                {{ substr($referrer->name, 0, 2) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $referrer->name }}</div>
                                <div class="text-xs text-gray-500">{{ $referrer->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap font-mono text-xs text-gray-900 dark:text-gray-300">
                        {{ $referrer->referral_code }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400">
                            {{ $referrer->referred_users_count }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold {{ $referrer->points > 0 ? 'bg-amber-100 text-amber-700 dark:bg-amber-500/10 dark:text-amber-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400' }}">
                            <i class="fa-solid fa-coins"></i> {{ number_format($referrer->points) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-900 dark:text-gray-300">
                        {{ $referrer->created_at->format('d M Y') }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        No se encontraron referidos.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($referrers->hasPages())
    <div class="p-4 border-t border-gray-100 dark:border-gray-800">
        {{ $referrers->links() }}
    </div>
    @endif
</div>
@endsection
