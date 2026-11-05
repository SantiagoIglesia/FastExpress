<?php

namespace App\Http\Controllers;

use App\Http\Requests\CotizarEnvioRequest;
use App\Http\Requests\StoreEnvioRequest;
use App\Http\Requests\UpdateEnvioRequest;
use App\Models\Cliente;
use App\Models\Envio;
use App\Models\EstadoEnvio;
use App\Services\CotizadorEnvioService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnvioController extends Controller
{
    private const RELACIONES = ['cliente', 'estado', 'tipoEnvio', 'rangoPeso'];

    public function __construct(private CotizadorEnvioService $cotizador)
    {
    }

    public function index(Request $request)
    {
        $query = Envio::with(self::RELACIONES);

        foreach (['peso_envio', 'cliente_cod', 'estado_cod', 'tipo_env_cod', 'rango_cod'] as $campo) {
            if ($request->filled($campo)) {
                $query->where($campo, $request->input($campo));
            }
        }

        if ($request->filled('fecha_envio')) {
            $query->whereDate('fecha_envio', $request->input('fecha_envio'));
        }

        return response()->json($query->get());
    }

    // Calcula sin guardar (para la pantalla de cotización)
    public function cotizar(CotizarEnvioRequest $request)
    {
        $datos = $request->validated();

        return response()->json($this->cotizador->cotizar(
            (float) $datos['peso_envio'],
            $datos['cliente_cod'],
            (int) $datos['tipo_env_cod']
        ));
    }

    public function store(StoreEnvioRequest $request)
    {
        $datos = $request->validated();

        $envio = DB::transaction(function () use ($datos) {
            $calculo = $this->cotizador->cotizar(
                (float) $datos['peso_envio'],
                $datos['cliente_cod'],
                (int) $datos['tipo_env_cod']
            );

            $calculo['estado_cod']  = $datos['estado_cod']
                ?? EstadoEnvio::orderBy('cod_estado')->value('cod_estado');
            $calculo['fecha_envio'] = $datos['fecha_envio'] ?? now();

            $envio = Envio::create($calculo);

            Cliente::where('cod_cliente', $datos['cliente_cod'])->increment('cant_env');

            return $envio;
        });

        return response()->json($envio->load(self::RELACIONES), 201);
    }

    public function show(Envio $envio)
    {
        return response()->json($envio->load(self::RELACIONES));
    }

    public function update(UpdateEnvioRequest $request, Envio $envio)
    {
        $datos = $request->validated();

        DB::transaction(function () use ($datos, $envio) {
            if (isset($datos['peso_envio']) || isset($datos['tipo_env_cod'])) {
                $calculo = $this->cotizador->cotizar(
                    (float) ($datos['peso_envio'] ?? $envio->peso_envio),
                    $envio->cliente_cod,
                    (int) ($datos['tipo_env_cod'] ?? $envio->tipo_env_cod)
                );
                $envio->update($calculo);
            }

            if (isset($datos['estado_cod'])) {
                $envio->update(['estado_cod' => $datos['estado_cod']]);
            }
        });

        return response()->json($envio->fresh(self::RELACIONES));
    }

    public function destroy(Envio $envio)
    {
        DB::transaction(function () use ($envio) {
            Cliente::where('cod_cliente', $envio->cliente_cod)
                ->where('cant_env', '>', 0)
                ->decrement('cant_env');

            $envio->delete();
        });

        return response()->json(['message' => 'Envío eliminado correctamente.']);
    }
}
