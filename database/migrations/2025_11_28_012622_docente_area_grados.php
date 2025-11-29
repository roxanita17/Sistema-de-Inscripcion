<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docente_area_grados', function (Blueprint $table) {
            $table->id();

            // FK a detalle_docente_estudios
            $table->foreignId('docente_estudio_realizado_id')
                ->constrained('detalle_docente_estudios')
                ->onDelete('cascade');

            // FK a áreas de estudios
            $table->foreignId('area_estudio_realizado_id')
                ->constrained('area_estudio_realizados')
                ->onDelete('cascade');

            // FK a grados
            $table->foreignId('grado_id')
                ->constrained('grados')
                ->onDelete('cascade');

            $table->boolean('status')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docente_area_grados');
    }
};
