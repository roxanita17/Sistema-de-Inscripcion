<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnioEscolar;
use App\Models\Docente;
use App\Models\DocenteAreaGrado;
use App\Models\Inscripcion;
use App\Models\InscripcionNuevoIngreso;
use App\Models\InscripcionProsecucion;

class HistoricoController extends Controller
{
    public function index(Request $request)
    {
        $anioEscolarId = $request->anio_escolar_id;
        $tipo = $request->get('tipo', 'inscripciones');
        $modalidad = $request->get('modalidad');
        $anios = AnioEscolar::orderBy('inicio_anio_escolar', 'desc')->get();
        if ($tipo === 'docentes') {
            $docentes = Docente::with([
                'persona',
                'anioEscolar',
                'asignacionesAreas.grado',
                'asignacionesAreas.areaEstudios.areaFormacion'
            ])
                ->when($anioEscolarId, fn($q) => $q->where('anio_escolar_id', $anioEscolarId))
                ->paginate(10)
                ->withQueryString();

            return view('admin.historico.index', compact(
                'docentes',
                'anios',
                'anioEscolarId',
                'tipo',
                'modalidad'
            ));
        }

        if ($modalidad === 'nuevo_ingreso') {
            $inscripciones = Inscripcion::with([
                'anioEscolar',
                'alumno.persona',
                'grado',
                'seccion',
                'seccionAsignada',
                'nuevoIngreso.institucionProcedencia',
                'nuevoIngreso.expresionLiteraria'
            ])
                ->whereHas('nuevoIngreso')
                ->when($anioEscolarId, fn($q) => $q->where('anio_escolar_id', $anioEscolarId))
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();

            return view('admin.historico.index', compact(
                'inscripciones',
                'anios',
                'anioEscolarId',
                'tipo',
                'modalidad'
            ));
        }

        if ($modalidad === 'prosecucion') {
            $inscripciones = InscripcionProsecucion::with([
                'inscripcion.anioEscolar',
                'inscripcion.alumno.persona',
                'inscripcion.grado',
                'inscripcion.seccion',
                'anioEscolar',
                'grado',
                'seccion'
            ])
                ->where('status', 'Activo')
                ->when($anioEscolarId, fn($q) => $q->where('anio_escolar_id', $anioEscolarId))
                ->orderBy('created_at', 'desc')
                ->paginate(10)
                ->withQueryString();

            return view('admin.historico.index', compact(
                'inscripciones',
                'anios',
                'anioEscolarId',
                'tipo',
                'modalidad'
            ));
        }

        $inscripciones = Inscripcion::with([
            'anioEscolar',
            'alumno.persona',
            'grado',
            'seccion',
            'seccionAsignada',
            'nuevoIngreso',
            'prosecucion.grado',
            'prosecucion.seccion'
        ])
            ->whereNull('deleted_at')
            ->when($anioEscolarId, fn($q) => $q->where('anio_escolar_id', $anioEscolarId))
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.historico.index', compact(
            'inscripciones',
            'anios',
            'anioEscolarId',
            'tipo',
            'modalidad'
        ));
    }
}
