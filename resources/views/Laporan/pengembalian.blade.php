<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengembalian | SISFO SARPRAS</title>
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

        .button-group {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }

        .button-group a {
            padding: 10px 16px;
            background-color: #2563eb;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        .button-group a.back {
            background-color: #6b7280;
        }
        .button-group select {
            padding: 10px 16px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }


        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f3f4f6;
            color: #374151;
        }

        td {
            color: #1f2937;
        }

        tr:nth-child(even) {
            background-color: #f9fafb;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="sidebar">
        <div>
            <div class="title">SISFO SARPRAS</div>
            <div class="nav">
                <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
                <a href="{{ route('barang.index') }}">💼 Barang</a>
                <a href="{{ route('kategori-barang.index') }}">📦 Kategori</a>
                <a href="{{ route('peminjaman.index') }}">📥 Peminjaman</a>
                <a href="{{ route('pengembalian.index') }}">✅ Pengembalian</a>
                <a href="{{ route('laporan.index') }}" class="active">📊 Laporan</a>
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
    <h2>Laporan Pengembalian</h2>

    <div class="button-group" style="display: flex; gap: 10px; flex-wrap: wrap; margin-bottom: 20px;">
        <form method="GET" action="{{ route('laporan.pengembalian') }}">
            <select name="status" onchange="this.form.submit()">
                <option value="">📋 Semua Status</option>
                <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>✅ Diterima</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending</option>
                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>❌ Ditolak</option>
            </select>
        </form>
        <a href="{{ route('laporan.pengembalian.pdf', ['status' => request('status')]) }}">📄 Download PDF</a>
        <a href="{{ route('laporan.pengembalian.excel', ['status' => request('status')]) }}">📊 Download Excel</a>
        <a href="{{ route('laporan.index') }}" class="back">🔙 Kembali</a>
    </div>

    <table>
        <thead>
        <tr>
            <th>Pengguna</th>
            <th>Barang</th>
            <th>Tanggal Kembali</th>
            <th>Kondisi</th>
            <th>Jumlah</th>
        </tr>
        </thead>
        <tbody>
        @forelse($data as $row)
            <tr>
                <td>{{ $row['pengguna'] }}</td>
                <td>{{ $row['barang'] }}</td>
                <td>{{ $row['tanggal_kembali'] }}</td>
                <td>{{ $row['kondisi'] }}</td>
                <td>{{ $row['jumlah'] }}</td>
            </tr>
        @empty
            <tr><td colspan="3">Tidak ada data pengembalian.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
</div>
</div>
</body>
</html>
