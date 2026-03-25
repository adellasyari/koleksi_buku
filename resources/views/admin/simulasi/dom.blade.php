@extends('layouts.master')
@section('title', 'Simulasi DOM - Praktikum')
@section('content')
<div class="card">
    <div class="card-header"><h4>Simulasi DOM - Tambah Barang (Frontend Only)</h4></div>
    <div class="card-body">
        <form id="form-simulasi" class="mb-3" autocomplete="off">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama-simulasi" class="form-label">Nama Barang</label>
                    <input type="text" id="nama-simulasi" name="nama" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="harga-simulasi" class="form-label">Harga Barang (Rp)</label>
                    <input type="number" id="harga-simulasi" name="harga" class="form-control" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="btn-submit-simulasi" class="btn btn-primary w-100">Submit</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID Barang</th>
                        <th>Nama</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody id="body-tabel-simulasi">
                    <!-- rows will be appended here -->
                </tbody>
            </table>
        </div>
    </div>
</div>

@push('script-page')
<script>
    $(document).ready(function(){
        $('#btn-submit-simulasi').on('click', function(e){
            e.preventDefault();
            var form = document.getElementById('form-simulasi');
            if (!form.checkValidity()) {
                form.reportValidity();
                return;
            }

            var $btn = $(this);
            $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            $btn.prop('disabled', true);

            setTimeout(function(){
                var id_random = Math.floor(Math.random() * 10000);
                var nama = $('#nama-simulasi').val();
                var harga = $('#harga-simulasi').val();

                $('#body-tabel-simulasi').append('<tr><td>'+ id_random +'</td><td>'+ $('<div>').text(nama).html() +'</td><td>'+ $('<div>').text(harga).html() +'</td></tr>');

                // clear inputs
                $('#nama-simulasi').val('');
                $('#harga-simulasi').val('');

                // restore button
                $btn.html('Submit');
                $btn.prop('disabled', false);
            }, 1000);
        });
    });
</script>
@endpush

@endsection
