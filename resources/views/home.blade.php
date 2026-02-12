
@extends('layouts.master')

@push('style-page')
<style>
  .stat-card .card-body { padding: 1.25rem; }
  .bg-gradient-info { background: linear-gradient(45deg,#2196F3,#21CBF3); }
  .bg-gradient-success { background: linear-gradient(45deg,#28a745,#8bdc85); }
</style>
@endpush

@section('content')
  <div class="page-header">
    <h3 class="page-title">Dashboard</h3>
  </div>

  <div class="row">
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card stat-card bg-gradient-info text-white">
        <div class="card-body">
          <h4 class="card-title">Jumlah Buku</h4>
          <h2 class="mb-0">{{ $jumlahBuku ?? 0 }}</h2>
        </div>
      </div>
    </div>

    <div class="col-md-6 grid-margin stretch-card">
      <div class="card stat-card bg-gradient-success text-white">
        <div class="card-body">
          <h4 class="card-title">Jumlah Kategori</h4>
          <h2 class="mb-0">{{ $jumlahKategori ?? 0 }}</h2>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('script-page')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    console.log('Dashboard loaded');
  });
</script>
@endpush

