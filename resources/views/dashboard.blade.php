@extends('layouts.app')

@section('content')
@php
    $user = auth()->user();
    $roles = $user->roles->pluck('name')->toArray();
    $roleLabel = 'Pengguna';
    if ($user->isAdmin()) {
        $roleLabel = 'Admin Dinas';
    } elseif ($user->isVerifier()) {
        $roleLabel = 'Petugas Verifikasi';
    } elseif ($user->isEmployer()) {
        $roleLabel = 'Perusahaan / Employer';
    } elseif ($user->isJobSeeker()) {
        $roleLabel = 'Pencari Kerja / Masyarakat';
    }
@endphp

<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 20px 60px rgba(0,0,0,0.08);">
    <div style="display:flex; flex-wrap:wrap; gap:18px; align-items:center; justify-content:space-between; margin-bottom:24px;">
        <div>
            <h2 style="margin:0 0 8px; font-size:2rem; color:#1a202c;">Dashboard {{ $roleLabel }}</h2>
            <p style="margin:0; color:#4a5568;">Halo, {{ $user->name }}. Anda masuk sebagai <strong>{{ $roleLabel }}</strong>.</p>
            @if(count($roles) > 1)
                <p style="margin:8px 0 0; color:#4a5568;">Role lain: {{ implode(', ', array_diff($roles, [strtolower(str_replace(' ', '_', $roleLabel))])) ?: 'Tidak ada' }}.</p>
            @endif
        </div>
        <div style="background:#f7fafc; padding:18px 22px; border-radius:16px; min-width:240px;">
            <p style="margin:0; font-weight:700; color:#2d3748;">Peran aktif saat ini</p>
            <p style="margin:8px 0 0; color:#4a5568;">{{ $roleLabel }}</p>
        </div>
    </div>

    @if($user->isAdmin())
    <div style="margin-bottom:24px; padding:24px; background:#e8f0fe; border-radius:18px;">
        <h3 style="margin:0 0 12px; color:#1e40af;">Panel Admin</h3>
        <p style="margin:0 0 16px; color:#334155;">Gunakan akses admin untuk memantau rekomendasi bantuan, data pencari kerja, dan laporan.</p>
        <div style="display:grid; gap:16px; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
            <a href="{{ route('admin.spk.index') }}" style="display:block; padding:18px; border-radius:16px; background:#ffffff; color:#1f2937; text-decoration:none; border:1px solid #cbd5e1;">
                <h4 style="margin:0 0 6px;">Rekomendasi Bantuan</h4>
                <p style="margin:0; color:#475569;">Akses dan kelola saran penyaluran berbasis kelayakan.</p>
            </a>
            <a href="{{ route('admin.jobseekers.index') }}" style="display:block; padding:18px; border-radius:16px; background:#ffffff; color:#1f2937; text-decoration:none; border:1px solid #cbd5e1;">
                <h4 style="margin:0 0 6px;">Data Pencari Kerja</h4>
                <p style="margin:0; color:#475569;">Lihat dan kelola profil pencari kerja.</p>
            </a>
            <a href="{{ route('laporan.index') }}" style="display:block; padding:18px; border-radius:16px; background:#ffffff; color:#1f2937; text-decoration:none; border:1px solid #cbd5e1;">
                <h4 style="margin:0 0 6px;">Laporan Bantuan</h4>
                <p style="margin:0; color:#475569;">Unduh laporan untuk analisa dan presentasi.</p>
            </a>
        </div>
    </div>
    @endif

    @if($user->isVerifier())
    <div style="margin-bottom:24px; padding:24px; background:#ecfdf5; border-radius:18px;">
        <h3 style="margin:0 0 12px; color:#166534;">Panel Verifikasi</h3>
        <p style="margin:0 0 16px; color:#475569;">Tinjau pengajuan bantuan dan tandai status verifikasi.</p>
        <div style="display:grid; gap:16px; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
            <a href="{{ route('admin.spk.index') }}" style="display:block; padding:18px; border-radius:16px; background:#ffffff; color:#1f2937; text-decoration:none; border:1px solid #cbd5e1;">
                <h4 style="margin:0 0 6px;">Rekomendasi Bantuan</h4>
                <p style="margin:0; color:#475569;">Lihat rekomendasi dan bantuan yang perlu diverifikasi.</p>
            </a>
            <a href="{{ route('laporan.index') }}" style="display:block; padding:18px; border-radius:16px; background:#ffffff; color:#1f2937; text-decoration:none; border:1px solid #cbd5e1;">
                <h4 style="margin:0 0 6px;">Laporan Bantuan</h4>
                <p style="margin:0; color:#475569;">Akses ringkasan laporan yang berkaitan verifikasi.</p>
            </a>
        </div>
    </div>
    @endif

    @if($user->isEmployer())
    <div style="margin-bottom:24px; padding:24px; background:#f0f9ff; border-radius:18px;">
        <h3 style="margin:0 0 12px; color:#1d4ed8;">Panel Perusahaan</h3>
        <p style="margin:0 0 16px; color:#475569;">Kelola lowongan dan lihat daftar postingan Anda.</p>
        <div style="display:grid; gap:16px; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
            <a href="{{ route('perusahaan.lowongan.create') }}" style="display:block; padding:18px; border-radius:16px; background:#ffffff; color:#1f2937; text-decoration:none; border:1px solid #cbd5e1;">
                <h4 style="margin:0 0 6px;">Posting Lowongan</h4>
                <p style="margin:0; color:#475569;">Buat lowongan kerja baru untuk perusahaan Anda.</p>
            </a>
            <a href="{{ route('lowongan.index') }}" style="display:block; padding:18px; border-radius:16px; background:#ffffff; color:#1f2937; text-decoration:none; border:1px solid #cbd5e1;">
                <h4 style="margin:0 0 6px;">Daftar Lowongan</h4>
                <p style="margin:0; color:#475569;">Lihat lowongan yang sudah dipublikasikan.</p>
            </a>
        </div>
    </div>
    @endif

    @if($user->isJobSeeker())
    <div style="margin-bottom:24px; padding:24px; background:#fff7ed; border-radius:18px;">
        <h3 style="margin:0 0 12px; color:#c2410c;">Panel Pencari Kerja</h3>
        <p style="margin:0 0 16px; color:#475569;">Lengkapi profil dan ajukan bantuan sesuai kebutuhan Anda.</p>
        <div style="display:grid; gap:16px; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
            <a href="{{ route('jobseeker.profile.create') }}" style="display:block; padding:18px; border-radius:16px; background:#ffffff; color:#1f2937; text-decoration:none; border:1px solid #cbd5e1;">
                <h4 style="margin:0 0 6px;">Profil Saya</h4>
                <p style="margin:0; color:#475569;">Lengkapi dan perbarui data diri untuk bantuan dan lowongan.</p>
            </a>
            <a href="{{ route('pengajuan-bantuan.create') }}" style="display:block; padding:18px; border-radius:16px; background:#ffffff; color:#1f2937; text-decoration:none; border:1px solid #cbd5e1;">
                <h4 style="margin:0 0 6px;">Ajukan Bantuan</h4>
                <p style="margin:0; color:#475569;">Submit pengajuan bantuan sosial yang diperlukan.</p>
            </a>
        </div>
    </div>
    @endif

    <div style="display:grid; gap:16px; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
        <a href="{{ route('notifications.index') }}" style="display:block; padding:18px; border-radius:16px; background:#fff5f7; color:#1a202c; text-decoration:none; border:1px solid #fed7d7;">
            <h4 style="margin:0 0 6px;">Notifikasi</h4>
            <p style="margin:0; color:#475569;">Cek pesan terbaru untuk akun Anda.</p>
        </a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="display:block; padding:18px; border-radius:16px; background:#f8fafc; color:#1a202c; text-decoration:none; border:1px solid #cbd5e1;">
            <h4 style="margin:0 0 6px;">Logout</h4>
            <p style="margin:0; color:#475569;">Keluar dari akun Anda dengan aman.</p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">@csrf</form>
    </div>
</div>
@endsection
