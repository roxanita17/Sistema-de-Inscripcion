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
        Schema::create('representantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("persona_id");
            $table->foreign("persona_id")->references("id")->on("personas")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("estado_id");
            $table->foreign("estado_id")->references("id")->on("estados")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("municipio_id");
            $table->foreign("municipio_id")->references("id")->on("municipios")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("parroquia_id");
            $table->foreign("parroquia_id")->references("id")->on("localidads")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("ocupacion_representante");
            $table->foreign("ocupacion_representante")->references("id")->on("ocupacions")->onDelete("cascade")->onUpdate("cascade");
            $table->string("convivenciaestudiante_representante");
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representantes');
    }
};
