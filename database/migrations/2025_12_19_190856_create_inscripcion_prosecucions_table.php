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
        Schema::create('inscripcion_prosecucions', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('inscripcion_id')->constrained('inscripcions')->cascadeOnDelete();
            $table->boolean('promovido');
            $table->boolean('repite_grado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripcion_prosecucions');
    }
};
