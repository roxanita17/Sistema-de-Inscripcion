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
use App\Models\AnioEscolar;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $buscar = request('buscar');
         // Se obtienen todos los alumnos ordenados por código
        $alumnos = Alumno::where('status', 'Activo')->buscar($buscar)->paginate(10);

        // Verificar si hay año escolar activo
        $anioEscolarActivo = $this->verificarAnioEscolar();

        // Se envían los datos a la vista
        return view('admin.alumnos.index', compact('alumnos', 'anioEscolarActivo', 'buscar'));
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
        $anioEscolarActivo = $this->verificarAnioEscolar();


        return view('admin.alumnos.create',compact('anioEscolarActivo',  ));
    }

    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return view('admin.alumnos.index');
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
    public function destroy($id)
    {
        Alumno::eliminar($id);
        
        return redirect()->route('admin.alumnos.index')->with('success', 'Alumno eliminado correctamente');
    }

    public function reportePDF($id){
        $alumno = Alumno::where('id', $id)
        ->with([
            'persona.tipoDocumento',
            'persona.genero',
            'institucionProcedencia',
            'expresionLiteraria',
            'ordenNacimiento',
            'lateralidad',
            'etniaIndigena'
        ])
        ->firstOrFail();

        $pdf = PDF::loadView('admin.alumnos.reportes.general_est', compact('alumno'));
        return $pdf->stream('alumno_' . $alumno->persona->numero_documento . '.pdf');
    }

public function reporteGeneralPDF(Request $request)
{
    $alumnos = Alumno::ReportePDF()
        ->map(function($alumno) {
            // Si el alumno tiene relación con persona, usar esos datos
            if (isset($alumno->persona)) {
                $alumno->primer_apellido = $alumno->persona->primer_apellido ?? 'N/A';
            }
            return $alumno;
        })
        ->sortBy(function($alumno) {
            // Ordenar por la primera letra del primer apellido
            $primerApellido = $alumno->primer_apellido ?? 
                            ($alumno->persona->primer_apellido ?? '');
            return strtoupper(substr($primerApellido, 0, 1));
        })
        ->values(); // Reindexar el array después de ordenar

    if ($alumnos->isEmpty()) {
        return response('No se encontraron alumnos con los criterios seleccionados', 404);
    }

    $pdf = PDF::loadview('admin.alumnos.reportes.Reporte_General', compact('alumnos'));
    return $pdf->stream('alumnos.pdf');
}
}
