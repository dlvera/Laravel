@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-2xl font-semibold mb-6">Editar Usuario</h2>

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <!-- Cédula (solo lectura) -->
            <div>
                <label for="cedula" class="block text-gray-700 font-medium mb-2">Cédula</label>
                <input type="text" id="cedula" name="cedula" value="{{ old('cedula', $user->cedula) }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-100" 
                    readonly>
                @error('cedula')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email (solo lectura) -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-gray-100" 
                    readonly>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nombre -->
            <div>
                <label for="name" class="block text-gray-700 font-medium mb-2">Nombre</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label for="phone" class="block text-gray-700 font-medium mb-2">Teléfono</label>
                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- País -->
            <div>
                <label for="country_id" class="block text-gray-700 font-medium mb-2">País</label>
                <select id="country_id" name="country_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Seleccione un país</option>
                    @foreach($countries as $country)
                        <option value="{{ $country->id }}" 
                            {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>
                            {{ $country->name }}
                        </option>
                    @endforeach
                </select>
                @error('country_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estado -->
            <div>
                <label for="state_id" class="block text-gray-700 font-medium mb-2">Estado/Provincia</label>
                <select id="state_id" name="state_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Seleccione un estado</option>
                    @if($user->state_id)
                        <option value="{{ $user->state_id }}" selected>{{ $user->state->name }}</option>
                    @endif
                </select>
                @error('state_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Ciudad -->
            <div>
                <label for="city_id" class="block text-gray-700 font-medium mb-2">Ciudad</label>
                <select id="city_id" name="city_id" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Seleccione una ciudad</option>
                    @if($user->city_id)
                        <option value="{{ $user->city_id }}" selected>{{ $user->city->name }}</option>
                    @endif
                </select>
                @error('city_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nueva Contraseña (opcional) -->
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-2">Nueva Contraseña (opcional)</label>
                <input type="password" id="password" name="password" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirmar Contraseña -->
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirmar Contraseña</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                Actualizar Usuario
            </button>
        </div>
    </form>
</div>

<!-- Script para los dropdowns dependientes -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Cargar estados cuando se selecciona un país
        document.getElementById('country_id').addEventListener('change', function() {
            const countryId = this.value;
            const stateSelect = document.getElementById('state_id');
            
            stateSelect.innerHTML = '<option value="">Seleccione un estado</option>';
            document.getElementById('city_id').innerHTML = '<option value="">Seleccione una ciudad</option>';
            
            if (countryId) {
                fetch(`/admin/users/states?country_id=${countryId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(state => {
                            const option = document.createElement('option');
                            option.value = state.id;
                            option.textContent = state.name;
                            stateSelect.appendChild(option);
                        });
                    });
            }
        });

        // Cargar ciudades cuando se selecciona un estado
        document.getElementById('state_id').addEventListener('change', function() {
            const stateId = this.value;
            const citySelect = document.getElementById('city_id');
            
            citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
            
            if (stateId) {
                fetch(`/admin/users/cities?state_id=${stateId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(city => {
                            const option = document.createElement('option');
                            option.value = city.id;
                            option.textContent = city.name;
                            citySelect.appendChild(option);
                        });
                    });
            }
        });

        // Disparar el evento change si ya hay un país seleccionado
        const countrySelect = document.getElementById('country_id');
        if (countrySelect.value) {
            countrySelect.dispatchEvent(new Event('change'));
            
            // Una vez cargados los estados, seleccionar el estado actual del usuario
            setTimeout(() => {
                const stateSelect = document.getElementById('state_id');
                if (stateSelect && '{{ $user->state_id }}') {
                    stateSelect.value = '{{ $user->state_id }}';
                    stateSelect.dispatchEvent(new Event('change'));
                    
                    // Una vez cargadas las ciudades, seleccionar la ciudad actual del usuario
                    setTimeout(() => {
                        const citySelect = document.getElementById('city_id');
                        if (citySelect && '{{ $user->city_id }}') {
                            citySelect.value = '{{ $user->city_id }}';
                        }
                    }, 500);
                }
            }, 500);
        }
    });
</script>
@endsection