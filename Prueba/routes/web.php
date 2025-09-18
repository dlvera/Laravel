<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas protegidas
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Perfil de usuario
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // Gestión de emails
    Route::resource('emails', EmailController::class)->except(['edit', 'update']);
    Route::get('emails/{email}/download/{attachment}', [EmailController::class, 'downloadAttachment'])
        ->name('emails.attachment.download');
});