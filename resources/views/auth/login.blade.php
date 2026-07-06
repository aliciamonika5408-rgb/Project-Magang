<x-guest-layout>
    <div class="text-center mb-4">
        <h4 class="fw-bold text-navy">Masuk Admin</h4>
        <p class="text-muted text-sm mb-0">Masukkan email dan kata sandi akun admin Anda.</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show text-sm mb-4" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label fw-bold text-navy text-sm">Alamat Email</label>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-envelope"></i></span>
                <input id="email" type="email" class="form-control border-start-0 py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="Masukkan email admin">
            </div>
            @error('email')
                <div class="text-danger text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label fw-bold text-navy text-sm mb-0">Kata Sandi</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs text-danger text-decoration-none">Lupa password?</a>
                @endif
            </div>
            <div class="input-group">
                <span class="input-group-text bg-light text-muted border-end-0"><i class="bi bi-lock"></i></span>
                <input id="password" type="password" class="form-control border-start-0 py-2 @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan kata sandi">
            </div>
            @error('password')
                <div class="text-danger text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4 form-check">
            <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
            <label class="form-check-label text-sm text-muted" for="remember_me">Ingat Saya</label>
        </div>

        <div class="d-grid mb-3">
            <button type="submit" class="btn btn-danger btn-lg py-2.5 fw-semibold text-white shadow-sm" style="background-color: var(--accent-orange); border-color: var(--accent-orange);">
                <i class="bi bi-box-arrow-in-right me-2"></i> Masuk ke Admin Panel
            </button>
        </div>
    </form>
</x-guest-layout>
