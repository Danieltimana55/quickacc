<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolController;
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
    // Route::resource('formations', FormationController::class);
    // Route::resource('devices', DeviceController::class);
    // Route::resource('records', RecordController::class);
}); 