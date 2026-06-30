<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVeiculoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isMaster();
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nome' => ['required', 'string', 'max:255'],
            'tipo_veiculo_id' => ['required', 'exists:tipo_veiculos,id'],
            'marca_id' => ['required', 'exists:marcas,id'],
            'data_aquisicao' => ['required', 'date'],
            'placa' => ['required', 'string', 'max:20'],
            'documento' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'vencimento_documento' => ['nullable', 'date'],
            'vencimento_seguro' => ['nullable', 'date'],
        ];
    }
}
