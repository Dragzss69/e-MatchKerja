@extends('layouts.app')

@section('title', 'Isi Profil Pencari Kerja')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4><i class="fas fa-user"></i> Isi Data Profil Pencari Kerja</h4>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('jobseeker.profile.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>NIK <span class="text-danger">*</span></label>
                                    <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenis_kelamin" class="form-select" required>
                                        <option value="">Pilih...</option>
                                        <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                        <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>No HP <span class="text-danger">*</span></label>
                                    <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label>Pendidikan Terakhir <span class="text-danger">*</span></label>
                                    <select name="pendidikan_terakhir" class="form-select" required>
                                        <option value="">Pilih Pendidikan</option>
                                        <option value="SD">SD</option>
                                        <option value="SMP">SMP</option>
                                        <option value="SMA/SMK">SMA/SMK</option>
                                        <option value="D3">D3</option>
                                        <option value="S1">S1</option>
                                        <option value="S2">S2</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Status Kerja Saat Ini <span class="text-danger">*</span></label>
                                    <select name="status_kerja_saat_ini" class="form-select" required>
                                        <option value="">Pilih Status</option>
                                        <option value="Menganggur">Menganggur</option>
                                        <option value="Bekerja">Bekerja</option>
                                        <option value="Freelance">Freelance</option>
                                        <option value="Wirausaha">Wirausaha</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Pendapatan Bulanan (Rp)</label>
                                    <input type="number" name="pendapatan_bulanan" class="form-control" value="{{ old('pendapatan_bulanan') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label>Jumlah Tanggungan</label>
                                    <input type="number" name="jumlah_tanggungan" class="form-control" value="{{ old('jumlah_tanggungan') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label>Alamat KTP <span class="text-danger">*</span></label>
                            <textarea name="alamat_ktp" class="form-control" rows="3" required>{{ old('alamat_ktp') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label>Upload KTP <span class="text-danger">*</span></label>
                                <input type="file" name="file_ktp" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label>Upload KK</label>
                                <input type="file" name="file_kk" class="form-control">
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">Simpan Profil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection