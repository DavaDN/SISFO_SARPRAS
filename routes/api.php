<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/barang', [BarangController::class, 'index']);
    Route::get('/peminjaman', [PeminjamanController::class, 'Index']);
    Route::post('/peminjaman', [PeminjamanController::class, 'Store']); // hanya user login
    Route::get('/peminjaman/report', [PeminjamanController::class, 'Report']);
    Route::post('/pengembalian', [PengembalianController::class, 'store']);
    Route::get('/report/peminjaman', [PeminjamanController::class, 'report']);
});
