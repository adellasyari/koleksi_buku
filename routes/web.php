<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\PdfController;


Auth::routes();

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

    // Routes for Buku and Kategori
    Route::resource('buku', BukuController::class);
    Route::resource('kategori', KategoriController::class);
});
