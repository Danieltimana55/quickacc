<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login-page');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';
require __DIR__.'/admin.php';

// Rutas para aprendiz
Route::middleware(['auth', 'verified', 'check.role:aprendiz'])->prefix('aprendiz')->name('aprendiz.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('aprendiz/Dashboard');
    })->name('dashboard');
});

// Rutas para instructor
Route::middleware(['auth', 'verified', 'check.role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('instructor/Dashboard');
    })->name('dashboard');
});

// Rutas para celador
Route::middleware(['auth', 'verified', 'check.role:celador'])->prefix('celador')->name('celador.')->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('celador/Dashboard');
    })->name('dashboard');
});
