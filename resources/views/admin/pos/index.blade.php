@extends('layouts.master')

@section('content')
  <div class="page-header">
    <h3 class="page-title">Kasir / POS</h3>
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

              {{-- Jika controller/route mengirimkan $qrCode (base64) dan $id_pesanan, tampilkan QR code di bawah detail transaksi --}}
              @isset($qrCode)
                <div class="mt-3 text-center">
                  <p style="margin-bottom:6px;font-weight:600">ID Pesanan: {{ $id_pesanan }}</p>
                  <img src="data:image/png;base64,{{ $qrCode }}" alt="QR {{ $id_pesanan }}" width="150" height="150" />
                </div>
              @endisset
        </div>
      </div>
    </div>
  </div>

@endsection

@push('script-page')
<script>
  (function ($) {
    const cariUrl = "{{ url('/pos/cari-barang') }}"; // will append /{id}

    function formatRupiah(amount) {
      if (!amount) return 'Rp 0';
      return 'Rp ' + Number(amount).toLocaleString('id-ID');
    }

    function hitungTotal() {
      let total = 0;
      $('#tabel-keranjang tbody tr').each(function () {
        const harga = parseFloat($(this).data('harga')) || 0;
        const jumlah = parseInt($(this).find('.input-jumlah').val()) || 0;
        const subtotal = harga * jumlah;
        $(this).find('.subtotal').text(formatRupiah(subtotal));
        $(this).find('.subtotal').data('value', subtotal);
        total += subtotal;
      });
      $('#total-harga').text('Total Harga: ' + formatRupiah(total));
    }

    $(document).ready(function () {
      // Enter press on kode_barang -> AJAX cari
      $('#kode_barang').on('keypress', function (e) {
        if (e.which === 13) {
          e.preventDefault();
          const kode = $(this).val().trim();
          if (!kode) return;
          // disable tombol selama request
          $('#btn-tambah').prop('disabled', true);

          $.ajax({
            url: cariUrl + '/' + encodeURIComponent(kode),
            method: 'GET',
            success: function (data) {
              // data diharapkan mengandung fields: id_barang, nama, harga
              $('#nama_barang').val(data.nama || '');
              $('#harga').val(data.harga ?? 0);
              $('#jumlah').val(1);
              $('#btn-tambah').prop('disabled', false);
            },
            error: function () {
              // SweetAlert2 notify
              if (typeof Swal !== 'undefined') {
                Swal.fire('Barang tidak ditemukan', '', 'warning');
              } else {
                alert('Barang tidak ditemukan');
              }
              $('#nama_barang').val('');
              $('#harga').val('');
              $('#jumlah').val(1);
              $('#btn-tambah').prop('disabled', true);
            }
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
          // update jumlah dan subtotal
          const $qtyInput = $existing.find('.input-jumlah');
          const current = parseInt($qtyInput.val()) || 0;
          $qtyInput.val(current + jumlah).trigger('change');
        } else {
          // append row
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

      // Delegated events for dynamic rows
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

    });
  })(jQuery);
</script>
<script>
  (function ($) {
    $(document).ready(function () {
      $('#btn-bayar').on('click', function () {
        const $tbody = $('#tabel-keranjang tbody');
        if ($tbody.find('tr').length === 0) {
          if (typeof Swal !== 'undefined') {
            Swal.fire('Keranjang masih kosong!', '', 'warning');
          } else {
            alert('Keranjang masih kosong!');
          }
          return;
        }

        const $btn = $(this);
        const originalHtml = $btn.html();
        // set loading state
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memproses...');

        // collect cart data
        const cart = [];
        $tbody.find('tr').each(function () {
          const $tr = $(this);
          const id_barang = $tr.data('kode');
          const harga = parseFloat($tr.data('harga')) || 0;
          const jumlah = parseInt($tr.find('.input-jumlah').val()) || 0;
          const subtotal = harga * jumlah;
          cart.push({ id_barang: id_barang, jumlah: jumlah, subtotal: subtotal });
        });

          $.ajax({
          url: "{{ route('pos.bayar') }}",
          method: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            cart: cart
          },
          success: function (res) {
            // if server returned penjualan_id, redirect to receipt page so controller can build QR
            if (res && res.penjualan_id) {
              window.location = "{{ url('/pos/receipt') }}/" + encodeURIComponent(res.penjualan_id);
              return;
            }
            if (typeof Swal !== 'undefined') {
              Swal.fire('Berhasil', 'Pembayaran berhasil.', 'success');
            } else {
              alert('Pembayaran berhasil.');
            }
            // clear cart UI
            $tbody.empty();
            $('#total-harga').text('Total Harga: Rp 0');
            $btn.prop('disabled', false).html(originalHtml);
          },
          error: function (xhr) {
            let msg = 'Terjadi kesalahan saat memproses pembayaran';
            if (xhr && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
            if (typeof Swal !== 'undefined') {
              Swal.fire('Gagal', msg, 'error');
            } else {
              alert(msg);
            }
            $btn.prop('disabled', false).html(originalHtml);
          }
        });

      });
    });
  })(jQuery);
</script>
@endpush
