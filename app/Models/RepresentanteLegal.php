<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RepresentanteLegal extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        "representante_id",
        "banco_id", 
        "parentesco",
        "correo_representante",
        "pertenece_a_organizacion_representante",
        "cual_organizacion_representante",
        "carnet_patria_afiliado",
        "serial_carnet_patria_representante",
        "direccion_representante",
        "estados_representante",
        "tipo_cuenta",
        "codigo_carnet_patria_representante"
    ];

    protected $table = "representante_legal";


    public function representante(){
        return $this->belongsTo(Representante::class,"representante_id","id");
    }
    
    public function prefijo()
{
    return $this->belongsTo(PrefijoTelefono::class, 'prefijo_id');
}

    public function banco()
    {
        return $this->belongsTo(Banco::class, 'banco_id');
    }

}