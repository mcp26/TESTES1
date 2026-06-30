@php($v = $veiculo ?? null)

<div class="mb-3">
    <label class="form-label">Nome</label>
    <input type="text" name="nome" value="{{ old('nome', $v?->nome) }}" class="form-control @error('nome') is-invalid @enderror" required autofocus>
    @error('nome')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Tipo de Veículo</label>
        <select name="tipo_veiculo_id" class="form-select @error('tipo_veiculo_id') is-invalid @enderror" required>
            <option value="">Selecione...</option>
            @foreach($tiposVeiculo as $tipo)
                <option value="{{ $tipo->id }}" {{ (int) old('tipo_veiculo_id', $v?->tipo_veiculo_id) === $tipo->id ? 'selected' : '' }}>{{ $tipo->nome }}</option>
            @endforeach
        </select>
        @error('tipo_veiculo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Marca</label>
        <select name="marca_id" class="form-select @error('marca_id') is-invalid @enderror" required>
            <option value="">Selecione...</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{ (int) old('marca_id', $v?->marca_id) === $marca->id ? 'selected' : '' }}>{{ $marca->nome }}</option>
            @endforeach
        </select>
        @error('marca_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Data de Aquisição</label>
        <input type="date" name="data_aquisicao" value="{{ old('data_aquisicao', $v?->data_aquisicao?->format('Y-m-d')) }}" class="form-control @error('data_aquisicao') is-invalid @enderror" required>
        @error('data_aquisicao')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Placa</label>
        <input type="text" name="placa" value="{{ old('placa', $v?->placa) }}" class="form-control @error('placa') is-invalid @enderror" required>
        @error('placa')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Vencimento do Documento</label>
        <input type="date" name="vencimento_documento" value="{{ old('vencimento_documento', $v?->vencimento_documento?->format('Y-m-d')) }}" class="form-control @error('vencimento_documento') is-invalid @enderror">
        @error('vencimento_documento')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">Vencimento do Seguro</label>
        <input type="date" name="vencimento_seguro" value="{{ old('vencimento_seguro', $v?->vencimento_seguro?->format('Y-m-d')) }}" class="form-control @error('vencimento_seguro') is-invalid @enderror">
        @error('vencimento_seguro')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Documento (PDF ou imagem, até 5MB)</label>
    <input type="file" name="documento" class="form-control @error('documento') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
    @error('documento')<div class="invalid-feedback">{{ $message }}</div>@enderror
    @if($v?->documento_path)
        <div class="form-text">
            Documento atual: <a href="{{ route('veiculos.documento', $v) }}">baixar</a> (envie um novo arquivo para substituir)
        </div>
    @endif
</div>
