@extends('layouts.master')

@push('style-page')
<!-- optional page styles -->
@endpush

@section('content')
  <div class="page-header">
    <h3 class="page-title">Buku</h3>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Daftar Buku</h4>
          <a href="{{ route('buku.create') }}" class="btn btn-primary mb-3">Tambah Buku</a>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Judul</th>
                  <th>Pengarang</th>
                  <th>Nama Kategori</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($bukus as $index => $buku)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $buku->kode }}</td>
                    <td>{{ $buku->judul }}</td>
                    <td>{{ $buku->pengarang }}</td>
                    <td>{{ $buku->kategori->nama_kategori ?? '-' }}</td>
                    <td>
                      <a href="{{ route('buku.edit', $buku->getKey()) }}" class="btn btn-sm btn-warning">Edit</a>

                      <form action="{{ route('buku.destroy', $buku->getKey()) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus buku ini?')">Hapus</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="6" class="text-center">Belum ada data buku.</td>
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
<!-- optional page scripts -->
@endpush
