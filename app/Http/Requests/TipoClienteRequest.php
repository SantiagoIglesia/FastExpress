<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

abstract class TipoClienteRequest extends FormRequest
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
    public function messages(): array
    {
        return [
            'nom_tipo_cli.required'     => 'El nombre debe ser digitado.',
            'nom_tipo_cli.string'       => 'El nombre debe contener caracteres alfanuméricos.',
            'nom_tipo_cli.max'          => 'El nombre debe tener máximo 100 caracteres.',
            'nom_tipo_cli.unique'       => 'Ya existe un tipo de cliente con ese nombre.',
            'porc_descuento.required'   => 'El porcentaje debe ser digitado.',
            'porc_descuento.numeric'    => 'El porcentaje debe ser numérico.',
            'porc_descuento.decimal'    => 'El porcentaje admite máximo 2 decimales.',
            'porc_descuento.min'        => 'El porcentaje debe ser al menos 0.1.',
        ];
    }
}
