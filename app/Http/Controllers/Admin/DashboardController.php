<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();

        $peminjamanHariIni = Peminjaman::where('status', 'diterima')
            ->whereDate('tanggal_pinjam', now())->count();

        $pengembalianHariIni = Pengembalian::where('status', 'diterima')
            ->whereDate('tanggal_kembali', now())->count();

        $labelHari = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $dataHari = [];
        $startOfWeek = now()->startOfWeek();

        foreach (range(0, 6) as $i) {
            $tanggal = $startOfWeek->copy()->addDays($i)->format('Y-m-d');
            $jumlah = Peminjaman::where('status', 'diterima')
                ->whereDate('tanggal_pinjam', $tanggal)->count();
            $dataHari[] = $jumlah;
        }

        $notifPeminjaman = Peminjaman::with('pengguna')
            ->where('status', 'pending')->latest()->take(5)->get();

        $notifPengembalian = Pengembalian::with('peminjaman.pengguna')
            ->where('status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalBarang',
            'peminjamanHariIni',
            'pengembalianHariIni',
            'labelHari',
            'dataHari',
            'notifPeminjaman',
            'notifPengembalian'
        ));
    }

    // ✅ Digunakan untuk AJAX refresh notifikasi
    public function getNotif()
    {
        $notifPeminjaman = Peminjaman::with('pengguna')
            ->where('status', 'pending')
            ->latest()->take(5)->get();

        $notifPengembalian = Pengembalian::with('peminjaman.pengguna')
            ->where('status', 'pending')
            ->latest()->take(5)->get();

        $jumlah = $notifPeminjaman->count() + $notifPengembalian->count();

        // Gunakan blade partial untuk bagian notifikasi
        $html = view('admin.partials.notifikasi', compact('notifPeminjaman', 'notifPengembalian'))->render();

        return response()->json([
            'jumlah' => $jumlah,
            'html' => $html
        ]);
    }
}
