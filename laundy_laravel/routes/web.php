<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::redirect('/', '/layanan');

    Route::controller(LayananController::class)->prefix('layanan')->name('layanan.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:layanan.lihat');
        Route::post('/', 'store')->name('store')->middleware('can:layanan.tambah');
        Route::get('/{layanan}/edit', 'edit')->name('edit')->middleware('can:layanan.edit');
        Route::put('/{layanan}', 'update')->name('update')->middleware('can:layanan.edit');
        Route::delete('/{layanan}', 'destroy')->name('destroy')->middleware('can:layanan.hapus');
    });

    Route::controller(PesananController::class)->prefix('pesanan')->name('pesanan.')->group(function () {
        Route::get('/', 'index')->name('index')->middleware('can:pesanan.lihat');
        Route::post('/', 'store')->name('store')->middleware('can:pesanan.tambah');
        Route::get('/{pesanan}/edit', 'edit')->name('edit')->middleware('can:pesanan.edit');
        Route::put('/{pesanan}', 'update')->name('update')->middleware('can:pesanan.edit');
        Route::delete('/{pesanan}', 'destroy')->name('destroy')->middleware('can:pesanan.hapus');
    });
});
