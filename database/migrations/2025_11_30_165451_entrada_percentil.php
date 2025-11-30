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
        Schema::create('entrada_percentil', function (Blueprint $table) {
            $table->id();
            $table->string('edad_util');
            $table->string('estatura_util');
            $table->string('peso_util');
            $table->string('puntaje');
            $table->foreignId('grado_id')->constrained('grados')->cascadeOnDelete();
            $table->foreignId('ejecucion_percentil_id')->constrained('ejecucion_percentil')->cascadeOnDelete();

            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrada_percentil');
    }
};

/* 
table de indices


*/
