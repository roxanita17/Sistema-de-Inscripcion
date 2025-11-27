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
        Schema::create('detalle_docente_estudios', function (Blueprint $table) {
            $table->id();

            $table->foreignId('docente_id')
                ->constrained('docentes')
                ->onDelete('cascade');

            $table->foreignId('estudios_id')
                ->constrained('estudios_realizados')
                ->onDelete('cascade');

            $table->boolean('status')->default(true);
            $table->timestamps();

            // Evita duplicados del mismo grado y área con un nombre más corto para el índice
            $table->unique(['docente_id', 'estudios_id'], 'docente_estudios_unique');
                });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_docente_estudios');
    }
};
