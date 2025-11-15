<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AnioEscolar;
use Symfony\Component\HttpFoundation\Response;

class VerificarAniosVencidos
{
    /**
     * Verifica y desactiva años escolares vencidos en cada request
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Solo verificar una vez por día por sesión para no sobrecargar
        $cacheKey = 'anios_verificados_' . date('Y-m-d');
        
        if (!session()->has($cacheKey)) {
            AnioEscolar::inactivarVencidos();
            session([$cacheKey => true]);
        }

        return $next($request);
    }
}