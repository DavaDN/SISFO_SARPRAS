<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::with('kategori'); // langsung with relasi

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        if ($request->has('sort')) {
            $query->orderBy('nama', $request->query('sort')); // perhatikan: kolomnya 'nama' bukan 'name'
        }

        $barang = $query->paginate(5)->appends($request->query());

        return view('barang.barang', compact('barang'));
    }


    public function create()
    {
        $kategori = KategoriBarang::all();
        return view('barang/tambahbarang', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer',
            'kategori_barang_id' => 'required|exists:kategori_barang,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:10000',
        ]);

        $path = null;
        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('gambar_barang', 'public');
        }

        Barang::create([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'kategori_barang_id' => $request->kategori_barang_id,
            'gambar' => $path,
        ]);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Barang $barang)
    {
        $kategori = KategoriBarang::all();
        return view('barang/editbarang', compact('barang', 'kategori'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer',
            'kategori_barang_id' => 'required|exists:kategori_barang,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:10000',
        ]);

        // Jika ada file baru di-upload
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
                Storage::disk('public')->delete($barang->gambar);
            }

            $barang->gambar = $request->file('gambar')->store('gambar_barang', 'public');
        }

        $barang->update([
            'nama' => $request->nama,
            'stok' => $request->stok,
            'kategori_barang_id' => $request->kategori_barang_id,
            'gambar' => $barang->gambar,
        ]);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui.');
    }


    public function destroy(Barang $barang)
    {
        if ($barang->gambar && Storage::disk('public')->exists($barang->gambar)) {
            Storage::disk('public')->delete($barang->gambar);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus.');
    }

    //mobile
    public function indexApi()
    {
        $barang = Barang::with('kategori')->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Barang',
            'data' => $barang
        ]);
        
        $query = Barang::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        return response()->json($query->get());
    }
}
