<?php
// app/Http/Controllers/EmailController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email;

class EmailController extends Controller
{
    public function index()
    {
        $emails = Email::where('user_id', auth()->id())
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
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'recipient' => 'required|email',
            'body' => 'required|string',
        ]);

        Email::create([
            'subject' => $validated['subject'],
            'recipient' => $validated['recipient'],
            'body' => $validated['body'],
            'user_id' => auth()->id(),
            'status' => 'pending'
        ]);

        return redirect()->route('emails.index')->with('success', 'Email creado exitosamente.');
    }

    public function show(Email $email)
    {
        // Verificar que el usuario puede ver este email
        if ($email->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403, 'Acceso denegado.');
        }

        return view('emails.show', compact('email'));
    }
}