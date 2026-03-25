@extends('layouts.master')

@section('content')
  <div class="page-header">
    <h3 class="page-title">Kasir / POS (Versi Axios)</h3>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Input Barang</h4>
          <form id="pos-form" class="row g-3">
            <div class="col-md-3">
              <label for="kode_barang" class="form-label">Kode Barang</label>
              <input type="text" class="form-control" id="kode_barang" name="kode_barang" placeholder="Masukkan kode">
            </div>
            <div class="col-md-3">
              <label for="nama_barang" class="form-label">Nama Barang</label>
              <input type="text" readonly class="form-control" id="nama_barang" name="nama_barang" placeholder="Nama akan muncul" />
            </div>
            <div class="col-md-2">
              <label for="harga" class="form-label">Harga</label>
              <input type="text" readonly class="form-control" id="harga" name="harga" placeholder="0" />
            </div>
            <div class="col-md-2">
              <label for="jumlah" class="form-label">Jumlah</label>
              <input type="number" class="form-control" id="jumlah" name="jumlah" value="1" min="1" />
            </div>
            <div class="col-md-2 d-flex align-items-end">
              <button type="button" class="btn btn-primary w-100" id="btn-tambah" disabled>Tambahkan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-3">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Keranjang Belanja</h4>
          <div class="table-responsive">
            <table class="table table-bordered" id="tabel-keranjang">
              <thead>
                <tr>
                  <th>Kode</th>
                  <th>Nama</th>
                  <th>Harga</th>
                  <th>Jumlah</th>
                  <th>Subtotal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <!-- Baris keranjang akan ditambahkan di sini -->
              </tbody>
            </table>
          </div>

          <div class="d-flex justify-content-between align-items-center mt-3">
            <h3 class="mb-0" id="total-harga">Total Harga: Rp 0</h3>
            <button type="button" class="btn btn-success" id="btn-bayar">Bayar</button>
          </div>
        </div>
      </div>
    </div>
  </div>


