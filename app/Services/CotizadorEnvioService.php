<?php

namespace App\Services;

use App\Models\Cliente;
use App\Models\Parametro;
use App\Models\RangoPeso;
use App\Models\TipoEnvio;
use Illuminate\Validation\ValidationException;

/**
 * Reglas de negocio de FastExpress (BR-01 a BR-04).
 * Toda la lógica de cálculo vive aquí para poder probarla (caja blanca)
 * sin pasar por HTTP.
 */
class CotizadorEnvioService
{
    /**
     * Busca los datos en la BD y delega el cálculo a calcular().
     * Devuelve los campos listos para guardar en la tabla envios.
     */
    public function cotizar(float $peso, string $clienteCod, int $tipoEnvCod): array
    {
        // BR-02: el rango se busca por peso. Si ninguno lo cubre (> 20 kg) se rechaza.
        $rango = RangoPeso::where('peso_min', '<=', $peso)
            ->where('peso_max', '>=', $peso)
            ->first();

        if (!$rango) {
            throw ValidationException::withMessages([
                'peso_envio' => 'Límite excedido: el peso no está dentro de ningún rango permitido.',
            ]);
        }

        // BR-01: tarifa base desde la tabla parametros.
        $parametro = Parametro::where('nom_param', 'TARIFA_BASE')->first();
        if (!$parametro) {
            abort(500, 'Falta el parámetro TARIFA_BASE en la tabla parametros.');
        }

        // BR-03: descuento según el tipo del cliente.
        $cliente     = Cliente::with('tipoCliente')->findOrFail($clienteCod);
        // BR-04: recargo según el tipo de envío.
        $tipoEnvio   = TipoEnvio::findOrFail($tipoEnvCod);

        $calculo = $this->calcular(
            $peso,
            (float) $parametro->valor,
            (float) $rango->valor_peso,
            (float) $cliente->tipoCliente->porc_descuento,
            (float) $tipoEnvio->porc_recargo
        );

        return $calculo + [
            'cliente_cod'  => $cliente->cod_cliente,
            'tipo_env_cod' => $tipoEnvio->cod_tipo_env,
            'rango_cod'    => $rango->cod_rango,
        ];
    }

    /**
     * Cálculo puro (sin BD). Los porcentajes llegan como 10 = 10 %.
     *
     *  subtotal = tarifa_base + (peso * valor_por_kg)
     *  descuento = subtotal * %desc
     *  recargo   = subtotal * %rec
     *  total     = subtotal - descuento + recargo
     */
    public function calcular(
        float $peso,
        float $tarifaBase,
        float $valorPorKg,
        float $porcDescuento,
        float $porcRecargo
    ): array {
        $costoPeso = round($peso * $valorPorKg, 2);
        $subtotal  = round($tarifaBase + $costoPeso, 2);
        $valorDesc = round($subtotal * $porcDescuento / 100, 2);
        $valorRec  = round($subtotal * $porcRecargo / 100, 2);
        $total     = round($subtotal - $valorDesc + $valorRec, 2);

        return [
            'peso_envio'        => round($peso, 2),
            'tarifa_base_envio' => round($tarifaBase, 2),
            'costo_peso_envio'  => $costoPeso,
            'subtotal_envio'    => $subtotal,
            'porc_desc_envio'   => $porcDescuento,
            'valor_desc_envio'  => $valorDesc,
            'porc_rec_envio'    => $porcRecargo,
            'valor_rec_envio'   => $valorRec,
            'total_envio'       => $total,
        ];
    }
}
