<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Peminjaman | SISFO SARPRAS</title>
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
        select {
            padding: 8px 12px;
            background-color: #2563eb;
            color: white;
            margin-left: 6px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
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
                <a href="{{ route('peminjaman.index') }}" class="active">📥 Peminjaman</a>
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

    <!-- Main Content -->
    <div class="main">
        <div class="topbar">
            <div class="logo-area">
                <iconify-icon icon="mdi:school-outline" style="font-size: 26px; color: #1f2937;"></iconify-icon>
                SISFO SARPRAS
            </div>
        </div>

        <div class="content">
            <h2>Data Peminjaman</h2>
            <div class="search-box">
                <form method="GET" action="{{ route('peminjaman.index') }}" style="margin-bottom: 20px; display: flex; align-items: center;">
                    <input type="text" name="search" placeholder="Cari daftar peminjaman..." value="{{ request('search') }}">
                    <button type="submit"
                            style="padding: 8px 12px; background-color: #2563eb; color: white; border: none; border-radius: 6px; margin-left: 6px;">
                        Cari
                    </button>
                    <a href="{{ route('peminjaman.index') }}"
                       style="padding: 8px 12px; background-color: #6b7280; color: white; text-decoration: none; border-radius: 6px; margin-left: 6px;">
                        Reset
                    </a>
                    <select name="status" onchange="this.form.submit()" >
                        <option value="">Sortir Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="diterima" {{ request('status') == 'diterima' ? 'selected' : '' }}>Diterima</option>
                        <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                    </select>
                </form>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Keperluan</th>
                        <th>Kelas</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Alasan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $pinjam)
                    <tr>
                        <td>{{ $pinjam->pengguna->name }}</td>
                        <td>{{ $pinjam->barang->nama }}</td>
                        <td>{{ $pinjam->tanggal_pinjam }}</td>
                        <td>{{ $pinjam->tanggal_kembali }}</td>
                        <td>{{ $pinjam->keperluan }}</td>
                        <td>{{ $pinjam->kelas }}</td>
                        <td>{{ $pinjam->jumlah }}</td>
                        <td>
                            @if ($pinjam->status == 'pending')
                                <span class="badge pending">Pending</span>
                            @elseif ($pinjam->status == 'diterima')
                                <span class="badge diterima">Diterima</span>
                            @elseif ($pinjam->status == 'ditolak')
                                <span class="badge ditolak">Ditolak</span>
                            @endif
                        </td>
                        <td>{{ $pinjam->alasan_ditolak ?? '-' }}</td>
                         <td>
                            @if ($pinjam->status == 'pending')
                                <form action="{{ route('peminjaman.setuju', $pinjam->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn-action btn-approve">Setujui</button>
                                </form>
                                <button type="button" class="btn-action btn-reject" onclick="bukaModal({{ $pinjam->id }})">Tolak</button>
                            @else
                                <span>-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                <tr><td colspan="9">Tidak ada data ditemukan.</td></tr>
            @endforelse
                </tbody>
            </table>
             <!-- Pagination -->
@if ($peminjaman->lastPage() > 1)
<div style="margin-top: 20px; display: flex; gap: 8px; flex-wrap: wrap;">
    {{-- Prev --}}
    @if ($peminjaman->onFirstPage())
        <span style="padding: 8px 12px; background-color: #e5e7eb; color: #aaa; border-radius: 5px;">&laquo;</span>
    @else
        <a href="{{ $peminjaman->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('status') ? '&status=' . request('status') : '' }}"
           style="padding: 8px 12px; background-color: white; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #2563eb;">
            &laquo;
        </a>
    @endif

    {{-- Page Links --}}
    @for ($i = 1; $i <= $peminjaman->lastPage(); $i++)
        @if ($i == $peminjaman->currentPage())
            <span style="padding: 8px 12px; background-color: #2563eb; color: white; border-radius: 5px;">{{ $i }}</span>
        @else
            <a href="{{ $peminjaman->url($i) }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('status') ? '&status=' . request('status') : '' }}"
               style="padding: 8px 12px; background-color: white; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #2563eb;">
                {{ $i }}
            </a>
        @endif
    @endfor

    {{-- Next --}}
    @if ($peminjaman->hasMorePages())
        <a href="{{ $peminjaman->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}{{ request('status') ? '&status=' . request('status') : '' }}"
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

<!-- Modal Tolak -->
<div id="modal-tolak" style="display:none; position: fixed; z-index: 1000; top: 0; left: 0; width: 100%; height: 100%; 
background: rgba(0,0,0,0.5); justify-content: center; align-items: center;">
    <div style="background:white; border-radius: 12px; max-width: 500px; width: 90%; padding: 20px; box-shadow: 0 0 20px rgba(0,0,0,0.3);">
        <h3>Alasan Tolak</h3>
        <form method="POST" id="form-tolak" action="">
            @csrf
            <input type="text" name="alasan_ditolak" placeholder="Masukkan alasan penolakan" required
                   style="padding: 10px; width: 100%; border: 1px solid #ccc; border-radius: 6px; margin-top: 8px; margin-bottom: 14px;">
            <div style="text-align: right;">
                <button type="submit" style="padding: 10px 16px; background-color: #ef4444; color: white; border: none; border-radius: 6px; cursor: pointer;">Kirim</button>
                <button type="button" onclick="tutupModal()" style="padding: 10px 16px; margin-left: 8px; background: #999; color: white; border: none; border-radius: 6px; cursor: pointer;">Batal</button>
            </div>
        </form>
    </div>
</div>

<script>
    function bukaModal(id) {
        const form = document.getElementById('form-tolak');
        form.action = "/peminjaman/" + id + "/tolak"; // Pastikan route ini sesuai dengan route di web.php
        document.getElementById('modal-tolak').style.display = 'flex';
    }
    function tutupModal() {
        document.getElementById('modal-tolak').style.display = 'none';
    }
    // Optional: Tutup modal jika klik di luar konten modal
    window.onclick = function(event) {
        const modal = document.getElementById('modal-tolak');
        if (event.target === modal) {
            tutupModal();
        }
    }
</script>

</body>
</html>
