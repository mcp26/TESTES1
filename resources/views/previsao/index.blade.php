@extends('layouts.app')

@section('title', 'Previsão de Manutenções')

@section('content')
    <h3 class="mb-4">Previsão de Próximas Manutenções</h3>

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Veículo</th>
                        <th>Tipo de Manutenção</th>
                        <th>Última Medição</th>
                        <th>Previsto Para</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($previsoes as $p)
                        <tr>
                            <td><a href="{{ route('veiculos.show', $p['veiculo']) }}">{{ $p['veiculo']->nome }}</a></td>
                            <td>{{ $p['tipo_manutencao']->nome }}</td>
                            <td>{{ number_format($p['valor_atual_veiculo'], 0, ',', '.') }} {{ $p['unidade'] }}</td>
                            <td>{{ number_format($p['valor_previsto'], 0, ',', '.') }} {{ $p['unidade'] }}</td>
                            <td>
                                @if($p['restante'] < 0)
                                    <span class="badge badge-overdue">Atrasada em {{ number_format(abs($p['restante']), 0, ',', '.') }} {{ $p['unidade'] }}</span>
                                @elseif($p['restante'] <= 1000)
                                    <span class="badge badge-soon">Faltam {{ number_format($p['restante'], 0, ',', '.') }} {{ $p['unidade'] }}</span>
                                @else
                                    <span class="badge badge-ok">Faltam {{ number_format($p['restante'], 0, ',', '.') }} {{ $p['unidade'] }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-muted text-center py-4">Nenhuma previsão disponível.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
