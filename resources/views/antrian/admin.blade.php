@extends('layouts.master')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-ticket-account"></i>
            </span> Kelola Antrian Hari Ini
        </h3>
        <button id="btnPanggil" class="btn btn-lg btn-gradient-primary">
            <i class="mdi mdi-bullhorn"></i> Panggil Berikutnya
        </button>
    </div>

    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Antrian</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="tabelAntrian">
                            <thead class="table-dark">
                                <tr>
                                    <th width="10%">Nomor</th>
                                    <th>Nama</th>
                                    <th width="20%">Status</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tabel-antrian">
                                <!-- Data akan dirender oleh AJAX Polling -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btnPanggil = document.getElementById('btnPanggil');
        const tbody = document.getElementById('tabel-antrian');

        // Panggil Berikutnya
        btnPanggil.addEventListener('click', function() {
            btnPanggil.disabled = true;
            btnPanggil.innerHTML = '<i class="mdi mdi-reload mdi-spin"></i> Memanggil...';

            fetch('{{ route("antrian.panggil") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.text())
            .then(text => {
                let data = {};
                try {
                    // Coba parse teks menjadi JSON, jika response kosong maka gunakan object kosong
                    data = text ? JSON.parse(text) : {};
                } catch (e) {
                    console.error('Response bukan JSON yang valid:', text);
                    return; // Hentikan eksekusi ke bawah
                }

                if (data.success === false) {
                    alert(data.message || 'Tidak ada antrian');
                }
            })
            .catch(error => {
                console.error('Error fetch:', error);
                alert('Terjadi kesalahan sistem saat menghubungi server.');
            })
            .finally(() => {
                btnPanggil.disabled = false;
                btnPanggil.innerHTML = '<i class="mdi mdi-bullhorn"></i> Panggil Berikutnya';
            });
        });

        // AJAX Polling menggantikan SSE
        function loadAntrian() {
            $.ajax({
                url: '{{ route("antrian.data_ajax") }}',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    tbody.innerHTML = '';
                    
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center">Belum ada antrian hari ini</td></tr>';
                        return;
                    }

                    data.forEach(item => {
                        let badgeClass = 'badge badge-secondary';
                        if (item.status === 'menunggu') badgeClass = 'badge badge-warning';
                        else if (item.status === 'dipanggil') badgeClass = 'badge badge-success';
                        else if (item.status === 'terlambat') badgeClass = 'badge badge-danger';

                        let trClass = item.status === 'dipanggil' ? 'table-success' : '';
                        
                        let aksiButton = '-';
                        if (item.status === 'dipanggil') {
                            aksiButton = `<button onclick="tandaiTerlambat(${item.id})" class="btn btn-sm btn-warning">Terlambat</button>`;
                        } else if (item.status === 'terlambat') {
                            aksiButton = `<button onclick="panggilUlang(${item.id})" class="btn btn-sm btn-info">Panggil Ulang</button>`;
                        }
                        
                        tbody.innerHTML += `
                            <tr class="${trClass}">
                                <td class="text-center"><strong>${item.nomor_antrian}</strong></td>
                                <td>${item.nama}</td>
                                <td><label class="${badgeClass}">${item.status.toUpperCase()}</label></td>
                                <td>${aksiButton}</td>
                            </tr>
                        `;
                    });
                },
                error: function(err) {
                    console.error('Gagal mengambil data antrian via AJAX', err);
                }
            });
        }

        // Panggil pertama kali saat halaman dimuat
        loadAntrian();
        
        // Interval polling 1.5 detik (1500 ms)
        setInterval(loadAntrian, 1500);
    });

    window.tandaiTerlambat = function(id) {
        fetch(`/antrian/${id}/terlambat`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert('Terjadi kesalahan saat memproses data.');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Terjadi kesalahan saat menghubungi server.');
        });
    };

    window.panggilUlang = function(id) {
        fetch(`/antrian/${id}/panggil-ulang`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                alert('Terjadi kesalahan saat memproses data.');
            }
        })
        .catch(err => {
            console.error('Error:', err);
            alert('Terjadi kesalahan saat menghubungi server.');
        });
    };
</script>
@endsection
