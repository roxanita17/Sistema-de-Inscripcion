<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use Illuminate\Http\Request;
use App\Models\Grado;
use App\Services\SectionDistributorService;

class InscripcionController extends Controller
{


    private function verificarAnioEscolar()
    {
        return \App\Models\AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Grado $grado)
    {
        $anioEscolarActivo = $this->verificarAnioEscolar();
        $inscripciones = Inscripcion::where('grado_id', $grado->id)
            ->with(['alumno.persona', 'representante.persona', 'grado'])
            ->paginate(10);

        return view('admin.transacciones.inscripcion.index', compact('inscripciones', 'anioEscolarActivo', 'grado'));
    }

    public function generarSecciones($gradoId)
    {
        $grado = Grado::findOrFail($gradoId);
        $servicio = app(SectionDistributorService::class);
        $resultado = $servicio->procesarGrado($grado);
        return back()->with('success', "Secciones generadas: {$resultado['total_secciones']}");
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inscripcion $inscripcion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inscripcion $inscripcion)
    {
        //
    }
}
