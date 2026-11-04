<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEstadoEnvioRequest;
use App\Http\Requests\UpdateEstadoEnvioRequest;
use App\Models\EstadoEnvio;
use Illuminate\Http\Request;

class EstadoEnvioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = EstadoEnvio::query();

        //Listar parámetros por nombre
        if($request->filled('nom_estado')) {
            $query->where('nom_estado', $request->input('nom_estado'));
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEstadoEnvioRequest $request)
    {
        $estado_envio = EstadoEnvio::create($request->validated());

        return response()->json($estado_envio, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(EstadoEnvio $estado_envio)
    {
        return response()->json($estado_envio);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEstadoEnvioRequest $request, EstadoEnvio $estado_envio)
    {
        $estado_envio->update($request->validated());
    
        return response()->json($estado_envio);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstadoEnvio $estado_envio)
    {
        $estado_envio->delete();

        return response()->json(['message' => 'Estado eliminado correctamente.']);
    }
}
