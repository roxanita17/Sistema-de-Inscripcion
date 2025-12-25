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

            $table->foreignId('anio_escolar_id')->nullable()
                  ->constrained('anio_escolars')
                  ->nullOnDelete();

            // Relaciones
            $table->foreignId('alumno_id')
                  ->constrained('alumnos')
                  ->onDelete('cascade');

            $table->foreignId('grado_id')
                  ->constrained('grados')
                  ->onDelete('cascade');

            $table->foreignId('seccion_id')->nullable()
                  ->constrained('seccions')
                  ->nullOnDelete();

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
                  
            $table->enum('tipo_inscripcion', ['nuevo_ingreso', 'prosecucion']);

            // Campos de documentos
            $table->json('documentos')->nullable();
            $table->string('estado_documentos')->default('Pendiente');

            // Fecha de inscripción
            $table->string('observaciones')->nullable();
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