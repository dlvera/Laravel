@extends('layouts.app')

@section('title', 'Editar Usuario')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Editar Usuario: {{ $user->name }}</h1>
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Volver
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="cedula" class="form-label">Cédula</label>
                        <input type="text" class="form-control bg-light" value="{{ $user->cedula }}" readonly>
                        <small class="form-text text-muted">La cédula no se puede modificar</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                        <small class="form-text text-muted">El email no se puede modificar</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="phone" class="form-label">Teléfono</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                        @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="country_id" class="form-label">País *</label>
                        <select class="form-control @error('country_id') is-invalid @enderror" 
                                id="country_id" name="country_id" required>
                            <option value="">Seleccione un país</option>
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}" 
                                    {{ old('country_id', $user->country_id) == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="state_id" class="form-label">Estado/Provincia *</label>
                        <select class="form-control @error('state_id') is-invalid @enderror" 
                                id="state_id" name="state_id" required>
                            <option value="">Seleccione un estado</option>
                            @if(isset($states) && $states->count() > 0)
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}" 
                                        {{ old('state_id', $user->state_id) == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('state_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="mb-3">
                        <label for="city_id" class="form-label">Ciudad *</label>
                        <select class="form-control @error('city_id') is-invalid @enderror" 
                                id="city_id" name="city_id" required>
                            <option value="">Seleccione una ciudad</option>
                            @if(isset($cities) && $cities->count() > 0)
                                @foreach($cities as $city)
                                    <option value="{{ $city->id }}" 
                                        {{ old('city_id', $user->city_id) == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                        @error('city_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password" class="form-label">Nueva Contraseña (opcional)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                            {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Usuario Activo</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_admin" name="is_admin" value="1" 
                            {{ old('is_admin', $user->is_admin) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_admin">Usuario Administrador</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <button type="submit" class="btn btn-primary">Actualizar Usuario</button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const countrySelect = document.getElementById('country_id');
    const stateSelect = document.getElementById('state_id');
    const citySelect = document.getElementById('city_id');

    // Usar URLs de Laravel
    const baseUrl = "{{ url('/') }}";

    // Cargar estados cuando cambia el país
    countrySelect.addEventListener('change', function() {
        const countryId = this.value;
        stateSelect.innerHTML = '<option value="">Seleccione un estado</option>';
        citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
        
        if (countryId) {
            fetch(`${baseUrl}/admin/users/ajax/states?country_id=${countryId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la petición');
                    }
                    return response.json();
                })
                .then(states => {
                    if (states.length > 0) {
                        states.forEach(state => {
                            const option = new Option(state.name, state.id);
                            stateSelect.add(option);
                        });
                        
                        // Si hay un estado seleccionado previamente, seleccionarlo
                        const selectedStateId = "{{ old('state_id', $user->state_id) }}";
                        if (selectedStateId && countryId == "{{ old('country_id', $user->country_id) }}") {
                            stateSelect.value = selectedStateId;
                            // Disparar change event para cargar ciudades
                            stateSelect.dispatchEvent(new Event('change'));
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading states:', error);
                    stateSelect.innerHTML = '<option value="">Error cargando estados</option>';
                });
        }
    });

    // Cargar ciudades cuando cambia el estado
    stateSelect.addEventListener('change', function() {
        const stateId = this.value;
        citySelect.innerHTML = '<option value="">Seleccione una ciudad</option>';
        
        if (stateId) {
            fetch(`${baseUrl}/admin/users/ajax/cities/${stateId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Error en la petición');
                    }
                    return response.json();
                })
                .then(cities => {
                    if (cities.length > 0) {
                        cities.forEach(city => {
                            const option = new Option(city.name, city.id);
                            citySelect.add(option);
                        });
                        
                        // Si hay una ciudad seleccionada previamente, seleccionarla
                        const selectedCityId = "{{ old('city_id', $user->city_id) }}";
                        if (selectedCityId && stateId == "{{ old('state_id', $user->state_id) }}") {
                            citySelect.value = selectedCityId;
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    citySelect.innerHTML = '<option value="">Error cargando ciudades</option>';
                });
        }
    });

    // Si hay un país seleccionado, cargar sus estados al iniciar
    const selectedCountryId = countrySelect.value;
    if (selectedCountryId) {
        countrySelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endpush
@endsection