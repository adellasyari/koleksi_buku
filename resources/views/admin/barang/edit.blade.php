@extends('layouts.master')
@section('title', 'Edit Barang')
@section('content')
<div class="card">
    <div class="card-header"><h4>Edit Data Barang</h4></div>
    <div class="card-body">
        <form action="{{ url('/barang/'.$barang->id_barang) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-3">
                <label>ID Barang (Otomatis)</label>
                <input type="text" class="form-control" value="{{ $barang->id_barang }}" readonly>
            </div>
            <div class="form-group mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama" class="form-control" value="{{ $barang->nama }}" required>
            </div>
            <div class="form-group mb-3">
                <label>Harga Barang (Rp)</label>
                <input type="number" name="harga" class="form-control" value="{{ $barang->harga }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Data</button>
            <a href="{{ url('/barang') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection