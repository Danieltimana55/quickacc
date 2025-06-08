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
        Schema::create('formaciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('nivel', ['tecnico', 'tecnologo']);
            $table->string('numero_ficha')->unique();
            $table->string('numero_ambiente');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->foreignId('jornada_id')->constrained('jornadas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formaciones');
    }
};
