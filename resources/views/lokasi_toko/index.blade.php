@extends('layouts.master')
@section('title', 'Data Lokasi Toko')
@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Data Lokasi Toko</h4>
        <a href="{{ route('lokasi_toko.create') }}" class="btn btn-primary">Tambah Toko</a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-light">
                    <tr>
                        <th>Barcode</th>
                        <th>Nama Toko</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Accuracy</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($lokasis as $lokasi)
                        <tr>
                            <td>{{ $lokasi->barcode }}</td>
                            <td>{{ $lokasi->nama_toko }}</td>
                            <td>{{ $lokasi->latitude }}</td>
                            <td>{{ $lokasi->longitude }}</td>
                            <td>{{ $lokasi->accuracy }}</td>
                            <td>
                                <a href="{{ route('lokasi_toko.cetak_barcode', $lokasi->barcode) }}" target="_blank" class="btn btn-sm btn-secondary">Cetak Barcode</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data toko.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
