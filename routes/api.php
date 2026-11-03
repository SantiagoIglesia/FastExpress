<?php

use App\Http\Controllers\ParametroController;
use App\Http\Controllers\TipoClienteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::apiResource('parametros', ParametroController::class);
Route::apiResource('tipos_cliente', TipoClienteController::class)->parameters(['tipos_cliente' => 'tipo_cliente']);
