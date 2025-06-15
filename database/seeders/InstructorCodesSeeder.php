<?php

namespace Database\Seeders;

use App\Models\InstructorVerificationCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstructorCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear un código de verificación por defecto para instructores
        InstructorVerificationCode::create([
            'code' => 'SENA2023',
            'is_used' => false,
        ]);

        // Crear algunos códigos de verificación adicionales
        for ($i = 0; $i < 5; $i++) {
            InstructorVerificationCode::create([
                'code' => InstructorVerificationCode::generateCode(),
                'is_used' => false,
                'expires_at' => now()->addMonths(3), // Expira en 3 meses
            ]);
        }
    }
} 