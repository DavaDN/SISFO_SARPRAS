<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;


class LaporanController extends Controller
{
    public function stok()
    {
        $barang = Barang::with('kategori')->get();
        $judul = 'Laporan Stok Barang';
        $headers = ['ID', 'Nama', 'Kategori', 'Stok','gambar'];
        $data = $barang->map(fn($b) => [
            $b->id,
            $b->nama,
            $b->kategori->nama ?? '-',
            $b->stok,
            $b->gambar ? '<img src="' . asset('storage/' . $b->gambar) . '" width="50" height="50">' : '-'
        ]);

        return view('laporan.stok', compact('judul', 'headers', 'data'));
    }
    public function exportStokPdf()
    {
        $data = Barang::with('kategori')->get()->map(fn($b) => [
            $b->id,
            $b->nama,
            $b->kategori->nama ?? '-',
            $b->stok,
            $b->gambar ? '<img src="' . asset('storage/' . $b->gambar) . '" width="50" height="50">' : '-'
        ]);

        $pdf = Pdf::loadView('laporan.template_pdf', [
            'judul' => 'Laporan Stok Barang',
            'headers' => ['ID', 'Nama', 'Kategori', 'Stok','gambar'],
            'data' => $data,
        ]);

        return $pdf->download('laporan_stok_barang.pdf');
    }

    public function exportStokExcel()
    {
        $data = Barang::with('kategori')->get()->map(fn($b) => [
            $b->id,
            $b->nama,
            $b->kategori->nama ?? '-',
            $b->stok,
            $b->gambar ? '<img src="' . asset('storage/' . $b->gambar) . '" width="50" height="50">' : '-'
        ])->toArray();

        return Excel::download(new GenericExport(['ID', 'Nama', 'Kategori', 'Stok','gambar'], $data), 'laporan_stok_barang.xlsx');
    }


    public function peminjaman()
    {
        $peminjaman = Peminjaman::with(['user', 'barang'])->get();
        $judul = 'Laporan Peminjaman';
        $headers = ['User', 'Barang', 'Tanggal Pinjam', 'Jumlah'];
        $data = $peminjaman->map(fn($p) => [
            $p->user->name ?? '-',
            $p->barang->nama ?? '-',
            $p->tanggal_pinjam,
            $p->jumlah
        ]);

        return view('laporan.peminjaman', compact('judul', 'headers', 'data'));
    }

    public function exportPeminjamanPdf()
    {
        $data = Peminjaman::with(['user', 'barang'])->get()->map(fn($p) => [
            $p->user->name ?? '-',
            $p->barang->nama ?? '-',
            $p->tanggal_pinjam,
            $p->jumlah
        ]);

        $pdf = Pdf::loadView('laporan.template_pdf', [
            'judul' => 'Laporan Peminjaman',
            'headers' => ['User', 'Barang', 'Tanggal Pinjam', 'Jumlah'],
            'data' => $data,
        ]);

        return $pdf->download('laporan_peminjaman.pdf');
    }

    public function exportPeminjamanExcel()
    {
        $data = Peminjaman::with(['user', 'barang'])->get()->map(fn($p) => [
            $p->user->name ?? '-',
            $p->barang->nama ?? '-',
            $p->tanggal_pinjam,
            $p->jumlah
        ])->toArray();

        return Excel::download(new GenericExport(['User', 'Barang', 'Tanggal Pinjam', 'Jumlah'], $data), 'laporan_peminjaman.xlsx');
    }


    public function pengembalian()
    {
        $pengembalian = Pengembalian::with(['peminjaman.user', 'peminjaman.barang'])->get();
        $judul = 'Laporan Pengembalian';
        $headers = ['User', 'Barang', 'Tanggal Kembali'];
        $data = $pengembalian->map(fn($k) => [
            $k->peminjaman->user->name ?? '-',
            $k->peminjaman->barang->nama ?? '-',
            $k->tanggal_kembali
        ]);

        return view('laporan.pengembalian', compact('judul', 'headers', 'data'));
    }

    public function exportPengembalianPdf()
    {
        $data = Pengembalian::with(['peminjaman.user', 'peminjaman.barang'])->get()->map(fn($k) => [
            $k->peminjaman->user->name ?? '-',
            $k->peminjaman->barang->nama ?? '-',
            $k->tanggal_kembali
        ]);

        $pdf = Pdf::loadView('laporan.template_pdf', [
            'judul' => 'Laporan Pengembalian',
            'headers' => ['User', 'Barang', 'Tanggal Kembali'],
            'data' => $data,
        ]);

        return $pdf->download('laporan_pengembalian.pdf');
    }

    public function exportPengembalianExcel()
    {
        $data = Pengembalian::with(['peminjaman.user', 'peminjaman.barang'])->get()->map(fn($k) => [
            $k->peminjaman->user->name ?? '-',
            $k->peminjaman->barang->nama ?? '-',
            $k->tanggal_kembali
        ])->toArray();

        return Excel::download(new GenericExport(['User', 'Barang', 'Tanggal Kembali'], $data), 'laporan_pengembalian.xlsx');
    }
}
