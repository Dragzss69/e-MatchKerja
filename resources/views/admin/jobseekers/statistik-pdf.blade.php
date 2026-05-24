<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
            padding: 20px;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4f46e5;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #1e1b4b;
            margin-bottom: 5px;
            font-size: 18px;
        }
        .header p {
            color: #666;
            font-size: 11px;
        }
        .date {
            text-align: right;
            font-size: 10px;
            margin-bottom: 20px;
        }
        
        /* Statistik Cards */
        .stats-container {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            flex: 1;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }
        .card.menganggur {
            background-color: #fff7ed;
            border: 1px solid #fdba74;
        }
        .card.bekerja {
            background-color: #f0fdf4;
            border: 1px solid #86efac;
        }
        .card h3 {
            font-size: 12px;
            margin-bottom: 8px;
            color: #666;
        }
        .card .number {
            font-size: 28px;
            font-weight: bold;
        }
        .card.menganggur .number { color: #ea580c; }
        .card.bekerja .number { color: #16a34a; }
        .progress-bar {
            margin-top: 10px;
            background-color: #e5e7eb;
            border-radius: 10px;
            height: 6px;
            overflow: hidden;
        }
        .progress-fill {
            height: 6px;
            border-radius: 10px;
        }
        .progress-fill.menganggur { background-color: #ea580c; }
        .progress-fill.bekerja { background-color: #16a34a; }
        
        /* Tabel */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f8fafc;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
        }
        .badge-menganggur { background: #fff7ed; color: #ea580c; }
        .badge-bekerja { background: #f0fdf4; color: #16a34a; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $title }}</h1>
        <p>{{ $subtitle }}</p>
        <p>e-MatchKerja - Sistem Pendukung Keputusan Penyaluran Bantuan</p>
    </div>

    <div class="date">
        Tanggal Cetak: {{ $tanggal_cetak }}<br>
        Dicetak oleh: {{ $petugas }}
    </div>

    @if($filter == 'all')
    <div class="stats-container">
        <div class="card menganggur">
            <h3>PENGGANGGURAN</h3>
            <div class="number">{{ $statistik['menganggur'] }}</div>
            <div class="percentage">{{ $statistik['persen_menganggur'] }}% dari total</div>
            <div class="progress-bar">
                <div class="progress-fill menganggur" style="width: {{ $statistik['persen_menganggur'] }}%"></div>
            </div>
        </div>
        <div class="card bekerja">
            <h3>BEKERJA</h3>
            <div class="number">{{ $statistik['bekerja'] }}</div>
            <div class="percentage">{{ $statistik['persen_bekerja'] }}% dari total</div>
            <div class="progress-bar">
                <div class="progress-fill bekerja" style="width: {{ $statistik['persen_bekerja'] }}%"></div>
            </div>
        </div>
    </div>
    
    <div style="text-align: center; margin-bottom: 20px; padding: 8px; background-color: #f0f9ff; border-radius: 6px;">
        <strong>Total Pencari Kerja: {{ $statistik['total'] }} orang</strong>
    </div>
    @endif

    <!-- Tabel Data -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama Lengkap</th>
                <th>Usia</th>
                <th>Pendidikan</th>
                <th>Status Kerja</th>
                <th>Lama Menganggur</th>
                <th>Status Verifikasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($profiles as $index => $profile)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $profile->nik }}</td>
                <td>{{ $profile->nama_lengkap }}</td>
                <td>{{ $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->age : '-' }} th</td>
                <td>{{ strtoupper($profile->pendidikan_terakhir) }}</td>
                <td>
                    <span class="badge {{ $profile->status_kerja_saat_ini == 'Menganggur' ? 'badge-menganggur' : 'badge-bekerja' }}">
                        {{ $profile->status_kerja_saat_ini }}
                    </span>
                </td>
                <td>{{ $profile->lama_menganggur }} bulan</td>
                <td>{{ $profile->status_verifikasi ?? 'Unverified' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center;">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>&copy; {{ date('Y') }} e-MatchKerja - All rights reserved</p>
    </div>
</body>
</html>