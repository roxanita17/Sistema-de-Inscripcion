<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
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
