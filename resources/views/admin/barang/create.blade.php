@extends('layouts.master')
@section('title', 'Tambah Barang')
@section('content')
<div class="card">
    <div class="card-header"><h4>Tambah Barang Baru</h4></div>
    <div class="card-body">
        <form id="form-barang" action="{{ url('/barang/store') }}" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label>Harga Barang (Rp)</label>
                <input type="number" name="harga" class="form-control" required>
            </div>
            <button type="button" id="btn-submit" class="btn btn-success">Simpan Data</button>
            <a href="{{ url('/barang') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@push('script-page')
<script>
    $(document).ready(function() {
        $('#btn-submit').on('click', function(e){
            var form = document.getElementById('form-barang');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            var $btn = $(this);
            $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $btn.prop('disabled', true);
            $('#form-barang').submit();
        });
    });
</script>
@endpush
@endsection

@push('scripts')
<script>
    $(function(){
        $('#btn-submit').on('click', function(e){
            var form = document.getElementById('form-barang');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }
            var $btn = $(this);
            $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $btn.prop('disabled', true);
            $('#form-barang').submit();
        });
    });
</script>
@endpush