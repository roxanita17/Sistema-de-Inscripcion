<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discapacidad_estudiantes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('alumno_id')
                ->constrained('alumnos')
                ->cascadeOnDelete();

            $table->foreignId('discapacidad_id')
                ->constrained('discapacidads')
                ->cascadeOnDelete();

            $table->boolean('status')->default(true);

            $table->timestamps();

            // Evita duplicados
            $table->unique(['alumno_id', 'discapacidad_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discapacidad_estudiantes');
    }
};
