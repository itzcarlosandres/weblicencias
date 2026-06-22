@extends('pages.customer.dashboard')

@section('title', 'Mis Referidos | TodoKeys')

@section('customer_content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-text-primary">Mis Referidos</h1>
    <p class="text-sm text-text-secondary mt-1">Invita a tus amigos y gana puntos cuando hagan su primera compra.</p>
</div>

<!-- Estadísticas de referidos -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        </div>
        <div>
            <div class="text-[11px] font-medium text-text-muted uppercase tracking-wide">Clics en tu enlace</div>
            <div class="text-2xl font-extrabold text-text-primary mt-1">{{ number_format($user->referral_clicks ?? 0) }}</div>
        </div>
    </div>
    
    <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-xl flex items-center justify-center shrink-0">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <div>
            <div class="text-[11px] font-medium text-text-muted uppercase tracking-wide">Amigos registrados</div>
            <div class="text-2xl font-extrabold text-text-primary mt-1">{{ number_format($referrals->total()) }}</div>
        </div>
    </div>
</div>

<!-- Referral Link -->
<div class="mb-8 bg-gradient-to-r from-blue-50 to-blue-100/50 rounded-2xl border border-blue-200/50 p-6">
    <div class="flex items-start gap-4">
        <div class="w-12 h-12 bg-blue-500 rounded-xl flex items-center justify-center shrink-0">
            <i class="fa-solid fa-link text-white text-xl"></i>
        </div>
        <div class="flex-1 min-w-0">
            <h4 class="text-[15px] font-bold text-blue-700">Tu Enlace de Invitación</h4>
            <p class="text-[13px] text-blue-600/70 mt-1">Comparte este enlace en tus redes sociales o envíalo directamente a tus amigos.</p>
            <div class="mt-4 flex flex-col sm:flex-row gap-2">
                <input type="text" readonly value="{{ route('register', ['ref' => $user->referral_code]) }}" class="flex-1 px-4 py-2.5 bg-white border border-blue-200 rounded-xl text-[13px] font-mono text-gray-600 focus:outline-none" onclick="this.select()">
                <button onclick="navigator.clipboard.writeText('{{ route('register', ['ref' => $user->referral_code]) }}'); alert('¡Enlace copiado al portapapeles!');" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-[13px] font-bold rounded-xl transition-colors whitespace-nowrap shadow-lg shadow-blue-600/20">
                    Copiar Enlace
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Tabla de Referidos -->
<div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h3 class="font-bold text-text-primary text-sm">Historial de Referidos</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Fecha de registro</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($referrals as $referral)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gray-100 border border-gray-200 overflow-hidden flex items-center justify-center shrink-0">
                                <img src="{{ $referral->avatar_url }}" alt="{{ $referral->name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-text-primary">{{ $referral->name }}</div>
                                <div class="text-xs text-text-muted">{{ substr($referral->email, 0, 3) }}***@{{ explode('@', $referral->email)[1] ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-text-primary">{{ $referral->created_at->format('d/m/Y') }}</div>
                        <div class="text-xs text-text-muted">{{ $referral->created_at->format('H:i') }}</div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="px-6 py-12 text-center text-gray-500">
                        <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <p class="text-sm font-medium text-gray-900">Aún no tienes referidos</p>
                        <p class="text-xs mt-1">Comparte tu enlace para empezar a ganar puntos.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($referrals->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
        {{ $referrals->links() }}
    </div>
    @endif
</div>
@endsection
