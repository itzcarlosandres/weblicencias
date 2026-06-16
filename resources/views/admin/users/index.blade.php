@extends('layouts.admin')

@section('title', 'Usuarios Registrados')
@section('header', 'Usuarios')
@section('breadcrumb')
    <span>Usuarios</span>
@endsection

@section('content')
<div class="mb-6 flex justify-between items-center">
    <div>
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Usuarios Registrados</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Gestiona los clientes de la tienda.</p>
    </div>
</div>

<div class="bg-white dark:bg-[#111827] rounded-xl shadow-sm border border-gray-200 dark:border-gray-800">
    <div class="p-4 border-b border-gray-200 dark:border-gray-800 flex justify-between items-center">
        <form action="{{ route('admin.users.index') }}" method="GET" class="relative w-full max-w-sm">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o email..." class="w-full pl-10 pr-4 py-2 bg-gray-50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 text-gray-900 dark:text-white">
            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </form>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 dark:text-gray-300 uppercase bg-gray-50 dark:bg-gray-800/50">
                <tr>
                    <th scope="col" class="px-6 py-4 font-semibold">Usuario</th>
                    <th scope="col" class="px-6 py-4 font-semibold">Registro</th>
                    <th scope="col" class="px-6 py-4 text-right font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-800">
                @forelse($users as $user)
                <tr class="hover:bg-gray-50 dark:hover:bg-white/5 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-lg object-cover bg-gray-100">
                            <div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900 dark:text-gray-300">{{ $user->created_at->format('d M Y') }}</div>
                        <div class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <a href="{{ route('admin.users.show', $user) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-400 hover:text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-500/10 transition-colors">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                        No se encontraron usuarios.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="p-4 border-t border-gray-200 dark:border-gray-800">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
