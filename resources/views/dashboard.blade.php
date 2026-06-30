@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h3 class="mb-4">Dashboard</h3>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-muted small">Veículos visíveis</div>
                    <div class="fs-2 fw-bold">{{ $totalVeiculos }}</div>
                    <i class="bi bi-truck text-secondary"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-danger">
                <div class="card-body">
                    <div class="text-muted small">Manutenções atrasadas</div>
                    <div class="fs-2 fw-bold text-danger">{{ $atrasadas }}</div>
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-warning">
                <div class="card-body">
                    <div class="text-muted small">Próximas (até 1000)</div>
                    <div class="fs-2 fw-bold text-warning">{{ $proximas }}</div>
                    <i class="bi bi-calendar-check text-warning"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <strong>Manutenções mais urgentes</strong>
        </div>
        <div class="card-body p-0">
            @if($previsoesUrgentes->isEmpty())
                <p class="text-muted p-3 mb-0">Nenhuma previsão disponível.</p>
            @else
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Veículo</th>
                            <th>Manutenção</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($previsoesUrgentes as $p)
                            <tr>
                                <td>{{ $p['veiculo']->nome }}</td>
                                <td>{{ $p['tipo_manutencao']->nome }}</td>
                                <td>
                                    @if($p['restante'] < 0)
                                        <span class="badge badge-overdue">Atrasada em {{ number_format(abs($p['restante']), 0, ',', '.') }} {{ $p['unidade'] }}</span>
                                    @else
                                        <span class="badge badge-soon">Faltam {{ number_format($p['restante'], 0, ',', '.') }} {{ $p['unidade'] }}</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
