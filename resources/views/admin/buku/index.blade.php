@extends('layouts.master')

@push('style-page')
<style>
  .table-actions form { display: inline-block; }
  .empty-state {
    text-align: center; padding: 60px 20px;
  }
  .empty-state i { font-size: 4rem; color: #e2e8f0; display: block; margin-bottom: 12px; }
  .empty-state p { color: #94a3b8; font-size: .9rem; }
</style>
@endpush

@section('title', 'Daftar Buku — Koleksi Buku')

@section('content')

  {{-- Page Header --}}
  <div class="page-header">
    <div>
      <div class="breadcrumb-nav">
        <a href="/home">Dashboard</a>
        <span class="sep"><i class="mdi mdi-chevron-right"></i></span>
        <span>Buku</span>
      </div>
      <h3 class="page-title">
        <i class="mdi mdi-book-open-page-variant-outline me-2" style="color:#6366f1;"></i>
        Daftar Buku
      </h3>
    </div>
    <a href="{{ route('buku.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
      <i class="mdi mdi-plus"></i>
      Tambah Buku
    </a>
  </div>

  @if(session('success'))
    <div class="alert alert-success d-flex align-items-center gap-2 mb-4">
      <i class="mdi mdi-check-circle-outline"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body" style="padding: 0 !important;">

          {{-- Card Header --}}
          <div class="d-flex align-items-center justify-content-between px-4 py-3" style="border-bottom:1px solid #f1f5f9;">
            <div>
              <h6 class="card-title mb-0" style="margin-bottom:0 !important;">Koleksi Buku</h6>
              <p style="font-size:.8rem;color:#94a3b8;margin:2px 0 0;">
                Total <strong style="color:#6366f1;">{{ isset($bukus) ? $bukus->count() : 0 }}</strong> buku terdaftar
              </p>
            </div>
          </div>

          {{-- Table --}}
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th style="width:50px;">#</th>
                  <th>Kode</th>
                  <th>Judul</th>
                  <th>Pengarang</th>
                  <th>Kategori</th>
                  <th style="width:140px; text-align:center;">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($bukus as $index => $buku)
                  <tr>
                    <td>
                      <span style="font-size:.8rem;color:#94a3b8;font-weight:600;">{{ $index + 1 }}</span>
                    </td>
                    <td>
                      <code style="background:#f1f5f9;color:#6366f1;padding:2px 8px;border-radius:6px;font-size:.8rem;">
                        {{ $buku->kode }}
                      </code>
                    </td>
                    <td>
                      <div style="font-weight:600;color:#0f172a;">{{ $buku->judul }}</div>
                    </td>
                    <td>
                      <div style="display:flex;align-items:center;gap:8px;">
                        <div style="width:28px;height:28px;border-radius:50%;background:linear-gradient(135deg,#e0e7ff,#c7d2fe);display:flex;align-items:center;justify-content:center;font-size:.7rem;font-weight:700;color:#4f46e5;flex-shrink:0;">
                          {{ strtoupper(substr($buku->pengarang, 0, 1)) }}
                        </div>
                        {{ $buku->pengarang }}
                      </div>
                    </td>
                    <td>
                      @if($buku->kategori)
                        <span class="badge-category">{{ $buku->kategori->nama_kategori }}</span>
                      @else
                        <span style="color:#cbd5e1;font-size:.8rem;">—</span>
                      @endif
                    </td>
                    <td class="table-actions" style="text-align:center;">
                      <a href="{{ route('buku.edit', $buku->getKey()) }}"
                         class="btn btn-sm btn-warning me-1"
                         title="Edit">
                        <i class="mdi mdi-pencil-outline"></i>
                      </a>
                      <form action="{{ route('buku.destroy', $buku->getKey()) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger"
                                title="Hapus"
                                onclick="return confirm('Yakin ingin menghapus buku ini?')">
                          <i class="mdi mdi-trash-can-outline"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6">
                      <div class="empty-state">
                        <i class="mdi mdi-book-off-outline"></i>
                        <p>Belum ada data buku.</p>
                        <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">Tambah Buku Pertama</a>
                      </div>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>

@endsection

@push('script-page')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    // auto-hide success alert
    setTimeout(function() {
      const alert = document.querySelector('.alert-success');
      if (alert) { alert.style.opacity = '0'; alert.style.transition = 'opacity .5s'; setTimeout(() => alert.remove(), 500); }
    }, 3500);
  });
</script>
@endpush
