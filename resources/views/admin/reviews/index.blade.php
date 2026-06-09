@extends('layouts.admin')

@section('title', 'Reseñas de Clientes')

@section('content')
<div class="p-6 max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Reseñas de Clientes</h1>
            <p class="text-sm text-gray-500 mt-1">Gestiona las opiniones y calificaciones de los productos.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex justify-between items-center">
            {{ session('success') }}
            <button onclick="this.parentElement.remove()" class="text-green-700 hover:text-green-900">&times;</button>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-gray-50/50 border-b border-gray-100 text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4 font-semibold text-xs">ID</th>
                        <th class="px-6 py-4 font-semibold text-xs">Producto</th>
                        <th class="px-6 py-4 font-semibold text-xs">Usuario</th>
                        <th class="px-6 py-4 font-semibold text-xs">Calificación</th>
                        <th class="px-6 py-4 font-semibold text-xs">Comentario</th>
                        <th class="px-6 py-4 font-semibold text-xs">Estado</th>
                        <th class="px-6 py-4 font-semibold text-xs text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-gray-700">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900">#{{ $review->id }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('products.show', $review->product->slug) }}" target="_blank" class="text-blue-600 hover:underline font-medium">
                                {{ Str::limit($review->product->name, 30) }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-600">
                                    {{ substr($review->user->name, 0, 1) }}
                                </div>
                                {{ $review->user->name }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <span class="{{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-gray-500 line-clamp-2 max-w-xs" title="{{ $review->comment }}">
                                {{ $review->comment }}
                            </p>
                            <span class="text-[10px] text-gray-400 mt-1">{{ $review->created_at->format('d M Y, H:i') }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if($review->is_approved)
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded">Aprobada</span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded">Pendiente</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end items-center gap-2">
                                <form action="{{ route('admin.reviews.update-status', $review) }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="is_approved" value="{{ $review->is_approved ? 0 : 1 }}">
                                    <button type="submit" class="text-xs font-bold px-3 py-1.5 rounded transition-colors {{ $review->is_approved ? 'bg-yellow-50 text-yellow-600 hover:bg-yellow-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }}">
                                        {{ $review->is_approved ? 'Ocultar' : 'Aprobar' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta reseña?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-bold bg-red-50 text-red-600 hover:bg-red-100 px-3 py-1.5 rounded transition-colors">
                                        Eliminar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                            No hay reseñas registradas en el sistema.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($reviews->hasPages())
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $reviews->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
