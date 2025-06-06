<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;
use Illuminate\Support\Facades\Route;

// Login (tanpa token)
Route::post('/login', [AuthController::class, 'login']);

Route::middleware([
    'auth:sanctum',
    EnsureFrontendRequestsAreStateful::class,
])->group(function () {
    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Barang
    Route::get('/barang', [BarangController::class, 'indexApi']);

    // Peminjaman
    Route::get('/peminjaman', [PeminjamanController::class, 'Apiindex']);
    Route::post('/peminjaman', [PeminjamanController::class, 'Apistore']);

    // Pengembalian
    Route::post('/pengembalian', [PengembalianController::class, 'Apistore']);

    // Report
    Route::get('/report/peminjaman', [PeminjamanController::class, 'Apireport']);
});