<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
  (function ($) {
    const cariUrl = "{{ url('/pos/cari-barang') }}"; // will append /{id}
    const bayarUrl = "{{ route('pos.bayar') }}";

    function formatRupiah(amount) {
      if (amount === null || amount === undefined || isNaN(amount) || Number(amount) === 0) return 'Rp 0';
      return 'Rp ' + Number(amount).toLocaleString('id-ID');
    }

    function hitungTotal() {
      let total = 0;
      $('#tabel-keranjang tbody tr').each(function () {
        const harga = parseFloat($(this).data('harga')) || 0;
        const jumlah = parseInt($(this).find('.input-jumlah').val()) || 0;
        const subtotal = harga * jumlah;
        $(this).find('.subtotal').text(formatRupiah(subtotal));
        total += subtotal;
      });
      $('#total-harga').text('Total Harga: ' + formatRupiah(total));
    }

    $(document).ready(function () {
      // Pencarian barang dengan Axios saat Enter
      $('#kode_barang').on('keypress', function (e) {
        if (e.which == 13 || e.keyCode == 13) {
          e.preventDefault();
          let kode = $(this).val().trim();
          console.log('Mencari barang: ' + kode);
          if (!kode) return;
          $('#btn-tambah').prop('disabled', true);

          axios.get('/pos/cari-barang/' + encodeURIComponent(kode))
            .then(function (response) {
              const data = response.data;
              $('#nama_barang').val(data.nama || '');
              $('#harga').val(data.harga ?? 0);
              $('#jumlah').val(1);
              $('#btn-tambah').prop('disabled', false);
            })
            .catch(function (error) {
              console.error(error);
              if (typeof Swal !== 'undefined') Swal.fire('Barang tidak ditemukan', '', 'warning');
              else alert('Barang tidak ditemukan');
              $('#nama_barang').val('');
              $('#harga').val('');
              $('#jumlah').val(1);
              $('#btn-tambah').prop('disabled', true);
            });
        }
      });

      // Tambah ke keranjang
      $('#btn-tambah').on('click', function () {
        const kode = $('#kode_barang').val().trim();
        const nama = $('#nama_barang').val().trim();
        const hargaRaw = $('#harga').val().toString().replace(/[^0-9.-]+/g, '');
        const harga = parseFloat(hargaRaw) || 0;
        let jumlah = parseInt($('#jumlah').val()) || 1;

        if (!kode || !nama) return;

        const $tbody = $('#tabel-keranjang tbody');
        const $existing = $tbody.find('tr[data-kode="' + kode + '"]');

        if ($existing.length) {
          const $qtyInput = $existing.find('.input-jumlah');
          const current = parseInt($qtyInput.val()) || 0;
          $qtyInput.val(current + jumlah).trigger('change');
        } else {
          const subtotal = harga * jumlah;
          const $tr = $(
            '<tr data-kode="' + kode + '" data-harga="' + harga + '">'
            + '<td class="kode">' + kode + '</td>'
            + '<td class="nama">' + nama + '</td>'
            + '<td class="harga">' + formatRupiah(harga) + '</td>'
            + '<td><input type="number" min="1" class="form-control input-jumlah" value="' + jumlah + '" style="width:100px" /></td>'
            + '<td class="subtotal">' + formatRupiah(subtotal) + '</td>'
            + '<td><button type="button" class="btn btn-sm btn-danger btn-hapus">Hapus</button></td>'
            + '</tr>'
          );

          $tbody.append($tr);
        }

        // reset input
        $('#kode_barang').val('');
        $('#nama_barang').val('');
        $('#harga').val('');
        $('#jumlah').val(1);
        $('#btn-tambah').prop('disabled', true);

        hitungTotal();
      });

      // Hapus dan update jumlah
      $('#tabel-keranjang').on('click', '.btn-hapus', function () {
        $(this).closest('tr').remove();
        hitungTotal();
      });

      $('#tabel-keranjang').on('change', '.input-jumlah', function () {
        const $tr = $(this).closest('tr');
        const harga = parseFloat($tr.data('harga')) || 0;
        const jumlah = parseInt($(this).val()) || 0;
        const subtotal = harga * jumlah;
        $tr.find('.subtotal').text(formatRupiah(subtotal));
        hitungTotal();
      });

      // Proses Bayar dengan Axios (perbaikan selektor dan payload 'cart')
      $('#btn-bayar').on('click', function () {
        const $rows = $('#tabel-keranjang tbody tr');
        if ($rows.length === 0) {
          if (typeof Swal !== 'undefined') Swal.fire('Keranjang masih kosong!', '', 'warning');
          else alert('Keranjang masih kosong!');
          return;
        }

        const $btn = $(this);
        const originalHtml = $btn.html();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...');

        const cart = [];
        $rows.each(function () {
          const $tr = $(this);
          const id_barang = $tr.data('kode');
          const harga = parseFloat($tr.data('harga')) || 0;
          const jumlah = parseInt($tr.find('.input-jumlah').val()) || 0;
          const subtotal = harga * jumlah;
          cart.push({ id_barang: id_barang, jumlah: jumlah, subtotal: subtotal });
        });

        axios.post(bayarUrl, { _token: '{{ csrf_token() }}', cart: cart })
          .then(function (response) {
            if (typeof Swal !== 'undefined') Swal.fire('Berhasil', 'Pembayaran berhasil.', 'success');
            else alert('Pembayaran berhasil.');
            // clear UI
            $('#tabel-keranjang tbody').empty();
            $('#total-harga').text('Total Harga: Rp 0');
            $btn.prop('disabled', false).html(originalHtml);
          })
          .catch(function (error) {
            let msg = 'Terjadi kesalahan saat memproses pembayaran';
            if (error && error.response && error.response.data && error.response.data.message) msg = error.response.data.message;
            if (typeof Swal !== 'undefined') Swal.fire('Gagal', msg, 'error');
            else alert(msg);
            $btn.prop('disabled', false).html(originalHtml);
          });

      });

    });
  })(jQuery);
</script>

@endsection
