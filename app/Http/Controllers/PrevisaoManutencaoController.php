<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Services\PrevisaoManutencaoCalculator;
use Illuminate\Http\Request;

class PrevisaoManutencaoController extends Controller
{
    public function index(Request $request, PrevisaoManutencaoCalculator $calculator)
    {
        $user = $request->user();

        $query = Veiculo::where('ativo', true)->with('tipoVeiculo.tiposManutencao');
        if (! $user->isMaster()) {
            $query->whereHas('usuarios', fn ($q) => $q->where('user_id', $user->id));
        }
        $veiculos = $query->get();

        $previsoes = $calculator->calcularParaVeiculos($veiculos);

        return view('previsao.index', compact('previsoes'));
    }
}
