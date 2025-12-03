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
        Schema::create('inscripcions', function (Blueprint $table) {
            $table->id();
            
            // Relación con el alumno
            $table->foreignId('alumno_id')
                  ->constrained('alumnos')
                  ->onDelete('cascade');
            
            // Relación con el grado
            $table->foreignId('grado_id')
                  ->constrained('grados')
                  ->onDelete('cascade');
            
            // Representantes (padre, madre y representante legal)
            $table->foreignId('padre_id')
                  ->nullable()
                  ->constrained('representantes')
                  ->onDelete('set null');
            
            $table->foreignId('madre_id')
                  ->nullable()
                  ->constrained('representantes')
                  ->onDelete('set null');
            
            $table->unsignedBigInteger('representante_legal_id')->nullable();

            $table->foreign('representante_legal_id')
                  ->references('id')
                  ->on('representante_legal')
                  ->nullOnDelete();

            
            
            $table->date('fecha_inscripcion')
                  ->default(now());
            
            $table->boolean('status')
                  ->default(true);
            
            $table->timestamps();
            $table->softDeletes();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcions');
    }
};