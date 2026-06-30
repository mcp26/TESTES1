@extends('layouts.app')

@section('title', 'Novo Tipo de Manutenção')

@section('content')
    <h3 class="mb-4">Novo Tipo de Manutenção</h3>

    <div class="card" style="max-width:600px;">
        <div class="card-body">
            <form method="POST" action="{{ route('tipos-manutencao.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" class="form-control @error('nome') is-invalid @enderror" required autofocus>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Intervalo (km ou horas, conforme o tipo de veículo)</label>
                    <input type="number" name="intervalo" value="{{ old('intervalo') }}" min="1" class="form-control @error('intervalo') is-invalid @enderror" required>
                    @error('intervalo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Aplica-se aos Tipos de Veículo</label>
                    <div class="border rounded p-2 @error('tipos_veiculo') is-invalid border-danger @enderror">
                        @forelse($tiposVeiculo as $tipo)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tipos_veiculo[]" value="{{ $tipo->id }}"
                                       id="tv{{ $tipo->id }}" {{ in_array($tipo->id, old('tipos_veiculo', [])) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tv{{ $tipo->id }}">
                                    {{ $tipo->nome }} <span class="text-muted small">({{ $tipo->unidade_medida }})</span>
                                </label>
                            </div>
                        @empty
                            <p class="text-muted small mb-0">Nenhum tipo de veículo cadastrado ainda.</p>
                        @endforelse
                    </div>
                    @error('tipos_veiculo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Salvar</button>
                    <a href="{{ route('tipos-manutencao.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
