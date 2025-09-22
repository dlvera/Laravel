<!-- resources/views/emails/index.blade.php -->
@extends('layouts.app')

@section('title', 'Mis Emails')

@section('content')
<div class="py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Mis Emails</h1>
        <a href="{{ route('emails.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Nuevo Email
        </a>
    </div>

    @if($emails->count() > 0)
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asunto</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destinatario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($emails as $email)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $email->subject }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $email->recipient }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full 
                            {{ $email->status === 'sent' ? 'bg-green-100 text-green-800' : 
                               ($email->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ $email->status === 'sent' ? 'Enviado' : 
                               ($email->status === 'pending' ? 'Pendiente' : 'Fallido') }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $email->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="{{ route('emails.show', $email) }}" class="text-blue-600 hover:text-blue-900">Ver</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $emails->links() }}
    </div>
    @else
    <div class="bg-white p-8 rounded-lg shadow text-center">
        <p class="text-gray-600">No has creado ningún email todavía.</p>
        <a href="{{ route('emails.create') }}" class="inline-block mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
            Crear mi primer email
        </a>
    </div>
    @endif
</div>
@endsection