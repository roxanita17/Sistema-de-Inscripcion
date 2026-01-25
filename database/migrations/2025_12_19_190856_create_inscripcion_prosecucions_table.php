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
        Schema::create('inscripcion_prosecucions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inscripcion_id')->constrained('inscripcions')->cascadeOnDelete();
            $table->foreignId('inscripcion_anterior_id')->nullable()->constrained('inscripcions')->nullOnDelete();
            $table->boolean('promovido')->default(false);
            $table->foreignId('grado_id')->nullable()->constrained('grados')->nullOnDelete();
            $table->foreignId('seccion_id')->nullable()->constrained('seccions')->nullOnDelete();
            $table->boolean('repite_grado')->nullable()->default(false);
            $table->string('observaciones')->nullable();
            $table->boolean('acepta_normas_contrato')->default(false);
            $table->foreignId('anio_escolar_id')->nullable()->constrained('anio_escolars')->nullOnDelete();
            $table->string('status')->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcion_prosecucions');
    }
};
