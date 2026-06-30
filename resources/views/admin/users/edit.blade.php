@extends('layouts.app')

@section('title', 'Editar Usuário')

@section('content')
    <h3 class="mb-4">Editar Usuário</h3>

    <div class="card" style="max-width:600px;">
        <div class="card-body">
            <form method="POST" action="{{ route('admin.users.update', $user) }}">
                @csrf
                @method('PUT')
                @include('admin.users.partials.form')
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-dark">Salvar</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection
