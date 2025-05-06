<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

// Route untuk user yang sudah login
Route::middleware('auth')->group(function () {
    // Profil akun admin
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dashboard
    Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen User Mobile (dibuat oleh admin)
    Route::resource('/user', UserController::class)->only(['index', 'create', 'store']);

    // Kategori Barang
    Route::resource('/kategori-barang', KategoriBarangController::class);

    // Barang
    Route::resource('/barang', BarangController::class);

    // Peminjaman
    Route::resource('/peminjaman', PeminjamanController::class);
    Route::post('/peminjaman/{id}/setuju', [PeminjamanController::class, 'setujui'])->name('peminjaman.setuju');
    Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');


    // Pengembalian
    Route::resource('/pengembalian', PengembalianController::class);

    // Laporan

    Route::get('/laporan', function () {
        return view('laporan.index'); // Halaman utama laporan
    })->name('laporan.index');

    Route::get('/laporan/stok', [LaporanController::class, 'stok'])->name('laporan.stok');
    Route::get('/laporan/peminjaman', [LaporanController::class, 'peminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/pengembalian', [LaporanController::class, 'pengembalian'])->name('laporan.pengembalian');
});

require __DIR__ . '/auth.php';
