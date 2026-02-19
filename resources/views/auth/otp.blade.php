<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Input OTP - {{ config('app.name', 'Koleksi Buku') }}</title>
    @include('layouts.style-global')
    <style>.auth .auth-form-light { max-width: 420px; margin: 0 auto; }</style>
</head>
<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="row w-100 m-0">
                <div class="content-wrapper full-page-wrapper d-flex align-items-center auth px-0">
                    <div class="card col-lg-4 mx-auto auth-form-light text-left p-4">
                        <h4 class="text-center">Verifikasi OTP</h4>
                        <p class="text-center">Kode OTP telah dikirim ke: <strong>{{ $user->email }}</strong></p>

                        @if ($errors->any())
                            <div class="alert alert-danger">{{ $errors->first() }}</div>
                        @endif

                        <form method="POST" action="{{ route('otp.verify') }}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <div class="form-group">
                                <input type="text" name="otp" maxlength="6" required autofocus class="form-control form-control-lg" placeholder="Masukkan 6 digit OTP">
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-block btn-gradient-primary btn-lg">Verifikasi</button>
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
