<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - @yield('title', 'Início')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <nav class="navbar navbar-dark bg-dark px-3">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-tools me-2"></i>{{ config('app.name') }}
        </a>
        <div class="d-flex align-items-center gap-3">
            <span class="text-light small">
                <i class="bi bi-person-circle me-1"></i>{{ auth()->user()->name }}
                @if(auth()->user()->isMaster())
                    <span class="badge bg-warning text-dark ms-1">Master</span>
                @endif
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-light">
                    <i class="bi bi-box-arrow-right me-1"></i>Sair
                </button>
            </form>
        </div>
    </nav>

    <div class="d-flex">
        <nav class="sidebar p-3" style="width:230px;flex-shrink:0;">
            <ul class="nav flex-column gap-1">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('veiculos.index') }}" class="nav-link {{ request()->routeIs('veiculos.*') ? 'active' : '' }}">
                        <i class="bi bi-truck"></i> Veículos
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('manutencoes.index') }}" class="nav-link {{ request()->routeIs('manutencoes.*') ? 'active' : '' }}">
                        <i class="bi bi-wrench-adjustable"></i> Manutenções
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('previsao.index') }}" class="nav-link {{ request()->routeIs('previsao.*') ? 'active' : '' }}">
                        <i class="bi bi-calendar-check"></i> Previsões
                    </a>
                </li>

                <li class="mt-3 mb-1 px-2">
                    <small class="text-secondary text-uppercase" style="font-size:.7rem;letter-spacing:.08em;">Cadastros</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('marcas.index') }}" class="nav-link {{ request()->routeIs('marcas.*') ? 'active' : '' }}">
                        <i class="bi bi-bookmark"></i> Marcas
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pecas.index') }}" class="nav-link {{ request()->routeIs('pecas.*') ? 'active' : '' }}">
                        <i class="bi bi-gear"></i> Peças
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tipos-veiculo.index') }}" class="nav-link {{ request()->routeIs('tipos-veiculo.*') ? 'active' : '' }}">
                        <i class="bi bi-tags"></i> Tipos de Veículo
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tipos-manutencao.index') }}" class="nav-link {{ request()->routeIs('tipos-manutencao.*') ? 'active' : '' }}">
                        <i class="bi bi-list-check"></i> Tipos de Manutenção
                    </a>
                </li>

                @if(auth()->user()->isMaster())
                <li class="mt-3 mb-1 px-2">
                    <small class="text-secondary text-uppercase" style="font-size:.7rem;letter-spacing:.08em;">Administração</small>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i> Usuários
                    </a>
                </li>
                @endif
            </ul>
        </nav>

        <main class="main-content flex-grow-1 p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
