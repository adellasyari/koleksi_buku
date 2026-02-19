<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - {{ config('app.name', 'Koleksi Buku') }}</title>
    @include('layouts.style-global')
    <style>
        .auth .auth-form-light { max-width: 420px; margin: 0 auto; border-radius: 8px; }
        .brand-logo img { width: 120px; }
        .auth-link { font-size: 0.95rem; }
    </style>
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth px-0">
                    <div class="card col-lg-4 mx-auto auth-form-light text-left p-4">
                        <div class="brand-logo text-center mb-3">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                        </div>
                        <h4 class="text-center">Selamat datang!</h4>
                        <h6 class="font-weight-light text-center mb-4">Masuk untuk melanjutkan ke dashboard</h6>

                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <form class="pt-3" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control form-control-lg" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" name="password" required class="form-control form-control-lg" placeholder="Password">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Masuk</button>
                            </div>
                            <div class="mt-2">
                                <a href="/auth/google" class="btn btn-block btn-google auth-form-btn" style="background-color: #db4437; color: white;">
                                    <i class="mdi mdi-google me-2"></i> Masuk dengan Google
                                </a>
                            </div>
                            <div class="my-2 d-flex justify-content-between align-items-center">
                                @if (Route::has('password.request'))
                                    <a class="auth-link" href="{{ route('password.request') }}">Lupa password?</a>
                                @endif
                            </div>
                            <div class="text-center mt-4 font-weight-light"> Belum punya akun? <a href="{{ route('register') }}" class="text-primary">Daftar di sini</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.script-global')
</body>
</html>
