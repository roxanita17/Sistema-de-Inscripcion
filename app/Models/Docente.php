<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';
    
    protected $fillable = [
        'primer_telefono',
        'segundo_telefono',
        'codigo',
        'dependencia',
        'status',
        'persona_id',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function scopeBuscar($query, $buscar)
    {
        if (!empty($buscar)) {
            $query->whereHas('persona', function ($q) use ($buscar) {
                $q->where(DB::raw("CONCAT(primer_nombre, ' ', primer_apellido)"), 'LIKE', "%{$buscar}%")
                ->orWhere('numero_documento', 'LIKE', "%{$buscar}%")
                ->orWhere('primer_nombre', 'LIKE', "%{$buscar}%")
                ->orWhere('primer_apellido', 'LIKE', "%{$buscar}%")
                ->orWhere('codigo', 'LIKE', "%{$buscar}%");
            });
        }

        return $query;
    }

    /**
     * Relación con DetalleDocenteEstudio
     */
    public function detalleDocenteEstudio()
    {
        return $this->hasMany(DetalleDocenteEstudio::class, 'docente_id', 'id');
    }

    /**
     * Relación directa con estudios realizados (many-to-many)
     */
    public function estudiosRealizados()
    {
        return $this->belongsToMany(
            EstudiosRealizado::class,
            'detalle_docente_estudios',
            'docente_id',
            'estudios_id'
        );
    }

    public function asignacionesAreas() 
    {
        // hasManyThrough(Target, Through, firstKeyOnThrough, secondKeyOnTarget, localKey, secondLocalKey)
        return $this->hasManyThrough(
            DocenteAreaGrado::class,
            DetalleDocenteEstudio::class,
            'docente_id',                    // FK en detalle_docente_estudios que apunta a docentes.id
            'docente_estudio_realizado_id',  // FK en docente_area_grados que apunta a detalle_docente_estudios.id
            'id',                            // PK local en docentes
            'id'                             // PK local en detalle_docente_estudios
        );
    }

    public function asignacionesAreasActivas()
    {
        return $this->asignacionesAreas()->where('docente_area_grados.status', true);
    }

    public function docenteAreaGrado()
    {
        return $this->hasManyThrough(
            DocenteAreaGrado::class,
            DetalleDocenteEstudio::class,
            'docente_id', // fk detalle → docente
            'docente_estudio_realizado_id', // fk area_grado → detalle
            'id', // docente
            'id'  // detalle
        );
    }



    public function detalleEstudios()
    {
        return $this->hasMany(DetalleDocenteEstudio::class, 'docente_id', 'id')->where('status', true);
    }

    /**
     * Relación con Persona
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id', 'id');
    }


    /**
     * Accessor para obtener el nombre completo
     */
    public function getNombreCompletoAttribute()
    {
        if (!$this->persona) {
            return '';
        }
        
        return trim(
            $this->persona->primer_nombre . ' ' .
            ($this->persona->segundo_nombre ?? '') . ' ' .
            ($this->persona->tercer_nombre ?? '') . ' ' .
            $this->persona->primer_apellido . ' ' .
            ($this->persona->segundo_apellido ?? '')
        );
    }

    /**
     * Accessor para obtener el teléfono completo
     */
    public function getTelefonoCompletoAttribute()
    {
        $prefijo = $this->prefijoTelefono->prefijo ?? '';
        return $prefijo . $this->primer_telefono;
    }

public static function reportePDF($id)
{
    // Cargar el docente con las relaciones necesarias
    $docente = Docente::select([
        'docentes.*',
        'personas.*',
        'tipo_documentos.abreviatura as tipo_documento_abreviatura',
        'generos.nombre as genero_nombre',
        'estudios_realizados.estudios as nombre_estudio',
        'area_formacions.nombre_area_formacion as nombre_area',
        'grado_area_formacions.codigo as nombre_grado'
    ])
    ->leftJoin('personas', 'personas.id', '=', 'docentes.persona_id')
    ->leftJoin('tipo_documentos', 'tipo_documentos.id', '=', 'personas.tipo_documento_id')
    ->leftJoin('generos', 'generos.id', '=', 'personas.genero_id')
    ->leftJoin('detalle_docente_estudios', 'detalle_docente_estudios.docente_id', '=', 'docentes.id')
    ->leftJoin('estudios_realizados', 'estudios_realizados.id', '=', 'detalle_docente_estudios.estudios_id')
    ->leftJoin('docente_area_grados', 'docente_area_grados.docente_estudio_realizado_id', '=', 'detalle_docente_estudios.id')
    ->leftJoin('area_formacions', 'area_formacions.id', '=', 'docente_area_grados.area_estudio_realizado_id')
    ->leftJoin('grado_area_formacions', 'grado_area_formacions.id', '=', 'docente_area_grados.grado_id')
    ->find($id);

    if (!$docente) {
        return response('No se encontró el docente solicitado', 404);
    }

    // Verificar si se cargaron los datos de la persona
    if ($docente->persona) {
        // Mapear los datos de la persona al objeto docente
        $docente->tipo_documento = $docente->tipo_documento_abreviatura ?? 'N/A';
        $docente->numero_documento = $docente->persona->numero_documento ?? 'N/A';
        $docente->primer_nombre = $docente->persona->primer_nombre ?? 'N/A';
        $docente->segundo_nombre = $docente->persona->segundo_nombre ?? 'N/A';
        $docente->tercer_nombre = $docente->persona->tercer_nombre ?? 'N/A';
        $docente->primer_apellido = $docente->persona->primer_apellido ?? 'N/A';
        $docente->segundo_apellido = $docente->persona->segundo_apellido ?? 'N/A';
        $docente->fecha_nacimiento = $docente->persona->fecha_nacimiento ?? 'N/A';
        $docente->genero = $docente->persona->genero->nombre ?? 'N/A';
        $docente->email = $docente->persona->email ?? 'N/A';
        $docente->direccion = $docente->persona->direccion ?? 'N/A';
        $docente->telefono = $docente->primer_telefono ?? $docente->segundo_telefono ?? 'N/A';
    }

    $pdf = PDF::loadView('admin.docente.reportes.individual_PDF', [
        'docente' => $docente
    ]);

    return $pdf->stream('docente_' . ($docente->numero_documento ?? $docente->id) . '.pdf');
}
    
}