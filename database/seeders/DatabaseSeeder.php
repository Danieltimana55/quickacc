<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Rol;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Ejecutar el seeder de roles
        $this->call(RolesSeeder::class);
        
        // Ejecutar el seeder de códigos de instructor
        $this->call(InstructorCodesSeeder::class);
        
        // Crear un usuario administrador por defecto
        User::create([
            'nombres' => 'Admin',
            'apellidos' => 'Sistema',
            'tipo_documento' => 'CC',
            'numero_documento' => '1000000000',
            'email' => 'admin@quickacc.com',
            'password' => Hash::make('password'),
            'rol_id' => 1, // Rol de administrador
        ]);
    }
}
