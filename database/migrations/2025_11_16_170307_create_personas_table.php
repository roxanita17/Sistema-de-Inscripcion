<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('primer_nombre');
            $table->string('segundo_nombre')->nullable();
            $table->string('tercer_nombre')->nullable();
            $table->string('primer_apellido');
            $table->string('segundo_apellido')->nullable();
            $table->string('numero_documento')->unique();
            $table->date('fecha_nacimiento');
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            $table->string('telefono_dos')->nullable();
            $table->boolean('status')->default(true);
            $table->foreignId('tipo_documento_id')->constrained('tipo_documentos')->cascadeOnDelete();
            $table->foreignId('genero_id')->constrained('generos')->cascadeOnDelete();
            $table->foreignId('localidad_id')->nullable()->constrained('localidads')->cascadeOnDelete();
            $table->foreignId('prefijo_id')->nullable()->constrained('prefijo_telefonos')->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};