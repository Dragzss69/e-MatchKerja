@extends('layouts.app')

@section('title', 'Lamar Lowongan')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4>Lamar Lowongan: {{ $lowongan->posisi }}</h4>
                </div>
                <div class="card-body">

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('lamaran.store', $lowongan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload CV (PDF) <span class="text-danger">*</span></label>
                            <input type="file" name="cv" class="form-control" accept=".pdf" required>
                            <small class="text-muted">Hanya file PDF, maksimal 5MB</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Upload Portofolio (PDF) <span class="text-muted">(Opsional)</span></label>
                            <input type="file" name="portofolio" class="form-control" accept=".pdf">
                            <small class="text-muted">Hanya file PDF, maksimal 10MB</small>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Catatan / Pesan untuk Perusahaan</label>
                            <textarea name="catatan" class="form-control" rows="5" 
                                placeholder="Tuliskan motivasi Anda, pengalaman relevan, atau pesan lainnya..."></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('lowongan.show', $lowongan->id) }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-success btn-lg">
                                Kirim Lamaran
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection