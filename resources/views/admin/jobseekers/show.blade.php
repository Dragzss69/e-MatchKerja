@extends('layouts.app')

@section('title', 'Detail Pencari Kerja')

@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h4>Detail Pencari Kerja</h4>
                </div>
                <div class="card-body">

                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            @if ($profile->file_ktp)
                                <img src="{{ asset('storage/' . $profile->file_ktp) }}" class="img-fluid rounded" style="max-height: 200px;">
                            @else
                                <div class="bg-light p-5 text-center rounded">No Photo</div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h3>{{ $profile->nama_lengkap }}</h3>
                            <p><strong>NIK:</strong> {{ $profile->nik }}</p>
                            <p><strong>Usia:</strong> {{ $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->age : '-' }} Tahun</p>
                            <p><strong>Jenis Kelamin:</strong> {{ $profile->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        </div>
                    </div>

                    <table class="table table-bordered">
                        <tr>
                            <th width="40%">Alamat KTP</th>
                            <td>{{ $profile->alamat_ktp }}</td>
                        </tr>
                        <tr>
                            <th>No HP</th>
                            <td>{{ $profile->no_hp }}</td>
                        </tr>
                        <tr>
                            <th>Pendidikan Terakhir</th>
                            <td>{{ $profile->pendidikan_terakhir }}</td>
                        </tr>
                        <tr>
                            <th>Status Kerja Saat Ini</th>
                            <td>{{ $profile->status_kerja_saat_ini }}</td>
                        </tr>
                        <tr>
                            <th>Lama Menganggur</th>
                            <td>{{ $profile->lama_menganggur }} Bulan</td>
                        </tr>
                        <tr>
                            <th>Pendapatan Bulanan</th>
                            <td>Rp {{ number_format($profile->pendapatan_bulanan) }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Tanggungan</th>
                            <td>{{ $profile->jumlah_tanggungan }} Orang</td>
                        </tr>
                    </table>

                    <div class="mt-4">
                        <a href="{{ route('admin.jobseekers.index') }}" class="btn btn-secondary">Kembali</a>
                        <a href="{{ route('jobseeker-profiles.edit', $profile->id) }}" class="btn btn-warning">Edit Data</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection