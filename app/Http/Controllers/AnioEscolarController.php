<?php

namespace App\Http\Controllers;

use App\Models\AnioEscolar;
use Illuminate\Http\Request;

class AnioEscolarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $escolar = AnioEscolar::all();
        return view('admin.anio_escolar.index', compact('escolar'));
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
    public function show(AnioEscolar $anioEscolar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AnioEscolar $anioEscolar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AnioEscolar $anioEscolar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $libro = AnioEscolar::find($id);
        if ($libro) {
            $libro->update([
                'estatus' => 'Inactivo',
            ]);
            return redirect()->route('admin.anio_escolar.index')->with('success', 'Anio eliminado correctamente.');
        }

        return redirect()->route('admin.anio_escolar.index')->with('error', 'Anio no encontrado.');
    }
}
