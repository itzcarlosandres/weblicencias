@extends('layouts.admin')

@section('title', 'Agregar Licencias')
@section('header', 'Importar Nuevas Licencias')

@section('breadcrumb')
    <a href="{{ route('admin.licenses.index') }}" class="hover:text-gray-900 dark:hover:text-white transition-colors">Gestor de Licencias</a>
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    <span class="text-gray-900 dark:text-white font-medium">Agregar</span>
@endsection

@section('content')
<div class="max-w-2xl">
    <div class="bg-white dark:bg-gray-900 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-800 p-6">
        <form action="{{ route('admin.licenses.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Producto Destino</label>
                <select name="product_id" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-200">
                    <option value="">-- Selecciona el producto --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id', $selectedProductId) == $product->id ? 'selected' : '' }}>
                            {{ $product->name }} (Stock actual: {{ $product->stock }})
                        </option>
                    @endforeach
                </select>
                @error('product_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Llaves / Códigos (Uno por línea)</label>
                <textarea name="licenses" rows="10" required class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl text-gray-900 dark:text-white font-mono text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500 transition-all duration-200" placeholder="XXXX-XXXX-XXXX-XXXX&#10;YYYY-YYYY-YYYY-YYYY&#10;ZZZZ-ZZZZ-ZZZZ-ZZZZ">{{ old('licenses') }}</textarea>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                    Ingresa una licencia, serial o gift card por cada línea. Los códigos duplicados para este mismo producto serán ignorados automáticamente.
                </p>
                @error('licenses')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-xl transition-all duration-300 shadow-sm">
                    <i class="fa-solid fa-upload mr-2"></i> Importar Licencias
                </button>
                <a href="{{ route('admin.licenses.index') }}" class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 font-medium px-6 py-3 rounded-xl transition-all duration-300">Cancelar</a>
            </div>
        </form>
    </div>
</div>
@endsection
