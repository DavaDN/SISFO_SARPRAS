<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\KategoriBarangController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\LaporanController;
use App\Models\KategoriBarang;
use App\Models\Barang;

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
    Route::resource('/pengguna', PenggunaController::class)->only(['index', 'create', 'store']);
    // Route untuk edit pengguna
    Route::get('pengguna/{pengguna}/edit', [PenggunaController::class, 'edit'])->name('pengguna.edit');

    // Route untuk update pengguna
    Route::put('pengguna/{pengguna}', [PenggunaController::class, 'update'])->name('pengguna.update');
    Route::delete('pengguna/{pengguna}', [PenggunaController::class, 'destroy'])->name('pengguna.destroy');



    // Kategori Barang
    Route::resource('/kategori-barang', KategoriBarangController::class);
    Route::get('tambahkategori', [KategoriBarangController::class, 'create'])->name('kategori.create');
    Route::post('/tambahkategori', [KategoriBarangController::class, 'store'])->name('kategori.store');

    // Barang
    Route::resource('/barang', BarangController::class);
    Route::get('tambahbarang', [BarangController::class, 'create'])->name('barang.tambah');
    Route::post('/tambahbarang', [BarangController::class, 'store'])->name('barang.store');


    // Peminjaman
    Route::resource('/peminjaman', PeminjamanController::class);
    Route::post('/peminjaman/{id}/setuju', [PeminjamanController::class, 'setujui'])->name('peminjaman.setuju');
    Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');


    // Pengembalian
    Route::resource('/pengembalian', PengembalianController::class);
    Route::post('/pengembalian/{id}/setuju', [pengembalianController::class, 'setujui'])->name('pengembalian.setuju');
    Route::post('/pengembalian/{id}/tolak', [pengembalianController::class, 'tolak'])->name('pengembalian.tolak');

    // Laporan

    Route::get('/laporan', function () {
        $judul = 'Laporan Stok Barang';
        $headers = ['ID', 'Nama', 'Kategori', 'Stok'];
        $data = Barang::with('kategori')->get()->map(fn($b) => [
            $b->id,
            $b->nama,
            $b->kategori->nama ?? '-',
            $b->stok
        ]);

        return view('laporan.laporan', compact('judul', 'headers', 'data'));
    })->name('laporan.index');

    Route::get('/laporan/stok', [LaporanController::class, 'laporanstok'])->name('laporan.stok');
    Route::get('/laporan/stok/pdf', [LaporanController::class, 'exportStokPdf'])->name('laporan.stok.pdf');
    Route::get('/laporan/stok/excel', [LaporanController::class, 'exportStokExcel'])->name('laporan.stok.excel');

    Route::get('/laporan/peminjaman', [LaporanController::class, 'laporanpeminjaman'])->name('laporan.peminjaman');
    Route::get('/laporan/peminjaman/pdf', [LaporanController::class, 'exportPeminjamanPdf'])->name('laporan.peminjaman.pdf');
    Route::get('/laporan/peminjaman/excel', [LaporanController::class, 'exportPeminjamanExcel'])->name('laporan.peminjaman.excel');

    Route::get('/laporan/pengembalian', [LaporanController::class, 'laporanpengembalian'])->name('laporan.pengembalian');
    Route::get('/laporan/pengembalian/pdf', [LaporanController::class, 'exportPengembalianPdf'])->name('laporan.pengembalian.pdf');
    Route::get('/laporan/pengembalian/excel', [LaporanController::class, 'exportPengembalianExcel'])->name('laporan.pengembalian.excel');
});

require __DIR__ . '/auth.php';
