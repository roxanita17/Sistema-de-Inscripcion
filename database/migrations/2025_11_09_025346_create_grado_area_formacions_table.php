<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grado_area_formacions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');

            // Claves foráneas
            $table->foreignId('grado_id')
                  ->constrained('grados')
                  ->onDelete('cascade');

            $table->foreignId('area_formacion_id')
                  ->constrained('area_formacions')
                  ->onDelete('cascade');

            // Otros campos
            $table->boolean('status')->default(true);

            $table->timestamps();

            // Evita duplicados del mismo grado y área
            $table->unique(['grado_id', 'area_formacion_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grado_area_formacions');
    }
};
