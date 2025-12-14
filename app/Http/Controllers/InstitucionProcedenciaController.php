<?php

namespace App\Http\Controllers;

use App\Models\InstitucionProcedencia;
use Illuminate\Http\Request;

class InstitucionProcedenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
    public function show(InstitucionProcedencia $institucionProcedencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InstitucionProcedencia $institucionProcedencia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InstitucionProcedencia $institucionProcedencia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InstitucionProcedencia $institucionProcedencia)
    {
        //
    }

    /**
     * Verifica si una institución ya existe
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verificarExistencia(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:150',
            ]);

            $existe = InstitucionProcedencia::where('nombre_institucion', $request->nombre)
                ->exists();

            return response()->json([
                'success' => true,
                'existe' => $existe
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Error en verificarExistencia: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar la institución',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
