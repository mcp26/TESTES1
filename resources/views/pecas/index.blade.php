@extends('layouts.app')

@section('title', 'Peças')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Peças</h3>
        <a href="{{ route('pecas.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg me-1"></i>Nova Peça
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead><tr><th>Nome</th></tr></thead>
                <tbody>
                    @forelse($pecas as $peca)
                        <tr><td>{{ $peca->nome }}</td></tr>
                    @empty
                        <tr><td class="text-muted text-center py-4">Nenhuma peça cadastrada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
