@extends('layouts.app')

@section('title', 'Edit Profil Pencari Kerja')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4><i class="fas fa-edit"></i> Edit Profil Pencari Kerja</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('jobseeker-profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" class="form-control" value="{{ old('nik', $profile->nik) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap', $profile->nama_lengkap) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir', $profile->tanggal_lahir?->format('Y-m-d')) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="L" {{ old('jenis_kelamin', $profile->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin', $profile->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">No HP <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $profile->no_hp) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                    <select name="pendidikan_terakhir" class="form-select" required>
                                        <option value="SD" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'SD' ? 'selected' : '' }}>SD</option>
                                        <option value="SMP" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'SMP' ? 'selected' : '' }}>SMP</option>
                                        <option value="SMA/SMK" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                                        <option value="D3" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'D3' ? 'selected' : '' }}>D3</option>
                                        <option value="S1" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'S1' ? 'selected' : '' }}>S1</option>
                                        <option value="S2" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>S2</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status Kerja Saat Ini</label>
                                    <select name="status_kerja_saat_ini" class="form-select">
                                        <option value="menganggur" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'menganggur' ? 'selected' : '' }}>Menganggur</option>
                                        <option value="bekerja" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'bekerja' ? 'selected' : '' }}>Bekerja</option>
                                        <option value="freelance" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'freelance' ? 'selected' : '' }}>Freelance</option>
                                        <option value="wirausaha" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat KTP <span class="text-danger">*</span></label>
                            <textarea name="alamat_ktp" class="form-control" rows="3" required>{{ old('alamat_ktp', $profile->alamat_ktp) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Upload KTP Baru (Opsional)</label>
                                <input type="file" name="file_ktp" class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Upload KK Baru (Opsional)</label>
                                <input type="file" name="file_kk" class="form-control">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-warning btn-lg">Update Profil</button>
                            <a href="{{ route('jobseeker.profile.create') }}" class="btn btn-secondary btn-lg">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection