@extends('layouts.master')

@section('title', 'Wilayah - Dependent Dropdown')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">AJAX Dependent Dropdown - Wilayah Indonesia</div>
      <div class="card-body">
        <form>
          <div class="row gx-3 gy-3">
            <div class="col-md-6">
              <label class="form-label">Provinsi</label>
              <select id="provinsi" class="form-select">
                <option value="0">Pilih ...</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Kota / Kabupaten</label>
              <select id="kota" class="form-select">
                <option value="0">Pilih ...</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Kecamatan</label>
              <select id="kecamatan" class="form-select">
                <option value="0">Pilih ...</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Kelurahan / Desa</label>
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
 
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
  console.log('wilayah script initialized');
  if(typeof jQuery === 'undefined'){
    console.warn('jQuery not found - AJAX may fail');
  } else {
    console.log('jQuery version:', jQuery.fn.jquery);
  }

  const base = 'https://www.emsifa.com/api-wilayah-indonesia/api';
  const $prov = $('#provinsi'), $kota = $('#kota'), $kec = $('#kecamatan'), $kel = $('#kelurahan');

  function setLoading($el){
    $el.html('<option value="0">Loading...</option>');
  }

  function setDefault($el){
    $el.html('<option value="0">Pilih ...</option>');
  }

  // Load provinces on page load
  setLoading($prov);
  $.ajax({
    url: base + '/provinces.json',
    dataType: 'json',
    timeout: 10000,
  })
  .done(function(data){
    console.log('provinces fetched, count=', Array.isArray(data)?data.length:'not-array', data && data[0]);
    setDefault($prov);
    if(Array.isArray(data)){
      $.each(data, function(i, item){
        $prov.append('<option value="'+item.id+'">'+item.name+'</option>');
      });
    } else {
      console.error('Unexpected provinces response', data);
    }
  })
  .fail(function(jqxhr, textStatus, error){
    setDefault($prov);
    console.error('Gagal memuat data provinsi:', textStatus, error, jqxhr.status, jqxhr.responseText);
  });

  // When provinsi changes -> clear kota/kecamatan/kelurahan -> load kota
  $prov.on('change', function(){
    const provId = $(this).val();
    setDefault($kota);
    setDefault($kec);
    setDefault($kel);

    if(provId && provId !== '0'){
      setLoading($kota);
      $.ajax({
        url: base + '/regencies/' + provId + '.json',
        dataType: 'json',
        timeout: 10000,
      })
      .done(function(data){
        console.log('regencies fetched for', provId, 'count=', Array.isArray(data)?data.length:'not-array');
        setDefault($kota);
        if(Array.isArray(data)){
          $.each(data, function(i, item){
            $kota.append('<option value="'+item.id+'">'+item.name+'</option>');
          });
        } else { console.error('Unexpected regencies response', data); }
      })
      .fail(function(jqxhr, textStatus, error){
        setDefault($kota);
        console.error('Gagal memuat data kota:', textStatus, error, jqxhr.status, jqxhr.responseText);
      });
    }
  });

  // When kota changes -> clear kecamatan/kelurahan -> load kecamatan
  $kota.on('change', function(){
    const kotaId = $(this).val();
    setDefault($kec);
    setDefault($kel);

    if(kotaId && kotaId !== '0'){
      setLoading($kec);
      $.ajax({
        url: base + '/districts/' + kotaId + '.json',
        dataType: 'json',
        timeout: 10000,
      })
      .done(function(data){
        console.log('districts fetched for', kotaId, 'count=', Array.isArray(data)?data.length:'not-array');
        setDefault($kec);
        if(Array.isArray(data)){
          $.each(data, function(i, item){
            $kec.append('<option value="'+item.id+'">'+item.name+'</option>');
          });
        } else { console.error('Unexpected districts response', data); }
      })
      .fail(function(jqxhr, textStatus, error){
        setDefault($kec);
        console.error('Gagal memuat data kecamatan:', textStatus, error, jqxhr.status, jqxhr.responseText);
      });
    }
  });

  // When kecamatan changes -> clear kelurahan -> load kelurahan
  $kec.on('change', function(){
    const kecId = $(this).val();
    setDefault($kel);

    if(kecId && kecId !== '0'){
      setLoading($kel);
      $.ajax({
        url: base + '/villages/' + kecId + '.json',
        dataType: 'json',
        timeout: 10000,
      })
      .done(function(data){
        console.log('villages fetched for', kecId, 'count=', Array.isArray(data)?data.length:'not-array');
        setDefault($kel);
        if(Array.isArray(data)){
          $.each(data, function(i, item){
            $kel.append('<option value="'+item.id+'">'+item.name+'</option>');
          });
        } else { console.error('Unexpected villages response', data); }
      })
      .fail(function(jqxhr, textStatus, error){
        setDefault($kel);
        console.error('Gagal memuat data kelurahan:', textStatus, error, jqxhr.status, jqxhr.responseText);
      });
    }
  });

});
</script>

@endsection
