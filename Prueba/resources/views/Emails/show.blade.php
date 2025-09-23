@extends('layouts.app')

@section('title', 'Ver Email')

@section('content')
<div class="py-6">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-900">{{ $email->subject }}</h1>
            <div class="mt-2 flex justify-between items-center">
                <div>
                    <span class="text-sm text-gray-600">Para: {{ $email->recipient }}</span>
                    <span class="mx-2">•</span>
                    <span class="text-sm text-gray-600">Fecha: {{ $email->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <span class="px-3 py-1 text-xs rounded-full 
                    {{ $email->status === 'sent' ? 'bg-green-100 text-green-800' : 
                       ($email->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                       ($email->status === 'sending' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                    {{ $email->status === 'sent' ? 'Enviado' : 
                       ($email->status === 'pending' ? 'Pendiente' : 
                       ($email->status === 'sending' ? 'Enviando' : 'Fallido')) }}
                </span>
            </div>
        </div>

        <div class="p-6">
            <div class="prose max-w-none">
                {!! nl2br(e($email->body)) !!}
            </div>
        </div>

        <div class="p-6 border-t border-gray-200 flex justify-between">
            <a href="{{ route('emails.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700">
                Volver a la lista
            </a>
            
            @if(auth()->user()->isAdmin() && $email->user)
            <div class="text-sm text-gray-600">
                Creado por: {{ $email->user->name }} ({{ $email->user->email }})
            </div>
            @endif
        </div>
    </div>
</div>
@endsection