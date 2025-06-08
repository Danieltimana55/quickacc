<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Show the login page.
     */
    public function create(Request $request): Response
    {
        return Inertia::render('auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => $request->session()->get('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        
        $user = Auth::user()->load('rol');
        
        // Redireccionar según el rol del usuario
        if ($user->esAdmin()) {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->esAprendiz()) {
            return redirect()->intended(route('aprendiz.dashboard'));
        } elseif ($user->esInstructor()) {
            return redirect()->intended(route('instructor.dashboard'));
        } elseif ($user->esCelador()) {
            return redirect()->intended(route('celador.dashboard'));
        }

        // Por defecto, si no hay un rol específico
        return redirect()->intended(route('dashboard'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
