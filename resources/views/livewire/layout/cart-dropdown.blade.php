<div class="relative" x-data="{ open: false }">
    <button @click="open = !open" class="flex flex-col items-center justify-center gap-1 text-gray-300 hover:text-blue-500 transition-colors group relative">
        <div class="relative">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            @if($count > 0)
            <span class="absolute -top-1.5 -right-2 w-[18px] h-[18px] bg-[#f48024] text-white text-[10px] font-bold rounded-full flex items-center justify-center border-2 border-[#12141d]">{{ $count }}</span>
            @endif
        </div>
        <span class="text-[10px] font-bold tracking-wider uppercase group-hover:text-blue-500 transition-colors hidden sm:block">Carrito</span>
    </button>

    <div x-show="open" @click.away="open = false" x-transition style="display:none;" class="absolute right-0 mt-4 w-80 bg-white rounded-lg shadow-2xl border border-gray-100 z-[60] text-gray-800">
        <div class="p-4 border-b border-gray-100 bg-gray-50/50 rounded-t-lg">
            <h3 class="font-bold text-gray-900">Tu Carrito ({{ $count }})</h3>
        </div>
        @if($count > 0)
        <div class="max-h-64 overflow-y-auto">
            @foreach($cartItems as $item)
            <div class="p-4 flex items-center gap-3 border-b border-gray-50 hover:bg-gray-50 transition-colors">
                <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center text-xl shrink-0">📦</div>
                <div class="flex-1 min-w-0">
                    <div class="text-sm font-semibold text-gray-800 truncate mb-1">{{ $item['name'] }}</div>
                    <div class="text-xs text-gray-500 font-medium">x{{ $item['quantity'] }} · <span class="text-blue-600 font-bold">{{ currency_format($item['price']) }}</span></div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="p-4 border-t border-gray-100 bg-gray-50/50 rounded-b-lg">
            <div class="flex justify-between items-center mb-4">
                <span class="text-sm font-semibold text-gray-600">Total</span>
                <span class="text-lg font-black text-gray-900">{{ currency_format($total) }}</span>
            </div>
            <a href="{{ route('cart.index') }}" class="block w-full bg-[#f48024] hover:bg-[#ff9845] text-white font-bold text-center text-sm py-3 rounded transition-colors">
                Ver Carrito y Pagar
            </a>
        </div>
        @else
        <div class="p-8 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <p class="text-sm font-medium text-gray-500">Tu carrito está vacío</p>
        </div>
        @endif
    </div>
</div>
