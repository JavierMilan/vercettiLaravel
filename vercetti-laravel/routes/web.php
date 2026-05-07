<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Página principal (de momento redirige al dashboard)
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
});

// Rutas públicas - Login
Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', function () {
    $credentials = request()->only('usuario', 'password');
    
    $admin = \App\Models\Admin::where('usuario', $credentials['usuario'])->first();
    
    if ($admin && password_verify($credentials['password'], $admin->password_hash)) {
        session(['admin_id' => $admin->id, 'admin_usuario' => $admin->usuario]);
        return redirect()->route('admin.dashboard');
    }
    
    return back()->withErrors(['login' => 'Usuario o contraseña incorrectos.']);
})->name('login.post');

Route::get('/logout', function () {
    session()->flush();
    return redirect()->route('login');
})->name('logout');

// Rutas protegidas - Admin
Route::middleware('auth.admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/crear', [AdminController::class, 'create'])->name('admin.crear');
    Route::post('/crear', [AdminController::class, 'store'])->name('admin.store');
    Route::get('/editar/{id}', [AdminController::class, 'edit'])->name('admin.editar');
    Route::put('/editar/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::delete('/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::get('/pdf', [AdminController::class, 'exportarPDF'])->name('admin.pdf');
});