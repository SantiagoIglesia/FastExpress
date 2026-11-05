<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

abstract class ParametroRequest extends FormRequest
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
            'nom_param.required'    => 'El nombre debe ser digitado.',
            'nom_param.string'      => 'El nombre debe contener caracteres alfanuméricos.',
            'nom_param.max'         => 'El nombre debe tener máximo 100 caracteres.',
            'nom_param.unique'      => 'Ya existe un parámetro con ese nombre.',
            'valor.required'        => 'El valor debe ser digitado.',
            'valor.numeric'         => 'El valor debe ser numérico.',
            'valor.decimal'         => 'El valor admite máximo 2 decimales.',
            'valor.min'             => 'El valor debe ser al menos 0.1.',
        ];
    }
}
