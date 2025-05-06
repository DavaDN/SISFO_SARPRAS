<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\User;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // =============================
    // WEB (ADMIN)
    // =============================

    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'barang'])->get();
        return view('peminjaman.peminjaman', compact('peminjaman'));
    }

    public function create()
    {
        abort(403, 'Peminjaman hanya dapat dilakukan oleh user melalui aplikasi.');
    }

    public function store(Request $request)
    {
        abort(403, 'Peminjaman hanya dapat dilakukan oleh user melalui aplikasi.');
    }

    public function setujui($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->status = 'diterima';
        $pinjam->save();

        return redirect()->back()->with('success', 'Peminjaman disetujui.');
    }

    public function tolak($id)
    {
        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->status = 'ditolak';
        $pinjam->save();

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }

    // =============================
    // API (USER)
    // =============================

    public function apiIndex(Request $request)
    {
        return Peminjaman::with('barang')
            ->where('user_id', $request->user()->id)
            ->get();
    }

    public function apiStore(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        return Peminjaman::create([
            'user_id' => $request->user()->id,
            'barang_id' => $request->barang_id,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => now(),
            'status' => 'pending',
        ]);
    }

    public function apiReport(Request $request)
    {
        return $this->apiIndex($request);
    }
}
