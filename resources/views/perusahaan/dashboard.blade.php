@extends('layouts.app')

@section('title', 'Dashboard Perusahaan')

@section('content')
<div class="container mt-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1">Selamat Datang, {{ auth()->user()->name }}</h2>
            <p class="text-muted mb-0">Kelola lowongan dan pelamar perusahaan Anda</p>
        </div>
        <a href="{{ route('perusahaan.lowongan.create') }}" class="btn btn-primary">
            + Posting Lowongan Baru
        </a>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Statistik --}}
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card text-center border-primary h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h2 class="text-primary fw-bold">{{ $lowongans->count() }}</h2>
                    <p class="mb-0 text-muted">Total Lowongan</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center border-success h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h2 class="text-success fw-bold">{{ $allApplicants->count() }}</h2>
                    <p class="mb-0 text-muted">Total Pelamar</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card text-center border-warning h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h2 class="text-warning fw-bold">
                        {{ $allApplicants->where('status', 'pending')->count() }}
                    </h2>
                    <p class="mb-0 text-muted">Menunggu Review</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Daftar Lowongan --}}
    <div class="card mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Lowongan Saya</h5>
            <span class="badge bg-secondary">{{ $lowongans->count() }} lowongan</span>
        </div>
        <div class="card-body p-0">
            @forelse($lowongans as $lowongan)
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                <div>
                    <strong>{{ $lowongan->posisi }}</strong>
                    <span class="ms-2 badge bg-{{ $lowongan->status == 'aktif' ? 'success' : 'secondary' }}">
                        {{ ucfirst($lowongan->status) }}
                    </span>
                    <br>
                    <small class="text-muted">
                        {{ $lowongan->lokasi }} &bull;
                        Deadline: {{ $lowongan->deadline->format('d M Y') }} &bull;
                        <strong>{{ $lowongan->lamaran_count }}</strong> pelamar /
                        Kuota: {{ $lowongan->kuota }}
                    </small>
                </div>
                <div class="d-flex gap-2 flex-wrap justify-content-end">
                    <a href="{{ route('perusahaan.pelamar.index', $lowongan->id) }}"
                       class="btn btn-sm btn-outline-info">
                        Lihat Pelamar
                    </a>
                    <a href="{{ route('lowongan.edit', $lowongan->id) }}"
                       class="btn btn-sm btn-outline-warning">
                        Edit
                    </a>
                    <form action="{{ route('lowongan.destroy', $lowongan->id) }}"
                          method="POST"
                          onsubmit="return confirm('Yakin hapus lowongan {{ $lowongan->posisi }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-muted">
                Belum ada lowongan.
                <a href="{{ route('perusahaan.lowongan.create') }}">Posting sekarang</a>
            </div>
            @endforelse
        </div>
    </div>

    {{-- Daftar Semua Pelamar --}}
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Semua Pelamar</h5>
            <span class="badge bg-secondary">{{ $allApplicants->count() }} pelamar</span>
        </div>
        <div class="card-body p-0">
            @forelse($allApplicants as $lamaran)
            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                <div>
                    <strong>{{ $lamaran->user->name }}</strong>
                    <br>
                    <small class="text-muted">
                        Melamar: <em>{{ $lamaran->lowongan->posisi }}</em> &bull;
                        {{ $lamaran->created_at->format('d M Y') }}
                    </small>
                </div>
                <div class="d-flex align-items-center gap-2">
                    {{-- Badge status --}}
                    @php
                        $badgeClass = match($lamaran->status) {
                            'pending'    => 'warning',
                            'wawancara'  => 'info',
                            'diterima'   => 'success',
                            'ditolak'    => 'danger',
                            default      => 'secondary',
                        };
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">
                        {{ ucfirst(str_replace('_', ' ', $lamaran->status)) }}
                    </span>
                    <a href="{{ route('perusahaan.pelamar.show', $lamaran->id) }}"
                       class="btn btn-sm btn-primary">
                        Detail & Download
                    </a>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-muted">
                Belum ada pencari kerja yang melamar di perusahaan Anda.
            </div>
            @endforelse
        </div>
    </div>

</div>
@endsection