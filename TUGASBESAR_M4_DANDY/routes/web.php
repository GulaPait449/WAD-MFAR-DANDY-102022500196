<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MesinController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;
use App\Models\Mesin;

// Halaman daftar mesin
Route::middleware(['auth', 'role:admin,petugas,pemilik'])->group(function () {
    Route::get('/', [MesinController::class, 'index'])
        ->name('mesin.index');
});

// Tambah mesin
Route::middleware(['auth', 'role:admin,petugas'])->group(function () {
    Route::get('/mesin/create', [MesinController::class, 'create'])
        ->name('mesin.create');

    Route::post('/mesin', [MesinController::class, 'store'])
        ->name('mesin.store');

    // Edit dan update mesin
    Route::get('/mesin/{id}/edit', [MesinController::class, 'edit'])
        ->name('mesin.edit');

    Route::put('/mesin/{id}', [MesinController::class, 'update'])
        ->name('mesin.update');
});

// Hapus mesin hanya untuk admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::delete('/mesin/{id}', [MesinController::class, 'destroy'])
        ->name('mesin.destroy');
});

// REST API untuk menampilkan data mesin dalam format JSON
Route::get('/api/mesin', function () {
    return response()->json([
        'data' => Mesin::all()
    ]);
});

// Dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profil pengguna
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// Layanan & Pesanan (hak akses diatur di config/rbac.php lewat Gate "can:")
Route::middleware('auth')->group(function () {
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

// Route autentikasi
require __DIR__.'/pelanggan.php';
require __DIR__.'/auth.php';