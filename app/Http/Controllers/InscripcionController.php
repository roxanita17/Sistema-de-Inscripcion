<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Models\Persona;
use App\Models\Genero;
use App\Models\TipoDocumento;
use App\Models\Alumno;
use App\Models\Grado;

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
    public function index()
    {
        // Verificar si hay año escolar activo
        $anioEscolarActivo = $this->verificarAnioEscolar();
        $inscripciones = Inscripcion::paginate(10);
        $grados = Grado::all();
        return view('admin.transacciones.inscripcion.index', compact('anioEscolarActivo', 'inscripciones', 'grados'));
    }

    public function create()
    {
        $this->verificarAnioEscolar();
        $personas = Persona::all();
        $generos = Genero::all();
        $tipoDocumentos = TipoDocumento::all();
        $alumnos = Alumno::all();
        $grados = Grado::all();

        return view('admin.transacciones.inscripcion.create', compact('personas', 'generos', 'tipoDocumentos', 'alumnos', 'grados'));
    }

    public function destroy($id)
    {
        Inscripcion::eliminar($id);
        
        return redirect()->route('admin.transacciones.inscripcion.index')->with('success', 'Inscripción eliminada correctamente');
    }
}
