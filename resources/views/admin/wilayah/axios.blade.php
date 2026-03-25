@extends('layouts.master')

@section('title', 'Axios Dependent Dropdown - Wilayah Indonesia')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="mb-0">Axios Dependent Dropdown - Wilayah Indonesia</h4>
      </div>
      <div class="card-body">
        <form autocomplete="off">
          <div class="row g-3">
            <div class="col-md-6">
              <label for="provinsi" class="form-label">Provinsi</label>
              <select id="provinsi" class="form-select">
                <option value="0">Pilih ...</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="kota" class="form-label">Kota / Kabupaten</label>
              <select id="kota" class="form-select">
                <option value="0">Pilih ...</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="kecamatan" class="form-label">Kecamatan</label>
              <select id="kecamatan" class="form-select">
                <option value="0">Pilih ...</option>
              </select>
            </div>

            <div class="col-md-6">
              <label for="kelurahan" class="form-label">Kelurahan / Desa</label>
              <select id="kelurahan" class="form-select">
                <option value="0">Pilih ...</option>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const base = 'https://www.emsifa.com/api-wilayah-indonesia/api';

  const provinsi = document.getElementById('provinsi');
  const kota = document.getElementById('kota');
  const kecamatan = document.getElementById('kecamatan');
  const kelurahan = document.getElementById('kelurahan');

  function setDefault(selectElement) {
    selectElement.innerHTML = '<option value="0">Pilih ...</option>';
  }

  function setLoading(selectElement) {
    selectElement.innerHTML = '<option value="0">Loading...</option>';
  }

  function appendOptions(selectElement, data) {
    data.forEach(function (item) {
      const option = document.createElement('option');
      option.value = item.id;
      option.textContent = item.name;
      selectElement.appendChild(option);
    });
  }

  function resetKotaKecamatanKelurahan() {
    setDefault(kota);
    setDefault(kecamatan);
    setDefault(kelurahan);
  }

  function resetKecamatanKelurahan() {
    setDefault(kecamatan);
    setDefault(kelurahan);
  }

  function resetKelurahan() {
    setDefault(kelurahan);
  }

  function loadProvinsi() {
    setLoading(provinsi);

    axios.get(base + '/provinces.json')
      .then(function (response) {
        setDefault(provinsi);
        appendOptions(provinsi, response.data);
      })
      .catch(function () {
        setDefault(provinsi);
      });
  }

  provinsi.addEventListener('change', function () {
    const provId = this.value;

    resetKotaKecamatanKelurahan();

    if (provId === '0') {
      return;
    }

    setLoading(kota);

    axios.get(base + '/regencies/' + provId + '.json')
      .then(function (response) {
        setDefault(kota);
        appendOptions(kota, response.data);
      })
      .catch(function () {
        setDefault(kota);
      });
  });

  kota.addEventListener('change', function () {
    const kotaId = this.value;

    resetKecamatanKelurahan();

    if (kotaId === '0') {
      return;
    }

    setLoading(kecamatan);

    axios.get(base + '/districts/' + kotaId + '.json')
      .then(function (response) {
        setDefault(kecamatan);
        appendOptions(kecamatan, response.data);
      })
      .catch(function () {
        setDefault(kecamatan);
      });
  });

  kecamatan.addEventListener('change', function () {
    const kecId = this.value;

    resetKelurahan();

    if (kecId === '0') {
      return;
    }

    setLoading(kelurahan);

    axios.get(base + '/villages/' + kecId + '.json')
      .then(function (response) {
        setDefault(kelurahan);
        appendOptions(kelurahan, response.data);
      })
      .catch(function () {
        setDefault(kelurahan);
      });
  });

  setDefault(provinsi);
  resetKotaKecamatanKelurahan();
  loadProvinsi();
});
</script>
@endsection
