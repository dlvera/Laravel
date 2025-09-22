<!-- resources/views/emails/create.blade.php -->
@extends('layouts.app')

@section('title', 'Crear Nuevo Email')

@section('content')
<div class="py-6">
    <h1 class="text-3xl font-bold text-gray-900 mb-6">Crear Nuevo Email</h1>

    <div class="bg-white p-6 rounded-lg shadow max-w-2xl mx-auto">
        <form action="{{ route('emails.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Asunto *</label>
                <input type="text" name="subject" value="{{ old('subject') }}" required
                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Destinatario *</label>
                <input type="email" name="recipient" value="{{ old('recipient') }}" required
                       class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                       placeholder="ejemplo@correo.com">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Mensaje *</label>
                <textarea name="body" rows="6" required
                          class="mt-1 block w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-blue-500 focus:border-blue-500">{{ old('body') }}</textarea>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('emails.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                    Cancelar
                </a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Enviar Email
                </button>
            </div>
        </form>
    </div>
</div>
@endsection