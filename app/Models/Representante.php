<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Representante extends Model
{
    use HasFactory;
    //
    use SoftDeletes;

    protected $table = "representantes";

    protected $fillable = [
        "persona_id",
        "estado_id",
        "ocupacion_representante",
        "convivenciaestudiante_representante",
        "municipio_id",
        "parroquia_id",
    ];


        public function estado()
    {
        return $this->belongsTo(Estado::class, "estado_id", "id");
    }

    public function municipios()
    {
        return $this->belongsTo(Municipio::class, "municipio_id", "id");
    }


    public function localidads(){
        return $this->belongsTo(Localidad::class,"parroquia_id","id");
    }

    public function persona()
    {
        return $this->belongsTo(Persona::class,"persona_id","id");
    }

    public function ocupacion()
    {
        return $this->belongsTo(Ocupacion::class, "ocupacion_representante", "id");
    }

    public function legal()
    {
        return $this->hasOne(RepresentanteLegal::class, 'representante_id', 'id');
    }

    //--- REPORTES ---//

    public static function reportePDF($filtro=null){
    $query=DB::table("representantes")
    ->select(
        // Datos del representante
            'representantes.id as representante_id',
            'representantes.ocupacion_representante',
            
            // Datos de persona
            'personas.primer_nombre',
            'personas.segundo_nombre',
            'personas.tercer_nombre',
            'personas.primer_apellido',
            'personas.segundo_apellido',
            'personas.numero_documento',
            'personas.telefono',
            'personas.email',
            'personas.status',
            'personas.tipo_documento_id',
            'personas.genero_id',
            'personas.localidad_id',
            'personas.prefijo_id',

            // Datos de ubicación
            'estados.nombre_estado as estado_nombre',
            'municipios.nombre_municipio as municipio_nombre',
            'localidads.nombre_localidad as localidad_nombre',
            'ocupacions.nombre_ocupacion as ocupacion_nombre',

            // Datos del representante legal
            'representante_legal.parentesco',
            'representante_legal.correo_representante',
            'representante_legal.pertenece_a_organizacion_representante',
            'representante_legal.cual_organizacion_representante',
            'representante_legal.carnet_patria_afiliado',
            'representante_legal.serial_carnet_patria_representante',
            'representante_legal.tipo_cuenta',
            'representante_legal.codigo_carnet_patria_representante',
            'bancos.nombre_banco as banco_nombre' // Si necesitas el nombre del banco
        )
        ->join("personas", "personas.id", "=", "representantes.persona_id")
        ->leftJoin("estados", "estados.id", "=", "representantes.estado_id")
        ->leftJoin("municipios", "municipios.id", "=", "representantes.municipio_id")
        ->leftJoin("localidads", "localidads.id", "=", "representantes.parroquia_id")
        ->leftJoin("ocupacions", "ocupacions.id", "=", "representantes.ocupacion_representante")
        ->leftJoin("representante_legal", "representante_legal.representante_id", "=", "representantes.id")
        ->leftJoin("bancos", "bancos.id", "=", "representante_legal.banco_id");
        
        // Filtro por tipo (representante legal o no)
    if (isset($filtro['es_legal'])) {
        if ($filtro['es_legal']) {
            $query->whereNotNull('representante_legal.id');
        } else {
            $query->whereNull('representante_legal.id');
        }
    }
    
    return $query->get();
    }
}
