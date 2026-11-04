<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

abstract class EstadoEnvioRequest extends FormRequest
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
            'nom_estado.required'   => 'El nombre debe ser digitado.',
            'nom_estado.string'     => 'El nombre debe contener caracteres alfanuméricos.',
            'nom_estado.max'        => 'El nombre debe tener máximo 100 caracteres.',
            'nom_estado.unique'     => 'Ya existe un estado con ese nombre.',
        ];
    }
}
