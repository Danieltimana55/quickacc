<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registro;
use App\Models\User;
use App\Models\Rol;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class RegistroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('admin/records/Index', [
            'registros' => Registro::with(['usuario', 'rol', 'celador'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/records/Create', [
            'usuarios' => User::all(),
            'roles' => Rol::all(),
            'celadores' => User::whereHas('rol', function ($query) {
                $query->where('nombre', 'celador');
            })->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_registro' => 'required|string|in:entrada,salida',
            'user_id' => 'required|exists:users,id',
            'rol_id' => 'required|exists:roles,id',
            'celador_id' => 'required|exists:users,id',
            'observacion' => 'nullable|string|max:255',
            'justificacion' => 'nullable|string',
            'foto_soporte' => 'nullable|image|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('foto_soporte')) {
            $validated['foto_soporte'] = $request->file('foto_soporte')->store('registros/soportes', 'public');
        }

        Registro::create($validated);

        return redirect()->route('admin.records.index')
            ->with('message', 'Registro creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Registro $registro): Response
    {
        return Inertia::render('admin/registros/Show', [
            'registro' => $registro->load(['usuario', 'rol', 'celador']),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Registro $record): Response
    {
        return Inertia::render('admin/records/Edit', [
            'registro' => $record,
            'usuarios' => User::all(),
            'roles' => Rol::all(),
            'celadores' => User::whereHas('rol', function ($query) {
                $query->where('nombre', 'celador');
            })->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Registro $record)
    {
        $validated = $request->validate([
            'tipo_registro' => 'required|string|in:entrada,salida',
            'user_id' => 'required|exists:users,id',
            'rol_id' => 'required|exists:roles,id',
            'celador_id' => 'required|exists:users,id',
            'observacion' => 'nullable|string|max:255',
            'justificacion' => 'nullable|string',
            'foto_soporte' => 'nullable|image|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('foto_soporte')) {
            // Delete old file if exists
            if ($record->foto_soporte) {
                Storage::disk('public')->delete($record->foto_soporte);
            }
            $validated['foto_soporte'] = $request->file('foto_soporte')->store('registros/soportes', 'public');
        }

        $record->update($validated);

        return redirect()->route('admin.records.index')
            ->with('message', 'Registro actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Registro $record)
    {
        // Delete associated file
        if ($record->foto_soporte) {
            Storage::disk('public')->delete($record->foto_soporte);
        }

        $record->delete();

        return redirect()->route('admin.records.index')
            ->with('message', 'Registro eliminado exitosamente');
    }
}