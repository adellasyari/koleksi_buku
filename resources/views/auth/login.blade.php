<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Login ke dashboard Koleksi Buku">
    <title>Masuk — {{ config('app.name', 'Koleksi Buku') }}</title>
    @include('layouts.style-global')
    <style>
        body { margin: 0; padding: 0; }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* ── Left Panel ─────────────────── */
        .auth-left {
            flex: 1;
            background: linear-gradient(145deg, #0f172a 0%, #1e1b4b 50%, #0c1445 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px;
            position: relative;
            overflow: hidden;
        }

        .auth-left::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,.3) 0%, transparent 65%);
            top: -100px; right: -100px;
            pointer-events: none;
        }
        .auth-left::after {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            background: radial-gradient(circle, rgba(6,182,212,.2) 0%, transparent 65%);
            bottom: -60px; left: -60px;
            pointer-events: none;
        }

        .auth-left-content { position: relative; z-index: 1; text-align: center; }

        .auth-brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 56px;
        }
        .auth-brand-icon {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #6366f1, #818cf8);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(99,102,241,.4);
        }
        .auth-brand-icon i { font-size: 1.6rem; color: #fff; }
        .auth-brand-name {
            text-align: left;
            font-size: 1.4rem;
            font-weight: 800;
            color: #f1f5f9;
            letter-spacing: -.03em;
            line-height: 1.1;
        }
        .auth-brand-name span { display: block; font-size: .8rem; font-weight: 400; color: #818cf8; letter-spacing: .02em; }

        .auth-illustration {
            margin-bottom: 48px;
        }
        .auth-illustration .illus-circle {
            width: 180px; height: 180px;
            border-radius: 50%;
            background: linear-gradient(135deg, rgba(99,102,241,.2), rgba(6,182,212,.15));
            border: 1px solid rgba(99,102,241,.3);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 32px;
            animation: float 4s ease-in-out infinite;
        }
        .auth-illustration .illus-circle i { font-size: 5rem; color: #818cf8; }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }

        .auth-tagline { color: #f1f5f9; font-size: 1.6rem; font-weight: 700; line-height: 1.3; margin-bottom: 12px; letter-spacing: -.02em; }
        .auth-tagline span { color: #818cf8; }
        .auth-sub { color: #64748b; font-size: .9rem; line-height: 1.6; max-width: 300px; margin: 0 auto; }

        .auth-dots { display: flex; gap: 8px; margin-top: 40px; justify-content: center; }
        .auth-dots span { width: 8px; height: 8px; border-radius: 99px; background: rgba(99,102,241,.3); transition: all .3s; }
        .auth-dots span:first-child { background: #6366f1; width: 24px; }

        /* ── Right Panel ─────────────────── */
        .auth-right {
            width: 480px;
            flex-shrink: 0;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 48px 56px;
        }

        .auth-form-container { width: 100%; }

        .auth-form-header { margin-bottom: 32px; }
        .auth-form-header h2 {
            font-size: 1.75rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
            letter-spacing: -.03em;
        }
        .auth-form-header p { color: #64748b; font-size: .9rem; margin: 0; }

        .form-floating-group {
            position: relative;
            margin-bottom: 16px;
        }
        .form-floating-group .form-icon {
            position: absolute;
            left: 14px; top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1.1rem;
            pointer-events: none;
            z-index: 1;
        }
        .form-floating-group .form-control {
            padding-left: 42px !important;
        }

        .btn-login {
            width: 100%;
            padding: 14px !important;
            font-size: 1rem !important;
            font-weight: 600 !important;
            border-radius: 12px !important;
            background: linear-gradient(135deg, #6366f1, #4f46e5) !important;
            color: #fff !important;
            border: none !important;
            box-shadow: 0 4px 20px rgba(99,102,241,.4) !important;
            transition: all .25s ease !important;
            margin-top: 8px;
            letter-spacing: .01em;
        }
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(99,102,241,.5) !important;
        }
        .btn-login:active { transform: scale(.98); }

        .btn-google-login {
            width: 100%;
            padding: 12px !important;
            border-radius: 12px !important;
            border: 1.5px solid #e2e8f0 !important;
            background: #fff !important;
            color: #334155 !important;
            font-weight: 500 !important;
            font-size: .9rem !important;
            display: flex !important;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all .2s ease !important;
            margin-top: 10px;
        }
        .btn-google-login:hover { background: #f8fafc !important; border-color: #cbd5e1 !important; }
        .google-icon {
            width: 20px; height: 20px;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><path fill="%23FFC107" d="M43.6 20H24v8h11.3c-1.6 4.6-6 8-11.3 8-6.6 0-12-5.4-12-12s5.4-12 12-12c3 0 5.7 1.1 7.8 2.9l6-6C34 5.1 29.3 3 24 3 12.4 3 3 12.4 3 24s9.4 21 21 21c11 0 21-8 21-21 0-1.3-.1-2.7-.4-4z"/><path fill="%23FF3D00" d="M6.3 14.7l6.6 4.8C14.4 15.1 18.9 12 24 12c3 0 5.7 1.1 7.8 2.9l6-6C34 5.1 29.3 3 24 3 16.3 3 9.6 7.9 6.3 14.7z"/><path fill="%234CAF50" d="M24 45c5.2 0 9.9-1.9 13.5-5l-6.2-5.2C29.4 36.5 26.9 37 24 37c-5.2 0-9.7-3.3-11.3-7.9l-6.6 5.1C9.5 41 16.3 45 24 45z"/><path fill="%231976D2" d="M43.6 20H24v8h11.3c-.7 2-2 3.8-3.8 5.1l6.2 5.2c3.6-3.4 5.8-8.4 5.8-14.3 0-1.3-.1-2.7-.4-4z"/></svg>') no-repeat center/contain;
            flex-shrink: 0;
        }

        .auth-divider {
            display: flex; align-items: center; gap: 12px;
            margin: 16px 0;
            color: #cbd5e1; font-size: .8rem;
        }
        .auth-divider::before, .auth-divider::after {
            content: ''; flex: 1; height: 1px; background: #e2e8f0;
        }

        .auth-links {
            text-align: center;
            margin-top: 24px;
        }
        .auth-links a { color: #6366f1; font-weight: 600; text-decoration: none; }
        .auth-links a:hover { text-decoration: underline; }
        .auth-links p { color: #64748b; font-size: .875rem; margin: 0; }

        .forgot-link {
            display: block;
            text-align: right;
            font-size: .8rem;
            color: #6366f1;
            text-decoration: none;
            margin-top: -8px;
            margin-bottom: 8px;
            font-weight: 500;
        }
        .forgot-link:hover { text-decoration: underline; }

        /* ── Responsive ─────────────────── */
        @media (max-width: 768px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; padding: 32px 24px; }
        }
    </style>
</head>
<body>
<div class="auth-wrapper">

    {{-- Left: Branding --}}
    <div class="auth-left">
        <div class="auth-left-content">
            <div class="auth-brand">
                <div class="auth-brand-icon">
                    <i class="mdi mdi-book-open-variant"></i>
                </div>
                <div class="auth-brand-name">
                    Koleksi Buku
                    <span>Management System</span>
                </div>
            </div>

            <div class="auth-illustration">
                <div class="illus-circle">
                    <i class="mdi mdi-library-shelves"></i>
                </div>
                <div class="auth-tagline">Kelola <span>Koleksi</span><br>dengan Mudah</div>
                <p class="auth-sub">Platform manajemen buku dan katalog digital yang modern, cepat, dan mudah digunakan.</p>
            </div>

            <div class="auth-dots">
                <span></span><span></span><span></span>
            </div>
        </div>
    </div>

    {{-- Right: Form --}}
    <div class="auth-right">
        <div class="auth-form-container">
            <div class="auth-form-header">
                <h2>Selamat Datang 👋</h2>
                <p>Masukkan kredensial Anda untuk mengakses dashboard</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
                    <i class="mdi mdi-alert-circle-outline"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating-group">
                    <i class="mdi mdi-email-outline form-icon"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus
                           class="form-control form-control-lg"
                           placeholder="Email address">
                </div>

                <div class="form-floating-group">
                    <i class="mdi mdi-lock-outline form-icon"></i>
                    <input id="password" type="password" name="password" required
                           class="form-control form-control-lg"
                           placeholder="Password">
                </div>

                @if (Route::has('password.request'))
                    <a class="forgot-link" href="{{ route('password.request') }}">Lupa password?</a>
                @endif

                <button type="submit" class="btn btn-login">
                    <i class="mdi mdi-login me-2"></i> Masuk
                </button>
            </form>

            <div class="auth-divider">atau lanjutkan dengan</div>

            <a href="/auth/google" class="btn btn-google-login">
                <span class="google-icon"></span>
                Masuk dengan Google
            </a>

            <div class="auth-links mt-4">
                <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
            </div>
        </div>
    </div>
</div>

@include('layouts.script-global')
</body>
</html>
