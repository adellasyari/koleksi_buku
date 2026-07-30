@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            @if(session('success'))
                <div class="card shadow-sm border-0 bg-success text-white text-center py-5">
                    <div class="card-body">
                        <h3 class="card-title">Nomor Antrian Anda:</h3>
                        <h1 class="display-1 fw-bold">{{ session('nomor_antrian') }}</h1>
                        <p class="mt-3">{{ session('success') }}</p>
                        <a href="{{ route('antrian.guest') }}" class="btn btn-light mt-4">Kembali</a>
                    </div>
                </div>
            @else
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white text-center py-3">
                        <h4 class="mb-0">Ambil Antrian</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('antrian.daftar') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap</label>
                                <input type="text" class="form-control" id="nama" name="nama" required placeholder="Masukkan nama Anda">
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Ambil Nomor Antrian</button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
