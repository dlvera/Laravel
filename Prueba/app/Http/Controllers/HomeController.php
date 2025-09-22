<?php
// app/Http/Controllers/HomeController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Email;

class HomeController extends Controller
{
    public function index()
    {
        // Si el usuario está autenticado, redirigir según su rol
        if (auth()->check()) {
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('emails.index');
            }
        }
        
        // Si no está autenticado, mostrar página de bienvenida
        return view('welcome');
    }

    public function adminDashboard()
    {
        // Verificar que el usuario es admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            return redirect()->route('login')->with('error', 'Acceso denegado.');
        }

        $stats = [
            'usersCount' => User::count(),
            'emailsCount' => Email::count(),
            'pendingEmails' => Email::where('status', 'pending')->count(),
            'sentEmails' => Email::where('status', 'sent')->count(),
        ];

        return view('admin.dashboard', $stats);
    }
}