<x-guest-layout>
    @if(session('status'))
        <div class="alert alert-info mb-3">{{ session('status') }}</div>
    @endif

    <h5 class="mb-4 fw-bold text-center">Entrar no Sistema</h5>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   required autofocus autocomplete="username">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input id="password" type="password" name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   required autocomplete="current-password">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label" for="remember_me">Lembrar-me</label>
        </div>

        <div class="d-flex justify-content-between align-items-center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small text-muted">Esqueceu a senha?</a>
            @endif
            <button type="submit" class="btn btn-dark px-4">Entrar</button>
        </div>
    </form>
</x-guest-layout>
