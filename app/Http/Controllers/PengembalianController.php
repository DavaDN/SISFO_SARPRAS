<?php
//api
namespace App\Http\Controllers\Api;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Http\Controllers\Controller;

class PengembalianController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
        ]);

        return Pengembalian::create([
            'peminjaman_id' => $request->peminjaman_id,
            'tanggal_kembali' => now(),
        ]);
    }
}
//web
namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('peminjaman.user', 'peminjaman.barang')->get();
        return view('pengembalian/pengembalian', compact('pengembalians'));
    }

    public function create()
    {
        $peminjaman = Peminjaman::doesntHave('pengembalian')->get();
        return view('pengembalian.create', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
        ]);

        Pengembalian::create([
            'peminjaman_id' => $request->peminjaman_id,
            'tanggal_kembali' => now(),
        ]);

        return redirect()->route('pengembalian/pengembalian')->with('success', 'Pengembalian berhasil dicatat');
    }
}

