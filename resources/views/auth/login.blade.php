<x-guest-layout>
    <style>
        .auth-form-card h2::before { content: ''; }
        .form-group { margin-bottom: 18px; }
        .form-label { display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px; }
        .form-input {
            width: 100%; padding: 10px 14px;
            border: 1.5px solid #E2E8F0; border-radius: 9px;
            font-size: 14px; font-family: inherit; color: #0F172A; outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }
        .form-input:focus { border-color: #3B82F6; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); }
        .form-error { color: #DC2626; font-size: 12px; margin-top: 4px; }
        .btn-login {
            width: 100%; padding: 11px; border-radius: 9px;
            background: #2563EB; color: #fff; font-weight: 700; font-size: 14px;
            border: none; cursor: pointer; font-family: inherit;
            transition: background 0.15s, transform 0.1s;
        }
        .btn-login:hover { background: #1D4ED8; transform: translateY(-1px); }
        .remember-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 20px; }
        .remember-check { display: flex; align-items: center; gap: 7px; font-size: 13px; color: #64748B; }
        .remember-check input[type=checkbox] { accent-color: #2563EB; width: 15px; height: 15px; }
        .forgot-link { font-size: 12.5px; color: #3B82F6; text-decoration: none; font-weight: 600; }
        .forgot-link:hover { color: #1D4ED8; }
        .status-msg { background: #F0FDF4; border: 1px solid #BBF7D0; color: #166534; padding: 10px 14px; border-radius: 8px; font-size: 13px; margin-bottom: 18px; }
    </style>

    <h2>Selamat Datang</h2>
    <p>Masuk ke panel administrasi SIAPU Desa Kadubeureum.</p>

    @if (session('status'))
        <div class="status-msg">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label class="form-label" for="login">Alamat Email / NIK / Username</label>
            <input id="login" class="form-input" type="text" name="login" value="{{ old('login', 'admin') }}" required autofocus autocomplete="username" placeholder="Masukkan Email, NIK, atau Username">
            @error('login') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="password">Password</label>
            <input id="password" class="form-input" type="password" name="password" value="password" required autocomplete="current-password" placeholder="••••••••">
            @error('password') <p class="form-error">{{ $message }}</p> @enderror
        </div>

        <div class="remember-row">
            <label class="remember-check">
                <input type="checkbox" name="remember" id="remember_me">
                Ingat saya
            </label>
            @if (Route::has('password.request'))
                <a class="forgot-link" href="{{ route('password.request') }}">Lupa password?</a>
            @endif
        </div>

        <button type="submit" class="btn-login">Masuk ke Dashboard</button>
    </form>
</x-guest-layout>
