<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\EmailAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $emails = Email::where('user_id', auth()->id())
            ->with('attachments')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('emails.index', compact('emails'));
    }

    public function create()
    {
        return view('emails.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'recipient_email' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'attachments.*' => 'file|max:10240', // Máximo 10MB por archivo
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Crear el email
        $email = Email::create([
            'user_id' => auth()->id(),
            'recipient_email' => $request->recipient_email,
            'subject' => $request->subject,
            'body' => $request->body,
            'status' => $request->has('save_draft') ? 'draft' : 'sent',
            'sent_at' => $request->has('save_draft') ? null : now(),
        ]);

        // Guardar archivos adjuntos
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('email_attachments/' . $email->id, 'local');

                EmailAttachment::create([
                    'email_id' => $email->id,
                    'original_name' => $file->getClientOriginalName(),
                    'storage_path' => $path,
                    'mime_type' => $file->getClientMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        }

        $message = $request->has('save_draft') 
            ? 'Email guardado como borrador correctamente.' 
            : 'Email enviado correctamente.';

        return redirect()->route('emails.index')->with('success', $message);
    }

    public function show(Email $email)
    {
        // Verificar que el usuario puede ver este email
        if ($email->user_id !== auth()->id()) {
            abort(403, 'No autorizado.');
        }

        $email->load('attachments');

        return view('emails.show', compact('email'));
    }

    public function destroy(Email $email)
    {
        // Verificar que el usuario puede eliminar este email
        if ($email->user_id !== auth()->id()) {
            abort(403, 'No autorizado.');
        }

        // Eliminar archivos adjuntos
        foreach ($email->attachments as $attachment) {
            Storage::delete($attachment->storage_path);
            $attachment->delete();
        }

        $email->delete();

        return redirect()->route('emails.index')->with('success', 'Email eliminado correctamente.');
    }

    public function downloadAttachment(EmailAttachment $attachment)
    {
        // Verificar que el usuario puede descargar este archivo
        if ($attachment->email->user_id !== auth()->id()) {
            abort(403, 'No autorizado.');
        }

        return Storage::download($attachment->storage_path, $attachment->original_name);
    }
}