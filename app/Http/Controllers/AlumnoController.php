<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Discapacidad;
use App\Models\EtniaIndigena;
use App\Models\ExpresionLiteraria;
use App\Models\InstitucionProcedencia;
use App\Models\Lateralidad;
use App\Models\OrdenNacimiento;
use App\Models\Persona;
use App\Models\TipoDocumento;
use App\Models\Genero;
use App\Models\Localidad;
use App\Models\Municipio;
use App\Models\Estado;

use Illuminate\Http\Request;


class AlumnoController extends Controller
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
    public function index()
    {
         // Se obtienen todos los alumnos ordenados por código
        $alumnos = Alumno::where('status', 'Activo')->paginate(10);

        // Verificar si hay año escolar activo
        $anioEscolarActivo = $this->verificarAnioEscolar();

        // Se envían los datos a la vista
        return view('admin.alumnos.index', compact('alumnos', 'anioEscolarActivo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $orden_nacimiento = OrdenNacimiento::all();
        $discapacidad = Discapacidad::all();
        $etnia_indigena = EtniaIndigena::all();
        $expresion_literaria= ExpresionLiteraria::all();
        $lateralidad = Lateralidad::all();
        $institucion_procedencia = InstitucionProcedencia::all();
        $persona = Persona::all();
        $tipo_documento = TipoDocumento::all();
        $genero = Genero::all();
        $localidad = Localidad::all();
        $municipio = Municipio::all();
        $estado = Estado::all();


        $alumnos = Alumno::all();
        return view('admin.alumnos.create', compact('persona',  'alumnos', 'orden_nacimiento', 'discapacidad', 'etnia_indigena', 'expresion_literaria', 'lateralidad', 'institucion_procedencia', 'tipo_documento', 'genero', 'localidad', 'municipio', 'estado'));

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
    public function show(Alumno $alumno)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumno $alumno)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumno $alumno)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumno $alumno)
    {
        //
    }
}
