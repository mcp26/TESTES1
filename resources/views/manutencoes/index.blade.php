@extends('layouts.app')

@section('title', 'Manutenções')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Manutenções</h3>
        <a href="{{ route('manutencoes.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg me-1"></i>Registrar Manutenção
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Veículo</th>
                        <th>Tipo de Manutenção</th>
                        <th>Medição</th>
                        <th>Registrado por</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($manutencoes as $m)
                        <tr>
                            <td>{{ $m->data_manutencao->format('d/m/Y') }}</td>
                            <td><a href="{{ route('veiculos.show', $m->veiculo) }}">{{ $m->veiculo->nome }}</a></td>
                            <td><a href="{{ route('manutencoes.show', $m) }}">{{ $m->tipoManutencao->nome }}</a></td>
                            <td>{{ number_format($m->valor_medicao, 0, ',', '.') }}</td>
                            <td>{{ $m->user->name }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted text-center py-4">Nenhuma manutenção registrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $manutencoes->links() }}</div>
@endsection
