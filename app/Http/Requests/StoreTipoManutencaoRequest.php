<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTipoManutencaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'intervalo' => ['required', 'integer', 'min:1'],
            'tipos_veiculo' => ['required', 'array', 'min:1'],
            'tipos_veiculo.*' => ['exists:tipo_veiculos,id'],
        ];
    }
}
