<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penyaluran Bantuan - AnoJobs</title>
    <style>
        body { 
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; 
            margin: 30px; 
            color: #334155;
            font-size: 11px;
        }
        h1 { 
            text-align: center; 
            color: #1e3a8a; 
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }
        .header { 
            text-align: center; 
            margin-bottom: 25px; 
            border-bottom: 2px solid #e2e8f0;
            padding-bottom: 15px;
        }
        .header p {
            margin: 4px 0 0;
            color: #64748b;
            font-size: 11px;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-top: 15px; 
        }
        th, td { 
            border: 1px solid #cbd5e1; 
            padding: 8px 10px; 
            text-align: left; 
        }
        th { 
            background-color: #f8fafc; 
            color: #1e293b;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        tr:nth-child(even) {
            background-color: #f8fafc/40;
        }
        .status {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN REKAPITULASI PENGAJUAN BANTUAN SOSIAL</h1>
        <p>Sistem Pendukung Keputusan Penyaluran Bantuan Sosial - AnoJobs</p>
        <p>Tanggal Cetak Dokumen: {{ date('d F Y H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="25%">Nama Lengkap</th>
                <th width="20%">Jenis Bantuan</th>
                <th class="text-right" width="20%">Nominal Diajukan</th>
                <th class="text-center" width="15%">Status Pengajuan</th>
                <th class="text-center" width="15%">Tanggal Pengajuan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengajuans as $key => $p)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td><strong>{{ $p->pencariKerja->name ?? '-' }}</strong></td>
                <td>{{ str_replace('_', ' ', ucwords($p->jenis_bantuan)) }}</td>
                <td class="text-right">Rp {{ number_format($p->nominal_diajukan ?? 0, 0, ',', '.') }}</td>
                <td class="text-center status">{{ $p->status }}</td>
                <td class="text-center">{{ $p->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>