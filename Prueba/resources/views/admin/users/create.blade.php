<!-- resources/views/admin/users/create.blade.php -->
@extends('layouts.app')

@section('title', 'Crear Usuario')

@section('content')
<div class="py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Crear Nuevo Usuario</h1>

    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Información básica -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Información Básica</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre *</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email *</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Cédula *</label>
                        <input type="text" name="cedula" value="{{ old('cedula') }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>

                <!-- Información adicional -->
                <div>
                    <h3 class="text-lg font-semibold mb-4">Información Adicional</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Contraseña *</label>
                        <input type="password" name="password" required
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Confirmar Contraseña *</label>
                        <input type="password" name="password_confirmation" required
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="phone" value="{{ old('phone') }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Fecha de Nacimiento *</label>
                        <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>
                </div>
            </div>

            <!-- Selects de ubicación (simplificado por ahora) -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Ciudad *</label>
                <select name="city_id" required class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2">
                    <option value="">Seleccionar ciudad</option>
                    @foreach(\App\Models\City::all() as $city)
                        <option value="{{ $city->id }}">{{ $city->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Crear Usuario</button>
            </div>
        </form>
    </div>
</div>
@endsection