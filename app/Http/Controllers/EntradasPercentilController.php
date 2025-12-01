<?php

namespace App\Http\Controllers;

use App\Models\EntradasPercentil;
use Illuminate\Http\Request;
use App\Models\Inscripcion;

class EntradasPercentilController extends Controller
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

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $anioEscolarActivo = $this->verificarAnioEscolar();

        $gradoId = $request->grado_id; // llega desde un botón o selector

        $entradasPercentil = EntradasPercentil::with(['inscripcion.estudiante', 'seccion'])
            ->whereHas('inscripcion', function($q) use ($gradoId) {
                if ($gradoId) {
                    $q->where('grado_id', $gradoId);
                }
            })
            ->paginate(10);

        return view('admin.transacciones.percentil.index', compact('entradasPercentil', 'anioEscolarActivo'));
    }


    public function store(Inscripcion $inscripcion)
    {
        $entrada = app(\App\Services\PercentilService::class)
                    ->crearEntradaDesdeInscripcion($inscripcion);

        return response()->json($entrada);
    }




    /**
     * Display the specified resource.
     */
    public function show(EntradasPercentil $entradasPercentil)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EntradasPercentil $entradasPercentil)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EntradasPercentil $entradasPercentil)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EntradasPercentil $entradasPercentil)
    {
        //
    }
}
