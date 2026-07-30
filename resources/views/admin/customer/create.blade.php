@extends('layouts.master')

@section('content')
	<div class="page-header">
		<h3 class="page-title">Tambah Customer</h3>
	</div>

	<div class="row">
		<div class="col-md-8 offset-md-2">
			<div class="card">
				<div class="card-body">
					<form id="customer-form" action="{{ route('customer.store') }}" method="POST">
						@csrf
						<input type="hidden" name="mode" value="{{ $mode ?? 'blob' }}">

						<div class="mb-3">
							<label for="nama" class="form-label">Nama</label>
							<input type="text" class="form-control" id="nama" name="nama" required />
						</div>

						<div class="mb-3">
							<label for="alamat" class="form-label">Alamat</label>
							<textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="provinsi" class="form-label">Provinsi</label>
								<input type="text" class="form-control" id="provinsi" name="provinsi" />
							</div>
							<div class="col-md-6 mb-3">
								<label for="kota" class="form-label">Kota</label>
								<input type="text" class="form-control" id="kota" name="kota" />
							</div>
						</div>

						<div class="row">
							<div class="col-md-6 mb-3">
								<label for="kecamatan" class="form-label">Kecamatan</label>
								<input type="text" class="form-control" id="kecamatan" name="kecamatan" />
							</div>
							<div class="col-md-6 mb-3">
								<label for="kodepos" class="form-label">Kodepos</label>
								<input type="text" class="form-control" id="kodepos" name="kodepos" />
							</div>
						</div>

						<!-- Hidden input to store base64 photo -->
						<input type="hidden" id="foto_data" name="foto_data" />

						<div class="mb-3">
							<label class="form-label">Foto</label>
							<div class="d-flex align-items-center">
								<div style="width:140px;height:140px;border:1px solid #ddd;display:flex;align-items:center;justify-content:center;margin-right:12px;">
									<img id="previewFoto" src="" alt="Preview Foto" style="max-width:100%;max-height:100%;display:none;" />
									<span id="previewPlaceholder" style="color:#999;">No foto</span>
								</div>
								<div>
									<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cameraModal">Ambil Foto</button>
								</div>
							</div>
						</div>

						<div class="mt-4">
							<button type="submit" class="btn btn-success">Simpan Customer</button>
							<a href="{{ url('/customer') }}" class="btn btn-secondary">Batal</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- Camera Modal -->
	<div class="modal fade" id="cameraModal" tabindex="-1" aria-labelledby="cameraModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="cameraModalLabel">Ambil Foto</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-8 text-center">
							<video id="video" autoplay playsinline style="width:100%;background:#000"></video>
							<canvas id="canvas" style="display:none;"></canvas>
						</div>
						<div class="col-md-4">
							<div class="mb-2">
								<label for="cameraSelect" class="form-label">Pilihan Kamera</label>
								<select id="cameraSelect" class="form-select"></select>
							</div>
							<div class="mb-3">
								<button type="button" id="btnSnapshot" class="btn btn-outline-primary w-100 mb-2">Ambil Snapshot</button>
								<button type="button" id="btnSavePhoto" class="btn btn-primary w-100" disabled>Simpan Foto</button>
							</div>
							<div>
								<p class="mb-1"><strong>Preview Snapshot</strong></p>
								<div style="width:100%;height:220px;border:1px solid #ddd;display:flex;align-items:center;justify-content:center;">
									<img id="snapshotPreview" src="" alt="Snapshot Preview" style="max-width:100%;max-height:100%;display:none;" />
									<span id="snapshotPlaceholder" style="color:#999;">Belum ada snapshot</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
				</div>
			</div>
		</div>
	</div>

@endsection

