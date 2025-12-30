<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Traits\ConvierteAMayusculas;


class Docente extends Model
{
    use HasFactory;
    use ConvierteAMayusculas;


    protected $table = 'docentes';

    protected $fillable = [
        'anio_escolar_id',
        'primer_telefono',
        'telefono_dos',
        'segundo_telefono',
        'codigo',
        'dependencia',
        'status',
        'persona_id',
    ];

        protected $mayusculas = [
        'dependencia'
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

    public function anioEscolar()
    {
        return $this->belongsTo(AnioEscolar::class, 'anio_escolar_id');
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


    public function reportePDF($id)
    {
        $docente = Docente::with([
            'persona.tipoDocumento',
            'persona.genero',
            'detalleDocenteEstudio.estudiosRealizado',
            'detalleDocenteEstudio.docenteAreaGrados.areaEstudioRealizado.areaFormacion',
            'detalleDocenteEstudio.docenteAreaGrados.grado'
        ])
            ->leftJoin('personas', 'docentes.persona_id', '=', 'personas.id')
            ->leftJoin('tipo_documentos', 'personas.tipo_documento_id', '=', 'tipo_documentos.id')
            ->leftJoin('generos', 'personas.genero_id', '=', 'generos.id')
            ->leftJoin('detalle_docente_estudios', 'docentes.id', '=', 'detalle_docente_estudios.docente_id')
            ->leftJoin('estudios_realizados', 'detalle_docente_estudios.estudios_id', '=', 'estudios_realizados.id')
            ->leftJoin('docente_area_grados', 'docente_area_grados.docente_estudio_realizado_id', '=', 'detalle_docente_estudios.id')
            ->leftJoin('area_estudio_realizados', 'docente_area_grados.area_estudio_realizado_id', '=', 'area_estudio_realizados.id')
            ->leftJoin('area_formacions', 'area_estudio_realizados.area_formacion_id', '=', 'area_formacions.id')
            ->leftJoin('grado_area_formacions', 'docente_area_grados.grado_id', '=', 'grado_area_formacions.id')
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
            $docente->telefono_dos = $docente->persona->telefono_dos ?? 'N/A';
        }

        // Obtener estudios realizados
        $estudios = DB::table('estudios_realizados')
            ->where('status', true)
            ->get();

        // Obtener las materias (áreas de formación) del docente
        $materias = DB::table('docentes as d')
            ->join('detalle_docente_estudios as dde', 'd.id', '=', 'dde.docente_id')
            ->join('docente_area_grados as dag', 'dde.id', '=', 'dag.docente_estudio_realizado_id')
            ->join('area_estudio_realizados as aer', 'dag.area_estudio_realizado_id', '=', 'aer.id')
            ->join('area_formacions as af', 'aer.area_formacion_id', '=', 'af.id')
            ->join('grados as g', 'dag.grado_id', '=', 'g.id')
            ->where('d.id', $id)
            ->where('dde.status', true)
            ->select(
                'af.nombre_area_formacion as materia',
                'g.nombre as grado'
            )
            ->get();

        $pdf = PDF::loadView('admin.docente.reportes.individual_PDF', [
            'docente' => $docente
        ]);

        return $pdf->stream('docente_' . ($docente->numero_documento ?? $docente->id) . '.pdf');
    }
}
