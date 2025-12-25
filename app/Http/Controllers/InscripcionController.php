<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Models\Persona;
use App\Models\Genero;
use App\Models\TipoDocumento;
use App\Models\Alumno;
use App\Models\Grado;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\ExpresionLiteraria;
use App\Models\InstitucionProcedencia;
use App\Models\EntradasPercentil;
use App\Models\Seccion;

class InscripcionController extends Controller
{
    /**
     * Verifica si hay un año escolar activo
     */
    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }

    public function index(Request $request)
    {
        // Obtener el año escolar activo
        $anioEscolarActivo = \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->first();

        // Obtener todos los grados
        $grados = Grado::where('status', true)
            ->orderBy('numero_grado', 'asc')
            ->get();

        $grado1 = Grado::find(1);
        $infoCupos = null;
        $entradasPercentil = collect();
        $seccionesResumen = collect();

        if ($grado1) {
            $inscritos = Inscripcion::where('grado_id', 1)
                ->where('status', 'Activo')
                ->when($anioEscolarActivo, function($q) use ($anioEscolarActivo) {
                    $q->where('anio_escolar_id', $anioEscolarActivo->id);
                })
                ->count();

            $infoCupos = [
                'nombre_grado' => $grado1->nombre ?? '1er Año',
                'total_cupos' => $grado1->capacidad_max,
                'cupos_ocupados' => $inscritos,
                'cupos_disponibles' => $grado1->capacidad_max - $inscritos,
                'porcentaje_ocupacion' => $grado1->capacidad_max > 0
                    ? round(($inscritos / $grado1->capacidad_max) * 100, 2)
                    : 0
            ];

            // Obtener entradas de percentil para estudiantes asignados a secciones
            $entradasPercentil = EntradasPercentil::with([
                'inscripcion.alumno.persona.tipoDocumento',
                'seccion'
            ])
                ->whereHas('inscripcion', function ($q) use ($grado1, $anioEscolarActivo) {
                    $q->where('grado_id', $grado1->id);
                    if ($anioEscolarActivo) {
                        $q->where('anio_escolar_id', $anioEscolarActivo->id);
                    }
                })
                ->orderBy('seccion_id')
                ->get();

            // Obtener resumen de secciones
            $seccionesResumen = EntradasPercentil::select('seccion_id')
                ->with('seccion')
                ->whereHas('inscripcion', function ($q) use ($grado1, $anioEscolarActivo) {
                    $q->where('grado_id', $grado1->id);
                    if ($anioEscolarActivo) {
                        $q->where('anio_escolar_id', $anioEscolarActivo->id);
                    }
                })
                ->groupBy('seccion_id')
                ->selectRaw('count(*) as total_estudiantes, seccion_id')
                ->get();
        }

        /* Filtros */
        $buscar = $request->get('buscar');
        $gradoId = $request->get('grado_id');
        $seccionId = $request->get('seccion_id');
        $tipoInscripcion = $request->get('tipo_inscripcion');

        // Cargar secciones según el grado seleccionado
        $secciones = collect();
        if ($gradoId) {
            $secciones = Seccion::where('grado_id', $gradoId)
                ->where('status', true)
                ->orderBy('nombre', 'asc')
                ->get();
        }

        // Query de inscripciones
        $inscripciones = Inscripcion::with([
            'alumno.persona',
            'alumno.discapacidades',
            'grado',
            'seccionAsignada',
            'nuevoIngreso',
            'prosecucion',
            'anioEscolar'
        ])
            // FILTRO POR AÑO ESCOLAR ACTIVO (por defecto)
            ->when($anioEscolarActivo, function($q) use ($anioEscolarActivo) {
                $q->where('anio_escolar_id', $anioEscolarActivo->id);
            })
            // Filtro por grado
            ->when($gradoId, fn($q) => $q->where('grado_id', $gradoId))
            // Filtro por sección
            ->when($seccionId, fn($q) => $q->where('seccion_id', $seccionId))
            // Filtro por tipo de inscripción
            ->when($tipoInscripcion, function($q) use ($tipoInscripcion) {
                if ($tipoInscripcion === 'nuevo_ingreso') {
                    $q->whereNotNull('nuevo_ingreso_id');
                } elseif ($tipoInscripcion === 'prosecucion') {
                    $q->whereNotNull('prosecucion_id');
                }
            })
            // Búsqueda
            ->when($buscar, function ($q) use ($buscar) {
                $q->whereHas('alumno.persona', function ($qq) use ($buscar) {
                    $qq->where('primer_nombre', 'like', "%$buscar%")
                        ->orWhere('primer_apellido', 'like', "%$buscar%")
                        ->orWhere('numero_documento', 'like', "%$buscar%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.transacciones.inscripcion.index', [
            'anioEscolarActivo' => $anioEscolarActivo ? true : false,
            'anioEscolar' => $anioEscolarActivo,
            'inscripciones' => $inscripciones,
            'grados' => $grados,
            'secciones' => $secciones,
            'buscar' => $buscar,
            'gradoId' => $gradoId,
            'seccionId' => $seccionId,
            'tipoInscripcion' => $tipoInscripcion,
            'infoCupos' => $infoCupos,
            'entradasPercentil' => $entradasPercentil,
            'seccionesResumen' => $seccionesResumen
        ]);
    }

    public function create()
    {
        $this->verificarAnioEscolar();
        $personas = Persona::all();
        $generos = Genero::all();
        $tipoDocumentos = TipoDocumento::all();
        $alumnos = Alumno::all();
        $grados = Grado::all();
        $expresion_literaria = ExpresionLiteraria::all();
        $institucion_procedencia = InstitucionProcedencia::all();

        return view('admin.transacciones.inscripcion.create', compact('personas', 'generos', 'tipoDocumentos', 'alumnos', 'grados'));
    }

    public function createProsecucion()
    {
        $this->verificarAnioEscolar();
        $personas = Persona::all();
        $generos = Genero::all();
        $tipoDocumentos = TipoDocumento::all();
        $alumnos = Alumno::all();
        $grados = Grado::all();
        $expresion_literaria = ExpresionLiteraria::all();
        $institucion_procedencia = InstitucionProcedencia::all();

        return view('admin.transacciones.inscripcion.createProsecucion', compact('personas', 'generos', 'tipoDocumentos', 'alumnos', 'grados'));
    }

    public function seccionesPorGrado($gradoId)
    {
        $secciones = Seccion::where('grado_id', $gradoId)
            ->where('status', true)
            ->orderBy('nombre')
            ->get(['id', 'nombre']);

        return response()->json($secciones);
    }

    public function createAlumno()
    {
        return redirect()->route('admin.transacciones.inscripcion.create');
    }

    public function destroy($id)
    {
        Inscripcion::inactivar($id);
        return redirect()->route('admin.transacciones.inscripcion.index')->with('success', 'Inscripción inactivada correctamente');
    }

    public function reporte($id)
    {
        $inscripcion = Inscripcion::with([
            'alumno.persona',
            'alumno.ordenNacimiento',
            'alumno.discapacidades',
            'alumno.etniaIndigena',
            'alumno.lateralidad',
            'grado',
            'padre.persona',
            'madre.persona',
            'representanteLegal.representante.persona',
            'institucionProcedencia',
            'expresionLiteraria',
            'seccionAsignada'
        ])->findOrFail($id);

        $datosCompletos = $inscripcion->obtenerDatosCompletos();

        // Obtener el año escolar activo
        $anioEscolarActivo = \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->first();

        $pdf = PDF::loadview('admin.transacciones.inscripcion.reporte.ficha_inscripcion', compact('datosCompletos', 'anioEscolarActivo'));
        return $pdf->stream('ficha_inscripcion.pdf');
    }
}