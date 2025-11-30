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
            $table->integer('talla_camisa');
            $table->integer('talla_pantalon');
            $table->integer('tallas_zapato');
            $table->integer('peso');
            $table->integer('estatura');
            $table->foreignId('orden_nacimiento_id')->constrained('orden_nacimientos')->cascadeOnDelete();
            $table->foreignId('discapacidad_id')->constrained('discapacidads')->cascadeOnDelete();
            $table->foreignId('etnia_indigena_id')->constrained('etnia_indigenas')->cascadeOnDelete();
            $table->foreignId('expresion_literaria_id')->constrained('expresion_literarias')->cascadeOnDelete();
            $table->foreignId('lateralidad_id')->constrained('lateralidads')->cascadeOnDelete();
            $table->foreignId('persona_id')->constrained('personas')->cascadeOnDelete();
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
