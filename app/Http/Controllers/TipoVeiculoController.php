<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTipoVeiculoRequest;
use App\Models\TipoVeiculo;

class TipoVeiculoController extends Controller
{
    public function index()
    {
        $tiposVeiculo = TipoVeiculo::orderBy('nome')->get();

        return view('tipos-veiculo.index', compact('tiposVeiculo'));
    }

    public function create()
    {
        return view('tipos-veiculo.create');
    }

    public function store(StoreTipoVeiculoRequest $request)
    {
        TipoVeiculo::create($request->validated());

        return redirect()->route('tipos-veiculo.index')->with('success', 'Tipo de veículo cadastrado com sucesso.');
    }
}
