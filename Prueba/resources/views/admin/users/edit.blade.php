@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Editar Usuario: {{ $user->name }}</h1>
        <a href="{{ route('admin.users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">
            ← Volver
        </a>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong>Errores encontrados:</strong>
            <ul class="mt-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-6 rounded-lg shadow">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Columna izquierda -->
                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nombre *</label>
                        <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 @error('name') border-red-500 @enderror">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" value="{{ $user->email }}" readonly
                               class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
                        <small class="text-gray-500">El email no se puede modificar</small>
                        <!-- 🔥 ENVIAR EMAIL COMO HIDDEN -->
                        <input type="hidden" name="email" value="{{ $user->email }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Cédula</label>
                        <input type="text" value="{{ $user->cedula }}" readonly
                               class="mt-1 block w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">
                        <small class="text-gray-500">La cédula no se puede modificar</small>
                        <!-- 🔥 ENVIAR CÉDULA COMO HIDDEN -->
                        <input type="hidden" name="cedula" value="{{ $user->cedula }}">
                    </div>
                </div>

                <!-- Columna derecha -->
                <div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Fecha de Nacimiento *</label>
                        <input type="date" name="birth_date" 
                               value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}" 
                               required
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 @error('birth_date') border-red-500 @enderror">
                        @error('birth_date')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nueva Contraseña (opcional)</label>
                        <input type="password" name="password" 
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 @error('password') border-red-500 @enderror"
                               placeholder="Dejar en blanco para no cambiar">
                        @error('password')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Confirmar Contraseña</label>
                        <input type="password" name="password_confirmation" 
                               class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2"
                               placeholder="Repetir nueva contraseña">
                    </div>
                </div>
            </div>

            <!-- Selects de ubicación -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">País *</label>
                    <select name="country_id" required 
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 @error('country_id') border-red-500 @enderror">
                        <option value="">Seleccionar país</option>
                        @foreach($countries as $country)
                            <option value="{{ $country->id }}" 
                                {{ old('country_id', $user->city->state->country_id ?? '') == $country->id ? 'selected' : '' }}>
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('country_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Estado *</label>
                    <select name="state_id" required 
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 @error('state_id') border-red-500 @enderror">
                        <option value="">Seleccionar estado</option>
                        @foreach($states as $state)
                            <option value="{{ $state->id }}" 
                                {{ old('state_id', $user->city->state_id ?? '') == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('state_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Ciudad *</label>
                    <select name="city_id" required 
                            class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 @error('city_id') border-red-500 @enderror">
                        <option value="">Seleccionar ciudad</option>
                        @foreach($cities as $city)
                            <option value="{{ $city->id }}" 
                                {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Actualizar Usuario</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.querySelector('select[name="country_id"]');
    const stateSelect = document.querySelector('select[name="state_id"]');
    const citySelect = document.querySelector('select[name="city_id"]');

    // Cargar estados cuando cambia el país
    countrySelect.addEventListener('change', function() {
        const countryId = this.value;
        stateSelect.innerHTML = '<option value="">Seleccione un estado</option>';
        citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
        
        if (countryId) {
            fetch(`/admin/users/ajax/states?country_id=${countryId}`)
                .then(response => response.json())
                .then(states => {
                    states.forEach(state => {
                        const option = new Option(state.name, state.id);
                        stateSelect.add(option);
                    });
                });
        }
    });

    // Cargar ciudades cuando cambia el estado
    stateSelect.addEventListener('change', function() {
        const stateId = this.value;
        citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
        
        if (stateId) {
            fetch(`/admin/users/ajax/cities/${stateId}`)
                .then(response => response.json())
                .then(cities => {
                    cities.forEach(city => {
                        const option = new Option(city.name, city.id);
                        citySelect.add(option);
                    });
                });
        }
    });
});
</script>
@endpush
@endsection