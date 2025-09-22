<?php
// app/Http/Controllers/EmailController.php
namespace App\Http\Controllers;

use App\Http\Requests\StoreEmailRequest;
use App\Models\Email;
use App\Jobs\SendEmailJob;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        $query = Email::with('user');
        
        // Si no es admin, solo ver sus emails
        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        // Filtros
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('subject', 'like', "%{$search}%")
                  ->orWhere('recipient', 'like', "%{$search}%");
            });
        }

        $emails = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('emails.index', compact('emails'));
    }

    public function create()
    {
        return view('emails.create');
    }

    public function store(StoreEmailRequest $request)
    {
        $email = Email::create([
            'subject' => $request->subject,
            'recipient' => $request->recipient,
            'body' => $request->body,
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);

        // Encolar el job para enviar el email
        SendEmailJob::dispatch($email);

        return redirect()->route('emails.index')
            ->with('success', 'Email creado y encolado para envío.');
    }

    public function show(Email $email)
    {
        // Verificar permisos
        if (!auth()->user()->isAdmin() && $email->user_id !== auth()->id()) {
            abort(403);
        }

        return view('emails.show', compact('email'));
    }
}