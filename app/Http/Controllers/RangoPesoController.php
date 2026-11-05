<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRangoPesoRequest;
use App\Http\Requests\UpdateRangoPesoRequest;
use App\Models\RangoPeso;
use Illuminate\Http\Request;

class RangoPesoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = RangoPeso::query();

        //Listar parámetros por nombre
        if($request->filled('peso_min')) {

            $query->where('peso_min', $request->input('peso_min'));

        } elseif($request->filled('peso_max')) {

            $query->where('peso_max', $request->input('peso_max'));
        }

        return response()->json($query->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRangoPesoRequest $request)
    {
        $rango_peso = RangoPeso::create($request->validated());

        return response()->json($rango_peso, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RangoPeso $rango_peso)
    {
        return response()->json($rango_peso);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRangoPesoRequest $request, RangoPeso $rango_peso)
    {
        $rango_peso->update($request->validated());
    
        return response()->json($rango_peso);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RangoPeso $rango_peso)
    {
        $rango_peso->delete();

        return response()->json(['message' => 'Rango de peso eliminado correctamente.']);
    }
}
