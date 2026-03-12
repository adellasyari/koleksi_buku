@extends('layouts.master')
@section('title', 'Simulasi Select - Praktikum')

<style>
    /* Make Select2 match Bootstrap .form-control appearance and vertically center text */
    .select2-container .select2-selection--single {
        height: 38px; /* match typical Bootstrap input height */
        padding: .375rem .75rem; /* same padding as .form-control */
        display: flex;
        align-items: center; /* vertically center the rendered text */
        border: 1px solid #ced4da; /* use Bootstrap input border color instead of black */
        border-radius: .25rem;
        background-color: #fff;
        box-shadow: none; /* remove unwanted black shadow */
    }

    /* Ensure rendered text is vertically centered and ellipsized when long */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        display: block;
        margin: 0;
        padding: 0;
        line-height: normal; /* let flex+align-items handle vertical centering */
        color: #495057; /* Bootstrap form text color */
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Align the dropdown arrow vertically to center */
    .select2-container .select2-selection__arrow {
        height: 100%;
        top: 0;
        display: flex;
        align-items: center;
        padding-left: .5rem;
    }

    /* Remove Select2's default black focus border; use Bootstrap focus shadow */
    .select2-container--default.select2-container--focus .select2-selection--single,
    .select2-container--default .select2-selection--single:focus,
    .select2-container--default .select2-selection--single:active {
        outline: none;
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.12);
        border-color: #86b7fe;
    }

    /* Make Select2 inherit form width behavior */
    .select2-container--default .select2-selection--single .select2-selection__rendered,
    .select2-container .select2-selection--single {
        width: 100%;
        min-height: 38px;
    }

    /* If you used .form-select on the original <select>, make select2 look consistent */
    select.form-select + .select2-container .select2-selection--single {
        border-radius: .25rem;
    }
</style>

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h5>Select Biasa</h5></div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="input-kota-1" class="form-label">Kota</label>
                    <input type="text" id="input-kota-1" class="form-control">
                </div>
                <div class="mb-3">
                    <button type="button" id="btn-tambah-1" class="btn btn-primary">Tambahkan</button>
                </div>

                <div class="mb-3">
                    <label for="select-kota-1" class="form-label">Pilih Kota</label>
                    <select id="select-kota-1" class="form-select">
                        <option value="">-- Pilih --</option>
                    </select>
                </div>

                <p>Kota Terpilih: <span id="hasil-kota-1"></span></p>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header"><h5>Select2</h5></div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="input-kota-2" class="form-label">Kota</label>
                    <input type="text" id="input-kota-2" class="form-control">
                </div>
                <div class="mb-3">
                    <button type="button" id="btn-tambah-2" class="btn btn-primary">Tambahkan</button>
                </div>

                <div class="mb-3">
                    <label for="select-kota-2" class="form-label">Pilih Kota (Select2)</label>
                    <select id="select-kota-2" class="form-select" style="width: 100%;">
                        <option value="">-- Pilih --</option>
                    </select>
                </div>

                <p>Kota Terpilih: <span id="hasil-kota-2"></span></p>
            </div>
        </div>
    </div>
</div>

@push('style-page')
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('script-page')
    <!-- Select2 JS (depends on jQuery which is loaded globally) -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function(){
            // initialize Select2
            $('#select-kota-2').select2({
                placeholder: '-- Pilih --',
                allowClear: true,
                width: 'resolve'
            });

            // Card 1: Tambah option ke select biasa
            $('#btn-tambah-1').on('click', function(){
                var val = $('#input-kota-1').val().trim();
                if (!val) return; // ignore empty
                // append option
                var $opt = $('<option>').val(val).text(val);
                $('#select-kota-1').append($opt);
                // clear input
                $('#input-kota-1').val('');
            });

            // Card 1: change event
            $('#select-kota-1').on('change', function(){
                var v = $(this).val();
                $('#hasil-kota-1').text(v);
            });

            // Card 2: Tambah option ke select2
            $('#btn-tambah-2').on('click', function(){
                var val = $('#input-kota-2').val().trim();
                if (!val) return;
                // append native option then notify select2
                var $opt = $('<option>').val(val).text(val);
                $('#select-kota-2').append($opt);
                // refresh select2
                $('#select-kota-2').trigger('change');
                // clear input
                $('#input-kota-2').val('');
            });

            // Card 2: change event for select2
            $('#select-kota-2').on('change', function(){
                var v = $(this).val();
                $('#hasil-kota-2').text(v);
            });
        });
    </script>
@endpush

@endsection
