<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnioEscolar;
use App\Models\Docente;
use App\Models\DocenteAreaGrado;
use App\Models\Inscripcion;

class HistoricoController extends Controller
{

    public function index(Request $request)
    {
        $anioEscolarId = $request->anio_escolar_id;
        $tipo = $request->get('tipo', 'inscripciones');
        $modalidad = $request->get('modalidad'); // 👈 NUEVO

        $anios = AnioEscolar::orderBy('inicio_anio_escolar', 'desc')->get();

        // ================= DOCENTES =================
        if ($tipo === 'docentes') {
            $docentes = Docente::with([
                'persona',
                'anioEscolar',
                'asignacionesAreas.grado',
                'asignacionesAreas.areaEstudios.areaFormacion'
            ])
                ->when(
                    $anioEscolarId,
                    fn($q) =>
                    $q->where('anio_escolar_id', $anioEscolarId)
                )
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
        $inscripciones = Inscripcion::with([
            'anioEscolar',
            'alumno.persona',
            'grado',
            'seccionAsignada',
            'nuevoIngreso',
            'prosecucion'
        ])
            ->when(
                $anioEscolarId,
                fn($q) =>
                $q->where('anio_escolar_id', $anioEscolarId)
            )

            // 👉 FILTRO POR MODALIDAD
            ->when(
                $modalidad === 'nuevo_ingreso',
                fn($q) =>
                $q->whereHas('nuevoIngreso')
                    ->whereDoesntHave('prosecucion')
            )
            ->when(
                $modalidad === 'prosecucion',
                fn($q) =>
                $q->whereHas('prosecucion')
            )

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
