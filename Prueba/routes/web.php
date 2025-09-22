<?php
// routes/web.php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\Admin\UserController;

// Ruta principal - siempre pública
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de autenticación de Laravel
Auth::routes(['register' => false]);

// Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    
    // Dashboard principal - redirige según el rol
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    
    // Módulo de emails - accesible para todos los usuarios autenticados
    Route::get('/emails', [EmailController::class, 'index'])->name('emails.index');
    Route::get('/emails/create', [EmailController::class, 'create'])->name('emails.create');
    Route::post('/emails', [EmailController::class, 'store'])->name('emails.store');
    Route::get('/emails/{email}', [EmailController::class, 'show'])->name('emails.show');
    
    // Rutas de administración - solo para admins
    Route::prefix('admin')->middleware('admin')->group(function () {
        // Dashboard de admin
        Route::get('/dashboard', [HomeController::class, 'adminDashboard'])->name('admin.dashboard');
        
        // Gestión de usuarios
        Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');
    });
});

// Ruta de logout personalizada
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');