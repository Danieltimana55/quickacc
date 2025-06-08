<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        // Verificar si el usuario tiene un rol asignado
        if (!$user->rol) {
            return redirect()->route('dashboard')->with('error', 'No tienes un rol asignado en el sistema.');
        }

        foreach ($roles as $role) {
            // Verificar por el nombre del rol
            if ($user->rol->nombre === $role) {
                return $next($request);
            }
            
            // También verificar por ID del rol
            if (is_numeric($role) && $user->rol_id == $role) {
                return $next($request);
            }
        }

        // Si el usuario no tiene ninguno de los roles requeridos
        return redirect()->route('dashboard')->with('error', 'No tienes permiso para acceder a esta página.');
    }
}
