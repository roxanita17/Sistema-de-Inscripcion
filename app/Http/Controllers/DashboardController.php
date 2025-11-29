<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Estudiante;
use App\Models\Docente;
use App\Models\Grado;
use App\Models\AnioEscolar;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas principales
        /* $totalEstudiantes = Estudiante::whereHas('persona', function($q) {
            $q->where('status', true);
        })->where('status', true)->count(); */

        $totalDocentes = Docente::whereHas('persona', function($query) {
            $query->where('status', true);
        })
        ->where('status', true)
        ->count();

        $totalGrados = Grado::total();

        // Año escolar activo
        $anioEscolar = AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->first();
        
        $anioEscolarActivo = $anioEscolar 
            ? $anioEscolar->inicio_anio_escolar->format('Y') . '-' . $anioEscolar->cierre_anio_escolar->format('Y')
            : 'No definido';

        // Total de usuarios
        $totalUsuarios = User::count();

        // Actividades recientes (opcional)
        // Puedes crear un modelo de "ActivityLog" o usar un package como spatie/laravel-activitylog
        $actividadesRecientes = []; // Por ahora vacío

        return view('dashboard', compact(
            'totalEstudiantes',
            'totalDocentes',
            'totalGrados',
            'anioEscolarActivo',
            'totalUsuarios',
            'actividadesRecientes'
        ));
    }
}