@extends('layouts.master')
@section('title', 'Tambah Barang')
@section('content')
<div class="card">
    <div class="card-header"><h4>Tambah Barang Baru</h4></div>
    <div class="card-body">
        <form action="{{ url('/barang/store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Harga Barang (Rp)</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Simpan Data</button>
            <a href="{{ url('/barang') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection