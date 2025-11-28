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
        Schema::create('representante_legal', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("representante_id");
            $table->foreign("representante_id")->references("id")->on("representantes")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("banco_id")->nullable();
            $table->foreign("banco_id")->references("id")->on("bancos")->onDelete("cascade")->onUpdate("cascade");
            $table->string("tipo_cuenta", 100);
            $table->string("parentesco", 100);
            $table->string("correo_representante",255);
            $table->boolean("pertenece_a_organizacion_representante");
            $table->string("cual_organizacion_representante",255);
            $table->boolean("carnet_patria_afiliado");
            $table->string("serial_carnet_patria_representante",20);
            $table->string("codigo_carnet_patria_representante",20);
            $table->text("direccion_representante");
            $table->string("estados_representante")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representante_legal');
    }
};
