@extends('layouts.master')
@section('title', 'Simulasi Select - Praktikum')

<style>
    /* Strong Select2 overrides to match Bootstrap form-control height and center content */
    .select2-container--default .select2-selection--single {
        min-height: 45px !important;     /* match Bootstrap input height */
        height: auto !important;
        display: flex !important;
        align-items: center !important;  /* vertical centering */
        padding: 0 .75rem !important;    /* horizontal padding like .form-control */
        border-radius: .25rem !important;
        border: 1px solid #ced4da !important;
        background: #fff !important;
        box-shadow: none !important;
        box-sizing: border-box !important;
    }

    /* Rendered selection / placeholder vertically centered */
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        display: block !important;
        height: 45px !important;
        line-height: 45px !important;    /* vertical center the text */
        padding: 0 !important;
        color: #495057 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
        box-sizing: border-box !important;
    }

    /* Placeholder should also be vertically centered */
    .select2-container--default .select2-selection--single .select2-selection__placeholder {
        line-height: 45px !important;
        padding: 0 !important;
    }

    /* Arrow centered on the right */
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 100% !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        right: .5rem !important;
        top: 0 !important;
        width: 2.5rem !important;
        box-sizing: border-box !important;
    }

    /* Focus styling consistent with Bootstrap */
    .select2-container--default.select2-container--open .select2-selection--single,
    .select2-container--default .select2-selection--single:focus {
        box-shadow: 0 0 0 0.2rem rgba(13,110,253,0.12) !important;
        border-color: #86b7fe !important;
        outline: none !important;
    }

    /* If original select uses .form-select, keep border-radius consistent */
    select.form-select + .select2-container .select2-selection--single {
        border-radius: .25rem !important;
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