@push('script-page')
<script>
	(function () {
		let stream = null;
		let lastSnapshotData = null;

		const video = document.getElementById('video');
		const canvas = document.getElementById('canvas');
		const btnSnapshot = document.getElementById('btnSnapshot');
		const btnSavePhoto = document.getElementById('btnSavePhoto');
		const snapshotPreview = document.getElementById('snapshotPreview');
		const snapshotPlaceholder = document.getElementById('snapshotPlaceholder');
		const previewFoto = document.getElementById('previewFoto');
		const previewPlaceholder = document.getElementById('previewPlaceholder');
		const fotoDataInput = document.getElementById('foto_data');
		const cameraSelect = document.getElementById('cameraSelect');

		const modalEl = document.getElementById('cameraModal');

		// Start camera with optional deviceId. Stops previous stream first.
		async function startCamera(deviceId = null) {
			// stop any existing stream first
			stopCamera();
			if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
				alert('Perangkat ini tidak mendukung akses kamera melalui browser (getUserMedia). Gunakan HTTPS atau browser/OS yang mendukung.');
				return;
			}
			try {
				const constraints = deviceId ? { video: { deviceId: { exact: deviceId } }, audio: false } : { video: { facingMode: 'environment' }, audio: false };
				stream = await navigator.mediaDevices.getUserMedia(constraints);
				video.srcObject = stream;
				await video.play();
			} catch (err) {
				console.error('getUserMedia error:', err);
				alert('Gagal mengakses kamera: ' + (err.message || err));
			}
		}

		function stopCamera() {
			if (stream) {
				const tracks = stream.getTracks();
				tracks.forEach(t => t.stop());
				stream = null;
			}
			try { video.pause(); video.srcObject = null; } catch (e) {}
		}

		function takeSnapshot() {
			if (!video || video.readyState === 0) return null;
			const w = video.videoWidth;
			const h = video.videoHeight;
			canvas.width = w;
			canvas.height = h;
			const ctx = canvas.getContext('2d');
			ctx.drawImage(video, 0, 0, w, h);
			const dataUrl = canvas.toDataURL('image/png');
			lastSnapshotData = dataUrl;
			snapshotPreview.src = dataUrl;
			snapshotPreview.style.display = 'block';
			snapshotPlaceholder.style.display = 'none';
			btnSavePhoto.disabled = false;
		}

		function saveSnapshotToForm() {
			if (!lastSnapshotData) return;
			// set hidden input and preview in main form
			fotoDataInput.value = lastSnapshotData;
			previewFoto.src = lastSnapshotData;
			previewFoto.style.display = 'block';
			previewPlaceholder.style.display = 'none';
			// close modal
			try {
				if (typeof bootstrap !== 'undefined') {
					const modal = bootstrap.Modal.getInstance(modalEl);
					if (modal) modal.hide();
				} else if (window.$) {
					$('#cameraModal').modal('hide');
				}
			} catch (e) {
				modalEl.style.display = 'none';
			}
			// stop camera
			stopCamera();
		}

		// Populate camera list
		async function populateCameraList() {
			if (!navigator.mediaDevices || !navigator.mediaDevices.enumerateDevices) return;
			try {
				const devices = await navigator.mediaDevices.enumerateDevices();
				const videoInputs = devices.filter(d => d.kind === 'videoinput');
				cameraSelect.innerHTML = '';
				if (videoInputs.length === 0) {
					const opt = document.createElement('option');
					opt.value = '';
					opt.text = 'No camera detected';
					cameraSelect.appendChild(opt);
					cameraSelect.disabled = true;
					return;
				}
				videoInputs.forEach((device, idx) => {
					const option = document.createElement('option');
					option.value = device.deviceId;
					// device.label may be empty until permission granted
					option.text = device.label || 'Camera ' + (idx + 1);
					cameraSelect.appendChild(option);
				});
				cameraSelect.disabled = false;
			} catch (e) {
				console.error('enumerateDevices error', e);
			}
		}

		// Bind events
		if (modalEl) {
			modalEl.addEventListener('shown.bs.modal', async function () {
				// reset snapshot state
				lastSnapshotData = null;
				snapshotPreview.src = '';
				snapshotPreview.style.display = 'none';
				snapshotPlaceholder.style.display = 'block';
				btnSavePhoto.disabled = true;
				// feature detect
				if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
					alert('Browser tidak mendukung kamera pada protokol ini. Gunakan HTTPS atau localhost.');
					return;
				}
				await populateCameraList();
				// choose selected camera if available
				const selected = cameraSelect && cameraSelect.value ? cameraSelect.value : null;
				startCamera(selected);
			});

			modalEl.addEventListener('hidden.bs.modal', function () {
				// stop camera when modal closes
				stopCamera();
			});
		}

		// When user switches camera selection, restart stream with chosen device
		if (cameraSelect) {
			cameraSelect.addEventListener('change', function () {
				const id = cameraSelect.value;
				if (!id) return;
				// stop existing and start with new device
				startCamera(id);
			});
		}

		if (btnSnapshot) btnSnapshot.addEventListener('click', takeSnapshot);
		if (btnSavePhoto) btnSavePhoto.addEventListener('click', saveSnapshotToForm);

		// Clean up when leaving page
		window.addEventListener('beforeunload', function () { stopCamera(); });
	})();
</script>
@endpush
