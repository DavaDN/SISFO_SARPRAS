<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $peminjamanHariIni = Peminjaman::whereDate('tanggal_pinjam', Carbon::today())->count();
        $pengembalianHariIni = Pengembalian::whereDate('tanggal_kembali', Carbon::today())->count();

        // Label hari Senin sampai Minggu
        $labelHari = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];
        $dataHari = [];

        // Ambil jumlah peminjaman tiap hari dalam minggu ini
        $startOfWeek = Carbon::now()->startOfWeek(); // Senin
        foreach (range(0, 6) as $i) {
            $tanggal = $startOfWeek->copy()->addDays($i)->format('Y-m-d');
            $jumlah = Peminjaman::whereDate('tanggal_pinjam', $tanggal)->count();
            $dataHari[] = $jumlah;
        }

        return view('admin.dashboard', compact(
            'totalBarang',
            'peminjamanHariIni',
            'pengembalianHariIni',
            'labelHari',
            'dataHari'
        ));
    }
}
