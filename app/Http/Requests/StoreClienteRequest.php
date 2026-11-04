<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreClienteRequest extends ClienteRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cod_cliente'       => ['required', 'string', 'min:8', 'max:12', 'regex:/^[0-9]+$/', 'unique:clientes,cod_cliente'],
            'nom_cliente'       => ['required', 'string', 'max:100', 'regex:/^[A-Z ]+$/'],
            'seg_nom_cliente'   => ['string', 'max:100', 'regex:/^[A-Z ]+$/'],
            'ape_cliente'       => ['required', 'string', 'max:100', 'regex:/^[A-Z ]+$/'],
            'seg_ape_cliente'   => ['string', 'max:100', 'regex:/^[A-Z ]+$/'],
            'dir_cliente'       => ['required', 'string', 'max:150'],
            'tel_cliente'       => ['required', 'string', 'max:100', 'regex:/^[0-9]+$/', 'unique:clientes,tel_cliente'],
            'tipo_cli_cod'      => ['required', 'numeric', 'exists:tipos_cliente,cod_tipo_cli'],
        ];
    }
}
