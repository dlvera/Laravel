@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Enviar Nuevo Email</h2>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('emails.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="recipient_email">Destinatario</label>
                            <input type="email" class="form-control @error('recipient_email') is-invalid @enderror" 
                                id="recipient_email" name="recipient_email" value="{{ old('recipient_email') }}" required>
                            @error('recipient_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="subject">Asunto</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                id="subject" name="subject" value="{{ old('subject') }}" required>
                            @error('subject')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="body">Mensaje</label>
                            <textarea class="form-control @error('body') is-invalid @enderror" 
                                id="body" name="body" rows="10" required>{{ old('body') }}</textarea>
                            @error('body')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="attachments">Archivos Adjuntos</label>
                            <input type="file" class="form-control-file" id="attachments" name="attachments[]" multiple>
                            <small class="form-text text-muted">
                                Puede seleccionar múltiples archivos (máximo 10MB cada uno).
                            </small>
                        </div>

                        <div class="form-group mb-0">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Enviar Email
                            </button>
                            <button type="submit" name="save_draft" value="1" class="btn btn-secondary">
                                <i class="fas fa-save"></i> Guardar como Borrador
                            </button>
                            <a href="{{ route('emails.index') }}" class="btn btn-link">Cancelar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection