@extends('layouts.app')

@section('title', 'Marcas')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Marcas</h3>
        <a href="{{ route('marcas.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg me-1"></i>Nova Marca
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead><tr><th>Nome</th></tr></thead>
                <tbody>
                    @forelse($marcas as $marca)
                        <tr><td>{{ $marca->nome }}</td></tr>
                    @empty
                        <tr><td class="text-muted text-center py-4">Nenhuma marca cadastrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
