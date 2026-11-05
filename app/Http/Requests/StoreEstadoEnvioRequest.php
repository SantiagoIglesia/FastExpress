<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreEstadoEnvioRequest extends EstadoEnvioRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom_estado'    => ['required', 'string', 'max:100', 'unique:estados_envio,nom_estado'],
        ];
    }
}
