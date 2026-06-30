@extends('layouts.app')

@section('title', 'Editar Veículo')

@section('content')
    <h3 class="mb-4">Editar Veículo</h3>

    <div class="card" style="max-width:700px;">
        <div class="card-body">
            <form method="POST" action="{{ route('veiculos.update', $veiculo) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('veiculos.partials.form')
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Salvar</button>
                    <a href="{{ route('veiculos.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
