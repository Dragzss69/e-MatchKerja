<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pengajuan Bantuan - e-MatchKerja</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { text-align: center; color: #1e40af; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #333; padding: 10px; text-align: left; }
        th { background-color: #f1f5f9; }
        .header { text-align: center; margin-bottom: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENGAJUAN BANTUAN</h1>
        <p>e-MatchKerja - Sistem Pendukung Keputusan Penyaluran Bantuan</p>
        <p>Tanggal Cetak: {{ date('d F Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Lengkap</th>
                <th>Jenis Bantuan</th>
                <th>Nominal</th>
                <th>Status</th>
                <th>Tanggal Pengajuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuans as $key => $p)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $p->pencariKerja->name ?? '-' }}</td>
                <td>{{ str_replace('_', ' ', ucwords($p->jenis_bantuan)) }}</td>
                <td>Rp {{ number_format($p->nominal_diajukan ?? 0) }}</td>
                <td>{{ ucfirst($p->status) }}</td>
                <td>{{ $p->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>