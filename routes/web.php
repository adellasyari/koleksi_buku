<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SimulasiController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AntrianController;


Auth::routes();

// Scanner barcode view and processing
Route::get('/scanner-barcode', function () {
    return view('scanner-barcode');
});
Route::post('/scanner-barcode/proses', [BarangController::class, 'prosesScan']);

// Social login (Google) and OTP routes
Route::get('/auth/google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');

Route::get('/auth/otp/{id}', [OtpController::class, 'index'])->name('otp.view');
Route::post('/auth/otp', [OtpController::class, 'verify'])->name('otp.verify');

// PDF routes (DomPDF)
Route::get('/pdf/sertifikat', [App\Http\Controllers\PdfController::class, 'downloadSertifikat'])->name('pdf.sertifikat');
Route::get('/pdf/undangan', [App\Http\Controllers\PdfController::class, 'downloadUndangan'])->name('pdf.undangan');

// Friendly routes for UI links
Route::get('/cetak-sertifikat', [PdfController::class, 'downloadSertifikat'])->name('cetak.sertifikat');
Route::get('/cetak-undangan', [PdfController::class, 'downloadUndangan'])->name('cetak.undangan');
// Public demo route for wilayah dependent dropdown (moved to auth group)
// Preview routes for in-dashboard PDF previews
Route::get('/preview-sertifikat', [PdfController::class, 'previewSertifikat'])->name('preview.sertifikat');
Route::get('/preview-undangan', [PdfController::class, 'previewUndangan'])->name('preview.undangan');
// Direct download routes
Route::get('/unduh-sertifikat', [PdfController::class, 'unduhSertifikat'])->name('unduh.sertifikat');
Route::get('/unduh-undangan', [PdfController::class, 'unduhUndangan'])->name('unduh.undangan');

// Redirect root to /home (which is protected by auth middleware)
Route::redirect('/', '/home');

// Protected routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Wilayah dependent dropdown (admin)
    Route::get('/wilayah', [WilayahController::class, 'index'])->name('wilayah.index');
    Route::get('/wilayah/axios', [WilayahController::class, 'axios'])->name('wilayah.axios');
    // POS (Kasir)
    Route::get('/pos', [PosController::class, 'index'])->name('pos.index');
    Route::get('/pos/cari-barang/{id}', [PosController::class, 'cariBarang'])->name('pos.cari_barang');
    Route::get('/pos/axios', [PosController::class, 'axiosIndex'])->name('pos.axios');
    Route::post('/pos/bayar', [PosController::class, 'bayar'])->name('pos.bayar');
    // Receipt/preview with QR code
    Route::get('/pos/receipt/{id}', [PosController::class, 'showReceipt'])->name('pos.receipt');
    Route::get('/barang', [BarangController::class, 'index']);
    Route::post('/cetak-label', [BarangController::class, 'cetakLabel']);
    Route::get('/barang/create', [BarangController::class, 'create']);
    // Legacy route names (kept for backward compatibility with existing views)
    Route::get('/barang/simulasi', [SimulasiController::class, 'dom'])->name('barang.simulasi');
    Route::get('/barang/simulasi-dt', [SimulasiController::class, 'datatables'])->name('barang.simulasidt');
    Route::get('/barang/simulasi-select', [SimulasiController::class, 'select'])->name('barang.simulasi.select');
    // (Simulasi routes moved to SimulasiController)
    Route::post('/barang/store', [BarangController::class, 'store']);
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/barang/{id}', [BarangController::class, 'update']);
    Route::delete('/barang/{id}', [BarangController::class, 'destroy']);
    // Simulation routes for Modul 4 (moved to dedicated controller)
    Route::get('/simulasi/dom', [SimulasiController::class, 'dom'])->name('simulasi.dom');
    Route::get('/simulasi/datatables', [SimulasiController::class, 'datatables'])->name('simulasi.datatables');
    Route::get('/simulasi/select', [SimulasiController::class, 'select'])->name('simulasi.select');

    // Routes for Buku and Kategori
    Route::resource('buku', BukuController::class);
    Route::resource('kategori', KategoriController::class);

    // Customer listing (index) and create/store routes
    Route::get('/customer', [CustomerController::class, 'index'])->name('customer.index');

    Route::post('/customer', [CustomerController::class, 'store'])->name('customer.store');
    Route::get('/customer/create-blob', [CustomerController::class, 'createBlob'])->name('customer.create.blob');
    Route::get('/customer/create-path', [CustomerController::class, 'createPath'])->name('customer.create.path');
    
});

// Lokasi Toko routes
use App\Http\Controllers\LokasiTokoController;

Route::get('/lokasi-toko', [LokasiTokoController::class, 'index'])->name('lokasi_toko.index');
Route::get('/lokasi-toko/create', [LokasiTokoController::class, 'create'])->name('lokasi_toko.create');
Route::post('/lokasi-toko', [LokasiTokoController::class, 'store'])->name('lokasi_toko.store');
Route::get('/lokasi-toko/cetak-barcode/{barcode}', [LokasiTokoController::class, 'cetakBarcode'])->name('lokasi_toko.cetak_barcode');
Route::get('/kunjungan-toko', [LokasiTokoController::class, 'halamanKunjungan'])->name('lokasi_toko.kunjungan');
Route::post('/kunjungan-toko/proses', [LokasiTokoController::class, 'prosesKunjungan'])->name('lokasi_toko.proses_kunjungan');

// Antrian routes
Route::get('/antrian', [AntrianController::class, 'halamanGuest'])->name('antrian.guest');
Route::post('/antrian/daftar', [AntrianController::class, 'daftarGuest'])->name('antrian.daftar');
Route::post('/antrian/panggil', [AntrianController::class, 'panggilAntrian'])->name('antrian.panggil');
Route::post('/antrian/{id}/terlambat', [AntrianController::class, 'tandaiTerlambat'])->name('antrian.terlambat');
Route::post('/antrian/{id}/panggil-ulang', [AntrianController::class, 'panggilUlang'])->name('antrian.panggil_ulang');
Route::get('/papan-antrian', [AntrianController::class, 'halamanPapan'])->name('antrian.papan');
Route::get('/admin-antrian', [AntrianController::class, 'halamanAdmin'])->name('antrian.admin');
Route::get('/sse/antrian', [AntrianController::class, 'stream'])->name('antrian.stream');
Route::get('/antrian/data-ajax', [AntrianController::class, 'dataAjax'])->name('antrian.data_ajax');
Route::get('/antrian/data-papan', [AntrianController::class, 'dataPapan'])->name('antrian.data_papan');

// NFC routes
use App\Http\Controllers\NfcController;

Route::get('/nfc', [NfcController::class, 'index'])->name('nfc.index');
Route::post('/nfc/scan', [NfcController::class, 'prosesScan'])->name('nfc.scan');
