@extends('layouts.app')

@section('title', 'Tipos de Manutenção')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Tipos de Manutenção</h3>
        <a href="{{ route('tipos-manutencao.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg me-1"></i>Novo Tipo
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Intervalo</th>
                        <th>Aplica-se a</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tiposManutencao as $tipo)
                        <tr>
                            <td>{{ $tipo->nome }}</td>
                            <td>{{ number_format($tipo->intervalo, 0, ',', '.') }}</td>
                            <td>
                                @foreach($tipo->tiposVeiculo as $tv)
                                    <span class="badge bg-secondary me-1">{{ $tv->nome }}</span>
                                @endforeach
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-muted text-center py-4">Nenhum tipo de manutenção cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
