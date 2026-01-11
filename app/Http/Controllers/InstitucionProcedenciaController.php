<?php

namespace App\Http\Controllers;

use App\Models\InstitucionProcedencia;
use Illuminate\Http\Request;

class InstitucionProcedenciaController extends Controller
{
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
