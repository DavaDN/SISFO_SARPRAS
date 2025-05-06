<?php

namespace App\Http\Controllers\Api;

use App\Models\Barang;
use App\Http\Controllers\Controller;

class BarangController extends Controller
{
    public function index()
    {
        return response()->json(Barang::with('kategori')->get());
    }
}

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    public function index()
    {
        $barang = Barang::with('kategori')->get();
        return view('barang/barang', compact('barang'));
    }

    public function create()
    {
        $kategori = KategoriBarang::all();
        return view('barang/tambahbarang', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'stok' => 'required|numeric',
            'kategori_barang_id' => 'required|exists:kategori_barangs,id',
        ]);

        Barang::create($request->all());
        return redirect()->route('barang/barang')->with('success', 'Barang berhasil ditambahkan');
    }

    public function edit(Barang $barang)
    {
        $kategori = KategoriBarang::all();
        return view('barang/editbarang', compact('barang', 'kategori'));
    }

    public function update(Request $request, Barang $barang)
    {
        $request->validate([
            'nama' => 'required',
            'stok' => 'required|numeric',
            'kategori_barang_id' => 'required|exists:kategori_barang,id',
        ]);

        $barang->update($request->all());
        return redirect()->route('barang/barang')->with('success', 'Barang berhasil diupdate');
    }

    public function destroy(Barang $barang)
    {
        $barang->delete();
        return redirect()->route('barang/barang')->with('success', 'Barang berhasil dihapus');
    }
}

