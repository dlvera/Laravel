<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Admin\UserController; 
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

// Rutas de administración
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // Dashboard de administración
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Gestión de usuarios
    Route::resource('users', UserController::class);
    Route::get('users/states', [UserController::class, 'getStates'])->name('users.states');
    Route::get('users/cities', [UserController::class, 'getCities'])->name('users.cities');
});