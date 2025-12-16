<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AnioEscolar;
use App\Models\Inscripcion;

class HistoricoController extends Controller
{
    public function index(Request $request)
    {
        $anioEscolarId = $request->anio_escolar_id;

        $anios = AnioEscolar::orderBy('inicio_anio_escolar', 'desc')->get();

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
            ->withQueryString(); // mantiene el filtro al paginar

        return view(
            'admin.historico.index',
            compact('inscripciones', 'anios', 'anioEscolarId')
        );
    }
}
