<?php

namespace App\Http\Controllers;

use App\Models\KategoriBarang;
use Illuminate\Http\Request;

class KategoriBarangController extends Controller
{
    
    public function index(Request $request)
    {
        $query = KategoriBarang::query();

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }
        if ($request->has('sort')) {
            $query->orderBy('name', $request->query('sort'));
        }

        $kategori_barang = $query->paginate(5)->appends($request->query());

        return view('kategori-barang/kategori-barang', compact('kategori_barang'));
    }



    public function create()
    {
        return view('Kategori-barang.tambahkategori');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required']);
        KategoriBarang::create($request->all());
        return redirect()->route('kategori-barang.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(KategoriBarang $kategori_barang)
    {
        return view('kategori-barang.editkategori', compact('kategori_barang'));
    }

    public function update(Request $request, KategoriBarang $kategori_barang)
    {
        $request->validate(['nama' => 'required']);
        $kategori_barang->update($request->all());
        return redirect()->route('kategori-barang.index')->with('success', 'Data berhasil diupdate');
    }

    public function destroy(KategoriBarang $kategori_barang)
    {
        $kategori_barang->delete();
        return redirect()->route('kategori-barang.index')->with('success', 'Data berhasil dihapus');
    }
}
