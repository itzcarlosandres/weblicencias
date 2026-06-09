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
