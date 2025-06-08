<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispositivo;
use App\Models\Formacion;
use App\Models\Registro;
use App\Models\Rol;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard administrativo
     */
    public function index()
    {
        // Verificar que el usuario tenga rol de administrador
        if (!auth()->user()->esAdmin()) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        // Obtener estadísticas para el dashboard
        $stats = [
            'usuarios' => [
                'total' => User::count(),
                'administradores' => User::whereHas('rol', function ($query) {
                    $query->where('nombre', 'administrador');
                })->count(),
                'instructores' => User::whereHas('rol', function ($query) {
                    $query->where('nombre', 'instructor');
                })->count(),
                'aprendices' => User::whereHas('rol', function ($query) {
                    $query->where('nombre', 'aprendiz');
                })->count(),
                'celadores' => User::whereHas('rol', function ($query) {
                    $query->where('nombre', 'celador');
                })->count(),
            ],
            'dispositivos' => [
                'total' => Dispositivo::count(),
            ],
            'formaciones' => [
                'total' => Formacion::count(),
                'activas' => Formacion::where('fecha_fin', '>=', Carbon::now()->toDateString())->count(),
            ],
            'registros' => [
                'total' => Registro::count(),
                'hoy' => Registro::whereDate('created_at', Carbon::today())->count(),
            ],
        ];

        // Renderizar la vista con Inertia
        return Inertia::render('admin/Dashboard', [
            'stats' => $stats,
        ]);
    }
}
