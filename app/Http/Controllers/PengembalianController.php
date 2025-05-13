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
            'peminjaman_id' => 'required|exists:peminjaman,id',
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
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengembalian::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->has('sort')) {
            $query->orderBy('name', $request->query('sort'));
        }

        $Pengembalian = $query->paginate(5)->appends($request->query());
        
        return view('Pengembalian.Pengembalian', compact('Pengembalian'));
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
