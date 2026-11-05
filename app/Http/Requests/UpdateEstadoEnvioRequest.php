<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEstadoEnvioRequest extends EstadoEnvioRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $estado_envio = $this->route('estado_envio');

        return [
            'nom_estado'    => ['required', 'string', 'max:100', Rule::unique('estados_envio', 'nom_estado')->ignore($estado_envio->cod_estado, 'cod_estado')],
        ];
    }
}
