@extends('layouts.app')

@section('title', 'Daftar Pencari Kerja')

@section('content')
<div class="container mt-4">
    <h2>Daftar Pencari Kerja</h2>

    <!-- Search & Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.jobseekers.index') }}">
                <div class="row g-3 align-items-end">
                    <!-- Search -->
                    <div class="col-md-4">
                        <label class="form-label">Cari</label>
                        <input type="text" name="search" class="form-control" 
                               placeholder="NIK, Nama, atau No HP" 
                               value="{{ request('search') }}">
                    </div>

                    <!-- Filter Status Kerja -->
                    <div class="col-md-3">
                        <label class="form-label">Status Kerja</label>
                        <select name="status_kerja" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="menganggur" {{ request('status_kerja') == 'menganggur' ? 'selected' : '' }}>Menganggur</option>
                            <option value="bekerja" {{ request('status_kerja') == 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                            <option value="freelance" {{ request('status_kerja') == 'freelance' ? 'selected' : '' }}>Freelance</option>
                            <option value="wirausaha" {{ request('status_kerja') == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                        </select>
                    </div>

                    <!-- Filter Pendidikan -->
                    <div class="col-md-3">
                        <label class="form-label">Pendidikan</label>
                        <select name="pendidikan" class="form-select">
                            <option value="">Semua Pendidikan</option>
                            <option value="SMA/SMK" {{ request('pendidikan') == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="D3" {{ request('pendidikan') == 'D3' ? 'selected' : '' }}>D3</option>
                            <option value="S1" {{ request('pendidikan') == 'S1' ? 'selected' : '' }}>S1</option>
                            <option value="S2" {{ request('pendidikan') == 'S2' ? 'selected' : '' }}>S2</option>
                        </select>
                    </div>

                    <!-- Button -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Terapkan Filter</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Data -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>NIK</th>
                        <th>Nama Lengkap</th>
                        <th>Usia</th>
                        <th>Pendidikan</th>
                        <th>Status Kerja</th>
                        <th>Lama Menganggur</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profiles as $profile)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $profile->nik }}</td>
                        <td><strong>{{ $profile->nama_lengkap }}</strong></td>
                        <td>{{ $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->age : '-' }} Tahun</td>
                        <td>{{ $profile->pendidikan_terakhir }}</td>
                        <td>{{ ucfirst($profile->status_kerja_saat_ini ?? '-') }}</td>
                        <td>{{ $profile->lama_menganggur }} Bulan</td>
                        <td>
                            <a href="{{ route('jobseeker-profiles.show', $profile->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('jobseeker-profiles.edit', $profile->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="mt-3">
                {{ $profiles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection