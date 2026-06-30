@extends('layouts.app')

@section('title', $veiculo->nome)

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">{{ $veiculo->nome }}</h3>
        @if(auth()->user()->isMaster())
            <a href="{{ route('veiculos.edit', $veiculo) }}" class="btn btn-outline-secondary">
                <i class="bi bi-pencil me-1"></i>Editar
            </a>
        @endif
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white"><strong>Dados do Veículo</strong></div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-5">Tipo</dt><dd class="col-7">{{ $veiculo->tipoVeiculo->nome }}</dd>
                        <dt class="col-5">Marca</dt><dd class="col-7">{{ $veiculo->marca->nome }}</dd>
                        <dt class="col-5">Placa</dt><dd class="col-7">{{ $veiculo->placa }}</dd>
                        <dt class="col-5">Aquisição</dt><dd class="col-7">{{ $veiculo->data_aquisicao->format('d/m/Y') }}</dd>
                        <dt class="col-5">Vencimento Documento</dt><dd class="col-7">{{ $veiculo->vencimento_documento?->format('d/m/Y') ?? '-' }}</dd>
                        <dt class="col-5">Vencimento Seguro</dt><dd class="col-7">{{ $veiculo->vencimento_seguro?->format('d/m/Y') ?? '-' }}</dd>
                        <dt class="col-5">Status</dt><dd class="col-7">{{ $veiculo->ativo ? 'Ativo' : 'Inativo' }}</dd>
                        <dt class="col-5">Documento</dt>
                        <dd class="col-7">
                            @if($veiculo->documento_path)
                                <a href="{{ route('veiculos.documento', $veiculo) }}"><i class="bi bi-download me-1"></i>Baixar</a>
                            @else
                                -
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header bg-white"><strong>Usuários Responsáveis</strong></div>
                <div class="card-body">
                    @forelse($veiculo->usuarios as $usuario)
                        <span class="badge bg-secondary me-1 mb-1">{{ $usuario->name }}</span>
                    @empty
                        <p class="text-muted mb-0">Nenhum usuário atribuído.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <strong>Histórico de Manutenções</strong>
            <a href="{{ route('manutencoes.create') }}" class="btn btn-sm btn-dark">
                <i class="bi bi-plus-lg me-1"></i>Registrar Manutenção
            </a>
        </div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Data</th>
                        <th>Tipo de Manutenção</th>
                        <th>Medição</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($veiculo->manutencoes->sortByDesc('data_manutencao') as $m)
                        <tr>
                            <td>{{ $m->data_manutencao->format('d/m/Y') }}</td>
                            <td><a href="{{ route('manutencoes.show', $m) }}">{{ $m->tipoManutencao->nome }}</a></td>
                            <td>{{ number_format($m->valor_medicao, 0, ',', '.') }} {{ $veiculo->tipoVeiculo->unidade_medida }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-muted text-center py-4">Nenhuma manutenção registrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
