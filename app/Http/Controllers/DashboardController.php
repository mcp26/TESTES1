<?php

namespace App\Http\Controllers;

use App\Models\Veiculo;
use App\Services\PrevisaoManutencaoCalculator;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request, PrevisaoManutencaoCalculator $calculator)
    {
        $user = $request->user();

        $veiculosQuery = Veiculo::where('ativo', true);
        if (! $user->isMaster()) {
            $veiculosQuery->whereHas('usuarios', fn ($q) => $q->where('user_id', $user->id));
        }
        $veiculos = $veiculosQuery->with('tipoVeiculo')->get();

        $previsoes = $calculator->calcularParaVeiculos($veiculos);
        $atrasadas = $previsoes->where('restante', '<', 0)->count();
        $proximas = $previsoes->where('restante', '>=', 0)->where('restante', '<=', 1000)->count();

        return view('dashboard', [
            'totalVeiculos' => $veiculos->count(),
            'atrasadas' => $atrasadas,
            'proximas' => $proximas,
            'previsoesUrgentes' => $previsoes->take(5),
        ]);
    }
}
