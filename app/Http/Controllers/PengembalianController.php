<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Pengguna;
use App\Http\Controllers\Controller;

class PengembalianController extends Controller
{
    public function Apistore(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string|max:255',
        ]);

        $pengembalian = Pengembalian::create([
            'peminjaman_id' => $request->peminjaman_id,
            'tanggal_kembali' => now(),
            'jumlah' => $request->jumlah, // ← tambahkan ini
            'kondisi' => $request->kondisi,
            'status' => 'pending' // jika kamu pakai approval admin
        ]);


        return response()->json([
            'message' => 'Pengembalian berhasil diajukan.',
            'data' => $pengembalian,
        ]);
    }

    //web



    public function index(Request $request)
    {
        $query = Pengembalian::with('peminjaman.pengguna', 'peminjaman.barang');

        if ($request->filled('search')) {
            $query->whereHas('peminjaman.barang', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pengembalian = $query->paginate(5)->appends($request->query());

        return view('pengembalian.pengembalian', compact('pengembalian'));
    }


    public function create()
    {
        abort(403, 'Pengembalian hanya dapat dilakukan oleh user melalui aplikasi.');
    }

    public function store(Request $request)
    {
        abort(403, 'Pengembalian hanya dapat dilakukan oleh user melalui aplikasi.');
    }

    public function setujui($id)
    {
        $kembali = Pengembalian::findOrFail($id);

        // Pastikan hanya menambahkan stok sekali
        if ($kembali->status !== 'diterima') {
            $barang = $kembali->peminjaman->barang;
            $barang->stok += $kembali->peminjaman->jumlah;
            $barang->save();
        }

        $kembali->status = 'diterima';
        $kembali->save();

        return redirect()->back()->with('success', 'Pengembalian disetujui.');
    }


    public function tolak($id)
    {
        $kembali = Pengembalian::findOrFail($id);
        $kembali->status = 'ditolak';
        $kembali->save();

        return redirect()->back()->with('success', 'Pengembalian ditolak.');
    }
}
