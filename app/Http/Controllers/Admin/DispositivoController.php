<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dispositivo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class DispositivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('admin/devices/Index', [
            'dispositivos' => Dispositivo::with('usuario')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/devices/Create', [
            'usuarios' => User::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo_dispositivo' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
            'serial' => 'required|string|max:100|unique:dispositivos',
            'foto_serial' => 'nullable|image|max:2048',
            'foto_dispositivo' => 'nullable|image|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        // Handle file uploads
        if ($request->hasFile('foto_serial')) {
            $validated['foto_serial'] = $request->file('foto_serial')->store('dispositivos/seriales', 'public');
        }

        if ($request->hasFile('foto_dispositivo')) {
            $validated['foto_dispositivo'] = $request->file('foto_dispositivo')->store('dispositivos/fotos', 'public');
        }

        Dispositivo::create($validated);

        return redirect()->route('admin.devices.index')
            ->with('message', 'Dispositivo registrado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dispositivo $dispositivo): Response
    {
        return Inertia::render('admin/dispositivos/Show', [
            'dispositivo' => $dispositivo->load('usuario'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dispositivo $device): Response
    {
        return Inertia::render('admin/devices/Edit', [
            'dispositivo' => $device,
            'usuarios' => User::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dispositivo $device)
    {
        $validated = $request->validate([
            'tipo_dispositivo' => 'required|string|max:50',
            'marca' => 'required|string|max:50',
            'serial' => 'required|string|max:100|unique:dispositivos,serial,' . $device->id,
            'foto_serial' => 'nullable|image|max:2048',
            'foto_dispositivo' => 'nullable|image|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        // Handle file uploads
        if ($request->hasFile('foto_serial')) {
            // Delete old file if exists
            if ($device->foto_serial) {
                Storage::disk('public')->delete($device->foto_serial);
            }
            $validated['foto_serial'] = $request->file('foto_serial')->store('dispositivos/seriales', 'public');
        }

        if ($request->hasFile('foto_dispositivo')) {
            // Delete old file if exists
            if ($device->foto_dispositivo) {
                Storage::disk('public')->delete($device->foto_dispositivo);
            }
            $validated['foto_dispositivo'] = $request->file('foto_dispositivo')->store('dispositivos/fotos', 'public');
        }

        $device->update($validated);

        return redirect()->route('admin.devices.index')
            ->with('message', 'Dispositivo actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dispositivo $device)
    {
        // Delete associated files
        if ($device->foto_serial) {
            Storage::disk('public')->delete($device->foto_serial);
        }
        
        if ($device->foto_dispositivo) {
            Storage::disk('public')->delete($device->foto_dispositivo);
        }

        $device->delete();

        return redirect()->route('admin.devices.index')
            ->with('message', 'Dispositivo eliminado exitosamente');
    }
}