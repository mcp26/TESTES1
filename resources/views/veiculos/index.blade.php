@extends('layouts.app')

@section('title', 'Veículos')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Veículos</h3>
        @if(auth()->user()->isMaster())
            <a href="{{ route('veiculos.create') }}" class="btn btn-dark">
                <i class="bi bi-plus-lg me-1"></i>Novo Veículo
            </a>
        @endif
    </div>

    @if(auth()->user()->isMaster())
        <form method="GET" class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="inativos" value="1" id="inativos"
                       {{ $mostrarInativos ? 'checked' : '' }} onchange="this.form.submit()">
                <label class="form-check-label" for="inativos">Mostrar inativos</label>
            </div>
        </form>
    @endif

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Tipo</th>
                        <th>Marca</th>
                        <th>Placa</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($veiculos as $veiculo)
                        <tr>
                            <td><a href="{{ route('veiculos.show', $veiculo) }}">{{ $veiculo->nome }}</a></td>
                            <td>{{ $veiculo->tipoVeiculo->nome }}</td>
                            <td>{{ $veiculo->marca->nome }}</td>
                            <td>{{ $veiculo->placa }}</td>
                            <td>
                                @if($veiculo->ativo)
                                    <span class="badge badge-ok">Ativo</span>
                                @else
                                    <span class="badge bg-secondary">Inativo</span>
                                @endif
                            </td>
                            <td class="text-end">
                                @if(auth()->user()->isMaster())
                                    <a href="{{ route('veiculos.edit', $veiculo) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                                    @if($veiculo->ativo)
                                        <form method="POST" action="{{ route('veiculos.inativar', $veiculo) }}" class="d-inline" onsubmit="return confirm('Inativar este veículo?');">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-eye-slash"></i></button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('veiculos.ativar', $veiculo) }}" class="d-inline">
                                            @csrf @method('PATCH')
                                            <button class="btn btn-sm btn-outline-success"><i class="bi bi-eye"></i></button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-muted text-center py-4">Nenhum veículo encontrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $veiculos->links() }}</div>
@endsection
