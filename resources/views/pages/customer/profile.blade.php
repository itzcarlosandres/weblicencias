@extends('pages.customer.dashboard')

@section('title', 'Mi Perfil | TodoKeys')

@section('customer_content')
<div class="mb-8">
    <h1 class="text-2xl font-extrabold text-text-primary">Mi Perfil</h1>
    <p class="text-sm text-text-secondary mt-1">Administra la información de tu cuenta, tu foto de perfil y tu contraseña</p>
</div>

<form action="{{ route('customer.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    @if($errors->any())
    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700 text-sm space-y-1">
        @foreach($errors->all() as $error)
            <div><i class="fa-solid fa-triangle-exclamation mr-1.5"></i> {{ $error }}</div>
        @endforeach
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Columna Izquierda: Foto de Perfil -->
        <div class="bg-white rounded-2xl border border-gray-100 p-6 flex flex-col items-center justify-center text-center">
            <h3 class="text-sm font-bold text-gray-800 mb-6 w-full text-left">Foto de Perfil</h3>
            
            <div class="relative group" x-data="{ avatarPreview: '{{ $user->avatar_url }}' }">
                <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-gray-50 shadow-md bg-gray-50 flex items-center justify-center">
                    <img :src="avatarPreview" alt="{{ $user->name }}" class="w-full h-full object-cover">
                </div>
                <label class="absolute inset-0 bg-black/50 rounded-full flex items-center justify-center text-white text-xs font-bold opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                    <i class="fa-solid fa-camera text-lg mb-1.5 block"></i>
                    <span class="absolute bottom-4">Cambiar</span>
                    <input type="file" name="avatar" class="hidden" accept="image/*" @change="
                        const file = $event.target.files[0];
                        if (file) {
                            avatarPreview = URL.createObjectURL(file);
                        }
                    ">
                </label>
            </div>
            
            <p class="text-[11px] text-gray-400 mt-4 leading-normal max-w-[200px]">
                Formatos soportados: JPG, PNG o WEBP. Máximo 2MB.
            </p>
        </div>

        <!-- Columna Derecha: Información Personal -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-5">Información Personal</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nombre Completo *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 rounded-xl text-sm text-gray-800 transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Teléfono</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 rounded-xl text-sm text-gray-800 transition-all" placeholder="Ej: +57 300 123 4567">
                    </div>
                    
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Correo Electrónico *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 rounded-xl text-sm text-gray-800 transition-all">
                        @if($user->google_id)
                            <p class="text-[10px] text-emerald-600 font-semibold mt-1.5 flex items-center gap-1">
                                <i class="fa-brands fa-google"></i> Cuenta vinculada e iniciada con Google
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Seguridad / Contraseña -->
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="text-sm font-bold text-gray-800 mb-2">Seguridad</h3>
                <p class="text-xs text-gray-400 mb-5">Completa estos campos únicamente si deseas cambiar tu contraseña actual.</p>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @if($user->password)
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Contraseña Actual</label>
                        <input type="password" name="current_password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 rounded-xl text-sm text-gray-800 transition-all">
                    </div>
                    @endif
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Nueva Contraseña</label>
                        <input type="password" name="new_password" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 rounded-xl text-sm text-gray-800 transition-all">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5">Confirmar Nueva Contraseña</label>
                        <input type="password" name="new_password_confirmation" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 focus:outline-none focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 rounded-xl text-sm text-gray-800 transition-all">
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-end gap-3">
                <a href="{{ route('customer.dashboard') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-bold rounded-xl transition-all">
                    Cancelar
                </a>
                <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl shadow-lg shadow-blue-600/20 hover:shadow-blue-600/30 transition-all">
                    Guardar Cambios
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
