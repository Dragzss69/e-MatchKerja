@extends('layouts.app')

@section('title', 'Posting Lowongan Kerja')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h4><i class="fas fa-briefcase"></i> Posting Lowongan Kerja Baru</h4>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('perusahaan.lowongan.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Posisi / Jabatan <span class="text-danger">*</span></label>
                                    <input type="text" name="posisi" class="form-control" value="{{ old('posisi') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gaji Minimum <span class="text-danger">*</span></label>
                                    <input type="number" name="gaji_min" class="form-control" value="{{ old('gaji_min') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gaji Maksimum</label>
                                    <input type="number" name="gaji_max" class="form-control" value="{{ old('gaji_max') }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi') }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kuota <span class="text-danger">*</span></label>
                                    <input type="number" name="kuota" class="form-control" value="{{ old('kuota') ?? 1 }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deadline <span class="text-danger">*</span></label>
                                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control" value="{{ old('kecamatan') }}">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" rows="5" required>{{ old('deskripsi') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Skill yang Dibutuhkan (tekan Ctrl untuk pilih banyak)</label>
                            <select name="skill_dibutuhkan[]" class="form-select" multiple size="6">
                                <option value="Microsoft Office">Microsoft Office</option>
                                <option value="Laravel">Laravel</option>
                                <option value="PHP">PHP</option>
                                <option value="MySQL">MySQL</option>
                                <option value="Desain Grafis">Desain Grafis</option>
                                <option value="Bahasa Inggris">Bahasa Inggris</option>
                                <option value="Administrasi">Administrasi</option>
                                <!-- Tambahkan skill lain sesuai kebutuhan -->
                            </select>
                            <small class="text-muted">Tekan Ctrl + Klik untuk memilih lebih dari satu</small>
                        </div>

                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-paper-plane"></i> Posting Lowongan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection