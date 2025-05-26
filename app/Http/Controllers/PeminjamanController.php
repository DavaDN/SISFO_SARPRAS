<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    // =============================
    // WEB (ADMIN)
    // =============================

    public function index(Request $request)
    {
        $query = Peminjaman::with('barang', 'pengguna')
            ->whereDoesntHave('pengembalian'); // hanya yang belum dikembalikan

        if ($request->filled('search')) {
            $query->whereHas('barang', function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%');
            });
        }

        // 👇 Jika ada filter status, tampilkan sesuai status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // 👇 Default: sembunyikan yang ditolak
            $query->where('status', '!=', 'ditolak');
        }

        if ($request->has('sort')) {
            $query->orderBy('tanggal_pinjam', $request->query('sort'));
        }

        $peminjaman = $query->paginate(5)->appends($request->query());

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

        // Cek apakah status belum diterima agar stok tidak dikurangi dua kali
        if ($pinjam->status !== 'diterima') {
            $barang = $pinjam->barang;
            $barang->stok -= $pinjam->jumlah;
            $barang->save();
        }

        $pinjam->status = 'diterima';
        $pinjam->save();

        return redirect()->back()->with('success', 'Peminjaman disetujui.');
    }


    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string|max:255',
        ]);

        $pinjam = Peminjaman::findOrFail($id);
        $pinjam->status = 'ditolak';
        $pinjam->alasan_ditolak = $request->alasan_ditolak;
        $pinjam->save();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman ditolak.');
    }



    // =============================
    // API (USER)
    // =============================

    public function ApiIndex(Request $request)
    {
        return Peminjaman::with('barang')
            ->where('pengguna_id', $request->user()->id)
            ->whereDoesntHave('pengembalian') // hanya yang belum dikembalikan
            ->get();
    }


    public function ApiStore(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barang,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        return Peminjaman::create([
            'pengguna_id' => $request->user()->id,
            'barang_id' => $request->barang_id,
            'keperluan' => $request->keperluan,
            'kelas' => $request->kelas,
            'jumlah' => $request->jumlah,
            'tanggal_pinjam' => now(),
            'tanggal_kembali' => $request->tanggal_kembali,
            'status' => 'pending',
        ]);
    }

    public function ApiReport(Request $request)
    {
        $query = Peminjaman::with('barang')
            ->where('pengguna_id', $request->user()->id);

        // Filter status jika ada
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', $request->status);
        }

        return response()->json([
            'data' => $query->get(),
        ]);
    }
}
