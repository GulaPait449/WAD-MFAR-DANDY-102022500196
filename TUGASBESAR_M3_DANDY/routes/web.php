<?php

use App\Http\Controllers\PesananController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/pesanan');
Route::resource('pesanan', PesananController::class)->except(['create', 'show']);