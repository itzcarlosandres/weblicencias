@extends('pages.customer.dashboard')

@section('title', 'Mis Licencias | TodoKeys')

@section('customer_content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-text-primary ">Mis Licencias</h1>
    <p class="text-sm text-text-secondary mt-1">Todas tus claves de activación</p>
</div>

@if($licenses->count())
<div class="space-y-4">
    @foreach($licenses as $license)
    <div class="card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-primary-50 rounded-xl flex items-center justify-center text-2xl shrink-0 overflow-hidden">
                    @if($license->product->image)
                        <img src="{{ asset('storage/' . $license->product->image) }}" alt="{{ $license->product->name }}" class="w-full h-full object-cover">
                    @elseif(isset($license->product->category->icon) && str_contains($license->product->category->icon, 'fa-'))
                        <i class="{{ $license->product->category->icon }} text-primary-500"></i>
                    @else
                        {{ $license->product->category->icon ?? '📦' }}
                    @endif
                </div>
                <div>
                    <div class="font-bold text-text-primary text-sm">{{ $license->product->name }}</div>
                    <div class="text-xs text-text-muted mt-0.5">Comprado el {{ $license->sold_at?->format('d M Y') ?? $license->created_at->format('d M Y') }}</div>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="badge
                    {{ $license->status === 'active' ? 'badge-success' : '' }}
                    {{ $license->status === 'used' ? 'bg-blue-100 text-blue-700' : '' }}
                    {{ $license->status === 'expired' ? 'badge-warning' : '' }}
                    {{ $license->status === 'revoked' ? 'badge-danger' : '' }}">
                    @if($license->status === 'active') Activa
                    @elseif($license->status === 'used') Usada
                    @elseif($license->status === 'expired') Expirada
                    @elseif($license->status === 'revoked') Revocada
                    @else {{ ucfirst($license->status) }}
                    @endif
                </span>
            </div>
        </div>
        <div class="mt-4 bg-gray-50 rounded-xl p-4">
            <div class="text-xs text-text-muted mb-1.5">Clave de activación</div>
            @if($license->is_revealed)
                <div class="font-mono text-sm font-bold text-text-primary bg-white px-4 py-3 rounded-lg border border-gray-200 select-all flex items-center justify-between">
                    <span>{{ $license->key }}</span>
                    <button onclick="navigator.clipboard.writeText('{{ $license->key }}'); this.textContent='Copiado!'; setTimeout(()=>this.textContent='Copiar', 2000)" class="text-primary-500 hover:text-primary-600 text-xs font-semibold shrink-0 ml-4">Copiar</button>
                </div>
            @else
                <div class="flex items-center gap-4 bg-white px-4 py-3 rounded-lg border border-gray-200" id="license-container-{{ $license->id }}">
                    <div class="font-mono text-sm font-bold text-text-primary tracking-widest text-gray-400 select-none">
                        ••••••••••••••••
                    </div>
                    <div class="relative group ml-auto flex items-center">
                        <button type="button" onclick="revealLicense({{ $license->id }}, this)" class="btn-primary py-1.5 px-4 text-xs whitespace-nowrap">
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
        


        @if($license->expires_at)
        <div class="mt-3 text-xs text-text-muted">
            Expira el {{ $license->expires_at->format('d/m/Y') }}
        </div>
        @endif
    </div>
    @endforeach
</div>
<div class="mt-8">{{ $licenses->links() }}</div>
@else
<div class="card p-12 text-center">
    <div class="w-20 h-20 bg-primary-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
    </div>
    <h3 class="text-xl font-bold text-text-primary mb-2">Sin licencias aún</h3>
    <p class="text-text-secondary mb-6">Tus claves de activación aparecerán aquí después de una compra.</p>
    <a href="{{ route('products.index') }}" class="btn-primary inline-flex items-center gap-2">
        Explorar Productos
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
    </a>
</div>
@endif

@push('scripts')
<script>
function revealLicense(licenseId, btn) {
    if (confirm('¿Estás seguro de que deseas revelar esta clave?')) {
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Revelando...';
        btn.disabled = true;

        fetch('{{ route("customer.licenses.reveal", ":id") }}'.replace(':id', licenseId), {
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
                    <div class="font-mono text-sm font-bold text-text-primary bg-white px-4 py-3 rounded-lg border border-gray-200 select-all flex items-center justify-between">
                        <span>${data.key}</span>
                        <button onclick="navigator.clipboard.writeText('${data.key}'); this.textContent='Copiado!'; setTimeout(()=>this.textContent='Copiar', 2000)" class="text-primary-500 hover:text-primary-600 text-xs font-semibold shrink-0 ml-4">Copiar</button>
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
