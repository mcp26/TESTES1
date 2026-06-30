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

        return $previsoes->sortBy('restante');
    }

    /**
     * Calcula a previsão de próximas manutenções para um único veículo.
     */
    public function calcularParaVeiculo(Veiculo $veiculo): Collection
    {
        $tiposManutencao = $veiculo->tipoVeiculo->tiposManutencao;

        return $tiposManutencao->map(function ($tipoManutencao) use ($veiculo) {
            $ultima = Manutencao::where('veiculo_id', $veiculo->id)
                ->where('tipo_manutencao_id', $tipoManutencao->id)
                ->orderByDesc('valor_medicao')
                ->orderByDesc('data_manutencao')
                ->first();

            $valorAtual = $ultima ? (float) $ultima->valor_medicao : 0;
            $previsto = $valorAtual + $tipoManutencao->intervalo;
            $restante = $previsto - $valorAtual;

            return [
                'veiculo' => $veiculo,
                'tipo_manutencao' => $tipoManutencao,
                'ultima_manutencao' => $ultima,
                'valor_atual' => $valorAtual,
                'valor_previsto' => $previsto,
                'restante' => $tipoManutencao->intervalo,
                'unidade' => $veiculo->tipoVeiculo->unidade_medida,
            ];
        });
    }
}
