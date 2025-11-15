<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AnioEscolar;
use Symfony\Component\HttpFoundation\Response;

class VerificarAnioEscolarActivo
{
    /**
     * Maneja la solicitud entrante.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Excluir rutas relacionadas con año escolar
        $rutasExcluidas = [
            'admin.anio_escolar.*',
            'logout',
            'login',
        ];

        // Si la ruta actual está excluida, permitir acceso
        foreach ($rutasExcluidas as $patron) {
            if ($request->routeIs($patron)) {
                return $next($request);
            }
        }

        // Verificar si existe un año escolar activo
        $anioEscolarActivo = AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();

        if (!$anioEscolarActivo) {
            // Si es una petición AJAX (Livewire), retornar error JSON
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'error' => 'Debe registrar un año escolar activo para continuar.'
                ], 403);
            }

            // Para solicitudes normales, redirigir con mensaje
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('warning', 'Debe registrar un año escolar activo antes de acceder a este módulo.');
        }

        return $next($request);
    }

    public function store(Request $request)
    {
        // Verificación adicional (opcional, el middleware ya lo hace)
        $anioEscolarActivo = AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();

        if (!$anioEscolarActivo) {
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('warning', 'Debe registrar un año escolar activo.');
        }

        // ... resto del código existente
    }
}