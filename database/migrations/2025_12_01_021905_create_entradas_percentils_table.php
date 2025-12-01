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
        Schema::create('entradas_percentils', function (Blueprint $table) {
            $table->id();
            $table->integer('edad_meses');
            $table->integer('peso_kg');
            $table->integer('estatura_cm');
            $table->integer('indice_edad');
            $table->integer('indice_peso');
            $table->integer('indice_estatura');
            $table->integer('indice_total');
            $table->foreignId('seccion_id')->constrained('seccions')->cascadeOnDelete();
            $table->foreignId('ejecucion_percentil_id')->constrained('ejecuciones_percentils')->cascadeOnDelete();
            $table->foreignId('inscripcion_id')->constrained('inscripcions')->cascadeOnDelete();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas_percentils');
    }
};
