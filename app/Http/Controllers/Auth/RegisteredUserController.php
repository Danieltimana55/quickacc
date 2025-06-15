<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Rol;
use App\Models\InstructorVerificationCode;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        return Inertia::render('auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validación básica de campos
        $validated = $request->validate([
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:10',
            'numero_documento' => 'required|string|max:20|unique:'.User::class,
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol_id' => 'required|exists:roles,id',
            'codigo_instructor' => 'nullable|string',
        ]);

        $rolId = $validated['rol_id'];
        $instructorRolId = Rol::where('nombre', 'instructor')->value('id');

        // Si se está registrando como instructor, validar el código
        if ($rolId == $instructorRolId) {
            if (empty($validated['codigo_instructor'])) {
                throw ValidationException::withMessages([
                    'codigo_instructor' => ['El código de verificación es obligatorio para registrarse como instructor.'],
                ]);
            }

            // Verificar si el código es válido
            if (!InstructorVerificationCode::isValid($validated['codigo_instructor'])) {
                throw ValidationException::withMessages([
                    'codigo_instructor' => ['El código de verificación no es válido o ya ha sido utilizado.'],
                ]);
            }
        }

        // Crear el usuario
        $user = User::create([
            'nombres' => $validated['nombres'],
            'apellidos' => $validated['apellidos'],
            'tipo_documento' => $validated['tipo_documento'],
            'numero_documento' => $validated['numero_documento'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'rol_id' => $rolId,
        ]);

        // Si es instructor, marcar el código como utilizado
        if ($rolId == $instructorRolId && !empty($validated['codigo_instructor'])) {
            $code = InstructorVerificationCode::where('code', strtoupper($validated['codigo_instructor']))
                ->where('is_used', false)
                ->first();
            
            if ($code) {
                $code->markAsUsed($user->id);
            }
        }

        event(new Registered($user));

        Auth::login($user);

        // Redireccionar según el rol
        if ($user->esInstructor()) {
            return to_route('instructor.dashboard');
        } elseif ($user->esAprendiz()) {
            return to_route('aprendiz.dashboard');
        }

        return to_route('dashboard');
    }
}
