<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscripcion_nuevo_ingresos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_zonificacion')->nullable();
            $table->foreignId('inscripcion_id')->constrained('inscripcions')->cascadeOnDelete();
            $table->foreignId('institucion_procedencia_id')->constrained('institucion_procedencias')->cascadeOnDelete();
            $table->foreignId('expresion_literaria_id')->constrained('expresion_literarias')->cascadeOnDelete();
            $table->date('anio_egreso');
            
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcion_nuevo_ingresos');
    }
};

