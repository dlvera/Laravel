<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\LocationController;
use Illuminate\Support\Facades\Route;

// Rutas públicas
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/', [LoginController::class, 'login']);


// Rutas protegidas
Route::middleware(['auth'])->group(function () {

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Dashboard
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Módulo de emails (accesible para todos los usuarios autenticados)
    Route::resource('emails', EmailController::class)->except(['edit', 'update']);
    
    // Rutas de administración
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::get('/dashboard', function () {
            $usersCount = \App\Models\User::count();
            $emailsCount = \App\Models\Email::count();
            $pendingEmails = \App\Models\Email::where('status', 'pending')->count();
            
            return view('admin.dashboard', compact('usersCount', 'emailsCount', 'pendingEmails'));
        })->name('admin.dashboard');
    });
});

// Rutas API para ubicaciones
Route::prefix('api')->group(function () {
    Route::get('/countries', [LocationController::class, 'countries']);
    Route::get('/countries/{countryId}/states', [LocationController::class, 'states']);
    Route::get('/states/{stateId}/cities', [LocationController::class, 'cities']);
    Route::get('/cities/{code}', [LocationController::class, 'cityByCode']);
});