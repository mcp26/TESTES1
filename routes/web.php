<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Ajax\MarcaQuickCreateController;
use App\Http\Controllers\Ajax\PecaQuickCreateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PecaController;
use App\Http\Controllers\PrevisaoManutencaoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TipoManutencaoController;
use App\Http\Controllers\TipoVeiculoController;
use App\Http\Controllers\VeiculoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Veículos (visualização escopada por papel; criação/edição é master-only)
    Route::get('/veiculos', [VeiculoController::class, 'index'])->name('veiculos.index');
    Route::get('/veiculos/{veiculo}', [VeiculoController::class, 'show'])->name('veiculos.show');
    Route::get('/veiculos/{veiculo}/documento', [VeiculoController::class, 'documento'])->name('veiculos.documento');

    // Catálogos (ambos os papéis podem criar)
    Route::get('/tipos-veiculo', [TipoVeiculoController::class, 'index'])->name('tipos-veiculo.index');
    Route::get('/tipos-veiculo/create', [TipoVeiculoController::class, 'create'])->name('tipos-veiculo.create');
    Route::post('/tipos-veiculo', [TipoVeiculoController::class, 'store'])->name('tipos-veiculo.store');

    Route::get('/marcas', [MarcaController::class, 'index'])->name('marcas.index');
    Route::get('/marcas/create', [MarcaController::class, 'create'])->name('marcas.create');
    Route::post('/marcas', [MarcaController::class, 'store'])->name('marcas.store');
    Route::post('/ajax/marcas', [MarcaQuickCreateController::class, 'store'])->name('ajax.marcas.store');

    Route::get('/pecas', [PecaController::class, 'index'])->name('pecas.index');
    Route::get('/pecas/create', [PecaController::class, 'create'])->name('pecas.create');
    Route::post('/pecas', [PecaController::class, 'store'])->name('pecas.store');
    Route::post('/ajax/pecas', [PecaQuickCreateController::class, 'store'])->name('ajax.pecas.store');

    Route::get('/tipos-manutencao', [TipoManutencaoController::class, 'index'])->name('tipos-manutencao.index');
    Route::get('/tipos-manutencao/create', [TipoManutencaoController::class, 'create'])->name('tipos-manutencao.create');
    Route::post('/tipos-manutencao', [TipoManutencaoController::class, 'store'])->name('tipos-manutencao.store');

    // Manutenções
    Route::get('/manutencoes', [ManutencaoController::class, 'index'])->name('manutencoes.index');
    Route::get('/manutencoes/create', [ManutencaoController::class, 'create'])->name('manutencoes.create');
    Route::post('/manutencoes', [ManutencaoController::class, 'store'])->name('manutencoes.store');
    Route::get('/manutencoes/{manutencao}', [ManutencaoController::class, 'show'])->name('manutencoes.show');

    // Previsão de próximas manutenções
    Route::get('/previsao', [PrevisaoManutencaoController::class, 'index'])->name('previsao.index');

    // Somente master
    Route::middleware('master')->group(function () {
        Route::get('/veiculos-create', [VeiculoController::class, 'create'])->name('veiculos.create');
        Route::post('/veiculos', [VeiculoController::class, 'store'])->name('veiculos.store');
        Route::get('/veiculos/{veiculo}/edit', [VeiculoController::class, 'edit'])->name('veiculos.edit');
        Route::put('/veiculos/{veiculo}', [VeiculoController::class, 'update'])->name('veiculos.update');
        Route::patch('/veiculos/{veiculo}/inativar', [VeiculoController::class, 'inativar'])->name('veiculos.inativar');
        Route::patch('/veiculos/{veiculo}/ativar', [VeiculoController::class, 'ativar'])->name('veiculos.ativar');

        Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');
        Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    });
});

require __DIR__.'/auth.php';
