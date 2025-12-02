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
        Schema::create('area_estudio_realizados', function (Blueprint $table) {
            $table->id();

            $table->foreignId('area_formacion_id')
                ->constrained('area_formacions')
                ->onDelete('cascade');

            $table->foreignId('estudios_id')
                ->constrained('estudios_realizados')
                ->onDelete('cascade');

            $table->boolean('status')->default(true);
            $table->timestamps();

            // Evita duplicados del mismo grado y área con un nombre más corto para el índice
            $table->unique(['area_formacion_id', 'estudios_id'], 'area_formacion_titulo_unique');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_estudio_realizados');
    }
};