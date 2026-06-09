@extends('layouts.app')

@section('title', 'Checkout | TodoKeys')

@section('content')
<div class="max-w-[1200px] mx-auto px-4 py-10">
    <nav class="flex items-center gap-2 text-[13px] font-medium text-gray-400 mb-8">
        <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Inicio</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="{{ route('cart.index') }}" class="hover:text-blue-600 transition-colors">Carrito</a>
        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-900">Checkout</span>
    </nav>

    <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-8">Finalizar Compra</h1>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Payment Form -->
        <div class="flex-1">
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 p-6 md:p-8">
                <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    Método de Pago
                </h2>

                <form action="{{ route('checkout.process') }}" method="POST" x-data="{ paymentMethod: '{{ $paypalEnabled ? 'paypal' : ($mercadopagoEnabled ? 'mercadopago' : (isset($wompiEnabled) && $wompiEnabled ? 'wompi' : 'points')) }}' }">
                    @csrf

                    <!-- Points Redemption -->
                    @if($pointsEnabled && $userPoints >= 100)
                    <div class="mb-6 p-5 bg-gradient-to-r from-amber-50 to-orange-50 rounded-[16px] border border-amber-100" x-data="{ usePoints: false, pointsToUse: 0, discount: 0, newTotal: '{{ number_format($total, 2) }}' }">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm">
                                    <i class="fa-solid fa-coins text-amber-500"></i>
                                </div>
                                <div>
                                    <h3 class="text-[14px] font-bold text-amber-900">Usar mis TodoPuntos</h3>
                                    <p class="text-[12px] text-amber-700/80">{{ number_format($userPoints) }} puntos disponibles (hasta {{ currency_format($maxRedeemable / 100) }})</p>
                                </div>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" x-model="usePoints" @change="if(usePoints){pointsToUse={{ $maxRedeemable }}}else{pointsToUse=0;discount=0;newTotal='{{ number_format($total, 2) }}'}" class="peer sr-only">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-amber-300 dark:peer-focus:ring-amber-800 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-amber-500"></div>
                            </label>
                        </div>
                        <div x-show="usePoints" x-transition class="mt-4 pt-4 border-t border-amber-200/50">
                            <label class="block text-[13px] font-bold text-amber-900 mb-2">Puntos a canjear</label>
                            <div class="flex items-center gap-3">
                                <input type="number" name="redeem_points" x-model.number="pointsToUse" min="0" max="{{ $maxRedeemable }}" step="100" @input="fetch('{{ route('checkout.apply-points') }}', {method:'POST', headers:{'Content-Type':'application/json','X-CSRF-TOKEN':'{{ csrf_token() }}'},body:JSON.stringify({points:pointsToUse})}).then(r=>r.json()).then(d=>{discount=d.discount;newTotal=d.new_total})" class="flex-1 px-4 py-3 bg-white border border-amber-200 rounded-xl text-[14px] font-bold text-amber-900 focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition-all">
                                <div class="bg-amber-100 text-amber-800 px-4 py-3 rounded-xl text-[13px] font-bold whitespace-nowrap">
                                    - $<span x-text="discount">0</span>
                                </div>
                            </div>
                            <div class="flex justify-between items-center mt-3 bg-white/60 p-3 rounded-lg">
                                <span class="text-[13px] font-semibold text-amber-800">Nuevo total a pagar:</span>
                                <span class="text-lg font-black text-amber-600"><span x-text="newTotal">{{ currency_format($total) }}</span></span>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="space-y-4">
                        @if($paypalEnabled)
                        <!-- PayPal -->
                        <label class="relative block cursor-pointer">
                            <input type="radio" name="payment_method" value="paypal" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-5 border-2 border-transparent peer-checked:border-blue-500 peer-checked:bg-blue-50/50 bg-white rounded-2xl flex items-center justify-between transition-all shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm text-[#003087] text-2xl border border-gray-100">
                                        <i class="fa-brands fa-paypal"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-[15px]">PayPal</div>
                                        <div class="text-[13px] text-gray-500">Paga con tu cuenta o tarjeta</div>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-4 peer-checked:border-blue-500 bg-white transition-all"></div>
                            </div>
                        </label>
                        @endif

                        @if($mercadopagoEnabled)
                        <!-- Mercado Pago -->
                        <label class="relative block cursor-pointer">
                            <input type="radio" name="payment_method" value="mercadopago" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-5 border-2 border-transparent peer-checked:border-[#009ee3] peer-checked:bg-[#009ee3]/10 bg-white rounded-2xl flex items-center justify-between transition-all shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm text-[#009ee3] text-2xl border border-gray-100">
                                        <i class="fa-solid fa-handshake"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-[15px]">Mercado Pago</div>
                                        <div class="text-[13px] text-gray-500">Tarjetas, efectivo y dinero en cuenta</div>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-4 peer-checked:border-[#009ee3] bg-white transition-all"></div>
                            </div>
                        </label>
                        @endif

                        @if(isset($wompiEnabled) && $wompiEnabled)
                        <!-- Wompi -->
                        <label class="relative block cursor-pointer">
                            <input type="radio" name="payment_method" value="wompi" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-5 border-2 border-transparent peer-checked:border-indigo-500 peer-checked:bg-indigo-50/50 bg-white rounded-2xl flex items-center justify-between transition-all shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-sm text-indigo-600 text-2xl border border-gray-100">
                                        <i class="fa-solid fa-building-columns"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-[15px]">Wompi (PSE, Nequi, Tarjetas)</div>
                                        <div class="text-[13px] text-gray-500">Paga seguro con métodos locales y efectivo</div>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-4 peer-checked:border-indigo-500 bg-white transition-all"></div>
                            </div>
                        </label>
                        @endif

                        <!-- Puntos -->
                        <label class="relative block cursor-pointer">
                            <input type="radio" name="payment_method" value="points" x-model="paymentMethod" class="peer sr-only" {{ (!isset($pointsEnabled) || !$pointsEnabled || !isset($userPoints) || $userPoints < ($total * 100)) ? 'disabled' : '' }}>
                            <div class="p-5 border-2 border-transparent peer-checked:border-amber-500 peer-checked:bg-amber-50 peer-disabled:opacity-60 peer-disabled:cursor-not-allowed bg-white rounded-2xl flex items-center justify-between transition-all shadow-sm">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-amber-400 to-orange-500 rounded-xl flex items-center justify-center shadow-sm text-white text-2xl border border-amber-200">
                                        <i class="fa-solid fa-coins"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-[15px]">Pagar con TodoPuntos</div>
                                        <div class="text-[13px] {{ (!isset($userPoints) || $userPoints < ($total * 100)) ? 'text-red-500' : 'text-amber-600 font-medium' }}">
                                            Tienes {{ isset($userPoints) ? number_format($userPoints) : 0 }} pts (${{ isset($userPoints) ? number_format($userPoints / 100, 2) : '0.00' }})
                                            @if(!isset($userPoints) || $userPoints < ($total * 100))
                                                - Insuficientes
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="w-6 h-6 rounded-full border-2 border-gray-200 peer-checked:border-4 peer-checked:border-amber-500 bg-white transition-all"></div>
                            </div>
                        </label>
                    </div>

                    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="flex flex-col items-center justify-center text-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center mb-2 text-lg">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <span class="text-[12px] font-bold text-gray-700">Pago 100% Seguro</span>
                        </div>
                        <div class="flex flex-col items-center justify-center text-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center mb-2 text-lg">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <span class="text-[12px] font-bold text-gray-700">Entrega Inmediata</span>
                        </div>
                        <div class="flex flex-col items-center justify-center text-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-2 text-lg">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <span class="text-[12px] font-bold text-gray-700">Soporte 24/7</span>
                        </div>
                    </div>

                    <button type="submit" 
                        :class="{
                            'bg-[#0070ba] hover:bg-[#003087] shadow-[0_4px_14px_0_rgba(0,112,186,0.39)] hover:shadow-[0_6px_20px_rgba(0,112,186,0.23)]': paymentMethod === 'paypal',
                            'bg-[#009ee3] hover:bg-[#008bd1] shadow-[0_4px_14px_0_rgba(0,158,227,0.39)] hover:shadow-[0_6px_20px_rgba(0,158,227,0.23)]': paymentMethod === 'mercadopago',
                            'bg-[#1e1b4b] hover:bg-[#312e81] shadow-[0_4px_14px_0_rgba(49,46,129,0.39)] hover:shadow-[0_6px_20px_rgba(49,46,129,0.23)]': paymentMethod === 'wompi',
                            'bg-amber-500 hover:bg-amber-600 shadow-[0_4px_14px_0_rgba(245,158,11,0.39)] hover:shadow-[0_6px_20px_rgba(245,158,11,0.23)]': paymentMethod === 'points'
                        }"
                        class="w-full mt-8 text-white font-bold py-4 px-6 rounded-xl hover:-translate-y-0.5 transition-all flex items-center justify-center gap-3 text-[16px]">
                        
                        <i x-show="paymentMethod === 'paypal'" class="fa-brands fa-paypal text-xl"></i>
                        <i x-show="paymentMethod === 'mercadopago'" class="fa-solid fa-handshake text-xl"></i>
                        <i x-show="paymentMethod === 'wompi'" class="fa-solid fa-building-columns text-xl"></i>
                        <i x-show="paymentMethod === 'points'" class="fa-solid fa-coins text-xl"></i>
                        
                        <span x-text="
                            paymentMethod === 'paypal' ? 'Pagar con PayPal • {{ currency_format($total) }}' : 
                            (paymentMethod === 'mercadopago' ? 'Pagar con Mercado Pago • {{ currency_format($total) }}' : 
                            (paymentMethod === 'wompi' ? 'Continuar a Wompi • {{ currency_format($total) }}' : 
                            'Canjear Puntos y Pagar'))
                        "></span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="w-full lg:w-[380px] shrink-0">
            <div class="bg-white rounded-[20px] shadow-sm border border-gray-100 p-6 sticky top-24">
                <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center">
                        <i class="fa-solid fa-basket-shopping"></i>
                    </div>
                    Resumen del Pedido
                </h2>

                <div class="space-y-4 mb-6">
                    @foreach($cart as $item)
                    <div class="flex gap-4">
                        <div class="w-16 h-16 bg-gray-50 rounded-xl flex items-center justify-center text-2xl shrink-0 border border-gray-100">
                            @if(isset($item['image']) && $item['image'])
                                <img src="{{ asset('storage/' . $item['image']) }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                📦
                            @endif
                        </div>
                        <div class="flex-1 min-w-0 flex flex-col justify-center">
                            <div class="text-[14px] font-bold text-gray-900 line-clamp-2 leading-snug mb-1">{{ $item['name'] }}</div>
                            <div class="flex items-center justify-between mt-auto">
                                <span class="text-[12px] font-bold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">Cant: {{ $item['quantity'] }}</span>
                                <span class="text-[14px] font-black text-gray-900">{{ currency_format($item['price'] * $item['quantity']) }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="border-t border-dashed border-gray-200 pt-4 space-y-3">
                    <div class="flex justify-between text-[14px]">
                        <span class="font-medium text-gray-500">Subtotal</span>
                        <span class="font-bold text-gray-900">{{ currency_format($subtotal) }}</span>
                    </div>
                    @if($discount > 0)
                    <div class="flex justify-between text-[14px]">
                        <span class="font-bold text-emerald-500 flex items-center gap-1"><i class="fa-solid fa-tag"></i> Descuento</span>
                        <span class="font-bold text-emerald-500">-{{ currency_format($discount) }}</span>
                    </div>
                    @endif
                    <div class="flex justify-between items-center border-t border-gray-100 pt-4 mt-2">
                        <span class="text-[16px] font-bold text-gray-900">Total a Pagar</span>
                        <span class="text-2xl font-black text-blue-600">{{ currency_format($total) }}</span>
                    </div>
                </div>

                @if($pointsEnabled)
                <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-100 flex items-start gap-3">
                    <div class="mt-0.5 text-blue-500"><i class="fa-solid fa-gift"></i></div>
                    <div class="text-[12px] text-blue-800 leading-relaxed">
                        Con esta compra ganarás <strong class="text-blue-600 font-black">{{ number_format($total) }} TodoPuntos</strong> para tus próximas compras.
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
