@extends('layouts.master')
@section('title', 'Tambah Lokasi Toko')
@section('content')
<div class="card">
    <div class="card-header"><h4>Tambah Lokasi Toko</h4></div>
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('lokasi_toko.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Toko</label>
                <input type="text" name="nama_toko" class="form-control" value="{{ old('nama_toko') }}" required>
            </div>
            <div class="mb-2">
                <button type="button" class="btn btn-info btn-sm" onclick="getLocation(this)">📍 Ambil Lokasi Saat Ini</button>
            </div>
            <div class="mb-3">
                <label class="form-label">Latitude</label>
                <input type="text" name="latitude" id="latitude" class="form-control" value="{{ old('latitude') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Longitude</label>
                <input type="text" name="longitude" id="longitude" class="form-control" value="{{ old('longitude') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Accuracy (meter)</label>
                <input type="text" name="accuracy" id="accuracy" class="form-control" value="{{ old('accuracy') }}">
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="{{ route('lokasi_toko.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

<script>
    /**
     * Fungsi global GPS — dipanggil langsung via onclick="getLocation(this)"
     * Sengaja dibuat di luar DOMContentLoaded agar kebal dari error JS template lain.
     * Setiap akses DOM dibungkus null-check defensif.
     */
    function getLocation(btn) {
        // Cek dukungan Geolocation API
        if (!navigator.geolocation) {
            alert('Browser Anda tidak mendukung fitur Geolocation. Silakan gunakan browser yang lebih baru.');
            return;
        }

        // Indikator visual: disable tombol & ubah teks
        btn.disabled    = true;
        btn.textContent = 'Mencari lokasi...';

        navigator.geolocation.getCurrentPosition(
            // --- Callback Sukses ---
            function (position) {
                var elLat = document.getElementById('latitude');
                var elLng = document.getElementById('longitude');
                var elAcc = document.getElementById('accuracy');

                // Null-check sebelum mengisi nilai
                if (elLat) { elLat.value = position.coords.latitude; }
                if (elLng) { elLng.value = position.coords.longitude; }
                if (elAcc) { elAcc.value = position.coords.accuracy.toFixed(2); }

                btn.disabled  = false;
                btn.innerHTML = '✅ Lokasi Berhasil Diambil';

                // Kembalikan teks asal setelah 3 detik
                setTimeout(function () {
                    btn.innerHTML = '📍 Ambil Lokasi Saat Ini';
                }, 3000);
            },
            // --- Callback Gagal ---
            function (error) {
                var pesan = 'Gagal mengambil lokasi. ';
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        pesan += 'Izin lokasi ditolak. Pastikan izin lokasi di browser Anda aktif.';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        pesan += 'Informasi lokasi tidak tersedia saat ini.';
                        break;
                    case error.TIMEOUT:
                        pesan += 'Permintaan lokasi habis waktu. Coba lagi.';
                        break;
                    default:
                        pesan += 'Terjadi kesalahan yang tidak diketahui.';
                }
                alert(pesan);

                // Kembalikan tombol ke kondisi semula
                btn.disabled  = false;
                btn.innerHTML = '📍 Ambil Lokasi Saat Ini';
            },
            // --- Opsi ---
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0
            }
        );
    }
</script>
