@extends('layouts.master')

@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Scanner Barcode</h4>
                    <div class="mb-3">
                        <button id="stopBtn" class="btn btn-danger">Stop Camera</button>
                        <input type="file" accept="image/*" id="file-input" class="form-control d-inline-block w-auto ms-2" />
                    </div>

                    <div id="reader" style="width:100%;max-width:600px;margin:12px 0;"></div>

                    <audio id="beepAudio" src="{{ asset('beep.mp3') }}" preload="auto" style="display:none;"></audio>

                    <div id="result" style="margin-top:18px;"></div>
        </div>
      </div>
    </div>
  </div>
@endsection

  <script src="{{ asset('js/html5-qrcode.min.js') }}"></script>
  <script>
  document.addEventListener('DOMContentLoaded', function () {
      const beepAudio = document.getElementById('beepAudio');
      const resultEl = document.getElementById('result');
      const stopBtn = document.getElementById('stopBtn');
      const fileInput = document.getElementById('file-input');
      const csrfToken = (document.querySelector('meta[name="csrf-token"]') && document.querySelector('meta[name="csrf-token"]').getAttribute('content')) || '';
      let isScanned = false;

      const html5QrCode = new Html5Qrcode('reader');

      function renderResultHtml(item) {
          const id = item.idbarang || item.id_barang || item.id || '';
          const name = item.nama_barang || item.nama || item.name || '';
          const price = item.harga_barang || item.harga || item.price || '';
          return `
              <table class="table table-bordered">
                  <thead>
                      <tr>
                          <th>IDbarang</th>
                          <th>Nama Barang</th>
                          <th>Harga Barang</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>${id}</td>
                          <td>${name}</td>
                          <td>${price}</td>
                      </tr>
                  </tbody>
              </table>
              <div class="mt-2"><button id="rescanBtn" class="btn btn-primary">Scan Ulang</button></div>
          `;
      }

      function attachRescanHandler() {
          const btn = document.getElementById('rescanBtn');
          if (!btn) return;
          btn.addEventListener('click', function () {
              resultEl.innerHTML = '';
              isScanned = false;
              startScanner();
          });
      }

      function showError(msg) {
          resultEl.innerHTML = `<div class="alert alert-danger">${msg}</div><div class="mt-2"><button id="rescanBtn" class="btn btn-primary">Scan Ulang</button></div>`;
          attachRescanHandler();
      }

      // helper to determine if camera scanner is running
      function _isCameraRunning() {
          try {
              const state = (html5QrCode.getState && html5QrCode.getState());
              const ScannerState = (typeof Html5QrcodeScannerState !== 'undefined') ? Html5QrcodeScannerState : (window && window.Html5QrcodeScannerState ? window.Html5QrcodeScannerState : null);
              if (ScannerState) return state === ScannerState.SCANNING;
              return state === 'SCANNING' || state === 'running' || state === true;
          } catch (e) {
              return false;
          }
      }

      async function onScanSuccess(decodedText, decodedResult) {
          if (isScanned) return;
          isScanned = true;

          // if scanner running, stop it first (safe-check)
          try {
              if (_isCameraRunning()) {
                  await html5QrCode.stop();
              }
          } catch (e) {
              console.warn('html5QrCode.stop() failed or camera was not running', e);
          }

          // clear any previous error messages
          try { if (resultEl) resultEl.innerHTML = ''; } catch (e) {}

          // play beep (best-effort)
          try { if (beepAudio && beepAudio.play) await beepAudio.play().catch(()=>{}); } catch (e) { /* ignore */ }

          // fetch data
          try {
              const resp = await fetch('/scanner-barcode/proses', {
                  method: 'POST',
                  credentials: 'same-origin',
                  headers: {
                      'Content-Type': 'application/json',
                      'X-CSRF-TOKEN': csrfToken,
                      'Accept': 'application/json'
                  },
                  body: JSON.stringify({ barcode: decodedText })
              });

              let data = null;
              try { data = await resp.json(); } catch (e) { data = null; }

              if (!resp.ok) {
                  const msg = (data && data.error) ? data.error : ('HTTP ' + resp.status);
                  showError(msg);
                  return;
              }

              if (!data) { showError('Respon server kosong'); return; }
              if (data.error) { showError(data.error); return; }

              const item = Array.isArray(data) ? data[0] : data;
              // ensure previous errors cleared before showing result
              resultEl.innerHTML = renderResultHtml(item);
              attachRescanHandler();
          } catch (err) {
              showError('Terjadi kesalahan: ' + (err.message || err));
              isScanned = false;
          }
      }

      function onScanFailure(error) { /* ignore intermittent failures */ }

      function startScanner() {
          isScanned = false;
          html5QrCode.start({ facingMode: { exact: 'environment' } }, { fps: 10, qrbox: { width: 250, height: 250 } }, onScanSuccess, onScanFailure)
          .then(() => {
              console.log('Scanner started');
              try { if (stopBtn) stopBtn.textContent = 'Stop Camera'; } catch(e){}
              try { if (resultEl) resultEl.innerHTML = ''; } catch(e){}
          })
          .catch(err => {
              console.warn('start with exact facingMode failed, fallback', err);
              html5QrCode.start({ facingMode: 'environment' }, { fps: 10, qrbox: { width: 250, height: 250 } }, onScanSuccess, onScanFailure)
              .then(() => {
                  try { if (stopBtn) stopBtn.textContent = 'Stop Camera'; } catch(e){}
                  try { if (resultEl) resultEl.innerHTML = ''; } catch(e){}
              })
              .catch(e => {
                  console.error('Scanner could not start', e);
                  resultEl.innerHTML = '<div class="alert alert-danger">Gagal memulai kamera: ' + (e.message || e) + '</div>';
              });
          });
      }

      // Stop button handler acts as toggle: Stop <-> Start
      if (stopBtn) {
          stopBtn.addEventListener('click', async function () {
              try {
                  if (_isCameraRunning()) {
                      // stop the running camera
                      await html5QrCode.stop();
                      isScanned = true;
                      stopBtn.textContent = 'Start Camera';
                      resultEl.innerHTML = '<div class="alert alert-info">Kamera dihentikan.</div><div class="mt-2"><button id="rescanBtn" class="btn btn-primary">Scan Ulang</button></div>';
                      attachRescanHandler();
                  } else {
                      // start camera
                      try {
                          resultEl.innerHTML = '<div class="alert alert-info">Mengaktifkan kamera...</div>';
                          startScanner();
                          stopBtn.textContent = 'Stop Camera';
                      } catch (e) {
                          console.warn('Failed to start camera via button', e);
                          resultEl.innerHTML = '<div class="alert alert-danger">Gagal mengaktifkan kamera: ' + (e.message || e) + '</div>';
                      }
                  }
              } catch (e) {
                  console.warn('Toggle camera failed', e);
                  resultEl.innerHTML = '<div class="alert alert-danger">Operasi kamera gagal: ' + (e.message || e) + '</div>';
              }
          });
      }

      // File input handler (scan image file)
      if (fileInput) {
          fileInput.addEventListener('change', async function () {
              const file = this.files && this.files[0];
              if (!file) return;
              // prevent concurrent handling
              if (isScanned) return;
              isScanned = true;
              try {
                  // if camera is currently scanning, stop it first
                  try {
                      if (_isCameraRunning()) {
                          await html5QrCode.stop();
                      }
                  } catch (e) { console.warn('Failed to stop camera before file scan', e); }

                  // ensure previous errors cleared
                  try { resultEl.innerHTML = ''; } catch (e) {}

                  // scan the file inside try/catch
                  try {
                      const decodedText = await html5QrCode.scanFile(file, true);
                      if (!decodedText) throw new Error('NO_DECODE');

                      // play beep
                      try { if (beepAudio && beepAudio.play) await beepAudio.play().catch(()=>{}); } catch (e) {}

                      // fetch data
                      const resp = await fetch('/scanner-barcode/proses', {
                          method: 'POST',
                          credentials: 'same-origin',
                          headers: {
                              'Content-Type': 'application/json',
                              'X-CSRF-TOKEN': csrfToken,
                              'Accept': 'application/json'
                          },
                          body: JSON.stringify({ barcode: decodedText })
                      });

                      let data = null;
                      try { data = await resp.json(); } catch (e) { data = null; }

                      if (!resp.ok) {
                          const msg = (data && data.error) ? data.error : ('HTTP ' + resp.status);
                          showError(msg);
                          isScanned = false;
                          return;
                      }

                      if (!data) { showError('Respon server kosong'); isScanned = false; return; }
                      if (data.error) { showError(data.error); isScanned = false; return; }

                      const item = Array.isArray(data) ? data[0] : data;
                      resultEl.innerHTML = renderResultHtml(item);
                      attachRescanHandler();
                  } catch (scanErr) {
                      console.warn('scanFile result/exception', scanErr);
                      showError('Barcode tidak ditemukan pada gambar');
                      isScanned = false;
                  }
              } finally {
                  this.value = '';
              }
          });
      }

      // start when ready
      startScanner();
  });
  </script>
