@extends('layouts.app')

@section('content')
<div style="background:#fff; border-radius:16px; padding:30px; box-shadow:0 20px 60px rgba(0,0,0,0.08);">
    <h2 style="margin:0 0 12px; font-size:2rem; color:#1a202c;">Dashboard</h2>
    <p style="margin:0 0 24px; color:#4a5568;">Halo, {{ auth()->user()->name }}. Ini adalah halaman kontrol utama untuk akun Anda.</p>

    <div style="display:grid; gap:18px; grid-template-columns:repeat(auto-fit, minmax(220px, 1fr));">
        @if(auth()->user()->isAdmin() || auth()->user()->isVerifier())
        <a href="{{ route('admin.spk.index') }}" style="display:block; padding:20px; border-radius:18px; background:#e2e8f0; color:#1a202c; text-decoration:none;">
            <h3 style="margin:0 0 8px; font-size:1.1rem;">Rekomendasi Bantuan</h3>
            <p style="margin:0; color:#4a5568;">Lihat dan kelola hasil rekomendasi berbasis data.</p>
        </a>
        <a href="{{ route('admin.jobseekers.index') }}" style="display:block; padding:20px; border-radius:18px; background:#ebf8ff; color:#1a202c; text-decoration:none;">
            <h3 style="margin:0 0 8px; font-size:1.1rem;">Data Pencari Kerja</h3>
            <p style="margin:0; color:#4a5568;">Kelola data pencari kerja dan profil.</p>
        </a>
        <a href="{{ route('laporan.index') }}" style="display:block; padding:20px; border-radius:18px; background:#f7fafc; color:#1a202c; text-decoration:none;">
            <h3 style="margin:0 0 8px; font-size:1.1rem;">Laporan Bantuan</h3>
            <p style="margin:0; color:#4a5568;">Unduh laporan bantuan dalam Excel atau PDF.</p>
        </a>
        @endif

        @if(auth()->user()->isEmployer())
        <a href="{{ route('perusahaan.lowongan.create') }}" style="display:block; padding:20px; border-radius:18px; background:#e6fffa; color:#1a202c; text-decoration:none;">
            <h3 style="margin:0 0 8px; font-size:1.1rem;">Posting Lowongan</h3>
            <p style="margin:0; color:#4a5568;">Buat lowongan baru untuk perusahaan Anda.</p>
        </a>
        <a href="{{ route('lowongan.index') }}" style="display:block; padding:20px; border-radius:18px; background:#ebf4ff; color:#1a202c; text-decoration:none;">
            <h3 style="margin:0 0 8px; font-size:1.1rem;">Daftar Lowongan</h3>
            <p style="margin:0; color:#4a5568;">Lihat semua lowongan yang sudah diposting.</p>
        </a>
        @endif

        @if(auth()->user()->isJobSeeker())
        <a href="{{ route('jobseeker.profile.create') }}" style="display:block; padding:20px; border-radius:18px; background:#fefcbf; color:#1a202c; text-decoration:none;">
            <h3 style="margin:0 0 8px; font-size:1.1rem;">Profil Saya</h3>
            <p style="margin:0; color:#4a5568;">Lengkapi profil pekerjaan untuk bantuan dan pencarian.</p>
        </a>
        <a href="{{ route('pengajuan-bantuan.create') }}" style="display:block; padding:20px; border-radius:18px; background:#f0fff4; color:#1a202c; text-decoration:none;">
            <h3 style="margin:0 0 8px; font-size:1.1rem;">Ajukan Bantuan</h3>
            <p style="margin:0; color:#4a5568;">Buat pengajuan bantuan sosial jika membutuhkan.</p>
        </a>
        @endif

        <a href="{{ route('notifications.index') }}" style="display:block; padding:20px; border-radius:18px; background:#fff5f7; color:#1a202c; text-decoration:none;">
            <h3 style="margin:0 0 8px; font-size:1.1rem;">Notifikasi</h3>
            <p style="margin:0; color:#4a5568;">Cek pesan terbaru dan aktivitas akun Anda.</p>
        </a>
    </div>
</div>
@endsection
