<?php

use App\Http\Controllers\EmailController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación (generadas por Breeze)
require __DIR__.'/auth.php';

// Rutas para usuarios autenticados
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para módulo de emails (accesible para todos los usuarios autenticados)
    Route::resource('emails', EmailController::class)->only(['index', 'create', 'store', 'show']);
    
    // Rutas solo para administradores
    Route::middleware('is_admin')->group(function () {
        Route::resource('users', UserController::class);
        Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');
    });
});

// Rutas API para selects anidados
Route::prefix('api')->group(function () {
    Route::get('countries', [App\Http\Controllers\Api\LocationController::class, 'getCountries']);
    Route::get('states/{country}', [App\Http\Controllers\Api\LocationController::class, 'getStates']);
    Route::get('cities/{state}', [App\Http\Controllers\Api\LocationController::class, 'getCities']);
});