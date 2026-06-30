<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoManutencaoRequest;
use App\Models\TipoManutencao;
use App\Models\TipoVeiculo;

class TipoManutencaoController extends Controller
{
    public function index()
    {
        $tiposManutencao = TipoManutencao::with('tiposVeiculo')->orderBy('nome')->get();

        return view('tipos-manutencao.index', compact('tiposManutencao'));
    }

    public function create()
    {
        $tiposVeiculo = TipoVeiculo::orderBy('nome')->get();

        return view('tipos-manutencao.create', compact('tiposVeiculo'));
    }

    public function store(StoreTipoManutencaoRequest $request)
    {
        $tipoManutencao = TipoManutencao::create($request->safe()->only(['nome', 'intervalo']));
        $tipoManutencao->tiposVeiculo()->attach($request->input('tipos_veiculo'));

        return redirect()->route('tipos-manutencao.index')->with('success', 'Tipo de manutenção cadastrado com sucesso.');
    }
}
