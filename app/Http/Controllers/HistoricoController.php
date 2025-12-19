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

        $anios = AnioEscolar::orderBy('inicio_anio_escolar', 'desc')->get();

        if ($tipo === 'docentes') {
            $docentes = Docente::with([
                'persona',
                'anioEscolar',
                'asignacionesAreas.grado',
                'asignacionesAreas.areaEstudios.areaFormacion'
            ])
                ->when($anioEscolarId, function ($q) use ($anioEscolarId) {
                    $q->where('anio_escolar_id', $anioEscolarId);
                })
                ->paginate(10)
                ->withQueryString();

            return view('admin.historico.index', compact(
                'docentes',
                'anios',
                'anioEscolarId',
                'tipo'
            ));
        }

        // INSCRIPCIONES (default)
        $inscripciones = Inscripcion::with([
            'anioEscolar',
            'alumno.persona',
            'grado',
            'seccionAsignada'
        ])
            ->when($anioEscolarId, function ($q) use ($anioEscolarId) {
                $q->where('anio_escolar_id', $anioEscolarId);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.historico.index', compact(
            'inscripciones',
            'anios',
            'anioEscolarId',
            'tipo'
        ));
    }
}
