@extends('layouts.admin')

@section('title', 'Editar Cupón: ' . $coupon->code)
@section('header', 'Editar Cupón')

@section('content')
<form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" class="max-w-3xl">
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Información del Cupón</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Código *</label>
                        <input type="text" name="code" value="{{ old('code', $coupon->code) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all font-mono uppercase" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Tipo *</label>
                            <select name="type" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required>
                                <option value="percentage" {{ old('type', $coupon->type) == 'percentage' ? 'selected' : '' }}>Porcentaje (%)</option>
                                <option value="fixed" {{ old('type', $coupon->type) == 'fixed' ? 'selected' : '' }}>Monto fijo ($)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Valor *</label>
                            <input type="number" name="value" value="{{ old('value', $coupon->value) }}" step="0.01" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Monto mínimo</label>
                            <input type="number" name="min_amount" value="{{ old('min_amount', $coupon->min_amount) }}" step="0.01" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        </div>
                        <div>
                            <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Descuento máximo</label>
                            <input type="number" name="max_discount" value="{{ old('max_discount', $coupon->max_discount) }}" step="0.01" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-6">
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <h3 class="text-[15px] font-semibold text-gray-900 dark:text-white mb-5">Límites</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Usos máximos</label>
                        <input type="number" name="max_uses" value="{{ old('max_uses', $coupon->max_uses) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Usos actuales</label>
                        <input type="text" value="{{ $coupon->used_count }}" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-500 dark:text-gray-400" disabled>
                    </div>
                    <div>
                        <label class="block text-[13px] font-medium text-gray-700 dark:text-gray-300 mb-1.5">Fecha de expiración</label>
                        <input type="date" name="expires_at" value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d')) }}" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-800 rounded-xl text-[13px] text-gray-900 dark:text-white placeholder:text-gray-400 focus:outline-none focus:ring-2 focus:ring-primary-400/30 focus:border-primary-400 transition-all">
                    </div>
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <div class="relative">
                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }} class="peer sr-only">
                            <div class="w-10 h-5 bg-gray-200 dark:bg-gray-700 peer-focus:ring-2 peer-focus:ring-primary-400/30 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-500"></div>
                        </div>
                        <span class="text-[13px] text-gray-700 dark:text-gray-300">Activo</span>
                    </label>
                </div>
            </div>
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-gray-200/60 dark:border-gray-800/60 p-6">
                <div class="space-y-3">
                    <button type="submit" class="w-full px-4 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-medium rounded-xl transition-colors shadow-sm shadow-primary-500/20">Guardar Cambios</button>
                    <a href="{{ route('admin.coupons.index') }}" class="w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-800 hover:bg-gray-200 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 text-[13px] font-medium rounded-xl transition-colors text-center block">Cancelar</a>
                </div>
            </div>
            <div class="bg-white dark:bg-[#111827] rounded-2xl border border-red-200/60 dark:border-red-800/30 p-6">
                <h3 class="text-[13px] font-semibold text-red-600 dark:text-red-400 mb-3">Zona de peligro</h3>
                <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" onsubmit="return confirm('¿Eliminar este cupón?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white text-[13px] font-medium rounded-xl transition-colors">Eliminar Cupón</button>
                </form>
            </div>
        </div>
    </div>
</form>
@endsection
