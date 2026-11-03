<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateParametroRequest extends ParametroRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $parametro = $this->route('parametro');

        return [
            'nom_param' => ['required', 'string', 'max:100',
                Rule::unique('parametros', 'nom_param')->ignore($parametro->cod_param, 'cod_param')],
            'valor' => ['required', 'numeric', 'decimal:0,2', 'min:0.1'],
        ];
    }
}
