<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Models\Persona;
use App\Models\Genero;
use App\Models\TipoDocumento;
use App\Models\Alumno;
use App\Models\Grado;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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

        $buscar = request('buscar');

        // Verificar si hay año escolar activo
        $anioEscolarActivo = $this->verificarAnioEscolar();
        $inscripciones = Inscripcion::buscar($buscar)->paginate(10);
        $grados = Grado::all();
        return view('admin.transacciones.inscripcion.index', compact('anioEscolarActivo', 'inscripciones', 'grados', 'buscar'));
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

    public function createAlumno()
    {
        

        return redirect()->route('admin.transacciones.inscripcion.create');
    }

    public function destroy($id)
    {
        Inscripcion::eliminar($id);
        
        return redirect()->route('admin.transacciones.inscripcion.index')->with('success', 'Inscripción eliminada correctamente');
    }

    //reportes PDF

    public function reporte(Request $request)
    {
        $inscripciones = Inscripcion::obtenerDatosInscripcion();
        
        if ($inscripciones->isEmpty()) {
            return response('No hay datos de inscripción disponibles', 404);
        }
        // Obtener el primer registro 
        $inscripcion = $inscripciones->first();
        
        $pdf = PDF::loadView('admin.inscripcion.reporte.ficha_inscripcion', ['data' => $inscripcion]);

        return $pdf->stream('ficha_inscripcion' . ($inscripcion->estudiante_cedula ?? '') . '.pdf');
    }
}
