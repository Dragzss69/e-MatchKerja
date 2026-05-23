@extends('layouts.app')

@section('title', 'Edit Lowongan Kerja')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h4><i class="fas fa-edit"></i> Edit Lowongan Kerja</h4>
                </div>
                <div class="card-body">

                    <form action="{{ route('lowongan.update', $lowongan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Posisi / Jabatan <span class="text-danger">*</span></label>
                                    <input type="text" name="posisi" class="form-control" value="{{ old('posisi', $lowongan->posisi) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gaji Minimum <span class="text-danger">*</span></label>
                                    <input type="number" name="gaji_min" class="form-control" value="{{ old('gaji_min', $lowongan->gaji_min) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Gaji Maksimum</label>
                                    <input type="number" name="gaji_max" class="form-control" value="{{ old('gaji_max', $lowongan->gaji_max) }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Lokasi <span class="text-danger">*</span></label>
                                    <input type="text" name="lokasi" class="form-control" value="{{ old('lokasi', $lowongan->lokasi) }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Kuota <span class="text-danger">*</span></label>
                                    <input type="number" name="kuota" class="form-control" value="{{ old('kuota', $lowongan->kuota) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Deadline <span class="text-danger">*</span></label>
                                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $lowongan->deadline->format('Y-m-d')) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                        <option value="aktif" {{ $lowongan->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="ditutup" {{ $lowongan->status == 'ditutup' ? 'selected' : '' }}>Ditutup</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi Pekerjaan <span class="text-danger">*</span></label>
                            <textarea name="deskripsi" class="form-control" rows="5" required>{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Skill yang Dibutuhkan</label>
                            <select name="skill_dibutuhkan[]" class="form-select" multiple size="6">
                                @php $skills = old('skill_dibutuhkan', $lowongan->skill_dibutuhkan ?? []) @endphp
                                <option value="Laravel" {{ in_array('Laravel', $skills) ? 'selected' : '' }}>Laravel</option>
                                <option value="PHP" {{ in_array('PHP', $skills) ? 'selected' : '' }}>PHP</option>
                                <option value="MySQL" {{ in_array('MySQL', $skills) ? 'selected' : '' }}>MySQL</option>
                                <option value="Microsoft Office" {{ in_array('Microsoft Office', $skills) ? 'selected' : '' }}>Microsoft Office</option>
                                <option value="Desain Grafis" {{ in_array('Desain Grafis', $skills) ? 'selected' : '' }}>Desain Grafis</option>
                                <!-- Tambah skill lain sesuai kebutuhan -->
                            </select>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-save"></i> Update Lowongan
                            </button>
                            <a href="{{ route('lowongan.index') }}" class="btn btn-secondary btn-lg">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection