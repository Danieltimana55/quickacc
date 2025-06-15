<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jornada;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class JornadaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('admin/jornadas/Index', [
            'jornadas' => Jornada::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/jornadas/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:jornadas',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
        ]);

        // Convertir a formato datetime para almacenar
        $validated['hora_entrada'] = date('Y-m-d H:i:s', strtotime($validated['hora_entrada']));
        $validated['hora_salida'] = date('Y-m-d H:i:s', strtotime($validated['hora_salida']));

        Jornada::create($validated);

        return redirect()->route('admin.jornadas.index')
            ->with('message', 'Jornada creada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jornada $jornada): Response
    {
        return Inertia::render('admin/jornadas/Show', [
            'jornada' => $jornada->load('formaciones'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jornada $jornada): Response
    {
        // Formatear las horas para el formulario
        $jornada->hora_entrada = date('H:i', strtotime($jornada->hora_entrada));
        $jornada->hora_salida = date('H:i', strtotime($jornada->hora_salida));
        
        return Inertia::render('admin/jornadas/Edit', [
            'jornada' => $jornada,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jornada $jornada)
    {
        $validated = $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('jornadas')->ignore($jornada->id),
            ],
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
        ]);

        // Convertir a formato datetime para almacenar
        $validated['hora_entrada'] = date('Y-m-d H:i:s', strtotime($validated['hora_entrada']));
        $validated['hora_salida'] = date('Y-m-d H:i:s', strtotime($validated['hora_salida']));

        $jornada->update($validated);

        return redirect()->route('admin.jornadas.index')
            ->with('message', 'Jornada actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jornada $jornada)
    {
        // Verificar si hay formaciones asociadas a esta jornada
        if ($jornada->formaciones()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la jornada porque tiene formaciones asociadas');
        }

        $jornada->delete();

        return redirect()->route('admin.jornadas.index')
            ->with('message', 'Jornada eliminada exitosamente');
    }
}