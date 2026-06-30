<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVeiculoRequest;
use App\Http\Requests\UpdateVeiculoRequest;
use App\Models\Marca;
use App\Models\TipoVeiculo;
use App\Models\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VeiculoController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $mostrarInativos = $request->boolean('inativos');

        $query = Veiculo::with(['tipoVeiculo', 'marca']);

        if (! $user->isMaster()) {
            $query->where('ativo', true)
                ->whereHas('usuarios', fn ($q) => $q->where('user_id', $user->id));
        } elseif (! $mostrarInativos) {
            $query->where('ativo', true);
        }

        $veiculos = $query->orderBy('nome')->paginate(15)->withQueryString();

        return view('veiculos.index', compact('veiculos', 'mostrarInativos'));
    }

    public function create()
    {
        $tiposVeiculo = TipoVeiculo::orderBy('nome')->get();
        $marcas = Marca::orderBy('nome')->get();

        return view('veiculos.create', compact('tiposVeiculo', 'marcas'));
    }

    public function store(StoreVeiculoRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('documento')) {
            $data['documento_path'] = $request->file('documento')->store('', 'veiculos');
        }
        unset($data['documento']);

        Veiculo::create($data);

        return redirect()->route('veiculos.index')->with('success', 'Veículo cadastrado com sucesso.');
    }

    public function show(Veiculo $veiculo)
    {
        $this->authorize('view', $veiculo);

        $veiculo->load(['tipoVeiculo', 'marca', 'usuarios', 'manutencoes.tipoManutencao']);

        return view('veiculos.show', compact('veiculo'));
    }

    public function edit(Veiculo $veiculo)
    {
        $this->authorize('update', $veiculo);

        $tiposVeiculo = TipoVeiculo::orderBy('nome')->get();
        $marcas = Marca::orderBy('nome')->get();

        return view('veiculos.edit', compact('veiculo', 'tiposVeiculo', 'marcas'));
    }

    public function update(UpdateVeiculoRequest $request, Veiculo $veiculo)
    {
        $this->authorize('update', $veiculo);

        $data = $request->validated();

        if ($request->hasFile('documento')) {
            if ($veiculo->documento_path) {
                Storage::disk('veiculos')->delete($veiculo->documento_path);
            }
            $data['documento_path'] = $request->file('documento')->store('', 'veiculos');
        }
        unset($data['documento']);

        $veiculo->update($data);

        return redirect()->route('veiculos.index')->with('success', 'Veículo atualizado com sucesso.');
    }

    public function inativar(Veiculo $veiculo)
    {
        $this->authorize('delete', $veiculo);

        $veiculo->update(['ativo' => false]);

        return redirect()->route('veiculos.index')->with('success', 'Veículo inativado com sucesso.');
    }

    public function ativar(Veiculo $veiculo)
    {
        $this->authorize('update', $veiculo);

        $veiculo->update(['ativo' => true]);

        return redirect()->route('veiculos.index')->with('success', 'Veículo reativado com sucesso.');
    }

    public function documento(Veiculo $veiculo)
    {
        $this->authorize('view', $veiculo);

        if (! $veiculo->documento_path || ! Storage::disk('veiculos')->exists($veiculo->documento_path)) {
            abort(404);
        }

        return Storage::disk('veiculos')->download($veiculo->documento_path);
    }
}
