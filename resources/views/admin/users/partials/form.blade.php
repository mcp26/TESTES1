@php($u = $user ?? null)

<div class="mb-3">
    <label class="form-label">Nome</label>
    <input type="text" name="name" value="{{ old('name', $u?->name) }}" class="form-control @error('name') is-invalid @enderror" required autofocus>
    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">E-mail</label>
    <input type="email" name="email" value="{{ old('email', $u?->email) }}" class="form-control @error('email') is-invalid @enderror" required>
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Senha {{ $u ? '(deixe em branco para manter a atual)' : '' }}</label>
    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" {{ $u ? '' : 'required' }}>
    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Papel</label>
    <select name="role" class="form-select @error('role') is-invalid @enderror" required>
        <option value="junior" {{ old('role', $u?->role) === 'junior' ? 'selected' : '' }}>Junior</option>
        <option value="master" {{ old('role', $u?->role) === 'master' ? 'selected' : '' }}>Master</option>
    </select>
    @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
</div>

<div class="mb-3">
    <label class="form-label">Veículos Atribuídos</label>
    <div class="border rounded p-2" style="max-height:220px;overflow-y:auto;">
        @php($atribuidos = old('veiculos', $u?->veiculos->pluck('id')->toArray() ?? []))
        @forelse($veiculos as $veiculo)
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="veiculos[]" value="{{ $veiculo->id }}"
                       id="v{{ $veiculo->id }}" {{ in_array($veiculo->id, $atribuidos) ? 'checked' : '' }}>
                <label class="form-check-label" for="v{{ $veiculo->id }}">{{ $veiculo->nome }}</label>
            </div>
        @empty
            <p class="text-muted small mb-0">Nenhum veículo ativo cadastrado.</p>
        @endforelse
    </div>
</div>
