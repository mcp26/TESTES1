@extends('layouts.app')

@section('title', 'Novo Tipo de Veículo')

@section('content')
    <h3 class="mb-4">Novo Tipo de Veículo</h3>

    <div class="card" style="max-width:500px;">
        <div class="card-body">
            <form method="POST" action="{{ route('tipos-veiculo.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" class="form-control @error('nome') is-invalid @enderror" required autofocus>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label">Unidade de Medida</label>
                    <select name="unidade_medida" class="form-select @error('unidade_medida') is-invalid @enderror" required>
                        <option value="">Selecione...</option>
                        <option value="km" {{ old('unidade_medida') === 'km' ? 'selected' : '' }}>Quilômetros (km)</option>
                        <option value="horas" {{ old('unidade_medida') === 'horas' ? 'selected' : '' }}>Horas</option>
                    </select>
                    @error('unidade_medida')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Salvar</button>
                    <a href="{{ route('tipos-veiculo.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
