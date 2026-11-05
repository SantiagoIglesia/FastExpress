<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoEnvioRequest;
use App\Http\Requests\UpdateTipoEnvioRequest;
use App\Models\TipoEnvio;
use Illuminate\Http\Request;

class TipoEnvioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TipoEnvio::query();

        //Listar parámetros por nombre
        if($request->filled('nom_tipo_env')) {
            $query->where('nom_tipo_env', $request->input('nom_tipo_env'));
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoEnvioRequest $request)
    {
        $tipo_envio = TipoEnvio::create($request->validated());

        return response()->json($tipo_envio, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoEnvio $tipo_envio)
    {
        return response()->json($tipo_envio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoEnvioRequest $request, TipoEnvio $tipo_envio)
    {
        $tipo_envio->update($request->validated());
    
        return response()->json($tipo_envio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoEnvio $tipo_envio)
    {
        $tipo_envio->delete();

        return response()->json(['message' => 'Tipo de envío eliminado correctamente.']);
    }
}
