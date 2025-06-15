<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolController;
use App\Http\Controllers\Admin\FormacionController;
use App\Http\Controllers\Admin\DispositivoController;
use App\Http\Controllers\Admin\JornadaController;
use App\Http\Controllers\Admin\RegistroController;
use App\Http\Controllers\Admin\InstructorCodeController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Rutas para admin
Route::middleware(['auth', 'verified', 'check.role:administrador'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('admin/Dashboard');
    })->name('dashboard');

    // Aquí puedes agregar más rutas específicas para el administrador
    Route::resource('users', UserController::class);
    Route::resource('roles', RolController::class);
    Route::resource('formations', FormacionController::class);
    Route::resource('devices', DispositivoController::class);
    Route::resource('jornadas', JornadaController::class);
    Route::resource('records', RegistroController::class);
    Route::resource('instructor-codes', InstructorCodeController::class)->except(['edit', 'update', 'show']);
});