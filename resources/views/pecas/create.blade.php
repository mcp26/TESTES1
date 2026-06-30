@extends('layouts.app')

@section('title', 'Nova Peça')

@section('content')
    <h3 class="mb-4">Nova Peça</h3>

    <div class="card" style="max-width:500px;">
        <div class="card-body">
            <form method="POST" action="{{ route('pecas.store') }}">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" value="{{ old('nome') }}" class="form-control @error('nome') is-invalid @enderror" required autofocus>
                    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Salvar</button>
                    <a href="{{ route('pecas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
