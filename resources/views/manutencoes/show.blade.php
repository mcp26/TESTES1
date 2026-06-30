@extends('layouts.app')

@section('title', 'Detalhe da Manutenção')

@section('content')
    <h3 class="mb-4">Manutenção: {{ $manutencao->tipoManutencao->nome }}</h3>

    <div class="card mb-4">
        <div class="card-body">
            <dl class="row mb-0">
                <dt class="col-3">Veículo</dt><dd class="col-9">{{ $manutencao->veiculo->nome }}</dd>
                <dt class="col-3">Data</dt><dd class="col-9">{{ $manutencao->data_manutencao->format('d/m/Y') }}</dd>
                <dt class="col-3">Medição</dt><dd class="col-9">{{ number_format($manutencao->valor_medicao, 0, ',', '.') }} {{ $manutencao->veiculo->tipoVeiculo->unidade_medida }}</dd>
                <dt class="col-3">Registrado por</dt><dd class="col-9">{{ $manutencao->user->name }}</dd>
            </dl>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white"><strong>Peças Utilizadas</strong></div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Peça</th>
                        <th>Marca</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($manutencao->pecas as $peca)
                        <tr>
                            <td>{{ $peca->nome }}</td>
                            <td>{{ $marcas[$peca->pivot->marca_id] ?? '-' }}</td>
                            <td>{{ $peca->pivot->quantidade }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
