@extends('layouts.master')

@section('content')
  <div class="page-header">
    <h3 class="page-title">Kategori</h3>
  </div>

  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <a href="{{ route('kategori.create') }}" class="btn btn-primary mb-3">Tambah Kategori</a>
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Kategori</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($kategoris as $index => $kategori)
                  <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $kategori->nama_kategori }}</td>
                    <td>
                      <a href="{{ route('kategori.edit', $kategori->getKey()) }}" class="btn btn-sm btn-warning">Edit</a>
                      <form action="{{ route('kategori.destroy', $kategori->getKey()) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="3" class="text-center">Belum ada kategori.</td>
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
