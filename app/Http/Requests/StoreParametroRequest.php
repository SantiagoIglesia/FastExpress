<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreParametroRequest extends ParametroRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom_param' => ['required', 'string', 'max:100', 'unique:parametros,nom_param'],
            'valor' => ['required', 'numeric', 'decimal:0,2', 'min:0.1'],
        ];
    }
}
