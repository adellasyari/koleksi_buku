<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;


Auth::routes();

// Redirect root to /home (which is protected by auth middleware)
Route::redirect('/', '/home');

// Protected routes (requires authentication)
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Routes for Buku and Kategori
    Route::resource('buku', BukuController::class);
    Route::resource('kategori', KategoriController::class);
});
