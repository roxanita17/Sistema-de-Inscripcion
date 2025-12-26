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

        // ================= DOCENTES =================
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

        // ================= INSCRIPCIONES =================

        // NUEVO INGRESO
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

        // PROSECUCIÓN
        if ($modalidad === 'prosecucion') {
            $inscripciones = InscripcionProsecucion::with([
                'inscripcion.anioEscolar', // Año de la inscripción base
                'inscripcion.alumno.persona',
                'inscripcion.grado', // Grado de la inscripción base (de donde viene)
                'inscripcion.seccion',
                'anioEscolar', // Año de la prosecución
                'grado', // Grado al que fue promovido
                'seccion' // Sección a la que fue asignado
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

        // TODAS LAS INSCRIPCIONES (sin filtro de modalidad)
        $inscripciones = Inscripcion::with([
            'anioEscolar',
            'alumno.persona',
            'grado',
            'seccion',
            'seccionAsignada',
            'nuevoIngreso',
            'prosecucion.grado', // Para obtener el grado de promoción
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
