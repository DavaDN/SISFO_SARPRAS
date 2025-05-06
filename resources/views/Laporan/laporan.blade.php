@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Laporan</h2>
    <ul>
        <li><a href="{{ route('laporan.stok') }}">📦 Laporan Stok Barang</a></li>
        <li><a href="{{ route('laporan.peminjaman') }}">📥 Laporan Peminjaman</a></li>
        <li><a href="{{ route('laporan.pengembalian') }}">✅ Laporan Pengembalian</a></li>
    </ul>
</div>
@endsection
