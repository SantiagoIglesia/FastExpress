<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTipoClienteRequest extends TipoClienteRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom_tipo_cli'      => ['required', 'string', 'max:100', 'unique:tipos_cliente,nom_tipo_cli'],
            'porc_descuento'    => ['required', 'numeric', 'decimal:0,2', 'min:0.1'],
        ];
    }
}
