<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rol;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class RolController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('admin/roles/Index', [
            'roles' => Rol::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/roles/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:roles',
            'descripcion' => 'nullable|string|max:255',
        ]);

        Rol::create($validated);

        return redirect()->route('admin.roles.index')
            ->with('message', 'Rol creado exitosamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rol $role): Response
    {
        return Inertia::render('admin/roles/Edit', [
            'role' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rol $role)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:roles,nombre,' . $role->id,
            'descripcion' => 'nullable|string|max:255',
        ]);

        $role->update($validated);

        return redirect()->route('admin.roles.index')
            ->with('message', 'Rol actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rol $role)
    {
        // Verificar si hay usuarios usando este rol
        if ($role->users()->exists()) {
            return back()->with('error', 'No se puede eliminar un rol que está siendo usado por usuarios');
        }

        $role->delete();

        return redirect()->route('admin.roles.index')
            ->with('message', 'Rol eliminado exitosamente');
    }
}
