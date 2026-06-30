<?php

namespace App\Http\Requests;

use App\Models\Veiculo;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreManutencaoRequest extends FormRequest
{
    public function authorize(): bool
    {
        $veiculo = Veiculo::find($this->input('veiculo_id'));

        if (! $veiculo) {
            return false;
        }

        return $this->user()->can('createFor', [\App\Models\Manutencao::class, $veiculo]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'veiculo_id' => ['required', 'exists:veiculos,id'],
            'tipo_manutencao_id' => ['required', 'exists:tipo_manutencoes,id'],
            'data_manutencao' => ['required', 'date'],
            'valor_medicao' => ['required', 'numeric', 'min:0'],
            'pecas' => ['required', 'array', 'min:1'],
            'pecas.*.peca_id' => ['required', 'exists:pecas,id'],
            'pecas.*.marca_id' => ['required', 'exists:marcas,id'],
            'pecas.*.quantidade' => ['required', 'integer', 'min:1'],
        ];
    }
}
