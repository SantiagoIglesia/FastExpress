<?php

use App\Http\Controllers\ParametroController;
use App\Http\Controllers\TipoClienteController;
use App\Http\Controllers\EstadoEnvioController;
use App\Http\Controllers\TipoEnvioController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');*/

Route::apiResource('parametros', ParametroController::class);
Route::apiResource('tipos_cliente', TipoClienteController::class)->parameters(['tipos_cliente' => 'tipo_cliente']);
Route::apiResource('estados_envio', EstadoEnvioController::class)->parameters(['estados_envio' => 'estado_envio']);
Route::apiResource('tipos_envio', TipoEnvioController::class)->parameters(['tipos_envio' => 'tipo_envio']);
