<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreParametroRequest;
use App\Http\Requests\UpdateParametroRequest;
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
        if($request->filled('nom_param')) {
            $query->where('nom_param', $request->input('nom_param'));
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParametroRequest $request)
    {
        $parametro = Parametro::create($request->validated());

        return response()->json($parametro, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Parametro $parametro)
    {
        return response()->json($parametro);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateParametroRequest $request, Parametro $parametro)
    {
        $parametro->update($request->validated());
    
        return response()->json($parametro);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Parametro $parametro)
    {
        $parametro->delete();

        //return response()->json(['message' => 'Parámetro eliminado correctamente.']);
        return response()->noContent();
    }
}
