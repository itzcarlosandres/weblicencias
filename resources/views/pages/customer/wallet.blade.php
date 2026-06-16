@extends('pages.customer.dashboard')

@section('title', 'Mi Monedero | TodoKeys')

@section('customer_content')
<div class="mb-6">
    <h1 class="text-2xl font-extrabold text-text-primary ">Mi Monedero</h1>
    <p class="text-sm text-text-secondary mt-1">Acumula Cashback y úsalo para comprar gratis.</p>
</div>

<!-- Wallet Balance Card -->
<div class="bg-gray-900 rounded-2xl p-6 text-white relative overflow-hidden mb-8 shadow-sm border border-gray-800">
    <div class="absolute top-0 right-0 w-32 h-32 bg-white/5 rounded-full -translate-y-12 translate-x-12"></div>
    <div class="absolute bottom-0 left-0 w-24 h-24 bg-black/20 rounded-full translate-y-8 -translate-x-8"></div>
    
    <div class="relative z-10">
        <div class="text-sm font-medium opacity-80 tracking-wide flex items-center gap-2 mb-2">
            <i class="fa-solid fa-wallet"></i> Saldo Disponible
        </div>
        <div class="text-4xl font-black mb-1">
            ${{ number_format(auth()->user()->wallet_balance, 2) }}
        </div>
        <div class="text-sm opacity-80 mt-4 flex items-center gap-2">
            <i class="fa-solid fa-circle-info"></i> 
            Este saldo se descontará automáticamente en tu próxima compra si lo seleccionas en el checkout.
        </div>
    </div>
</div>

<!-- Transactions History -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
        <h3 class="font-bold text-text-primary">Historial de Movimientos</h3>
    </div>
    
    @if($transactions->count() > 0)
        <div class="divide-y divide-gray-50">
            @foreach($transactions as $transaction)
            <div class="flex items-center justify-between px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0 
                        {{ $transaction->amount > 0 ? 'bg-emerald-100 text-emerald-500' : 'bg-red-100 text-red-500' }}">
                        @if($transaction->type === 'cashback')
                            <i class="fa-solid fa-coins text-lg"></i>
                        @elseif($transaction->type === 'purchase')
                            <i class="fa-solid fa-cart-shopping text-sm"></i>
                        @elseif($transaction->type === 'refund')
                            <i class="fa-solid fa-rotate-left text-sm"></i>
                        @else
                            <i class="fa-solid fa-gears text-sm"></i>
                        @endif
                    </div>
                    <div>
                        <div class="text-[14px] font-bold text-text-primary">
                            {{ $transaction->description }}
                        </div>
                        <div class="text-[12px] text-text-muted mt-0.5">
                            {{ $transaction->created_at->format('d M Y, H:i') }}
                        </div>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-[15px] font-bold {{ $transaction->amount > 0 ? 'text-emerald-500' : 'text-red-500' }}">
                        {{ $transaction->amount > 0 ? '+' : '' }}${{ number_format($transaction->amount, 2) }}
                    </div>
                    <div class="text-[11px] text-text-muted mt-0.5 uppercase tracking-wide">
                        {{ $transaction->type }}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $transactions->links() }}
        </div>
    @else
        <div class="px-6 py-12 text-center">
            <div class="w-16 h-16 mx-auto bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-400">
                <i class="fa-solid fa-receipt text-2xl"></i>
            </div>
            <h4 class="text-[15px] font-bold text-text-primary mb-1">Aún no hay movimientos</h4>
            <p class="text-[13px] text-text-muted max-w-sm mx-auto">
                Compra juegos para ganar cashback o utiliza tu saldo disponible para ver el historial aquí.
            </p>
            <a href="{{ route('products.index') }}" class="inline-block mt-4 px-5 py-2.5 bg-primary-500 hover:bg-primary-600 text-white text-[13px] font-bold rounded-xl transition-colors">
                Ir a la Tienda
            </a>
        </div>
    @endif
</div>
@endsection
