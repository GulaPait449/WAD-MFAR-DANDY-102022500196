<?php

use App\Http\Controllers\PelangganController;
use Illuminate\Support\Facades\Route;

// Lihat daftar: semua role
Route::middleware(['auth', 'role:admin,petugas,pemilik'])->group(function () {
    Route::get('/pelanggan', [PelangganController::class, 'index'])
        ->name('pelanggan.index');
});

// Tambah & edit: admin dan petugas
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/pelanggan/create', [PelangganController::class, 'create'])
        ->name('pelanggan.create');

    Route::post('/pelanggan', [PelangganController::class, 'store'])
        ->name('pelanggan.store');

    Route::get('/pelanggan/{pelanggan}/edit', [PelangganController::class, 'edit'])
        ->name('pelanggan.edit');

    Route::put('/pelanggan/{pelanggan}', [PelangganController::class, 'update'])
        ->name('pelanggan.update');
});

// Hapus: hanya admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('/pelanggan/{pelanggan}', [PelangganController::class, 'destroy'])
        ->name('pelanggan.destroy');
});
