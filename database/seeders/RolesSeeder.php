<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear los roles básicos del sistema
        $roles = [
            [
                'nombre' => 'administrador',
                'descripcion' => 'Administrador del sistema con acceso total',
            ],
            [
                'nombre' => 'instructor',
                'descripcion' => 'Instructor de formación',
            ],
            [
                'nombre' => 'celador',
                'descripcion' => 'Personal de seguridad que registra entradas y salidas',
            ],
            [
                'nombre' => 'aprendiz',
                'descripcion' => 'Aprendiz en formación',
            ],
        ];

        foreach ($roles as $rol) {
            Rol::create($rol);
        }
    }
}
