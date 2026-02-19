@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="col-12 grid-margin stretch-card">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Preview Undangan</h4>

          <a href="{{ url('/unduh-undangan') }}" class="btn btn-gradient-primary">Download PDF</a>

          <div class="mt-3">
            <iframe src="{{ url('/cetak-undangan') }}" width="100%" height="700px" frameborder="0"></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
