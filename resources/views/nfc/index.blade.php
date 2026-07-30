@extends('layouts.master')

@section('title', 'Scanner Absensi NFC')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-5 mt-5">
        <div class="card shadow text-center">
            <div class="card-body">
                <h4 class="card-title mb-4">Scanner Absensi NFC</h4>
                
                <button id="btn-scan" class="btn btn-primary btn-lg mb-3">
                    <i class="mdi mdi-cellphone-nfc"></i> Aktifkan Sensor NFC
                </button>
                
                <div id="status-teks" class="alert alert-info">
                    Menunggu aktivasi...
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Audio beep untuk feedback saat scan NFC berhasil --}}
<audio id="beep-nfc" src="{{ asset('beep.mp3') }}" preload="auto" hidden></audio>
@endsection

@push('script-page')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const btnScan = document.getElementById('btn-scan');
    const statusTeks = document.getElementById('status-teks');

    btnScan.addEventListener('click', async () => {
        if (!('NDEFReader' in window)) {
            statusTeks.className = 'alert alert-danger mt-3';
            statusTeks.innerText = 'Error: Web NFC API tidak didukung di browser atau perangkat ini.';
            return;
        }

        try {
            const ndef = new NDEFReader();
            await ndef.scan();
            statusTeks.className = 'alert alert-warning mt-3';
            statusTeks.innerText = 'NFC Aktif. Silakan tempelkan kartu...';

            ndef.addEventListener('reading', ({ serialNumber }) => {
                // Mainkan suara instan
                const beepNfc = document.getElementById('beep-nfc');
                if (beepNfc) {
                    beepNfc.currentTime = 0;
                    beepNfc.play().catch(() => {});
                }

                // Tampilkan serial number segera sebelum melakukan request
                statusTeks.className = 'alert alert-info mt-3';
                statusTeks.innerHTML = 'Serial Number kartu ini: ' + serialNumber + '<br><small>Memeriksa ke database...</small>';

                fetch('{{ route("nfc.scan") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ serial_number: serialNumber })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        statusTeks.className = 'alert alert-success mt-3';
                        statusTeks.innerHTML += `<br><strong>Berhasil!</strong> Absensi untuk: ${data.nama}`;
                    } else {
                        statusTeks.className = 'alert alert-danger mt-3';
                        statusTeks.innerHTML += `<br>Gagal: ${data.message}`;
                    }
                })
                .catch(error => {
                    statusTeks.className = 'alert alert-danger mt-3';
                    statusTeks.innerHTML += `<br>Error sistem: ${error.message}`;
                });
            });
        } catch (error) {
            statusTeks.className = 'alert alert-danger mt-3';
            statusTeks.innerText = `Error: ${error.message}`;
        }
    });
});
</script>
@endpush
