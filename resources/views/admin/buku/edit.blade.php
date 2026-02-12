@extends('layouts.master')

@section('content')
  <div class="page-header">
    <h3 class="page-title">Ubah Buku</h3>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <form action="{{ route('buku.update', $buku->getKey()) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label">Kategori</label>
              <select name="idkategori" class="form-control">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kat)
                  <option value="{{ $kat->idkategori }}" {{ $buku->idkategori == $kat->idkategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Kode</label>
              <input type="text" name="kode" class="form-control" value="{{ old('kode', $buku->kode) }}">
            </div>
            <div class="mb-3">
              <label class="form-label">Judul</label>
              <input type="text" name="judul" class="form-control" value="{{ old('judul', $buku->judul) }}">
            </div>
            <div class="mb-3">
              <label class="form-label">Pengarang</label>
              <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang', $buku->pengarang) }}">
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('buku.index') }}" class="btn btn-secondary">Batal</a>
          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
