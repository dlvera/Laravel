@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Dashboard - {{ Auth::user()->is_admin ? 'Administrador' : 'Usuario' }}</h2>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <!-- Tarjeta de Perfil -->
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Mi Perfil</h5>
                                    <p class="card-text">Ver y gestionar mi información personal</p>
                                    <a href="{{ route('profile') }}" class="btn btn-primary">
                                        <i class="fas fa-user"></i> Ver Perfil
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tarjeta de Emails -->
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Emails</h5>
                                    <p class="card-text">Gestionar emails enviados y borradores</p>
                                    <a href="{{ route('emails.index') }}" class="btn btn-success">
                                        <i class="fas fa-envelope"></i> Gestionar Emails
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tarjeta Específica según tipo de usuario -->
                        @if(Auth::user()->is_admin)
                        <!-- Panel de Administración para admins -->
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Administración</h5>
                                    <p class="card-text">Gestionar usuarios del sistema</p>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-warning">
                                        <i class="fas fa-cog"></i> Panel Admin
                                    </a>
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- Cerrar Sesión para usuarios normales -->
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Cerrar Sesión</h5>
                                    <p class="card-text">Salir de manera segura del sistema</p>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Resumen de actividad específico por tipo de usuario -->
                    <div class="mt-4">
                        <h4>Resumen de Actividad</h4>
                        <div class="row">
                            @if(Auth::user()->is_admin)
                            <!-- Resumen para administradores -->
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <strong>Total de Usuarios:</strong> 
                                    {{ App\Models\User::count() }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-warning">
                                    <strong>Usuarios Activos:</strong> 
                                    {{ App\Models\User::where('is_active', true)->count() }}
                                </div>
                            </div>
                            @else
                            <!-- Resumen para usuarios normales -->
                            <div class="col-md-6">
                                <div class="alert alert-info">
                                    <strong>Emails Enviados:</strong> 
                                    {{ Auth::user()->sentEmails()->where('status', 'sent')->count() }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="alert alert-warning">
                                    <strong>Borradores:</strong> 
                                    {{ Auth::user()->sentEmails()->where('status', 'draft')->count() }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection