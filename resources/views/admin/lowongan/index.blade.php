@extends('layouts.app')

@section('title', 'Daftar Lowongan Kerja')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Lowongan Kerja</h2>
        <a href="{{ route('perusahaan.lowongan.create') }}" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Lowongan
        </a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Posisi</th>
                <th>Perusahaan</th>
                <th>Gaji</th>
                <th>Lokasi</th>
                <th>Kuota</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($lowongans as $lowongan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td><strong>{{ $lowongan->posisi }}</strong></td>
                <td>{{ $lowongan->perusahaan->name ?? 'N/A' }}</td>
                <td>Rp {{ number_format($lowongan->gaji_min) }} - 
                    Rp {{ number_format($lowongan->gaji_max ?? $lowongan->gaji_min) }}
                </td>
                <td>{{ $lowongan->lokasi }}</td>
                <td>{{ $lowongan->kuota }}</td>
                <td>{{ \Carbon\Carbon::parse($lowongan->deadline)->format('d M Y') }}</td>
                <td>
                    <span class="badge bg-{{ $lowongan->status == 'aktif' ? 'success' : 'secondary' }}">
                        {{ ucfirst($lowongan->status) }}
                    </span>
                </td>
                <td>
                    <a href="#" class="btn btn-info btn-sm">Detail</a>
                    <a href="#" class="btn btn-warning btn-sm">Edit</a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-3">
        {{ $lowongans->links() }}
    </div>
</div>
@endsection