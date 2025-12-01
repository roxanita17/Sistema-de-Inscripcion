<?php

use App\Models\Estudiante;
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
        Schema::create('estudiantes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("persona_id");
            $table->foreign("persona_id")->references("id")->on("personas")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("estado_id");
            $table->foreign("estado_id")->references("id")->on("estados")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("municipio_id");
            $table->foreign("municipio_id")->references("id")->on("municipios")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("localidad_id");
            $table->foreign("localidad_id")->references("id")->on("localidads")->onDelete("cascade")->onUpdate("cascade");
            // $table->unsignedBigInteger("institucion_id");
            // $table->foreign("institucion_id")->references("id")->on("instituciones")->onDelete("cascade")->onUpdate("cascade");
            $table->unsignedBigInteger("institucion_id");
$table->foreign("institucion_id")->references("id")->on("institucion_procedencias")->onDelete("cascade")->onUpdate("cascade");
            $table->integer("orden_nacimiento_estudiante");
            // $table->integer("edad_estudiante");
            // $table->integer("meses_estudiante");
            // $table->boolean("pueblo_indigena_estudiante");
            $table->text("cual_pueblo_indigna")->nullable();;
            $table->string("talla_camisa");
            $table->string("talla_pantalon");
            $table->integer("talla_zapato");
            $table->integer("talla_estudiante");
            $table->decimal("peso_estudiante",8,2);
            // $table->boolean("posee_discapacidad_estudiante");
            $table->string("discapacidad_estudiante",150)->nullable();;
            // $table->boolean("documentos_estudiante");
            $table->integer("numero_zonificacion_plantel")->nullable();
            // $table->string("intitucion_procedencia",255);
            $table->string("ano_ergreso_estudiante",255);
            $table->string("expresion_literaria",255);
            $table->string("lateralidad_estudiante",255);



            $table->string("documentos_estudiante",255)->nullable();
            $table->enum("status",[
                'Activo',
                'En Espera',
                'Inactivo',
            ])->default('Activo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estudiantes');
    }
};

