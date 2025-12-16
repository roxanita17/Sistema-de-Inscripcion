<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Grado;
use App\Models\Docente;
use App\Models\AnioEscolar;
use App\Models\Inscripcion;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalGrados = Grado::where('status', true)->count();

        $totalUsuarios = User::count();

        $totalDocentes = Docente::whereHas('persona', function($query) {
            $query->where('status', true);
        })
        ->where('status', true)
        ->count();

        $totalInscripciones = Inscripcion::where('status', 'Activo')->count();

        $totalEstudiantes = Alumno::where('status', 'Activo')->count();

        // Año escolar activo
        $anioEscolar = AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->first();
        
        $anioEscolarActivo = $anioEscolar 
            ? $anioEscolar->inicio_anio_escolar->format('Y') . '-' . $anioEscolar->cierre_anio_escolar->format('Y')
            : 'No definido';



        return view('home', compact('totalUsuarios', 'totalGrados', 'totalDocentes', 'totalEstudiantes', 'anioEscolarActivo', 'totalInscripciones'));
    }
}
