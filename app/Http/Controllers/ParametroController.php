<?php

namespace App\Http\Controllers;

use App\Models\Parametro;
use Illuminate\Http\Request;

class ParametroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Parametro::query();

        //Listar parámetros por nombre
        if($request->has('nom_param')) {
            $query->where('nom_param', $request->input('nom_param'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom_param' => 'required|string|max:100',
            'valor' => 'required|integer|min:0.1'
        ]);

        $parametro = Parametro::create($validated);

        return response()->json($parametro, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $parametro = Parametro::findOrFail($id);

        return response()->json($parametro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $parametro = Parametro::findOrFail($id);

        $validated = $request->validate([
            'nom_param' => 'required|string|max:100',
            'valor' => 'required|integer|min:0.1'
        ]);

        $parametro = Parametro::update($validated);

        return response()->json($parametro);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $parametro = Parametro::findOrFail($id);
        $parametro->delete();

        return response()->json(['message' => 'Parámetro eliminado correctamente.']);
    }
}
