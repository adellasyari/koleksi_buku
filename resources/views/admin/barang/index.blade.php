
@extends('layouts.master')

@section('title', 'Daftar Barang UMKM')

@section('content')
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Daftar Barang UMKM</h4>
		</div>
		<div class="mb-3">
			<a href="{{ url('/barang/create') }}" class="btn btn-primary btn-sm">Tambah Barang Baru</a>
			<a href="{{ route('barang.simulasi') }}" class="btn btn-info btn-sm ms-2">Simulasi DOM Modul 4</a>
			<a href="{{ route('barang.simulasidt') }}" class="btn btn-success btn-sm ms-2">Simulasi DataTables Modul 4</a>
			<a href="{{ route('barang.simulasi.select') }}" class="btn btn-warning btn-sm ms-2">Simulasi Select Modul 4</a>
		</div>
		<div class="card-body">
			<div class="table-responsive">
						<div class="mb-2">
							<label style="font-weight:600;">
								<input type="checkbox" id="select-all-global"> Pilih semua (semua halaman)
							</label>
						</div>
							<table id="tabel-barang" class="table table-striped">
								<thead>
									<tr>
										<th>Pilih</th>
										<th>No</th>
										<th>ID Barang</th>
										<th>Nama Barang</th>
										<th>Harga</th>
										<th>Aksi</th>
									</tr>
								</thead>
								<tbody>
									@foreach($barang as $item)
										<tr>
											<td>
												<input type="checkbox" name="barang_id[]" value="{{ $item->id_barang }}" form="form-cetak" class="row-checkbox" data-id="{{ $item->id_barang }}">
											</td>
											<td>{{ $loop->iteration }}</td>
											<td>{{ $item->id_barang }}</td>
											<td>{{ $item->nama }}</td>
											<td>{{ 'Rp ' . number_format($item->harga, 0, ',', '.') }}</td>
											<td>
												<a href="{{ url('/barang/'.$item->id_barang.'/edit') }}" class="btn btn-sm btn-warning">Edit</a>
												<form action="{{ url('/barang/'.$item->id_barang) }}" method="POST" class="d-inline">
													@csrf
													@method('DELETE')
													<button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
												</form>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>

							<form id="form-cetak" action="{{ url('/cetak-label') }}" method="POST" target="_blank">
								@csrf
								<div class="row mt-3">
									<div class="col-md-3">
										<div class="mb-3">
											<label class="form-label">Mulai dari Kolom (X)</label>
											<input type="number" name="posisi_x" min="1" max="5" value="1" class="form-control">
										</div>
									</div>
									<div class="col-md-3">
										<div class="mb-3">
											<label class="form-label">Mulai dari Baris (Y)</label>
											<input type="number" name="posisi_y" min="1" max="8" value="1" class="form-control">
										</div>
									</div>
								</div>

								<button type="submit" class="btn btn-success mt-3">Cetak Label Harga</button>
							</form>
			</div>
		</div>
	</div>
@endsection

@push('style-page')
	<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@endpush

@push('script-page')
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
			var table = $('#tabel-barang').DataTable();

			// store selected IDs across all pages
			var selectedIds = new Set();

			function updateGlobalCheckbox() {
				var total = table.rows().data().length;
				$('#select-all-global').prop('checked', total > 0 && selectedIds.size === total);
			}

			// sync DOM checkboxes on draw (pagination/search)
			table.on('draw', function() {
				table.cells().nodes().to$().find('input.row-checkbox').each(function() {
					var id = String($(this).data('id'));
					$(this).prop('checked', selectedIds.has(id));
				});
				updateGlobalCheckbox();
			});

			// Global select-all (all pages)
			$('#select-all-global').on('change', function() {
				var checked = $(this).is(':checked');
				var $all = table.cells().nodes().to$().find('input.row-checkbox');
				$all.each(function() {
					var id = String($(this).data('id'));
					if (checked) selectedIds.add(id); else selectedIds.delete(id);
				});
				$all.prop('checked', checked);
				updateGlobalCheckbox();
			});

			// Individual checkbox toggle
			$(document).on('change', 'input.row-checkbox', function() {
				var id = String($(this).data('id'));
				if ($(this).is(':checked')) selectedIds.add(id); else selectedIds.delete(id);
				updateGlobalCheckbox();
			});

			// On form submit, append hidden inputs for all selected IDs (so server receives all selections)
			$('#form-cetak').on('submit', function() {
				// remove previous temp inputs
				$(this).find('input[name="barang_id[]"].temp-input').remove();
				selectedIds.forEach(function(id) {
					$('<input>').attr({type: 'hidden', name: 'barang_id[]', value: id}).addClass('temp-input').appendTo('#form-cetak');
				});
				return true;
			});

			// initial sync
			table.draw(false);
		});
	</script>
@endpush
