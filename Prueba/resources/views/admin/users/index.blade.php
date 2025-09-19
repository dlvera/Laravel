@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h2>Gestión de Usuarios</h2>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary float-end">
            <i class="fas fa-plus me-1"></i>Nuevo Usuario
        </a>
    </div>

    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Filtros -->
        <div class="row mb-3">
            <div class="col-md-6">
                <form method="GET" action="{{ route('admin.users.index') }}">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Buscar por nombre, cédula, email o celular" value="{{ $search }}">
                        <button type="submit" class="btn btn-outline-secondary">Buscar</button>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <form method="GET" action="{{ route('admin.users.index') }}" class="form-inline">
                    <input type="hidden" name="search" value="{{ $search }}">
                    <input type="hidden" name="sort_field" value="{{ $sortField }}">
                    <input type="hidden" name="sort_direction" value="{{ $sortDirection }}">
                    <label for="per_page" class="me-2">Registros por página:</label>
                    <select name="per_page" id="per_page" class="form-select d-inline-block w-auto" onchange="this.form.submit()">
                        <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                        <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                    </select>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        @php
                            $sortableFields = [
                                'identifier' => 'Identificador',
                                'name' => 'Nombre',
                                'email' => 'Email',
                                'cedula' => 'Cédula',
                                'phone' => 'Teléfono',
                                'birth_date' => 'Fecha Nac.',
                                'age' => 'Edad',
                                'city.name' => 'Ciudad'
                            ];
                        @endphp
                        @foreach($sortableFields as $field => $label)
                            <th>
                                <a href="{{ route('admin.users.index', [
                                    'search' => $search,
                                    'per_page' => $perPage,
                                    'sort_field' => $field,
                                    'sort_direction' => $sortField == $field && $sortDirection == 'asc' ? 'desc' : 'asc'
                                ]) }}">
                                    {{ $label }}
                                    @if($sortField == $field)
                                        <i class="fas fa-sort-{{ $sortDirection == 'asc' ? 'up' : 'down' }}"></i>
                                    @else
                                        <i class="fas fa-sort"></i>
                                    @endif
                                </a>
                            </th>
                        @endforeach
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->identifier }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->cedula }}</td>
                            <td>{{ $user->phone ?? 'N/A' }}</td>
                            <td>{{ $user->birth_date ? $user->birth_date->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $user->birth_date ? $user->birth_date->age . ' años' : 'N/A' }}</td>
                            <td>{{ $user->city->name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay usuarios para mostrar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $users->appends([
                'search' => $search,
                'per_page' => $perPage,
                'sort_field' => $sortField,
                'sort_direction' => $sortDirection
            ])->links() }}
        </div>
    </div>
</div>
@endsection

