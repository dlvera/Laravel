@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Gestión de Usuarios</h1>
        <a href="{{ route('users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Crear Usuario
        </a>
    </div>

    <div class="bg-white shadow-md rounded my-6">
        <table class="min-w-full table-auto" id="users-table">
            <thead>
                <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                    <th class="py-3 px-6 text-left">ID</th>
                    <th class="py-3 px-6 text-left">Nombre</th>
                    <th class="py-3 px-6 text-left">Email</th>
                    <th class="py-3 px-6 text-left">Cédula</th>
                    <th class="py-3 px-6 text-left">Teléfono</th>
                    <th class="py-3 px-6 text-left">Edad</th>
                    <th class="py-3 px-6 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                <!-- Los datos se cargarán mediante DataTables -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('users.index') }}",
        columns: [
            { data: 'identifier', name: 'identifier' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'document', name: 'document' },
            { data: 'phone', name: 'phone' },
            { data: 'age', name: 'age', orderable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
        }
    });
});
</script>
@endpush