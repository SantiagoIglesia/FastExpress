<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEnvioRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tipo_env_cod' => ['sometimes', 'integer', 'exists:tipos_envio,cod_tipo_env'],
            'peso_envio'   => ['sometimes', 'numeric', 'min:0.01', 'decimal:0,2'],
            'estado_cod'   => ['sometimes', 'integer', 'exists:estados_envio,cod_estado'],
        ];
    }
}