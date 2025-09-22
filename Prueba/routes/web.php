<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);

// Rutas protegidas
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // Emails
    Route::prefix('emails')->name('emails.')->group(function () {
        Route::get('/', [EmailController::class, 'index'])->name('index');
        Route::get('/create', [EmailController::class, 'create'])->name('create');
        Route::post('/', [EmailController::class, 'store'])->name('store');
        Route::get('/{email}', [EmailController::class, 'show'])->name('show');
        Route::delete('/{email}', [EmailController::class, 'destroy'])->name('destroy');
        Route::get('/{email}/download/{attachment}', [EmailController::class, 'downloadAttachment'])
            ->name('attachment.download');
    });
});

// Rutas de administración
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalUsers' => \App\Models\User::count(),
            'activeUsers' => \App\Models\User::where('is_active', true)->count(),
            'adminUsers' => \App\Models\User::where('is_admin', true)->count()
        ]);
    })->name('dashboard');
    
    // Gestión de usuarios
    Route::resource('users', UserController::class);
    
    // Rutas AJAX - CORREGIDAS
    Route::get('users/ajax/states', [UserController::class, 'getStates']);
    Route::get('users/ajax/cities/{state}', [UserController::class, 'getCities']);
});