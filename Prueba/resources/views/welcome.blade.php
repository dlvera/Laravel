<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('title', 'MAILER S.A. - Sistema de Gestión')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-20 w-20 bg-blue-600 rounded-full flex items-center justify-center mb-4">
                <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-extrabold text-gray-900">
                MAILER S.A.
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                Sistema de gestión de usuarios y envío de emails
            </p>
        </div>
        
        <div class="mt-8 space-y-4">
            @guest
                <!-- Botón de Login para usuarios no autenticados -->
                <a href="{{ route('login') }}" 
                   class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </span>
                    Iniciar Sesión en el Sistema
                </a>
                
                <!-- Información adicional -->
                <div class="bg-blue-50 p-4 rounded-lg">
                    <p class="text-sm text-blue-700 text-center">
                        <strong>Credenciales de prueba:</strong><br>
                        Admin: admin@mailer.com / Admin123!<br>
                        Usuario: user@mailer.com / User123!
                    </p>
                </div>
            @else
                <!-- Botones para usuarios autenticados -->
                <div class="space-y-3">
                    <a href="{{ route('dashboard') }}" 
                       class="w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 transition duration-200">
                        Ir al Dashboard Principal
                    </a>
                    
                    <div class="text-center">
                        <p class="text-sm text-gray-600">
                            Has iniciado sesión como: <strong>{{ auth()->user()->name }}</strong><br>
                            Rol: <span class="capitalize">{{ auth()->user()->role }}</span>
                        </p>
                    </div>
                </div>
            @endguest
        </div>
        
        <!-- Información del sistema -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <div class="grid grid-cols-2 gap-4 text-center">
                <div>
                    <p class="text-lg font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                    <p class="text-sm text-gray-600">Usuarios</p>
                </div>
                <div>
                    <p class="text-lg font-bold text-gray-900">{{ \App\Models\Email::count() }}</p>
                    <p class="text-sm text-gray-600">Emails</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection