<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Models\Persona;
use App\Models\Genero;
use App\Models\TipoDocumento;
use App\Models\Alumno;
use App\Models\Grado;
use App\Models\ExpresionLiteraria;
use App\Models\InstitucionProcedencia;

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
        // Obtener todos los grados
        $grados = Grado::where('status', true)->get();

        $grado1 = Grado::find(1); // O usa: Grado::where('nombre', '1er Año')->first();

        if ($grado1) {
            $inscritos = Inscripcion::where('grado_id', 1)
                ->where('status', 'Activo')
                ->count();

            $infoCupos = [
                'nombre_grado' => $grado1->nombre,
                'total_cupos' => $grado1->capacidad_max,
                'cupos_ocupados' => $inscritos,
                'cupos_disponibles' => $grado1->capacidad_max - $inscritos,
                'porcentaje_ocupacion' => $grado1->capacidad_max > 0
                    ? round(($inscritos / $grado1->capacidad_max) * 100, 2)
                    : 0
            ];
        }



        // Verificar si hay año escolar activo
        $anioEscolarActivo = $this->verificarAnioEscolar();
        $inscripciones = Inscripcion::buscar($buscar)->paginate(10);
        $grados = Grado::all();
        return view('admin.transacciones.inscripcion.index', compact('anioEscolarActivo', 'inscripciones', 'grados', 'buscar', 'infoCupos'));
    }

    public function create()
    {
        $this->verificarAnioEscolar();
        $personas = Persona::all();
        $generos = Genero::all();
        $tipoDocumentos = TipoDocumento::all();
        $alumnos = Alumno::all();
        $grados = Grado::all();
        $expresion_literaria = ExpresionLiteraria::all();
        $institucion_procedencia = InstitucionProcedencia::all();

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
}
