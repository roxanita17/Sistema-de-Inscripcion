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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->integer('numero_zonificacion');
            $table->date('anio_egreso');
            $table->string('talla_camisa');
            $table->string('talla_pantalon');
            $table->string('talla_zapato');
            $table->integer('peso');
            $table->integer('estatura');
            $table->foreignId('orden_nacimiento_id')->nullable()->constrained('orden_nacimientos')->cascadeOnDelete();
            $table->foreignId('discapacidad_id')->nullable()->constrained('discapacidads')->cascadeOnDelete();
            $table->foreignId('etnia_indigena_id')->nullable()->constrained('etnia_indigenas')->cascadeOnDelete();
            $table->foreignId('expresion_literaria_id')->nullable()->constrained('expresion_literarias')->cascadeOnDelete();
            $table->foreignId('lateralidad_id')->nullable()->constrained('lateralidads')->cascadeOnDelete();
            $table->foreignId('persona_id')->constrained('personas')->cascadeOnDelete();
            $table->foreignId('institucion_procedencia_id')->constrained('institucion_procedencias')->cascadeOnDelete();

            $table->string('status')->default('Activo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
