<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Asumimos que el administrador es el usuario con email 'admin@mailersa.com'
        if (Auth::check() && Auth::user()->email === 'admin@mailersa.com') {
            return $next($request);
        }

        abort(403, 'No autorizado.');
    }
}