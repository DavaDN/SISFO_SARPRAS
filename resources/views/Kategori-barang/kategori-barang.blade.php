<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kategori Barang | SISFO SARPRAS</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        * { box-sizing: border-box; font-family: Arial, sans-serif; }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            background-color: #f0f2f5;
            color: #333;
            overflow: hidden;
        }

        .container { display: flex; height: 100vh; }

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

        .nav a:hover { background-color: #19376D; }

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
            flex-grow: 1;
            overflow-y: auto;
        }

        .content h2 {
            font-size: 24px;
            color: #1e3a8a;
            margin-bottom: 20px;
        }

        .add-btn {
            display: inline-block;
            background-color: #2563eb;
            color: white;
            padding: 10px 16px;
            border-radius: 6px;
            text-decoration: none;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.05);
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th { background-color: #f9fafb; }

        .text-blue { color: #2563eb; text-decoration: none; margin-right: 10px; }
        .text-red { color: #dc2626; background: none; border: none; cursor: pointer; }

        .pagination {
            display: flex;
            list-style: none;
            gap: 8px;
            margin-top: 20px;
            padding: 0;
        }

        .pagination li a,
        .pagination li span {
            padding: 6px 12px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 4px;
            color: #2563eb;
            text-decoration: none;
        }

        .pagination li.active span {
            font-weight: bold;
            background-color: #2563eb;
            color: white;
            border-color: #2563eb;
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
                <a href="{{ route('kategori-barang.index') }}" class="active">📦 Kategori</a>
                <a href="{{ route('peminjaman.index') }}">📥 Peminjaman</a>
                <a href="{{ route('pengembalian.index') }}">✅ Pengembalian</a>
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

    <!-- Main -->
    <div class="main">
        <div class="topbar">
            <div class="logo-area">
                <iconify-icon icon="mdi:school-outline" style="font-size: 26px; color: #1f2937;"></iconify-icon>
                SISFO SARPRAS
            </div>
        </div>

        <div class="content">
            <h2>Kategori Barang</h2>
            <a href="{{ route('kategori-barang.create') }}" class="add-btn">+ Tambah Kategori</a>

            <!-- Search Form -->
            <form method="GET" action="{{ route('kategori-barang.index') }}" style="margin-bottom: 20px;">
                <input type="text" name="search" placeholder="Cari nama kategori..." value="{{ request('search') }}"
                       style="padding: 8px; border: 1px solid #ccc; border-radius: 6px; width: 250px;">
                <button type="submit"
                        style="padding: 8px 12px; background-color: #2563eb; color: white; border: none; border-radius: 6px; margin-left: 6px;">
                    Cari
                </button>
                <a href="{{ route('kategori-barang.index') }}"
                   style="padding: 8px 12px; background-color: #6b7280; color: white; text-decoration: none; border-radius: 6px; margin-left: 6px;">
                    Reset
                </a>
            </form>

            <!-- Table -->
            <table>
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
                </thead>
                <tbody>
                @forelse($kategori_barang as $kategori)
                    <tr>
                        <td>{{ $kategori->id }}</td>
                        <td>{{ $kategori->nama }}</td>
                        <td>
                            <a href="{{ route('kategori-barang.edit', $kategori) }}" class="text-blue">Edit</a>
                            <form action="{{ route('kategori-barang.destroy', $kategori) }}" method="POST" style="display: inline;">
                                @csrf @method('DELETE')
                                <button class="text-red" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3">Tidak ada data ditemukan.</td></tr>
                @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
@if ($kategori_barang->lastPage() > 1)
<div style="margin-top: 20px; display: flex; gap: 8px; flex-wrap: wrap;">
    {{-- Prev --}}
    @if ($kategori_barang->onFirstPage())
        <span style="padding: 8px 12px; background-color: #e5e7eb; color: #aaa; border-radius: 5px;">&laquo;</span>
    @else
        <a href="{{ $kategori_barang->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}"
           style="padding: 8px 12px; background-color: white; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #2563eb;">
            &laquo;
        </a>
    @endif

    {{-- Page Links --}}
    @for ($i = 1; $i <= $kategori_barang->lastPage(); $i++)
        @if ($i == $kategori_barang->currentPage())
            <span style="padding: 8px 12px; background-color: #2563eb; color: white; border-radius: 5px;">{{ $i }}</span>
        @else
            <a href="{{ $kategori_barang->url($i) }}{{ request('search') ? '&search=' . request('search') : '' }}"
               style="padding: 8px 12px; background-color: white; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #2563eb;">
                {{ $i }}
            </a>
        @endif
    @endfor

    {{-- Next --}}
    @if ($kategori_barang->hasMorePages())
        <a href="{{ $kategori_barang->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}"
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
