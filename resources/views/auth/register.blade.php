<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Daftar akun baru di Koleksi Buku">
    <title>Daftar — {{ config('app.name', 'Koleksi Buku') }}</title>
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
            background: radial-gradient(circle, rgba(16,185,129,.15) 0%, transparent 65%);
            bottom: -60px; left: -60px;
            pointer-events: none;
        }
        .auth-left-content { position: relative; z-index: 1; text-align: center; }

        .auth-brand {
            display: inline-flex; align-items: center; gap: 14px; margin-bottom: 56px;
        }
        .auth-brand-icon {
            width: 52px; height: 52px;
            background: linear-gradient(135deg, #10b981, #34d399);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(16,185,129,.4);
        }
        .auth-brand-icon i { font-size: 1.6rem; color: #fff; }
        .auth-brand-name {
            text-align: left; font-size: 1.4rem; font-weight: 800;
            color: #f1f5f9; letter-spacing: -.03em; line-height: 1.1;
        }
        .auth-brand-name span { display: block; font-size: .8rem; font-weight: 400; color: #34d399; letter-spacing: .02em; }

        .auth-illustration { margin-bottom: 48px; }
        .illus-circle {
            width: 180px; height: 180px; border-radius: 50%;
            background: linear-gradient(135deg, rgba(16,185,129,.2), rgba(99,102,241,.15));
            border: 1px solid rgba(16,185,129,.3);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 32px;
            animation: float 4s ease-in-out infinite;
        }
        .illus-circle i { font-size: 5rem; color: #34d399; }
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }

        .auth-tagline { color: #f1f5f9; font-size: 1.6rem; font-weight: 700; line-height: 1.3; margin-bottom: 12px; letter-spacing: -.02em; }
        .auth-tagline span { color: #34d399; }
        .auth-sub { color: #64748b; font-size: .9rem; line-height: 1.6; max-width: 300px; margin: 0 auto; }

        .auth-dots { display: flex; gap: 8px; margin-top: 40px; justify-content: center; }
        .auth-dots span { width: 8px; height: 8px; border-radius: 99px; background: rgba(16,185,129,.3); }
        .auth-dots span:last-child { background: #10b981; width: 24px; }

        /* ── Right Panel ─────────────────── */
        .auth-right {
            width: 520px; flex-shrink: 0;
            background: #fff;
            display: flex; flex-direction: column;
            align-items: center; justify-content: center;
            padding: 48px 56px;
            overflow-y: auto;
        }
        .auth-form-container { width: 100%; }
        .auth-form-header { margin-bottom: 28px; }
        .auth-form-header h2 { font-size: 1.65rem; font-weight: 800; color: #0f172a; margin-bottom: 6px; letter-spacing: -.03em; }
        .auth-form-header p { color: #64748b; font-size: .9rem; margin: 0; }

        .form-floating-group { position: relative; margin-bottom: 14px; }
        .form-floating-group .form-icon {
            position: absolute; left: 14px; top: 50%;
            transform: translateY(-50%); color: #94a3b8;
            font-size: 1.1rem; pointer-events: none; z-index: 1;
        }
        .form-floating-group .form-control { padding-left: 42px !important; }

        .btn-register {
            width: 100%; padding: 14px !important; font-size: 1rem !important;
            font-weight: 600 !important; border-radius: 12px !important;
            background: linear-gradient(135deg, #10b981, #059669) !important;
            color: #fff !important; border: none !important;
            box-shadow: 0 4px 20px rgba(16,185,129,.4) !important;
            transition: all .25s ease !important; margin-top: 8px;
        }
        .btn-register:hover { transform: translateY(-2px); box-shadow: 0 8px 28px rgba(16,185,129,.5) !important; }
        .btn-register:active { transform: scale(.98); }

        .auth-links { text-align: center; margin-top: 20px; }
        .auth-links a { color: #6366f1; font-weight: 600; text-decoration: none; }
        .auth-links a:hover { text-decoration: underline; }
        .auth-links p { color: #64748b; font-size: .875rem; margin: 0; }

        .form-row { display: flex; gap: 12px; }
        .form-row .form-floating-group { flex: 1; }

        @media (max-width: 768px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; padding: 32px 24px; }
            .form-row { flex-direction: column; gap: 0; }
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
                    <i class="mdi mdi-account-plus-outline"></i>
                </div>
                <div class="auth-tagline">Bergabung <span>Sekarang</span><br>dan Mulai Berkarya</div>
                <p class="auth-sub">Buat akun untuk mengakses seluruh fitur manajemen buku dan katalog digital.</p>
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
                <h2>Buat Akun Baru ✨</h2>
                <p>Isi formulir di bawah untuk mendaftar sebagai pengguna baru</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
                    <i class="mdi mdi-alert-circle-outline"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-floating-group">
                    <i class="mdi mdi-account-outline form-icon"></i>
                    <input id="name" type="text" name="name" value="{{ old('name') }}"
                           required autofocus
                           class="form-control form-control-lg"
                           placeholder="Nama lengkap">
                </div>

                <div class="form-floating-group">
                    <i class="mdi mdi-email-outline form-icon"></i>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required
                           class="form-control form-control-lg"
                           placeholder="Email address">
                </div>

                <div class="form-row">
                    <div class="form-floating-group">
                        <i class="mdi mdi-lock-outline form-icon"></i>
                        <input id="password" type="password" name="password" required
                               class="form-control form-control-lg"
                               placeholder="Password">
                    </div>
                    <div class="form-floating-group">
                        <i class="mdi mdi-lock-check-outline form-icon"></i>
                        <input id="password-confirm" type="password" name="password_confirmation" required
                               class="form-control form-control-lg"
                               placeholder="Konfirmasi">
                    </div>
                </div>

                <button type="submit" class="btn btn-register">
                    <i class="mdi mdi-account-plus me-2"></i> Daftar Sekarang
                </button>
            </form>

            <div class="auth-links mt-4">
                <p>Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a></p>
            </div>
        </div>
    </div>
</div>

@include('layouts.script-global')
</body>
</html>
