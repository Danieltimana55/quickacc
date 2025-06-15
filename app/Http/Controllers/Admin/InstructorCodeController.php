<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstructorVerificationCode;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class InstructorCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('admin/instructor-codes/Index', [
            'codes' => InstructorVerificationCode::with('usedByUser')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('admin/instructor-codes/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'nullable|string|max:20|unique:instructor_verification_codes,code',
            'expires_at' => 'nullable|date|after:today',
        ]);

        // Si no se proporciona un código, generar uno automáticamente
        if (empty($validated['code'])) {
            $validated['code'] = InstructorVerificationCode::generateCode();
        } else {
            // Asegurarse de que el código sea siempre mayúsculas
            $validated['code'] = strtoupper($validated['code']);
        }

        InstructorVerificationCode::create($validated);

        return redirect()->route('admin.instructor-codes.index')
            ->with('message', 'Código de verificación creado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstructorVerificationCode $instructorCode)
    {
        // No permitir eliminar códigos que ya han sido utilizados
        if ($instructorCode->is_used) {
            return back()->with('error', 'No se puede eliminar un código que ya ha sido utilizado.');
        }

        $instructorCode->delete();

        return redirect()->route('admin.instructor-codes.index')
            ->with('message', 'Código de verificación eliminado exitosamente');
    }
} 