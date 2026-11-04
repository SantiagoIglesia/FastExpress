<?php

namespace App\Http\Requests;

use App\Models\Parametro;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\RangoPeso;

abstract class RangoPesoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /** En update devuelve el código del rango actual para no compararlo consigo mismo. */
    protected function rangoAIgnorar(): ?int
    {
        return null;
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if ($validator->errors()->hasAny(['peso_min', 'peso_max'])) {
                return;
            }

            // BR-02: ningún rango puede superar el peso máximo permitido
            $peso_max = Parametro::where('nom_param', 'PESO_MAX')->value('valor');
    
            if ($peso_max !== null && $this->input('peso_max') > $peso_max) {
                $validator->errors()->add(
                    'peso_max',
                    "El peso máximo no puede superar el límite de envío ({$peso_max} kg)."
                );
            }
    
            // Solapamiento con rangos cerrados [min, max]
            $solapado = RangoPeso::query()
                ->when($this->rangoAIgnorar(), fn ($q, $id) => $q->where('cod_rango', '!=', $id))
                ->where('peso_min', '<=', $this->input('peso_max'))
                ->where('peso_max', '>=', $this->input('peso_min'))
                ->first();
    
            if ($solapado) {
                $validator->errors()->add(
                    'peso_min',
                    "El rango se solapa con el rango existente de {$solapado->peso_min} a {$solapado->peso_max} kg."
                );
            }
        });
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function messages(): array
    {
        return [
            'peso_min.required'   => 'El peso mínimo debe ser digitado.',
            'peso_min.numeric'    => 'El peso mínimo debe ser numérico.',
            'peso_min.decimal'    => 'El peso mínimo admite máximo 2 decimales.',
            'peso_min.min'        => 'El peso mínimo debe ser al menos 0.01.',
            'peso_min.lt'         => 'El peso mínimo debe ser menor que el peso máximo.',
            'peso_max.required'   => 'El peso máximo debe ser digitado.',
            'peso_max.numeric'    => 'El peso máximo debe ser numérico.',
            'peso_max.decimal'    => 'El peso máximo admite máximo 2 decimales.',
            'peso_max.min'        => 'El peso máximo debe ser al menos 0.01.',
            'peso_max.max'        => 'El peso máximo no puede superar 999.99.',
            'peso_max.gt'         => 'El peso máximo debe ser mayor que el peso mínimo.',
            'valor_peso.required' => 'El valor del rango debe ser digitado.',
            'valor_peso.numeric'  => 'El valor del rango debe ser numérico.',
            'valor_peso.decimal'  => 'El valor del rango admite máximo 2 decimales.',
            'valor_peso.min'      => 'El valor del rango debe ser al menos 0.01.',
        ];
    }
}
