<?php

namespace App\Http\Controllers;

use App\Models\ExpresionLiteraria;
use Illuminate\Http\Request;

class ExpresionLiterariaController extends Controller
{
    public function index()
    {
        $expresionLiteraria = ExpresionLiteraria::orderBy('letra_expresion_literaria', 'asc')->get();
        return view('admin.expresion_literaria.index', compact('expresionLiteraria'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'letra_expresion_literaria' => ['required', 'regex:/^[A-Za-z]$/'],
        ]);

        try {
            ExpresionLiteraria::create([
                'letra_expresion_literaria' => strtoupper($request->letra_expresion_literaria),
                'status' => 1,
            ]);

            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('success', 'Expresión literaria creada exitosamente.');
        } catch (\Exception $e) {
            return redirect()
                ->route('admin.expresion_literaria.index')
                ->with('error', 'Error al crear la expresión literaria: ' . $e->getMessage());
        }
    }

    public function update(Request $request, ExpresionLiteraria $expresionLiteraria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ExpresionLiteraria $expresionLiteraria)
    {
        //
    }
}
