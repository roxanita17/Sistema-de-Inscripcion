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
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_uno',140);
            $table->string('nombre_dos',140)->nullable();
            $table->string('nombre_tres',140)->nullable();
            $table->string('apellido_uno',140);
            $table->string('apellido_dos',140)->nullable();
            $table->string('sexo');
            $table->string('tipo_cedula_persona');
            $table->string('codigo_telefono_persona',10)->nullable();
            $table->string('numero_cedula_persona',20);
            $table->date('fecha_nacimiento_personas');
            $table->string('prefijo_telefono_personas',10)->nullable();
            $table->string('telefono_personas',20)->nullable();
            $table->string('lugar_nacimiento_persona',255)->nullable();
            $table->string("direccion_persona",255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
