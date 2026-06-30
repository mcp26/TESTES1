@extends('layouts.app')

@section('title', 'Registrar Manutenção')

@section('content')
    <h3 class="mb-4">Registrar Manutenção</h3>

    <div x-data="manutencaoForm(@js($pecasOptions), @js($marcasOptions), @js($veiculosData))" class="card" style="max-width:800px;">
        <div class="card-body">
            <form method="POST" action="{{ route('manutencoes.store') }}">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Veículo</label>
                        <select name="veiculo_id" x-model="veiculoId" class="form-select @error('veiculo_id') is-invalid @enderror" required>
                            <option value="">Selecione...</option>
                            @foreach($veiculos as $veiculo)
                                <option value="{{ $veiculo->id }}" {{ (int) old('veiculo_id') === $veiculo->id ? 'selected' : '' }}>{{ $veiculo->nome }}</option>
                            @endforeach
                        </select>
                        @error('veiculo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tipo de Manutenção</label>
                        <select name="tipo_manutencao_id" x-model="tipoManutencaoId" class="form-select @error('tipo_manutencao_id') is-invalid @enderror" required>
                            <option value="">Selecione um veículo primeiro...</option>
                            <template x-for="tm in tiposManutencaoDisponiveis" :key="tm.id">
                                <option :value="tm.id" x-text="tm.nome"></option>
                            </template>
                        </select>
                        @error('tipo_manutencao_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Data da Manutenção</label>
                        <input type="date" name="data_manutencao" value="{{ old('data_manutencao') }}" class="form-control @error('data_manutencao') is-invalid @enderror" required>
                        @error('data_manutencao')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quilometragem / Horas</label>
                        <input type="number" step="0.01" min="0" name="valor_medicao" value="{{ old('valor_medicao') }}" class="form-control @error('valor_medicao') is-invalid @enderror" required>
                        @error('valor_medicao')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label mb-0 fw-bold">Peças Utilizadas</label>
                    <button type="button" class="btn btn-sm btn-outline-dark" @click="addLinha()">
                        <i class="bi bi-plus-lg me-1"></i>Adicionar Peça
                    </button>
                </div>
                @error('pecas')<div class="text-danger small mb-2">{{ $message }}</div>@enderror

                <template x-for="(linha, index) in linhas" :key="index">
                    <div class="peca-row">
                        <div class="row align-items-end">
                            <div class="col-md-5 mb-2">
                                <label class="form-label small">Peça</label>
                                <div class="input-group">
                                    <select :name="`pecas[${index}][peca_id]`" x-model="linha.peca_id" class="form-select" required>
                                        <option value="">Selecione...</option>
                                        <template x-for="p in pecasDisponiveis" :key="p.id">
                                            <option :value="p.id" x-text="p.nome"></option>
                                        </template>
                                    </select>
                                    <button type="button" class="btn btn-outline-secondary" @click="openQuickCreate('peca', index)" title="Cadastrar nova peça">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <label class="form-label small">Marca</label>
                                <div class="input-group">
                                    <select :name="`pecas[${index}][marca_id]`" x-model="linha.marca_id" class="form-select" required>
                                        <option value="">Selecione...</option>
                                        <template x-for="m in marcasDisponiveis" :key="m.id">
                                            <option :value="m.id" x-text="m.nome"></option>
                                        </template>
                                    </select>
                                    <button type="button" class="btn btn-outline-secondary" @click="openQuickCreate('marca', index)" title="Cadastrar nova marca">
                                        <i class="bi bi-plus-lg"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-2 mb-2">
                                <label class="form-label small">Qtd.</label>
                                <input type="number" min="1" :name="`pecas[${index}][quantidade]`" x-model="linha.quantidade" class="form-control" required>
                            </div>
                            <div class="col-md-1 mb-2">
                                <button type="button" class="btn btn-outline-danger" @click="removeLinha(index)" x-show="linhas.length > 1" title="Remover">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-dark">Salvar Manutenção</button>
                    <a href="{{ route('manutencoes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
                </div>
            </form>
        </div>

        {{-- Modal de criação rápida (compartilhado entre todas as linhas) --}}
        <div class="modal fade" id="quickCreateModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" x-text="quickCreateTarget?.type === 'peca' ? 'Nova Peça' : 'Nova Marca'"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" x-model="quickCreateNome" @keydown.enter.prevent="submitQuickCreate()">
                        <div class="text-danger small mt-1" x-show="quickCreateError" x-text="quickCreateError"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-dark" @click="submitQuickCreate()">Salvar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
