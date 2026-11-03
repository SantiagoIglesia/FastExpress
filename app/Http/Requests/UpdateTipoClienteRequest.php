<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTipoClienteRequest extends TipoClienteRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $tipo_cliente = $this->route('tipo_cliente');

        return [
            'nom_tipo_cli'      => ['required', 'string', 'max:100', Rule::unique('tipos_cliente', 'nom_tipo_cli')->ignore($tipo_cliente->cod_tipo_cli, 'cod_tipo_cli')],
            'porc_descuento'    => ['required', 'numeric', 'decimal:0,2', 'min:0.1'],
        ];
    }
}
