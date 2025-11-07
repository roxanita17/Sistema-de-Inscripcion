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
        Schema::create('anio_escolars', function (Blueprint $table) {
            $table->id();
            $table->date("inicio_anio_escolar");
            $table->date("cierre_anio_escolar");
            $table->date("extencion_anio_escolar")->nullable();
            $table->enum("status",['Inactivo', 'Activo', 'Extendido'])->default('Inactivo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anio_escolars');
    }
};
