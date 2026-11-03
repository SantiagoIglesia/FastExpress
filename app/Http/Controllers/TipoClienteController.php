<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoClienteRequest;
use App\Http\Requests\UpdateTipoClienteRequest;
use App\Models\TipoCliente;
use Illuminate\Http\Request;

class TipoClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = TipoCliente::query();

        //Listar parámetros por nombre
        if($request->filled('nom_tipo_cli')) {
            $query->where('nom_tipo_cli', $request->input('nom_tipo_cli'));
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTipoClienteRequest $request)
    {
        $tipo_cliente = TipoCliente::create($request->validated());

        return response()->json($tipo_cliente, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(TipoCliente $tipo_cliente)
    {
        return response()->json($tipo_cliente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTipoClienteRequest $request, TipoCliente $tipo_cliente)
    {
        $tipo_cliente->update($request->validated());
    
        return response()->json($tipo_cliente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TipoCliente $tipo_cliente)
    {
        $tipo_cliente->delete();

        return response()->json(['message' => 'Tipo de cliente eliminado correctamente.']);
    }
}
