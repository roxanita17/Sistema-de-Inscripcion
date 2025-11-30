<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::create('nuevo_ingresos', function (Blueprint $table) {
    //         $table->id();
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::dropIfExists('nuevo_ingresos');
    // }


    public function up(): void
    {
        Schema::create('nuevo_ingresos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("estudiante_id");
            $table->foreign("estudiante_id")->references("id")->on("estudiantes")->onDelete("cascade");
            $table->unsignedBigInteger("representante_id");
            $table->foreign("representante_id")->references("id")->on("representantes")->onDelete("cascade");
            $table->unsignedBigInteger("ano_escolar_id");
            $table->foreign("ano_escolar_id")->references("id")->on("anio_escolars")->onDelete("cascade");
            $table->date("fecha_inscripcion");
            $table->integer("grado_academico");
            
            $table->json("documentos_entregados")->nullable();
            $table->text("observaciones")->nullable();
            $table->enum("status", [
                'pendiente',
                'completada',
                'rechazada'
            ])->default('pendiente');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nuevo_ingresos');
    }

};