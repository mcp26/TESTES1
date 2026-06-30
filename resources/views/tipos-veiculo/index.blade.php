@extends('layouts.app')

@section('title', 'Tipos de Veículo')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Tipos de Veículo</h3>
        <a href="{{ route('tipos-veiculo.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg me-1"></i>Novo Tipo
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Unidade de Medida</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tiposVeiculo as $tipo)
                        <tr>
                            <td>{{ $tipo->nome }}</td>
                            <td><span class="badge bg-secondary">{{ $tipo->unidade_medida }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="2" class="text-muted text-center py-4">Nenhum tipo de veículo cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
