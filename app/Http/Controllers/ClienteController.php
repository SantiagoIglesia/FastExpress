<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClienteRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cliente::query();

        //Listar parámetros por nombre
        if($request->filled('nom_cliente')) {

            $query->where('nom_cliente', $request->input('nom_cliente'));

        } elseif($request->filled('seg_nom_cliente')) {

            $query->where('seg_nom_cliente', $request->input('seg_nom_cliente'));

        } elseif($request->filled('ape_cliente')) {

            $query->where('ape_cliente', $request->input('ape_cliente'));

        } elseif($request->filled('seg_ape_cliente')) {

            $query->where('seg_ape_cliente', $request->input('seg_ape_cliente'));

        } elseif($request->filled('tel_cliente')) {

            $query->where('tel_cliente', $request->input('tel_cliente'));

        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClienteRequest $request)
    {
        $cliente = Cliente::create($request->validated());

        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        return response()->json($cliente);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        $cliente->update($request->validated());
    
        return response()->json($cliente);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();

        return response()->json(['message' => 'Cliente eliminado correctamente.']);
    }
}
