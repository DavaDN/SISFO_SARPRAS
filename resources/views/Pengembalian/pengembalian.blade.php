<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Pengembalian | SISFO SARPRAS</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #f0f2f5;
            color: #333;
        }

        .container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 250px;
            background-color: #111827;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .sidebar .title {
            padding: 25px;
            font-size: 22px;
            font-weight: bold;
            text-align: center;
        }

        .nav a {
            display: block;
            padding: 16px 22px;
            text-decoration: none;
            color: white;
            font-size: 16px;
        }

        .nav a.active {
            background-color: white;
            color: black;
            font-weight: bold;
            border-radius: 12px 0 0 12px;
        }

        .nav a:hover {
            background-color: #19376D;
        }

        .logout {
            padding: 24px;
        }

        .logout form button {
            width: 100%;
            padding: 12px;
            background-color: #19376D;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 80px;
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 30px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        .topbar .logo-area {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            font-size: 20px;
            color: #1f2937;
        }

        .avatar {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .content {
            padding: 30px;
            overflow-y: auto;
        }

        .content h2 {
            font-size: 22px;
            color: #1d4ed8;
            margin-bottom: 20px;
        }

        .btn {
            background-color: #2563eb;
            color: white;
            padding: 10px 16px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        thead {
            background-color: #f3f4f6;
        }

        .badge {
            padding: 6px 10px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .pending { background: #fef3c7; color: #92400e; }
        .diterima { background: #d1fae5; color: #065f46; }
        .ditolak { background: #fee2e2; color: #991b1b; }

        .btn-action {
            padding: 6px 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }
        .search-box input {
            padding: 10px;
            width: 220px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .btn-approve {
            background-color: #22c55e;
            color: white;
            margin-right: 6px;
        }

        .btn-reject {
            background-color: #ef4444;
            color: white;
        }
    </style>
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <div class="title">SISFO SARPRAS</div>
            <div class="nav">
                <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
                <a href="{{ route('barang.index') }}">💼 Barang</a>
                <a href="{{ route('kategori-barang.index') }}">📦 Kategori</a>
                <a href="{{ route('peminjaman.index') }}" >📥 Peminjaman</a>
                <a href="{{ route('pengembalian.index') }}" class="active">✅ Pengembalian</a>
                <a href="{{ route('laporan.index') }}">📊 Laporan</a>
                <a href="{{ route('pengguna.index') }}">👥 Pengguna</a>
            </div>
        </div>
        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">📤 Logout</button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main">
        <div class="topbar">
            <div class="logo-area">
                <iconify-icon icon="mdi:school-outline" style="font-size: 26px; color: #1f2937;"></iconify-icon>
                SISFO SARPRAS
            </div>
        </div>

        <div class="content">
            <h2>Data Pengembalian</h2>
            <div class="search-box">
                <form method="GET" action="{{ route('pengembalian.index') }}" style="margin-bottom: 20px;">
                    <input type="text" name="search" placeholder="Cari daftar peminjaman..." value="{{ request('search') }}"
                           style="padding: 8px; border: 1px solid #ccc; border-radius: 6px; width: 250px;">
                    <button type="submit"
                            style="padding: 8px 12px; background-color: #2563eb; color: white; border: none; border-radius: 6px; margin-left: 6px;">
                        Cari
                    </button>
                    <a href="{{ route('pengembalian.index') }}"
                       style="padding: 8px 12px; background-color: #6b7280; color: white; text-decoration: none; border-radius: 6px; margin-left: 6px;">
                        Reset
                    </a>
                    <form method="GET" action="{{ route('pengembalian.index') }}" style="margin-bottom: 20px;">
                    <select name="status" onchange="this.form.submit()" style="padding: 8px 12px; background-color: #2563eb; color: white;margin-left: 6px; border: none; border-radius: 6px; font-size: 14px;">
                        <option value="">Sortir Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Barang</th>
                        <th>Tanggal kembali</th>
                        <th>Kondisi</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengembalian as $kembali)
                    <tr>
                        <td>{{ $kembali->peminjaman->pengguna->name }}</td>
                        <td>{{ $kembali->peminjaman->barang->nama }}</td>
                        <td>{{ $kembali->tanggal_kembali }}</td>
                        <td>{{ $kembali->kondisi }}</td>
                        <td>{{ $kembali->jumlah }}</td>
                        <td>
                            @if ($kembali->status == 'pending')
                                <span class="badge pending">Pending</span>
                            @elseif ($kembali->status == 'diterima')
                                <span class="badge diterima">Diterima</span>
                            @elseif ($kembali->status == 'ditolak')
                                <span class="badge ditolak">Ditolak</span>
                            @endif
                        </td>
                        <td>
                            @if ($kembali->status == 'pending')
                                <form action="{{ route('pengembalian.setuju', $kembali->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-approve">Setujui</button>
                                </form>
                                <form action="{{ route('pengembalian.tolak', $kembali->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-reject">Tolak</button>
                                </form>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                <tr><td colspan="3">Tidak ada data ditemukan.</td></tr>
            @endforelse
                </tbody>
            </table>
             <!-- Pagination -->
@if ($pengembalian->lastPage() > 1)
<div style="margin-top: 20px; display: flex; gap: 8px; flex-wrap: wrap;">
    {{-- Prev --}}
    @if ($pengembalian->onFirstPage())
        <span style="padding: 8px 12px; background-color: #e5e7eb; color: #aaa; border-radius: 5px;">&laquo;</span>
    @else
        <a href="{{ $pengembalian->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}"
           style="padding: 8px 12px; background-color: white; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #2563eb;">
            &laquo;
        </a>
    @endif

    {{-- Page Links --}}
    @for ($i = 1; $i <= $pengembalian->lastPage(); $i++)
        @if ($i == $pengembalian->currentPage())
            <span style="padding: 8px 12px; background-color: #2563eb; color: white; border-radius: 5px;">{{ $i }}</span>
        @else
            <a href="{{ $pengembalian->url($i) }}{{ request('search') ? '&search=' . request('search') : '' }}"
               style="padding: 8px 12px; background-color: white; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #2563eb;">
                {{ $i }}
            </a>
        @endif
    @endfor

    {{-- Next --}}
    @if ($pengembalian->hasMorePages())
        <a href="{{ $pengembalian->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}"
           style="padding: 8px 12px; background-color: white; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #2563eb;">
            &raquo;
        </a>
    @else
        <span style="padding: 8px 12px; background-color: #e5e7eb; color: #aaa; border-radius: 5px;">&raquo;</span>
    @endif
</div>
@endif
        </div>
    </div>
</div>

</body>
</html>
