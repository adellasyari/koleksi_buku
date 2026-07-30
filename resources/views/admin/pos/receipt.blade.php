@extends('layouts.master')

@section('content')
  <div class="page-header">
    <h3 class="page-title">Struk Pembayaran</h3>
  </div>

  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="card">
        <div class="card-body text-center">
          <h5 class="mb-2">ID Pesanan</h5>
          <p style="font-weight:700;">{{ $id_pesanan }}</p>

          @if(!empty($qrCode))
            <div class="my-3">
              <img src="{{ $qrCode }}" alt="QR {{ $id_pesanan }}" width="150" height="150" />
            </div>
          @endif
          @unless(!empty($qrCode))
            <div class="alert alert-warning mt-3">QR Code tidak tersedia. Periksa log di <code>storage/logs/laravel.log</code> untuk detail.</div>
          @endunless

          <div class="mt-3">
            <a href="{{ route('pos.index') }}" class="btn btn-primary">Kembali ke POS</a>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
