@extends('layouts.master')

@section('content')
    <div class="page-header">
        <h3 class="page-title">Data Customer</h3>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Daftar Customer</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:70px">No</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Kota</th>
                                    <th style="width:160px">Foto</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($customers ?? [] as $row)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $row->nama }}</td>
                                        <td style="max-width:400px; white-space:normal;">{{ $row->alamat }}</td>
                                        <td>{{ $row->kota }}</td>
                                        <td>
                                            @if(!empty($row->foto_blob))
                                                <img src="data:image/png;base64,{{ base64_encode($row->foto_blob) }}" alt="Foto Profil" class="img-fluid" style="width:80px;height:80px;object-fit:cover;border-radius:0;" />
                                            @elseif(!empty($row->foto_path))
                                                <img src="{{ asset('uploads/customers/' . $row->foto_path) }}" alt="Foto Profil" class="img-fluid" style="width:80px;height:80px;object-fit:cover;border-radius:0;" />
                                            @else
                                                <span class="text-muted">No foto</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada customer.</td>
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
