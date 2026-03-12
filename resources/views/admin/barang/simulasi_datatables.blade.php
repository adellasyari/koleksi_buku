@extends('layouts.master')
@section('title', 'Simulasi DataTables - Praktikum')
@section('content')
<div class="card">
    <div class="card-header"><h4>Simulasi DataTables - Tambah Barang (Frontend Only)</h4></div>
    <div class="card-body">
        <form id="form-simulasi-dt" class="mb-3" autocomplete="off">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama-simulasi-dt" class="form-label">Nama Barang</label>
                    <input type="text" id="nama-simulasi-dt" name="nama" class="form-control" required>
                </div>
                <div class="col-md-4">
                    <label for="harga-simulasi-dt" class="form-label">Harga Barang (Rp)</label>
                    <input type="number" id="harga-simulasi-dt" name="harga" class="form-control" required>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="btn-submit-simulasi-dt" class="btn btn-primary w-100">Submit</button>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table id="tabel-simulasi-dt" class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID Barang</th>
                        <th>Nama</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- DataTables will manage rows -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal untuk aksi Ubah / Hapus -->
<div class="modal fade" id="modal-aksi" tabindex="-1" aria-labelledby="modalAksiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAksiLabel">Ubah / Hapus Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="form-modal-aksi">
                    <div class="mb-3">
                        <label for="modal-id" class="form-label">ID Barang</label>
                        <input type="text" id="modal-id" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modal-nama" class="form-label">Nama Barang</label>
                        <input type="text" id="modal-nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="modal-harga" class="form-label">Harga Barang (Rp)</label>
                        <input type="number" id="modal-harga" class="form-control" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" id="btn-modal-hapus" class="btn btn-danger">Hapus</button>
                <button type="button" id="btn-modal-ubah" class="btn btn-warning">Ubah</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('style-page')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <style>
        /* Pointer cursor on table rows to indicate clickability */
        #tabel-simulasi-dt tbody tr { cursor: pointer; }
    </style>
@endpush

@push('script-page')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            var table = $('#tabel-simulasi-dt').DataTable();
            var barisTerpilih = null;

            $('#btn-submit-simulasi-dt').on('click', function(e){
                e.preventDefault();
                var form = document.getElementById('form-simulasi-dt');
                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                var $btn = $(this);
                $btn.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
                $btn.prop('disabled', true);

                setTimeout(function(){
                    var id_random = Math.floor(Math.random() * 10000);
                    var nama = $('#nama-simulasi-dt').val();
                    var harga = $('#harga-simulasi-dt').val();

                    // Add row via DataTables API
                    table.row.add([id_random, $('<div>').text(nama).html(), $('<div>').text(harga).html()]).draw(false);

                    // clear inputs
                    $('#nama-simulasi-dt').val('');
                    $('#harga-simulasi-dt').val('');

                    // restore button
                    $btn.html('Submit');
                    $btn.prop('disabled', false);
                }, 1000);
            });

            // Klik baris: tampilkan modal dengan data
            $('#tabel-simulasi-dt tbody').on('click', 'tr', function () {
                var data = table.row(this).data();
                if (!data) return; // nothing
                barisTerpilih = this;
                $('#modal-id').val(data[0]);
                $('#modal-nama').val(data[1]);
                $('#modal-harga').val(data[2]);
                var modal = new bootstrap.Modal(document.getElementById('modal-aksi'));
                modal.show();
            });

            // Hapus baris
            $('#btn-modal-hapus').on('click', function(){
                if (barisTerpilih) {
                    table.row(barisTerpilih).remove().draw(false);
                    barisTerpilih = null;
                }
                var modalEl = document.getElementById('modal-aksi');
                var modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            });

            // Ubah baris
            $('#btn-modal-ubah').on('click', function(){
                var formModal = document.getElementById('form-modal-aksi');
                if (!formModal.checkValidity()) { formModal.reportValidity(); return; }
                if (barisTerpilih) {
                    var id = $('#modal-id').val();
                    var namaBaru = $('#modal-nama').val();
                    var hargaBaru = $('#modal-harga').val();
                    table.row(barisTerpilih).data([id, namaBaru, hargaBaru]).draw(false);
                    barisTerpilih = null;
                }
                var modalEl = document.getElementById('modal-aksi');
                var modalInstance = bootstrap.Modal.getInstance(modalEl);
                if (modalInstance) modalInstance.hide();
            });
        });
    </script>
@endpush

@endsection
