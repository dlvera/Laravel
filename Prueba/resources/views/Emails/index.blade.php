@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Mis Emails</h2>
                    <a href="{{ route('emails.create') }}" class="btn btn-primary float-right">
                        <i class="fas fa-plus"></i> Nuevo Email
                    </a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Destinatario</th>
                                    <th>Asunto</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($emails as $email)
                                    <tr>
                                        <td>{{ $email->recipient_email }}</td>
                                        <td>{{ Str::limit($email->subject, 50) }}</td>
                                        <td>
                                            <span class="badge badge-{{ $email->status == 'sent' ? 'success' : 'secondary' }}">
                                                {{ $email->status == 'sent' ? 'Enviado' : 'Borrador' }}
                                            </span>
                                        </td>
                                        <td>{{ $email->created_at->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('emails.show', $email) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <form action="{{ route('emails.destroy', $email) }}" method="POST" class="d-inline">
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
                                        <td colspan="5" class="text-center">No hay emails para mostrar.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-center">
                        {{ $emails->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection