<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;
use Illuminate\Http\Request;


class LaporanController extends Controller
{
    public function laporanstok()
    {
        $barang = Barang::with('kategori')->get();
        $judul = 'Laporan Stok Barang';
        $headers = ['ID', 'Nama', 'Kategori', 'Stok', 'gambar'];
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
            'headers' => ['ID', 'Nama', 'Kategori', 'Stok', 'gambar'],
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

        return Excel::download(new GenericExport(['ID', 'Nama', 'Kategori', 'Stok', 'gambar'], $data), 'laporan_stok_barang.xlsx');
    }


    public function laporanpeminjaman(Request $request)
    {
        $status = $request->get('status'); // ambil dari URL
        $query = Peminjaman::with(['pengguna', 'barang']);

        if ($status) {
            $query->where('status', $status);
        }

        $peminjaman = $query->get();

        $judul = 'Laporan Peminjaman';
        $headers = ['Pengguna', 'Barang', 'Tanggal Pinjam', 'Tanggal Kembali', 'Keperluan', 'Kelas', 'Jumlah'];
        $data = $peminjaman->map(fn($p) => [
            'pengguna' => $p->pengguna->name ?? '-',
            'barang' => $p->barang->nama ?? '-',
            'tanggal_pinjam' => $p->tanggal_pinjam,
            'tanggal_kembali' => $p->tanggal_kembali,
            'keperluan' => $p->keperluan,
            'kelas' => $p->kelas,
            'jumlah' => $p->jumlah,
        ]);

        return view('laporan.peminjaman', compact('judul', 'headers', 'data', 'status'));
    }



    public function exportPeminjamanPdf(Request $request)
    {
        $status = $request->get('status');
        $query = Peminjaman::with(['pengguna', 'barang']);

        if ($status) {
            $query->where('status', $status);
        }

        $peminjaman = $query->get();

        $data = $peminjaman->map(fn($p) => [
            'pengguna' => $p->pengguna->name ?? '-',
            'barang' => $p->barang->nama ?? '-',
            'tanggal_pinjam' => $p->tanggal_pinjam,
            'tanggal_kembali' => $p->tanggal_kembali,
            'keperluan' => $p->keperluan,
            'kelas' => $p->kelas,
            'jumlah' => $p->jumlah
        ]);

        $pdf = Pdf::loadView('laporan.template_pdf', [
            'judul' => 'Laporan Peminjaman',
            'headers' => ['Pengguna', 'Barang', 'Tanggal Pinjam', 'Tanggal Kembali', 'Keperluan', 'Kelas', 'Jumlah'],
            'data' => $data,
        ]);

        return $pdf->download('laporan_peminjaman.pdf');
    }


    public function exportPeminjamanExcel(Request $request)
    {
        $status = $request->get('status');
        $query = Peminjaman::with(['pengguna', 'barang']);

        if ($status) {
            $query->where('status', $status);
        }

        $peminjaman = $query->get();
        $data = $peminjaman->map(fn($p) => [
            'pengguna' => $p->pengguna->name ?? '-',
            'barang' => $p->barang->nama ?? '-',
            'tanggal_pinjam' => $p->tanggal_pinjam,
            'tanggal_kembali' => $p->tanggal_kembali,
            'keperluan' => $p->keperluan,
            'kelas' => $p->kelas,
            'jumlah' => $p->jumlah
        ])->toArray();

        return Excel::download(
            new GenericExport(['Pengguna', 'Barang', 'Tanggal Pinjam', 'Tanggal Kembali', 'Keperluan', 'Kelas', 'Jumlah'], $data),
            'laporan_peminjaman.xlsx'
        );
    }



    public function laporanpengembalian(Request $request)
    {
        $status = $request->get('status');
        $query = Pengembalian::with(['peminjaman.pengguna', 'peminjaman.barang']);

        if ($status) {
            $query->where('status', $status);
        }

        $pengembalian = $query->get();
        $judul = 'Laporan Pengembalian';
        $headers = ['pengguna', 'Barang', 'Tanggal Kembali'];
        $data = $pengembalian->map(fn($k) => [
            'pengguna' => $k->peminjaman->pengguna->name ?? '-',
            'barang' => $k->peminjaman->barang->nama ?? '-',
            'tanggal_kembali' => $k->tanggal_kembali,
            'kondisi' => $k->kondisi ?? '-',
            'jumlah' => $k->jumlah ?? '-', // tambahkan jika ada kolom ini
        ]);


        return view('laporan.pengembalian', compact('judul', 'headers', 'data', 'status'));
    }



    public function exportPengembalianPdf(Request $request)
    {
        $status = $request->get('status');
        $query = Pengembalian::with(['peminjaman.pengguna', 'peminjaman.barang']);

        if ($status) {
            $query->where('status', $status);
        }

        $data = $query->get()->map(fn($k) => [
            $k->peminjaman->pengguna->name ?? '-',
            $k->peminjaman->barang->nama ?? '-',
            $k->tanggal_kembali
        ]);

        $pdf = Pdf::loadView('laporan.template_pdf', [
            'judul' => 'Laporan Pengembalian',
            'headers' => ['pengguna', 'Barang', 'Tanggal Kembali'],
            'data' => $data,
        ]);

        return $pdf->download('laporan_pengembalian.pdf');
    }


    public function exportPengembalianExcel(Request $request)
    {
        $status = $request->get('status');
        $query = Pengembalian::with(['peminjaman.pengguna', 'peminjaman.barang']);

        if ($status) {
            $query->where('status', $status);
        }

        $data = $query->get()->map(fn($k) => [
            $k->peminjaman->pengguna->name ?? '-',
            $k->peminjaman->barang->nama ?? '-',
            $k->tanggal_kembali
        ])->toArray();

        return Excel::download(
            new GenericExport(['pengguna', 'Barang', 'Tanggal Kembali'], $data),
            'laporan_pengembalian.xlsx'
        );
    }
}
