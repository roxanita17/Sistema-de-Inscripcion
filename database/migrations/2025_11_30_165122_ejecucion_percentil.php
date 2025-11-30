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
        Schema::create('ejecucion_percentil', function (Blueprint $table) {
            $table->id();
            $table->string('fecha_ejecucion');
            $table->string('total_evaluados');
            $table->string('parametros');
            $table->foreignId('grado_id')->constrained('grados')->cascadeOnDelete();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ejecucion_percentil');
    }
};
