<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - {{ config('app.name', 'Koleksi Buku') }}</title>
    @include('layouts.style-global')
    <style>
        .auth .auth-form-light { max-width: 520px; margin: 0 auto; border-radius: 8px; }
        .brand-logo img { width: 120px; }
    </style>
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth px-0">
                    <div class="card col-lg-6 mx-auto auth-form-light text-left p-4">
                        <div class="brand-logo text-center mb-3">
                            <img src="{{ asset('assets/images/logo.svg') }}" alt="logo">
                        </div>
                        <h4 class="text-center">Buat akun baru</h4>
                        <h6 class="font-weight-light text-center mb-4">Daftar untuk mendapatkan akses ke dashboard</h6>

                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('register') }}" class="pt-3">
                            @csrf
                            <div class="form-group">
                                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus class="form-control form-control-lg" placeholder="Nama">
                            </div>
                            <div class="form-group">
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required class="form-control form-control-lg" placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input id="password" type="password" name="password" required class="form-control form-control-lg" placeholder="Password">
                            </div>
                            <div class="form-group">
                                <input id="password-confirm" type="password" name="password_confirmation" required class="form-control form-control-lg" placeholder="Konfirmasi Password">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg font-weight-medium auth-form-btn">Daftar</button>
                            </div>
                            <div class="text-center mt-4 font-weight-light"> Sudah punya akun? <a href="{{ route('login') }}" class="text-primary">Masuk di sini</a>
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
