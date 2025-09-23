<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MAILER S.A.')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100">
    <!-- Navigation -->
    @auth
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <div class="flex items-center space-x-8">
                    <a href="{{ url('/') }}" class="text-xl font-bold">MAILER S.A.</a>
                    
                    <div class="flex items-center space-x-4">
                        <span class="text-sm bg-blue-500 px-2 py-1 rounded">Hola, {{ auth()->user()->name }}</span>
                        
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hover:bg-blue-700 px-3 py-2 rounded transition duration-200">
                                Dashboard Admin
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded transition duration-200">
                                Gestionar Usuarios
                            </a>
                        @endif
                        
                        <a href="{{ route('emails.index') }}" class="hover:bg-blue-700 px-3 py-2 rounded transition duration-200">
                            Emails
                        </a>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ url('/') }}" class="hover:bg-blue-700 px-3 py-2 rounded transition duration-200">
                        Inicio
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="hover:bg-blue-700 px-3 py-2 rounded transition duration-200">
                            Cerrar Sesión
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Main Content -->
    <main class="{{ auth()->check() ? 'py-8' : '' }}">
        <div class="{{ auth()->check() ? 'max-w-7xl mx-auto px-4 sm:px-6 lg:px-8' : '' }}">
            <!-- Mensajes de sesión -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Content -->
            @yield('content')
        </div>
    </main>
</body>
</html>