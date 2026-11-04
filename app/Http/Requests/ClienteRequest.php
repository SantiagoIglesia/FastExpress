<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

abstract class ClienteRequest extends FormRequest
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
            'cod_cliente.required'      => 'La identificación debe ser digitada.',
            'cod_cliente.string'        => 'La identificación debe contener caracteres alfanuméricos.',
            'cod_cliente.min'           => 'La identificación debe tener mínimo 8 caracteres.',
            'cod_cliente.max'           => 'La identificación debe tener máximo 12 caracteres.',
            'cod_cliente.regex'         => 'Identificación inválida.',
            'cod_cliente.unique'        => 'Ya existe un cliente con esa identificación.',
            'nom_cliente.required'      => 'El primer nombre debe ser digitado.',
            'nom_cliente.string'        => 'El primer nombre debe contener caracteres alfanuméricos.',
            'nom_cliente.max'           => 'El primer nombre debe tener máximo 100 caracteres.',
            'nom_cliente.regex'         => 'Nombre inválido.',
            'seg_nom_cliente.required'  => 'El segundo nombre debe ser digitado.',
            'seg_nom_cliente.string'    => 'El segundo nombre debe contener caracteres alfanuméricos.',
            'seg_nom_cliente.max'       => 'El segundo nombre debe tener máximo 100 caracteres.',
            'seg_nom_cliente.regex'     => 'Nombre inválido.',
            'ape_cliente.required'      => 'El primer apellido debe ser digitado.',
            'ape_cliente.string'        => 'El primer apellido debe contener caracteres alfanuméricos.',
            'ape_cliente.max'           => 'El primer apellido debe tener máximo 100 caracteres.',
            'ape_cliente.regex'         => 'Apellido inválido.',
            'seg_ape_cliente.required'  => 'El segundo apellido debe ser digitado.',
            'seg_ape_cliente.string'    => 'El segundo apellido debe contener caracteres alfanuméricos.',
            'seg_ape_cliente.max'       => 'El segundo apellido debe tener máximo 100 caracteres.',
            'seg_ape_cliente.regex'     => 'Apellido inválido.',
            'dir_cliente.required'      => 'La dirección debe ser digitado.',
            'dir_cliente.string'        => 'La dirección debe contener caracteres alfanuméricos.',
            'dir_cliente.max'           => 'La dirección debe tener máximo 150 caracteres.',
            'tel_cliente.required'      => 'El teléfono debe ser digitado.',
            'tel_cliente.string'        => 'El teléfono debe contener caracteres alfanuméricos.',
            'tel_cliente.max'           => 'El teléfono debe tener máximo 10 caracteres.',
            'tel_cliente.regex'         => 'Teléfono inválido.',
            'tel_cliente.unique'        => 'Ya existe un cliente con ese teléfono.',
            'tipo_cli_cod.required'     => 'El tipo de cliente debe ser digitado.',
            'tipo_cli_cod.numeric'      => 'El tipo de cliente debe ser numérico.',
            'tipo_cli_cod.exists'       => 'El tipo de cliente no está registrado en el sistema.',
        ];
    }
}
