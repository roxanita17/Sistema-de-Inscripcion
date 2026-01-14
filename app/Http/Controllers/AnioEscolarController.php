<?php

namespace App\Http\Controllers;

use App\Models\AnioEscolar;
use App\Services\AnioEscolarService;
use App\Http\Requests\StoreAnioEscolarRequest;
use App\Http\Requests\ExtenderAnioEscolarRequest;

class AnioEscolarController extends Controller
{
    protected $anioEscolarService;

    public function __construct(AnioEscolarService $anioEscolarService)
    {
        $this->anioEscolarService = $anioEscolarService;
    }

    private function verificarAnioEscolar()
    {
        return AnioEscolar::where('status', 'Activo')
            ->orWhere('status', 'Extendido')
            ->exists();
    }

    public function index()
    {
        $escolar = AnioEscolar::orderBy('inicio_anio_escolar', 'desc')->paginate(10);
        $anioEscolarActivo = $this->verificarAnioEscolar();
        return view('admin.anio_escolar.index', compact('escolar', 'anioEscolarActivo'));
    }

    public function store(StoreAnioEscolarRequest $request)
    {
        $resultado = $this->anioEscolarService->crear($request->validated());

        if ($resultado['success']) {
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('success', 'Año escolar creado correctamente.');
        }

        return redirect()
            ->route('admin.anio_escolar.index')
            ->with('error', $resultado['error']);
    }

    public function extender(ExtenderAnioEscolarRequest $request, $id)
    {
        $resultado = $this->anioEscolarService->extender($id, $request->cierre_anio_escolar);

        if ($resultado['success']) {
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('success', 'Año escolar extendido correctamente.');
        }

        return redirect()
            ->route('admin.anio_escolar.index')
            ->with('error', $resultado['error']);
    }

    public function destroy($id)
    {
        $resultado = $this->anioEscolarService->inactivar($id);

        if ($resultado['success']) {
            return redirect()
                ->route('admin.anio_escolar.index')
                ->with('success', 'Año escolar inactivado correctamente.');
        }

        return redirect()
            ->route('admin.anio_escolar.index')
            ->with('error', $resultado['error']);
    }
}
