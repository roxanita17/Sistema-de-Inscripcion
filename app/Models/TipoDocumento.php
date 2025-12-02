<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoDocumento extends Model
{
    protected $table = "tipo_documentos";

    protected $fillable = [
        'nombre',
    ];

    public function persona()
    {
        return $this->hasMany(Persona::class, 'tipo_documento_id', 'id');
    }

    
}
