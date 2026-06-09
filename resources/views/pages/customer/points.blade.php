@extends('pages.customer.dashboard')

@section('title', 'Mis Puntos | TodoKeys')

@section('customer_content')
<div class="mb-6">
    <h1 class="text-[22px] font-extrabold text-gray-900 ">Mis Puntos</h1>
    <p class="text-[13px] text-gray-500 mt-1">Consulta tu saldo y historial de transacciones de puntos.</p>
</div>

<!-- Points Card -->
<div class="bg-gradient-to-br from-[#6B8FCC] to-[#4A6FA5] rounded-2xl p-6 text-white mb-6 shadow-xl shadow-primary-500/10">
    <div class="flex items-center justify-between">
        <div>
            <div class="text-[12px] font-medium opacity-80">Saldo Disponible</div>
            <div class="text-4xl font-extrabold mt-1 tracking-tight">{{ number_format($totalPoints) }}</div>
            <div class="text-[13px] opacity-70 mt-0.5">= {{ currency_format($pointsValue) }} de descuento</div>
        </div>
        <div class="w-16 h-16 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/></svg>
        </div>
    </div>

    @if($totalPoints > 0)
    <div class="mt-4 pt-4 border-t border-white/20">
        <div class="flex items-center gap-2 text-[12px]">
            <svg class="w-4 h-4 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            <span class="opacity-80">Gana más puntos con cada compra. Canjéalos en el checkout para obtener descuentos.</span>
        </div>
    </div>
    @endif
</div>

<!-- How it Works -->
<div class="bg-white rounded-2xl p-6 border border-gray-100 mb-6">
    <h2 class="text-[15px] font-bold text-gray-900 mb-4">¿Cómo funciona?</h2>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="text-center p-4">
            <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            </div>
            <div class="text-[13px] font-semibold text-gray-900 ">1. Compra</div>
            <div class="text-[11px] text-gray-500 mt-1">Realiza tu pedido normalmente</div>
        </div>
        <div class="text-center p-4">
            <div class="w-10 h-10 bg-[#6B8FCC]/10 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-[#6B8FCC]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/></svg>
            </div>
            <div class="text-[13px] font-semibold text-gray-900 ">2. Gana Puntos</div>
            <div class="text-[11px] text-gray-500 mt-1">Recibe puntos tras la entrega</div>
        </div>
        <div class="text-center p-4">
            <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <div class="text-[13px] font-semibold text-gray-900 ">3. Canjea</div>
            <div class="text-[11px] text-gray-500 mt-1">Úsalos en tu próxima compra</div>
        </div>
    </div>
</div>

<!-- Transaction History -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 ">
        <h2 class="text-[15px] font-bold text-gray-900 ">Historial de Transacciones</h2>
    </div>

    @if($transactions->isEmpty())
    <div class="p-12 text-center">
        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div class="text-[14px] font-semibold text-gray-900 mb-1">Sin transacciones</div>
        <div class="text-[12px] text-gray-500 ">Aún no tienes movimientos de puntos. ¡Realiza tu primera compra!</div>
    </div>
    @else
    <div class="divide-y divide-gray-50 ">
        @foreach($transactions as $transaction)
        <div class="px-6 py-4 hover:bg-gray-50/50 transition-colors">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 {{ $transaction->points > 0 ? 'bg-emerald-100 ' : 'bg-red-100 ' }} rounded-xl flex items-center justify-center shrink-0">
                        @if($transaction->points > 0)
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        @else
                        <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                        @endif
                    </div>
                    <div>
                        <div class="text-[13px] font-medium text-gray-900 ">{{ $transaction->description }}</div>
                        <div class="text-[11px] text-gray-500 ">{{ $transaction->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                </div>
                <div class="text-[13px] font-bold {{ $transaction->points > 0 ? 'text-emerald-500' : 'text-red-500' }}">
                    {{ $transaction->points > 0 ? '+' : '' }}{{ number_format($transaction->points) }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
