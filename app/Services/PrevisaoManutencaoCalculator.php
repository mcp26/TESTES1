<?php

namespace App\Services;

use App\Models\Manutencao;
use App\Models\Veiculo;
use Illuminate\Support\Collection;

class PrevisaoManutencaoCalculator
{
    /**
     * Calcula a previsão de próximas manutenções para uma coleção de veículos.
     * Retorna uma coleção plana de previsões ordenadas pela mais urgente primeiro.
     */
    public function calcularParaVeiculos(Collection $veiculos): Collection
    {
        $previsoes = collect();

        foreach ($veiculos as $veiculo) {
            $previsoes = $previsoes->merge($this->calcularParaVeiculo($veiculo));
        }

        return $previsoes->sortBy('restante')->values();
    }

    /**
     * Calcula a previsão de próximas manutenções para um único veículo.
     * O km/horas "atual" do veículo é estimado pela maior leitura já registrada
     * em qualquer manutenção (independente do tipo).
     */
    public function calcularParaVeiculo(Veiculo $veiculo): Collection
    {
        $valorAtualVeiculo = (float) (Manutencao::where('veiculo_id', $veiculo->id)->max('valor_medicao') ?? 0);

        $tiposManutencao = $veiculo->tipoVeiculo->tiposManutencao;

        return $tiposManutencao->map(function ($tipoManutencao) use ($veiculo, $valorAtualVeiculo) {
            $ultima = Manutencao::where('veiculo_id', $veiculo->id)
                ->where('tipo_manutencao_id', $tipoManutencao->id)
                ->orderByDesc('valor_medicao')
                ->orderByDesc('data_manutencao')
                ->first();

            $baseValor = $ultima ? (float) $ultima->valor_medicao : 0;
            $previsto = $baseValor + $tipoManutencao->intervalo;
            $restante = $previsto - $valorAtualVeiculo;

            return [
                'veiculo' => $veiculo,
                'tipo_manutencao' => $tipoManutencao,
                'ultima_manutencao' => $ultima,
                'valor_atual_veiculo' => $valorAtualVeiculo,
                'valor_previsto' => $previsto,
                'restante' => $restante,
                'unidade' => $veiculo->tipoVeiculo->unidade_medida,
            ];
        });
    }
}
