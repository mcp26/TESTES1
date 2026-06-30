@extends('layouts.app')

@section('title', 'Usuários')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">Usuários</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-dark">
            <i class="bi bi-plus-lg me-1"></i>Novo Usuário
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Papel</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->isMaster())
                                    <span class="badge bg-warning text-dark">Master</span>
                                @else
                                    <span class="badge bg-secondary">Junior</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-pencil"></i></a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-muted text-center py-4">Nenhum usuário cadastrado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">{{ $users->links() }}</div>
@endsection
