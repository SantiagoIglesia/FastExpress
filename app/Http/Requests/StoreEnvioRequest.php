<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEnvioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cliente_cod'  => ['required', 'string', 'exists:clientes,cod_cliente'],
            'tipo_env_cod' => ['required', 'integer', 'exists:tipos_envio,cod_tipo_env'],
            'peso_envio'   => ['required', 'numeric', 'min:0.01', 'decimal:0,2'],
            'estado_cod'   => ['nullable', 'integer', 'exists:estados_envio,cod_estado'],
            'fecha_envio'  => ['nullable', 'date'],
        ];
    }
}