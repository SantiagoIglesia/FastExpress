<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTipoEnvioRequest extends TipoEnvioRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom_tipo_env'  => ['required', 'string', 'max:100', 'unique:tipos_envio,nom_tipo_env'],
            'porc_recargo'  => ['required', 'numeric', 'decimal:0,2', 'min:0.1'],
        ];
    }
}
