<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Data Barang | SISFO SARPRAS</title>
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        html,
        body {
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

        /* SIDEBAR */
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

        /* MAIN */
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

        .btn {
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
        }

        th,
        td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        thead {
            background-color: #f3f4f6;
        }

        th {
            color: #374151;
            font-weight: bold;
        }

        td {
            color: #1f2937;
        }

        .text-blue {
            color: #2563eb;
            text-decoration: none;
        }

        .text-red {
            color: #dc2626;
            background: none;
            border: none;
            font-size: 14px;
            cursor: pointer;
        }

        .form-inline {
            display: inline;
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
                    <a href="{{ route('barang.index') }}" class="active">💼 Barang</a>
                    <a href="{{ route('kategori-barang.index') }}">📦 Kategori</a>
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

        <!-- Main Content -->
        <div class="main">
            <div class="topbar">
                <div class="logo-area">
                    <iconify-icon icon="mdi:school-outline" style="font-size: 26px; color: #1f2937;"></iconify-icon>
                    SISFO SARPRAS
                </div>
            </div>
            <div class="content">
                <h2>Data Barang</h2>
                <button class="btn" onclick="openTambahModal()">+ Tambah Barang</button>
                <form method="GET" action="{{ route('barang.index') }}" style="margin-bottom: 20px;">
                    <input type="text" name="search" placeholder="Cari nama barang ..."
                        value="{{ request('search') }}"
                        style="padding: 8px; border: 1px solid #ccc; border-radius: 6px; width: 250px;">
                    <button type="submit"
                        style="padding: 8px 12px; background-color: #2563eb; color: white; border: none; border-radius: 6px; margin-left: 6px;">
                        Cari
                    </button>
                    <a href="{{ route('barang.index') }}"
                        style="padding: 8px 12px; background-color: #6b7280; color: white; text-decoration: none; border-radius: 6px; margin-left: 6px;">
                        Reset
                    </a>
                </form>

                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $b)
                            <tr>
                                <td>{{ $b->id }}</td>
                                <td>{{ $b->nama }}</td>
                                <td>{{ $b->kategori->nama }}</td>
                                <td>{{ $b->stok }}</td>
                                <td>
                                    @if ($b->gambar)
                                        <img src="{{ asset('storage/' . $b->gambar) }}" alt="{{ $b->nama }}"
                                            style="width: 60px; height: auto; border-radius: 4px;">
                                    @else
                                        <span style="color: #888;">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="text-blue"
                                        onclick="openEditModal({{ $b->id }})">Edit</button>
                                    <form action="{{ route('barang.destroy', $b) }}" method="POST"
                                        class="form-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Yakin?')" class="text-red">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">Tidak ada data ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <!-- Pagination -->
                @if ($barang->lastPage() > 1)
                    <div style="margin-top: 20px; display: flex; gap: 8px; flex-wrap: wrap;">
                        {{-- Prev --}}
                        @if ($barang->onFirstPage())
                            <span
                                style="padding: 8px 12px; background-color: #e5e7eb; color: #aaa; border-radius: 5px;">&laquo;</span>
                        @else
                            <a href="{{ $barang->previousPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}"
                                style="padding: 8px 12px; background-color: white; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #2563eb;">
                                &laquo;
                            </a>
                        @endif

                        {{-- Page Links --}}
                        @for ($i = 1; $i <= $barang->lastPage(); $i++)
                            @if ($i == $barang->currentPage())
                                <span
                                    style="padding: 8px 12px; background-color: #2563eb; color: white; border-radius: 5px;">{{ $i }}</span>
                            @else
                                <a href="{{ $barang->url($i) }}{{ request('search') ? '&search=' . request('search') : '' }}"
                                    style="padding: 8px 12px; background-color: white; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #2563eb;">
                                    {{ $i }}
                                </a>
                            @endif
                        @endfor

                        {{-- Next --}}
                        @if ($barang->hasMorePages())
                            <a href="{{ $barang->nextPageUrl() }}{{ request('search') ? '&search=' . request('search') : '' }}"
                                style="padding: 8px 12px; background-color: white; border: 1px solid #ccc; border-radius: 5px; text-decoration: none; color: #2563eb;">
                                &raquo;
                            </a>
                        @else
                            <span
                                style="padding: 8px 12px; background-color: #e5e7eb; color: #aaa; border-radius: 5px;">&raquo;</span>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    <div id="modalTambah"
        style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); justify-content:center; align-items:center;">
        <div
            style="background: white; margin: 5% auto; padding: 20px; width: 90%; max-width: 500px; border-radius: 8px; position: relative;">
            <h2 style="margin-bottom: 16px;">Tambah Barang</h2>
            <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label>Nama</label>
                <input type="text" name="nama" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
                <label>Stok</label>
                <input type="number" name="stok" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
                <label>Kategori</label>
                <select name="kategori_barang_id" required style="width: 100%; padding: 8px; margin-bottom: 10px;">
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}"
                            {{ old('kategori_barang_id') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama }}
                        </option>
                    @endforeach
                </select>
                <label>Gambar</label>
                <input type="file" name="gambar" required style="margin-bottom: 10px;">
                <div style="text-align: right;">
                    <button type="submit"
                        style="background: #2563eb; color: white; padding: 10px 16px; border: none; border-radius: 6px;">Simpan</button>
                    <button type="button" onclick="closeTambahModal()"
                        style="margin-left: 8px; background: #aaa; color: white; padding: 10px 16px; border: none; border-radius: 6px;">Tutup</button>
                </div>
            </form>
        </div>
    </div>
    <!-- Modal Edit -->
    @foreach ($barang as $b)
        <div id="editModal-{{ $b->id }}" class="modal"
            style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.4); justify-content:center; align-items:center;">
            <div style="background:white; padding:24px; border-radius:12px; max-width:400px; width:90%;">
                <h3>Edit Barang</h3>
                <form action="{{ route('barang.update', $b) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <label>Nama</label>
                    <input type="text" name="nama" value="{{ $b->nama }}" required
                        style="width:100%; margin-bottom:10px;">

                    <label>Stok</label>
                    <input type="number" name="stok" value="{{ $b->stok }}" required
                        style="width:100%; margin-bottom:10px;">

                    <label>Kategori</label>
                    <select name="kategori_barang_id" required style="width:100%; margin-bottom:10px;">
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}"
                                {{ $b->kategori_barang_id == $k->id ? 'selected' : '' }}>
                                {{ $k->nama }}
                            </option>
                        @endforeach
                    </select>

                    <label>Gambar</label>
                    <input type="file" name="gambar" accept="image/*" style="margin-bottom:10px;">

                    <div style="text-align: right;">
                        <button type="submit"
                            style="
                    padding: 10px 20px;
                    background-color: #2563eb;
                    color: white;
                    border: none;
                    border-radius: 10px;
                    font-weight: bold;
                    margin-right: 10px;
                    cursor: pointer;
                ">Simpan</button>

                        <button type="button" onclick="closeEditModal({{ $b->id }})"
                            style="
                    padding: 10px 20px;
                    background-color: #9ca3af;
                    color: white;
                    border: none;
                    border-radius: 10px;
                    font-weight: bold;
                    cursor: pointer;
                ">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <script>
        function openTambahModal() {
            document.getElementById('modalTambah').style.display = 'flex';
        }

        function closeTambahModal() {
            document.getElementById('modalTambah').style.display = 'none';
        }


        function openEditModal(id) {
            document.getElementById('editModal-' + id).style.display = 'flex';
        }

        function closeEditModal(id) {
            document.getElementById('editModal-' + id).style.display = 'none';
        }

        // Tutup modal jika klik di luar kontennya
        window.onclick = function(e) {
            document.querySelectorAll('.modal').forEach(modal => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });
        }
    </script>


</body>

</html>
