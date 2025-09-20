@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Crear Nuevo Usuario</h2>
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}" id="userForm">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="identifier">Identificador *</label>
                        <input type="number" class="form-control @error('identifier') is-invalid @enderror" 
                               id="identifier" name="identifier" value="{{ old('identifier') }}" required>
                        @error('identifier')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nombre *</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" required maxlength="100">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cedula">Cédula *</label>
                        <input type="text" class="form-control @error('cedula') is-invalid @enderror" 
                               id="cedula" name="cedula" value="{{ old('cedula') }}" required maxlength="11">
                        @error('cedula')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Contraseña *</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password" required>
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <small class="form-text text-muted">
                            Mínimo 8 caracteres, al menos una mayúscula, un número y un carácter especial.
                        </small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password_confirmation">Confirmar Contraseña *</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="phone">Número Celular</label>
                        <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                               id="phone" name="phone" value="{{ old('phone') }}" maxlength="10">
                        @error('phone')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="birth_date">Fecha de Nacimiento *</label>
                        <input type="date" class="form-control @error('birth_date') is-invalid @enderror" 
                               id="birth_date" name="birth_date" value="{{ old('birth_date') }}" required>
                        @error('birth_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="country_id">País *</label>
                        <select class="form-control @error('country_id') is-invalid @enderror" 
                                id="country_id" name="country_id" required>
                            <option value="">Seleccione un país</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('country_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="state_id">Estado *</label>
                        <select class="form-control @error('state_id') is-invalid @enderror" 
                                id="state_id" name="state_id" required disabled>
                            <option value="">Seleccione un estado</option>
                        </select>
                        @error('state_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="city_id">Ciudad *</label>
                        <select class="form-control @error('city_id') is-invalid @enderror" 
                                id="city_id" name="city_id" required disabled>
                            <option value="">Seleccione una ciudad</option>
                        </select>
                        @error('city_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form-group mb-0 mt-3">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-link">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function() {
        // Cargar estados cuando se seleccione un país
        $('#country_id').change(function() {
            var countryId = $(this).val();
            if (countryId) {
                $('#state_id').prop('disabled', false);
                $.get("{{ route('admin.users.states') }}", { country_id: countryId }, function(data) {
                    $('#state_id').empty().append('<option value="">Seleccione un estado</option>');
                    $('#city_id').empty().append('<option value="">Seleccione una ciudad</option>').prop('disabled', true);
                    $.each(data, function(key, value) {
                        $('#state_id').append('<option value="'+key+'">'+value+'</option>');
                    });
                });
            } else {
                $('#state_id').empty().append('<option value="">Seleccione un estado</option>').prop('disabled', true);
                $('#city_id').empty().append('<option value="">Seleccione una ciudad</option>').prop('disabled', true);
            }
        });

        // Cargar ciudades cuando se seleccione un estado
        $('#state_id').change(function() {
            var stateId = $(this).val();
            if (stateId) {
                $('#city_id').prop('disabled', false);
                $.get("{{ route('admin.users.cities') }}", { state_id: stateId }, function(data) {
                    $('#city_id').empty().append('<option value="">Seleccione una ciudad</option>');
                    $.each(data, function(key, value) {
                        $('#city_id').append('<option value="'+key+'">'+value+'</option>');
                    });
                });
            } else {
                $('#city_id').empty().append('<option value="">Seleccione una ciudad</option>').prop('disabled', true);
            }
        });
    });
</script>
@endsection
@endsection