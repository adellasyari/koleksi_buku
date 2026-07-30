@extends('layouts.master')

@section('title', 'Edit Buku — Koleksi Buku')

@section('content')

  {{-- Page Header --}}
  <div class="page-header">
    <div>
      <div class="breadcrumb-nav">
        <a href="/home">Dashboard</a>
        <span class="sep"><i class="mdi mdi-chevron-right"></i></span>
        <a href="{{ route('buku.index') }}">Buku</a>
        <span class="sep"><i class="mdi mdi-chevron-right"></i></span>
        <span>Edit</span>
      </div>
      <h3 class="page-title">
        <i class="mdi mdi-pencil-circle-outline me-2" style="color:#f59e0b;"></i>
        Edit Buku
      </h3>
    </div>
  </div>

  <div class="row justify-content-center">
    <div class="col-lg-7">

      {{-- Edit mode notice --}}
      <div style="background:#fffbeb;border:1px solid #fde68a;border-radius:12px;padding:12px 16px;margin-bottom:20px;display:flex;align-items:center;gap:10px;">
        <i class="mdi mdi-pencil-outline" style="color:#f59e0b;font-size:1.2rem;flex-shrink:0;"></i>
        <div>
          <span style="font-weight:600;color:#92400e;font-size:.875rem;">Mode Edit</span>
          <span style="color:#78350f;font-size:.8rem;margin-left:6px;">Anda sedang mengubah data buku: <strong>{{ $buku->judul }}</strong></span>
        </div>
      </div>

      <div class="card">
        <div class="card-body">

          {{-- Card Title --}}
          <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid #f1f5f9;">
            <div style="width:42px;height:42px;background:linear-gradient(135deg,#f59e0b,#fbbf24);border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
              <i class="mdi mdi-book-edit-outline" style="color:#fff;font-size:1.2rem;"></i>
            </div>
            <div>
              <div style="font-weight:700;color:#0f172a;font-size:1rem;">Form Edit Buku</div>
              <div style="font-size:.8rem;color:#94a3b8;">Perbarui informasi buku di bawah ini</div>
            </div>
          </div>

          @if ($errors->any())
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
              <i class="mdi mdi-alert-circle-outline"></i>
              <span>{{ $errors->first() }}</span>
            </div>
          @endif

          <form action="{{ route('buku.update', $buku->getKey()) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
              <label class="form-label">Kategori</label>
              <select name="idkategori" class="form-control">
                <option value="">— Pilih Kategori —</option>
                @foreach($kategoris as $kat)
                  <option value="{{ $kat->idkategori }}" {{ $buku->idkategori == $kat->idkategori ? 'selected' : '' }}>
                    {{ $kat->nama_kategori }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Kode Buku</label>
              <div style="position:relative;">
                <i class="mdi mdi-barcode-scan" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:1.1rem;"></i>
                <input type="text" name="kode" class="form-control" style="padding-left:38px;" value="{{ old('kode', $buku->kode) }}" placeholder="Contoh: BK-001">
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Judul Buku</label>
              <div style="position:relative;">
                <i class="mdi mdi-book-outline" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:1.1rem;"></i>
                <input type="text" name="judul" class="form-control" style="padding-left:38px;" value="{{ old('judul', $buku->judul) }}" placeholder="Masukkan judul buku">
              </div>
            </div>

            <div class="mb-4">
              <label class="form-label">Pengarang</label>
              <div style="position:relative;">
                <i class="mdi mdi-account-edit-outline" style="position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#94a3b8;font-size:1.1rem;"></i>
                <input type="text" name="pengarang" class="form-control" style="padding-left:38px;" value="{{ old('pengarang', $buku->pengarang) }}" placeholder="Nama pengarang">
              </div>
            </div>

            <div class="d-flex gap-3">
              <button type="submit" class="btn btn-warning d-flex align-items-center gap-2">
                <i class="mdi mdi-content-save-edit-outline"></i>
                Perbarui Data
              </button>
              <a href="{{ route('buku.index') }}" class="btn btn-secondary d-flex align-items-center gap-2">
                <i class="mdi mdi-arrow-left"></i>
                Kembali
              </a>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>

@endsection
