<?php
// app/Http/Controllers/EmailController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;
use App\Http\Requests\StoreEmailRequest;
use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
    public function index()
    {
        // Si es admin, ver todos los emails, si no, solo los suyos
        if (auth()->user()->isAdmin()) {
            $emails = Email::with('user')->orderBy('created_at', 'desc')->paginate(10);
        } else {
            $emails = Email::where('user_id', auth()->id())
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);
        }
        
        return view('emails.index', compact('emails'));
    }

    public function create()
    {
        return view('emails.create');
    }

    public function store(StoreEmailRequest $request)
    {
        try {
            $email = Email::create([
                'subject' => $request->subject,
                'recipient' => $request->recipient,
                'body' => $request->body,
                'user_id' => auth()->id(),
                'status' => Email::STATUS_PENDING
            ]);

            // Despachar job para enviar email
            SendEmailJob::dispatch($email);

            return redirect()->route('emails.index')
                ->with('success', 'Email creado exitosamente y encolado para envío.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al crear el email: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Email $email)
    {
        // Verificar permisos - corrección de la condición
        if ($email->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'No tienes permisos para ver este email.');
        }

        return view('emails.show', compact('email'));
    }
}