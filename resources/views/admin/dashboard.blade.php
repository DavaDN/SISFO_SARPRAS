<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | SISFO SARPRAS</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            height: 110px; /* tambah tinggi */
            background-color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 40px; /* opsional: tambah horizontal spacing */
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }


        .topbar .logo-area {
            display: flex;
            align-items: center;
            gap: 16px;
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
            display: flex;
            flex-direction: column;
            font-weight: bold;
        }

        .content h1 { margin-bottom: 30px; }

        .cards {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            flex: 1;
            background-color: white;
            padding: 20px;
            border-left: 8px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .card.blue { border-color: #3B82F6; }
        .card.green { border-color: #22c55e; }
        .card.red { border-color: #ef4444; }

        .card .label {
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .card .value {
            font-size: 28px;
            font-weight: bold;
        }

        .chart-container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            flex-grow: 1;
        }

        canvas { max-width: 100%; }
    </style>
</head>
<body>

<div class="container">

    <!-- Sidebar -->
    <div class="sidebar">
        <div>
            <div class="title">SISFO SARPRAS</div>
            <div class="nav">
                <a href="{{ route('dashboard') }}" class="active">🏠 Dashboard</a>
                <a href="{{ route('barang.index') }}">💼 Barang</a>
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

    <!-- Main -->
    <div class="main">
        <div class="topbar">
            <div class="logo-area">
                <iconify-icon icon="mdi:school-outline" style="font-size: 26px; color: #1f2937;"></iconify-icon>
                SISFO SARPRAS
            </div>
        </div>

        <div class="content">
            <h1>Dashboard</h1>

            <!-- Cards -->
            <div class="cards">
                <div class="card blue">
                    <div class="label">Total Barang</div>
                    <div class="value">{{ $totalBarang }}</div>
                </div>
                <div class="card green">
                    <div class="label">Peminjaman Hari Ini</div>
                    <div class="value">{{ $peminjamanHariIni }}</div>
                </div>
                <div class="card red">
                    <div class="label">Pengembalian Hari Ini</div>
                    <div class="value">{{ $pengembalianHariIni }}</div>
                </div>
            </div>

            <!-- Chart -->
            <div class="chart-container">
                <h3 style="margin-bottom: 20px;">Peminjaman per Minggu</h3>
                <canvas id="peminjamanChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script>
    const ctx = document.getElementById('peminjamanChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($labelHari) !!},
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: {!! json_encode($dataHari) !!},
                borderColor: '#3B82F6',
                backgroundColor: 'rgba(59,130,246,0.2)',
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1 }
                }
            }
        }
    });
</script>

</body>
</html>
