@extends('layouts.app')

@section('title', 'Registrarse | TodoKeys')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-6">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-400 to-primary-600 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                    </svg>
                </div>
                <span class="text-2xl font-bold bg-gradient-to-r from-primary-500 to-primary-700 bg-clip-text text-transparent">TodoKeys</span>
            </a>
            <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark">Crear Cuenta</h1>
            <p class="text-text-secondary mt-2">Regístrate para comenzar a comprar</p>
        </div>

        <div class="card p-8">
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-text-secondary mb-1">Nombre</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus class="input-field" placeholder="Tu nombre">
                        @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-secondary mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="input-field" placeholder="tu@email.com">
                        @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-secondary mb-1">Contraseña</label>
                        <input type="password" name="password" required class="input-field" placeholder="••••••••">
                        @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-text-secondary mb-1">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" required class="input-field" placeholder="••••••••">
                    </div>
                    <div class="flex items-start gap-2">
                        <input type="checkbox" name="terms" required class="w-4 h-4 text-primary-500 rounded border-gray-300 focus:ring-primary-400 mt-0.5">
                        <span class="text-sm text-text-secondary">Acepto los <a href="#" class="text-primary-500 hover:text-primary-600">Términos de Servicio</a> y la <a href="#" class="text-primary-500 hover:text-primary-600">Política de Privacidad</a></span>
                    </div>
                    <button type="submit" class="w-full btn-primary text-center">Crear Cuenta</button>
                </div>
            </form>

            <div class="mt-8 relative z-10">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-xs">
                        <span class="bg-white px-4 text-gray-400 uppercase tracking-widest font-bold">o continuar con</span>
                    </div>
                </div>

                <div class="mt-6">
                    <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-2 w-full px-4 py-2.5 border border-gray-200 rounded-xl bg-white hover:bg-gray-50 text-sm font-bold text-gray-700 transition-colors">
                        <svg class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Google
                    </a>
                </div>
            </div>

            <div class="mt-6 text-center">
                <p class="text-sm text-text-secondary">
                    ¿Ya tienes cuenta?
                    <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-medium">Inicia sesión</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
