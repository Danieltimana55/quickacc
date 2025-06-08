<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_registro', [
                'entrada', 
                'salida', 
                'salida_anticipada', 
                'entrada_fuera_horario', 
                'salida_fuera_horario'
            ]);
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('rol_id')->constrained('roles');
            $table->foreignId('celador_id')->constrained('users');
            $table->text('observacion')->nullable();
            $table->text('justificacion')->nullable();
            $table->string('foto_soporte')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};
