@extends('layouts.master')
@section('title', 'Kunjungan Toko')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Kunjungan Toko</h4>
        <div>
            <button id="btn-start" class="btn btn-success">Mulai Scan</button>
            <button id="btn-stop" class="btn btn-secondary" disabled>Stop</button>
        </div>
    </div>
    <div class="card-body">
        <div id="reader" style="width:100%;max-width:640px;margin:0 auto 16px;"></div>

        <div id="info" class="mb-3 text-center">
            <div id="scan-result" class="fw-bold"></div>
            <div id="gps-status" class="text-muted small"></div>
        </div>

        <div id="result" style="white-space:pre-wrap;"></div>

        {{-- Audio beep untuk feedback saat scan berhasil --}}
        <audio id="beep-sound" src="{{ asset('beep.mp3') }}" preload="auto" hidden></audio>
    </div>
</div>

@push('script-page')
    <script src="/js/html5-qrcode.min.js"></script>
    <script>
        const html5QrCode = new Html5Qrcode("reader");
        const btnStart    = document.getElementById('btn-start');
        const btnStop     = document.getElementById('btn-stop');
        const scanResultEl = document.getElementById('scan-result');
        const gpsStatusEl  = document.getElementById('gps-status');
        const resultEl     = document.getElementById('result');

        // ─── [OPTIMASI] Variabel global menyimpan hasil pre-fetch GPS ──────────
        let prefetchedPos   = null;   // posisi terbaik yang sudah diperoleh sejak "Mulai Scan"
        let prefetchWatchId = null;   // ID watchPosition pre-fetch agar bisa di-clear

        /**
         * Mulai watchPosition di background saat "Mulai Scan" diklik.
         * Setiap kali koordinat baru masuk dan lebih akurat, simpan sebagai prefetchedPos.
         * Ini berarti saat barcode terbaca, kita sudah punya koordinat siap pakai!
         */
        function startGpsPrefetch() {
            if (!navigator.geolocation) return;
            if (prefetchWatchId !== null) return; // sudah berjalan

            gpsStatusEl.textContent = 'GPS: menyiapkan posisi...';
            prefetchWatchId = navigator.geolocation.watchPosition(
                pos => {
                    const acc = pos.coords.accuracy || 999999;
                    if (!prefetchedPos || acc < prefetchedPos.coords.accuracy) {
                        prefetchedPos = pos;
                        gpsStatusEl.textContent = `GPS siap (akurasi ~${Math.round(acc)} m)`;
                    }
                },
                err => {
                    gpsStatusEl.textContent = 'GPS: gagal mendapatkan sinyal (' + (err.message || err) + ')';
                    prefetchWatchId = null;
                },
                { enableHighAccuracy: true, maximumAge: 5000, timeout: 15000 }
            );
        }

        /** Hentikan watchPosition pre-fetch agar tidak boros baterai. */
        function stopGpsPrefetch() {
            if (prefetchWatchId !== null) {
                navigator.geolocation.clearWatch(prefetchWatchId);
                prefetchWatchId = null;
            }
        }

        /**
         * Ambil posisi dengan strategi berlapis:
         *  1. Jika pre-fetch sudah punya posisi (< 30 detik), langsung resolve.
         *  2. Jika belum ada, panggil getCurrentPosition dengan timeout 5 detik
         *     (bukan watchPosition 20 detik yang lama!).
         *  3. Jika timeout, gunakan posisi pre-fetch terbaik walau sudah agak lama.
         */
        function getPosition() {
            return new Promise((resolve, reject) => {
                // Jika cache prefetch ada dan masih segar (< 30 detik), pakai langsung
                if (prefetchedPos) {
                    const ageMs = Date.now() - prefetchedPos.timestamp;
                    if (ageMs < 30000) {
                        return resolve(prefetchedPos);
                    }
                }

                // Belum ada cache / kedaluwarsa — panggil getCurrentPosition dengan timeout singkat
                navigator.geolocation.getCurrentPosition(
                    pos => {
                        // Simpan ke cache juga agar berikutnya lebih cepat
                        if (!prefetchedPos || pos.coords.accuracy < prefetchedPos.coords.accuracy) {
                            prefetchedPos = pos;
                        }
                        resolve(pos);
                    },
                    err => {
                        // Timeout/error — gunakan cache prefetch walau agak lama, daripada gagal total
                        if (prefetchedPos) {
                            resolve(prefetchedPos);
                        } else {
                            reject(err);
                        }
                    },
                    { enableHighAccuracy: true, timeout: 5000, maximumAge: 10000 }
                );
            });
        }

        /** Tampilkan loading spinner instan di div hasil. */
        function showLoadingResult() {
            resultEl.innerHTML = `
                <div class="alert alert-info d-flex align-items-center gap-2" id="loading-indicator">
                    <div class="spinner-border spinner-border-sm text-info" role="status" aria-hidden="true"></div>
                    <span>Memproses data lokasi dan validasi server... mohon tunggu.</span>
                </div>`;
        }

        /** Kirim data ke backend dan render hasil. */
        function submitToServer(decodedText, pos) {
            const payload = {
                barcode:   decodedText,
                lat_sales: pos.coords.latitude,
                lng_sales: pos.coords.longitude,
                acc_sales: pos.coords.accuracy
            };
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch('{{ route('lokasi_toko.proses_kunjungan') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            }).then(async res => {
                const json = await res.json().catch(() => null);
                if (!res.ok) {
                    const msg = (json && json.error) ? json.error : ('HTTP ' + res.status);
                    throw new Error(msg);
                }

                const status     = json.status || 'UNKNOWN';
                const alertClass = (status === 'DITERIMA') ? 'alert alert-success' : 'alert alert-danger';

                resultEl.innerHTML = `
                    <div class="${alertClass}"><strong>${status}</strong></div>
                    <table class="table table-sm">
                        <tbody>
                            <tr><th>Barcode</th><td>${json.barcode}</td></tr>
                            <tr><th>Nama Toko</th><td>${json.nama_toko}</td></tr>
                            <tr><th>Jarak Aktual (m)</th><td>${Number(json.jarak_aktual).toFixed(2)}</td></tr>
                            <tr><th>Threshold Efektif (m)</th><td>${Number(json.threshold_efektif).toFixed(2)}</td></tr>
                            <tr><th>Akurasi Toko (m)</th><td>${Number(json.acc_toko).toFixed(2)}</td></tr>
                            <tr><th>Akurasi Sales (m)</th><td>${Number(json.acc_sales).toFixed(2)}</td></tr>
                        </tbody>
                    </table>`;
            }).catch(err => {
                resultEl.innerHTML = `<div class="alert alert-warning">Terjadi kesalahan: ${err.message}</div>`;
            });
        }

        function startScanner() {
            scanResultEl.textContent = '';
            resultEl.innerHTML       = '';
            gpsStatusEl.textContent  = '';
            prefetchedPos            = null; // reset cache saat scan baru dimulai

            // ─── [OPTIMASI] Mulai pre-fetch GPS segera saat scanner dibuka ───────
            startGpsPrefetch();

            const config = { fps: 10, qrbox: { width: 300, height: 150 }, videoConstraints: { facingMode: "environment" } };

            html5QrCode.start({ facingMode: "environment" }, config,
                (decodedText) => {
                    // Hentikan scanner
                    html5QrCode.stop().then(() => {
                        btnStart.disabled = false;
                        btnStop.disabled  = true;
                    }).catch(() => {});

                    // Hentikan pre-fetch agar hemat baterai
                    stopGpsPrefetch();

                    // ─── [OPTIMASI 1] Visual feedback INSTAN — sebelum tunggu GPS ─
                    scanResultEl.textContent = 'Scanned: ' + decodedText;
                    showLoadingResult();

                    // Beep feedback
                    const beep = document.getElementById('beep-sound');
                    if (beep) { beep.currentTime = 0; beep.play().catch(() => {}); }

                    // ─── [OPTIMASI 2] GPS: coba ambil dari cache prefetch dulu ────
                    gpsStatusEl.textContent = 'Mengambil posisi GPS...';
                    getPosition().then(pos => {
                        gpsStatusEl.textContent = `GPS acquired (akurasi ~${Math.round(pos.coords.accuracy)} m)`;
                        // ─── Langsung fetch ke backend begitu koordinat tersedia ──
                        submitToServer(decodedText, pos);
                    }).catch(err => {
                        resultEl.innerHTML = `<div class="alert alert-danger">Gagal mendapatkan GPS: ${err.message || err}</div>`;
                        gpsStatusEl.textContent = '';
                    });
                },
                (errorMessage) => {
                    scanResultEl.textContent = 'Scan error: ' + errorMessage;
                }
            ).then(() => {
                btnStart.disabled = true;
                btnStop.disabled  = false;
            }).catch(err => {
                scanResultEl.textContent = 'Gagal memulai kamera: ' + err;
                stopGpsPrefetch();
            });
        }

        btnStart.addEventListener('click', () => { startScanner(); });

        btnStop.addEventListener('click', () => {
            stopGpsPrefetch();
            html5QrCode.stop().then(() => {
                btnStart.disabled = false;
                btnStop.disabled  = true;
                scanResultEl.textContent = 'Scanner berhenti.';
            }).catch(err => { scanResultEl.textContent = 'Gagal stop scanner: ' + err; });
        });
    </script>
@endpush

@endsection
