<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->id();

            // Relaciones
            $table->foreignId('alumno_id')
                  ->constrained('alumnos')
                  ->onDelete('cascade');

            $table->foreignId('grado_id')
                  ->constrained('grados')
                  ->onDelete('cascade');

            $table->foreignId('padre_id')
                  ->nullable()
                  ->constrained('representantes')
                  ->nullOnDelete();

            $table->foreignId('madre_id')
                  ->nullable()
                  ->constrained('representantes')
                  ->nullOnDelete();

            $table->unsignedBigInteger('representante_legal_id')->nullable();
            $table->foreign('representante_legal_id')
                  ->references('id')
                  ->on('representante_legal')
                  ->nullOnDelete();

            // Campos de documentos
            $table->json('documentos')->nullable();
            $table->string('estado_documentos')->default('Pendiente');

            // Fecha de inscripción
            $table->date('fecha_inscripcion');

            $table->string('observaciones')->nullable();

            $table->integer('numero_zonificacion');
            $table->date('anio_egreso');
            $table->foreignId('institucion_procedencia_id')->constrained('institucion_procedencias')->cascadeOnDelete();
            $table->foreignId('expresion_literaria_id')->constrained('expresion_literarias')->cascadeOnDelete();
            $table->boolean('acepta_normas_contrato')->default(false);




            $table->string('status')->default('Activo');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripcions');
    }
};