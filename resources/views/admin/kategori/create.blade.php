@extends('layouts.master')

@section('content')
  <div class="page-header">
    <h3 class="page-title">Tambah Kategori</h3>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label">Nama Kategori</label>
              <input type="text" name="nama_kategori" class="form-control" value="{{ old('nama_kategori') }}">
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('kategori.index') }}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
