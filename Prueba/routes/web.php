<?php
// routes/web.php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// Rutas de autenticación
Auth::routes(['register' => false]); // Deshabilitar registro si no es necesario

// Ruta principal
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas protegidas
Route::middleware(['auth'])->group(function () {
    // Dashboard según rol
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    // Módulo de emails para todos los usuarios autenticados
    Route::resource('emails', EmailController::class)->except(['edit', 'update']);
    
    // Rutas de administración (solo para admins)
    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
        Route::resource('users', UserController::class);
    });
});

// Redirección post-login (Laravel automáticamente redirige a /home)
// Asegúrate de que RedirectIfAuthenticated middleware esté configurado correctamente
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
