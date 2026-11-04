<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRangoPesoRequest extends RangoPesoRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'peso_min'      => ['required', 'numeric', 'decimal:0,2', 'min:0.01', 'lt:peso_max'],
            'peso_max'      => ['required', 'numeric', 'decimal:0,2', 'min:0.01', 'max:999.99', 'gt:peso_min'],
            'valor_peso'    => ['required', 'numeric', 'decimal:0,2', 'min:0.01'],
        ];
    }

    protected function rangoAIgnorar(): ?int
    {
        return $this->route('rango_peso')->cod_rango;
    }
}
