<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreManutencaoRequest;
use App\Models\Manutencao;
use App\Models\Marca;
use App\Models\Peca;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManutencaoController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $query = Manutencao::with(['veiculo', 'tipoManutencao', 'user']);

        if (! $user->isMaster()) {
            $query->whereHas('veiculo.usuarios', fn ($q) => $q->where('user_id', $user->id));
        }

        $manutencoes = $query->orderByDesc('data_manutencao')->paginate(15);

        return view('manutencoes.index', compact('manutencoes'));
    }

    public function create(Request $request)
    {
        $user = $request->user();

        $veiculosQuery = Veiculo::where('ativo', true);
        if (! $user->isMaster()) {
            $veiculosQuery->whereHas('usuarios', fn ($q) => $q->where('user_id', $user->id));
        }
        $veiculos = $veiculosQuery->with('tipoVeiculo.tiposManutencao')->orderBy('nome')->get();

        $pecas = Peca::orderBy('nome')->get();
        $marcas = Marca::orderBy('nome')->get();

        return view('manutencoes.create', compact('veiculos', 'pecas', 'marcas'));
    }

    public function store(StoreManutencaoRequest $request)
    {
        DB::transaction(function () use ($request) {
            $manutencao = Manutencao::create([
                'veiculo_id' => $request->input('veiculo_id'),
                'tipo_manutencao_id' => $request->input('tipo_manutencao_id'),
                'user_id' => $request->user()->id,
                'data_manutencao' => $request->input('data_manutencao'),
                'valor_medicao' => $request->input('valor_medicao'),
            ]);

            foreach ($request->input('pecas') as $linha) {
                $manutencao->pecas()->attach($linha['peca_id'], [
                    'marca_id' => $linha['marca_id'],
                    'quantidade' => $linha['quantidade'],
                ]);
            }
        });

        return redirect()->route('manutencoes.index')->with('success', 'Manutenção registrada com sucesso.');
    }

    public function show(Manutencao $manutencao)
    {
        $this->authorize('view', $manutencao);

        $manutencao->load(['veiculo', 'tipoManutencao', 'user', 'pecas']);
        $marcas = Marca::whereIn('id', $manutencao->pecas->pluck('pivot.marca_id'))->pluck('nome', 'id');

        return view('manutencoes.show', compact('manutencao', 'marcas'));
    }
}
