@extends('layouts.app')

@section('content')
<div class="container py-10">
    <h2 class="text-2xl font-bold text-blue-800 mb-4">Data Pengembalian</h2>

    <table class="w-full mt-4 table-auto border">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">User</th>
                <th class="p-2 border">Barang</th>
                <th class="p-2 border">Tanggal Kembali</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengembalian as $kembali)
            <tr>
                <td class="p-2 border">{{ $kembali->peminjaman->user->name }}</td>
                <td class="p-2 border">{{ $kembali->peminjaman->barang->nama }}</td>
                <td class="p-2 border">{{ $kembali->tanggal_kembali }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
