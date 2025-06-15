<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Formacion;
use App\Models\User;
use App\Models\Jornada;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class FormacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('admin/formations/Index', [
            'formaciones' => Formacion::with(['instructor', 'jornada'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/formations/Create', [
            'instructores' => User::where('rol_id', function($query) {
                $query->select('id')
                      ->from('roles')
                      ->where('nombre', 'instructor');
            })->get(),
            'jornadas' => Jornada::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'nivel' => 'required|string|max:100',
            'numero_ficha' => 'required|string|max:50|unique:formaciones',
            'instructor_id' => 'required|exists:users,id',
            'numero_ambiente' => 'required|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'jornada_id' => 'required|exists:jornadas,id',
        ]);

        Formacion::create($validated);

        return redirect()->route('admin.formations.index')
            ->with('message', 'Formación creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Formacion $formacione): Response
    {
        return Inertia::render('admin/formaciones/Show', [
            'formacion' => $formacione->load(['instructor', 'jornada', 'aprendices']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Formacion $formation): Response
    {
        return Inertia::render('admin/formations/Edit', [
            'formacion' => $formation,
            'instructores' => User::where('rol_id', function($query) {
                $query->select('id')
                      ->from('roles')
                      ->where('nombre', 'instructor');
            })->get(),
            'jornadas' => Jornada::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Formacion $formation)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'nivel' => 'required|string|max:100',
            'numero_ficha' => 'required|string|max:50|unique:formaciones,numero_ficha,' . $formation->id,
            'instructor_id' => 'required|exists:users,id',
            'numero_ambiente' => 'required|string|max:50',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'jornada_id' => 'required|exists:jornadas,id',
        ]);

        $formation->update($validated);

        return redirect()->route('admin.formations.index')
            ->with('message', 'Formación actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Formacion $formation)
    {
        // Check if formation has aprendices
        if ($formation->aprendices()->exists()) {
            return back()->with('error', 'No se puede eliminar una formación que tiene aprendices');
        }

        $formation->delete();

        return redirect()->route('admin.formations.index')
            ->with('message', 'Formación eliminada exitosamente');
    }
}