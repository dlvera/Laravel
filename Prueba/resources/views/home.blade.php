@extends('layouts.app')

@section('header')
    <h2 class="text-3xl font-bold text-gray-800">Dashboard</h2>
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold text-gray-900">Welcome to {{ config('app.name') }}</h2>
                </div>
            </div>
        </div>
    </div>
@endsection