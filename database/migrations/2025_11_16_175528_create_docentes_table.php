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
        Schema::create('docentes', function (Blueprint $table) {
            $table->id();
            $table->integer('primer_telefono');
            $table->integer('segundo_telefono')->nullable();
            $table->string('codigo')->nullable();
            $table->string('dependencia')->nullable();
            $table->boolean('status')->default(true);
            $table->foreignId('prefijo_id')->constrained('prefijo_telefonos')->cascadeOnDelete();
            $table->foreignId('persona_id')->constrained('personas')->cascadeOnDelete();
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};
