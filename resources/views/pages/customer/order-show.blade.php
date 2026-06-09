@extends('pages.customer.dashboard')

@section('title', 'Pedido ' . $order->order_number . ' | TodoKeys')

@section('customer_content')
<div class="mb-8">
    <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-2 text-sm text-text-secondary hover:text-primary-500 transition-colors mb-4">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Volver a Mis Pedidos
    </a>
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-extrabold text-text-primary ">Pedido {{ $order->order_number }}</h1>
            <p class="text-sm text-text-secondary mt-1">Realizado el {{ $order->created_at->format('d \d\e M \d\e Y, H:i') }}</p>
        </div>
        <span class="badge text-sm px-4 py-1.5
            {{ $order->status === 'delivered' ? 'badge-success' : '' }}
            {{ $order->status === 'pending' ? 'badge-warning' : '' }}
            {{ $order->status === 'cancelled' ? 'badge-danger' : '' }}
            {{ !in_array($order->status, ['delivered', 'pending', 'cancelled']) ? 'bg-primary-100 text-primary-700' : '' }}">
            @if($order->status === 'delivered') Entregado
            @elseif($order->status === 'pending') Pendiente
            @elseif($order->status === 'processing') Procesando
            @elseif($order->status === 'paid') Pagado
            @elseif($order->status === 'cancelled') Cancelado
            @elseif($order->status === 'refunded') Reembolsado
            @endif
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Items -->
    <div class="lg:col-span-2 space-y-6">
        <div class="card">
            <div class="p-6 border-b border-gray-100 ">
                <h2 class="font-bold text-text-primary ">Productos</h2>
            </div>
            <div class="divide-y divide-gray-100 ">
                @foreach($order->items as $item)
                <div class="p-6 flex items-center gap-4">
                    <div class="w-14 h-14 bg-primary-50 rounded-xl flex items-center justify-center text-2xl shrink-0 overflow-hidden">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                        @elseif(isset($item->product->category->icon) && str_contains($item->product->category->icon, 'fa-'))
                            <i class="{{ $item->product->category->icon }} text-primary-500"></i>
                        @else
                            {{ $item->product->category->icon ?? '📦' }}
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-semibold text-text-primary text-sm">{{ $item->product->name }}</div>
                        <div class="text-xs text-text-muted mt-0.5">Cantidad: {{ $item->quantity }}</div>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="font-bold text-text-primary ">{{ currency_format($item->price * $item->quantity) }}</div>
                        @if($item->license)
                        <div class="text-xs text-green-600 mt-1 font-mono">
                            {{ $item->license->is_revealed ? substr($item->license->key, 0, 16) . '...' : '••••••••••••••••' }}
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        @if($order->status === 'delivered' && $order->items->where('license')->count())
        <div class="card">
            <div class="p-6 border-b border-gray-100 ">
                <h2 class="font-bold text-text-primary flex items-center gap-2">
                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
                    Licencias Entregadas
                </h2>
            </div>
            <div class="p-6 space-y-3">
                @foreach($order->items->where('license') as $item)
                <div class="bg-gray-50 rounded-xl p-4">
                    <div class="text-xs text-text-muted mb-1">{{ $item->product->name }}</div>
                    @if($item->license->is_revealed)
                        <div class="font-mono text-sm font-bold text-text-primary bg-white px-4 py-2 rounded-lg border border-gray-200 select-all">
                            {{ $item->license->key }}
                        </div>
                    @else
                        <div class="flex items-center gap-4 bg-white px-4 py-2 rounded-lg border border-gray-200" id="license-container-{{ $item->license->id }}">
                            <div class="font-mono text-sm font-bold text-text-primary tracking-widest text-gray-400 select-none">
                                ••••••••••••••••
                            </div>
                            <div class="relative group ml-auto flex items-center">
                                <button type="button" onclick="revealLicense({{ $item->license->id }}, this)" class="btn-primary py-1.5 px-4 text-xs whitespace-nowrap">
                                    <i class="fa-solid fa-eye mr-1"></i> Revelar Clave
                                </button>
                                <!-- Tooltip -->
                                <div class="absolute bottom-full right-0 mb-2 w-64 p-3 bg-gray-900 text-white text-[11px] leading-snug rounded-lg shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-10 pointer-events-none transform translate-y-1 group-hover:translate-y-0 text-center font-normal">
                                    Al revelar esta clave, el sistema registrará que la has visualizado.
                                    <!-- Flecha -->
                                    <div class="absolute top-full right-6 -mt-1 w-2 h-2 bg-gray-900 transform rotate-45"></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Summary -->
    <div class="space-y-6">
        <div class="card p-6">
            <h3 class="font-bold text-text-primary mb-4">Resumen</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-text-secondary">Subtotal</span>
                    <span class="font-medium text-text-primary ">{{ currency_format($order->subtotal) }}</span>
                </div>
                @if($order->discount > 0)
                <div class="flex justify-between text-green-600">
                    <span>Descuento {{ $order->coupon ? '(' . $order->coupon->code . ')' : '' }}</span>
                    <span class="font-medium">-{{ currency_format($order->discount) }}</span>
                </div>
                @endif
                <div class="flex justify-between">
                    <span class="text-text-secondary">Impuestos</span>
                    <span class="font-medium text-text-primary ">{{ currency_format($order->tax) }}</span>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-100 ">
                    <span class="font-bold text-text-primary ">Total</span>
                    <span class="font-extrabold text-lg text-primary-500">{{ currency_format($order->total) }}</span>
                </div>
            </div>
        </div>

        <div class="card p-6">
            <h3 class="font-bold text-text-primary mb-4">Detalles de Pago</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-text-secondary">Método</span>
                    <span class="font-medium text-text-primary ">PayPal</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-text-secondary">Estado</span>
                    <span class="badge badge-success text-xs">{{ ucfirst($order->status) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-text-secondary">Fecha</span>
                    <span class="font-medium text-text-primary ">{{ $order->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>

        @if($order->status === 'pending')
        <a href="{{ route('checkout.index') }}" class="btn-primary w-full text-center block">
            Completar Pago
        </a>
        @endif
    </div>
</div>

@push('scripts')
<script>
function revealLicense(licenseId, btn) {
    if (confirm('¿Estás seguro de que deseas revelar esta clave?')) {
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Revelando...';
        btn.disabled = true;

        fetch(`/mi-cuenta/licencias/${licenseId}/reveal`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const container = document.getElementById(`license-container-${licenseId}`);
                container.outerHTML = `
                    <div class="font-mono text-sm font-bold text-text-primary bg-white px-4 py-2 rounded-lg border border-gray-200 select-all">
                        ${data.key}
                    </div>
                `;
            } else {
                alert('Error al revelar la licencia. Intenta de nuevo.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al procesar la solicitud.');
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
}
</script>
@endpush
@endsection
