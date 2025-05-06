<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;

class LaporanController extends Controller
{
    public function stok()
    {
        $data = Barang::with('kategori')->get();
        $judul = 'Stok Barang';
        $headers = ['ID', 'Nama', 'Kategori', 'Stok'];
        $rows = $data->map(fn($b) => [$b->id, $b->nama, $b->kategori->nama, $b->stok]);

        return view('laporan/laporan', ['judul' => $judul, 'headers' => $headers, 'data' => $rows]);
    }

    public function peminjaman()
    {
        $data = Peminjaman::with(['user', 'barang'])->get();
        $judul = 'Laporan Peminjaman';
        $headers = ['User', 'Barang', 'Tanggal Pinjam', 'Jumlah'];
        $rows = $data->map(fn($p) => [$p->user->name, $p->barang->nama, $p->tanggal_pinjam, $p->jumlah]);

        return view('laporan/laporan', ['judul' => $judul, 'headers' => $headers, 'data' => $rows]);
    }

    public function pengembalian()
    {
        $data = Pengembalian::with(['peminjaman.user', 'peminjaman.barang'])->get();
        $judul = 'Laporan Pengembalian';
        $headers = ['User', 'Barang', 'Tanggal Kembali'];
        $rows = $data->map(fn($k) => [
            $k->peminjaman->user->name,
            $k->peminjaman->barang->nama,
            $k->tanggal_kembali
        ]);

        return view('laporan/laporan', ['judul' => $judul, 'headers' => $headers, 'data' => $rows]);
    }
}

