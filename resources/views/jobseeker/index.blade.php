@extends('layouts.app')

@section('title', 'Daftar Pencari Kerja')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Pencari Kerja</h2>
        <a href="{{ route('admin.jobseekers.index') }}" class="btn btn-primary">
            Refresh
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Usia</th>
                        <th>Jenis Kelamin</th>
                        <th>Pendidikan</th>
                        <th>Status Kerja</th>
                        <th>Lama Menganggur</th>
                        <th>Pendapatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($profiles as $profile)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $profile->nik }}</td>
                        <td><strong>{{ $profile->nama_lengkap }}</strong></td>
                        <td>
                            {{ $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->age : '-' }} Tahun
                        </td>
                        <td>{{ $profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                        <td>{{ $profile->pendidikan_terakhir }}</td>
                        <td>{{ ucfirst($profile->status_kerja_saat_ini ?? '-') }}</td>
                        <td>{{ $profile->lama_menganggur }} Bulan</td>
                        <td>Rp {{ number_format($profile->pendapatan_bulanan ?? 0) }}</td>
                        <td>
                            <a href="#" class="btn btn-info btn-sm">Detail</a>
                            <a href="#" class="btn btn-warning btn-sm">Edit</a>
                            <a href="#" class="btn btn-danger btn-sm" 
                               onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="mt-3">
                {{ $profiles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection