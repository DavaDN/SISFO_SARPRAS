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
        $peminjaman = Peminjaman::where('id', $request->peminjaman_id)
            ->where('pengguna_id', $request->user()->id)
            ->first();

        if (!$peminjaman) {
            return response()->json(['message' => 'Peminjaman tidak ditemukan atau bukan milik Anda.'], 403);
        }

        $request->validate([
            'peminjaman_id' => 'required|exists:peminjaman,id',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|file|mimes:jpg,jpeg,png|max:10000', // jika berupa gambar
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);
        if ($peminjaman->status !== 'diterima') {
            return response()->json(['message' => 'Pengembalian hanya untuk peminjaman yang diterima.'], 422);
        }

        $path = $request->file('kondisi')->store('kondisi', 'public');

        $pengembalian = Pengembalian::create([
            'peminjaman_id' => $request->peminjaman_id,
            'tanggal_kembali' => now(),
            'jumlah' => $request->jumlah,
            'kondisi' => $path,
            'status' => 'pending',
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


    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string|max:255',
        ]);

        $kembali = Pengembalian::findOrFail($id);
        $kembali->status = 'ditolak';
        $kembali->alasan_ditolak = $request->alasan_ditolak;
        $kembali->save();

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian ditolak.');
    }
}
