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
        Schema::create('prosecucion_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscripcion_prosecucion_id')->constrained('inscripcion_prosecucions')->cascadeOnDelete();
            $table->foreignId('grado_area_formacion_id')->constrained('grado_area_formacions')->cascadeOnDelete();
            $table->string('status')->enum('Aprobado', 'Pendiente', 'Reprobado');
            $table->timestamps();
        });
    } 

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prosecucion_areas');
    }
};
