@extends('layouts.app')

@section('title', 'Dashboard')

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

    // Hitung statistik untuk Dashboard Admin & Verifikator secara langsung via Eloquent
    $statSeekers = \App\Models\JobSeekerProfile::count();
    $statJobs = \App\Models\LowonganKerja::count();
    $statPengajuans = \App\Models\PengajuanBantuan::count();
    $statPending = \App\Models\PengajuanBantuan::where('status', 'pending')->count();
    $statVerified = \App\Models\PengajuanBantuan::where('status', 'diverifikasi')->count();
    $statApproved = \App\Models\PengajuanBantuan::where('status', 'disetujui')->count();
    $statDisbursed = \App\Models\PengajuanBantuan::where('status', 'disalurkan')->count();

    // Statistik Perusahaan
    $employerJobsActive = \App\Models\LowonganKerja::where('perusahaan_id', $user->id)->where('status', 'aktif')->count();
    $employerJobsClosed = \App\Models\LowonganKerja::where('perusahaan_id', $user->id)->where('status', 'ditutup')->count();

    // Data Pencari Kerja
    $seekerProfile = $user->jobSeekerProfile;
    $seekerApplication = \App\Models\PengajuanBantuan::where('pencari_kerja_id', $user->id)->latest()->first();
@endphp

<div class="space-y-8">
    
    <!-- Welcome Header Banner -->
    <div class="relative overflow-hidden rounded-3xl bg-white border border-slate-200/80 shadow-sm p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div class="space-y-1">
            <h2 class="text-2xl font-extrabold text-slate-900">Halo, {{ $user->name }}</h2>
            <p class="text-xs text-slate-500 font-medium">Selamat datang kembali! Anda masuk sebagai <span class="text-indigo-600 font-bold">{{ $roleLabel }}</span>.</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-50 border border-slate-100 shrink-0">
            <div class="h-2.5 w-2.5 rounded-full bg-emerald-500 animate-pulse"></div>
            <span class="text-[11px] font-bold text-slate-600 uppercase tracking-wider">Sesi Aktif</span>
        </div>
    </div>

    <!-- ==================== 1. ADMIN Dinas Dashboard ==================== -->
    @if($user->isAdmin())
    <div class="space-y-6">
        
        <!-- Section Title -->
        <div class="flex items-center justify-between border-b border-slate-200/60 pb-3">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                <i class="fa-solid fa-folder-open text-indigo-500"></i> Panel Manajemen Admin
            </h3>
            <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">ADMINISTRASI KELAYAKAN</span>
        </div>

        <!-- Admin Stats Grid -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Pencari Kerja</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600"><i class="fa-solid fa-users text-sm"></i></div>
                </div>
                <h4 class="text-2xl font-black text-slate-900">{{ $statSeekers }}</h4>
            </div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Lowongan Pekerjaan</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-sky-50 text-sky-600"><i class="fa-solid fa-briefcase text-sm"></i></div>
                </div>
                <h4 class="text-2xl font-black text-slate-900">{{ $statJobs }}</h4>
            </div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pengajuan Bantuan</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-amber-50 text-amber-600"><i class="fa-solid fa-file-invoice-dollar text-sm"></i></div>
                </div>
                <h4 class="text-2xl font-black text-slate-900">{{ $statPengajuans }}</h4>
            </div>
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Dana Disalurkan</span>
                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-50 text-emerald-600"><i class="fa-solid fa-circle-check text-sm"></i></div>
                </div>
                <h4 class="text-2xl font-black text-slate-900">{{ $statDisbursed }}</h4>
            </div>
        </div>

        <!-- Detailed Status Breakdown -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="md:col-span-2 rounded-2xl bg-white border border-slate-200/80 shadow-sm p-6 space-y-4">
                <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Alur Tahapan Pengajuan Bantuan Sosial</h4>
                <div class="grid grid-cols-4 gap-3">
                    <div class="bg-slate-50 border border-slate-200/50 p-4 rounded-xl text-center">
                        <span class="text-[10px] font-bold text-slate-400 uppercase block mb-1">Pending</span>
                        <span class="text-lg font-black text-slate-800">{{ $statPending }}</span>
                    </div>
                    <div class="bg-sky-50/50 border border-sky-100 p-4 rounded-xl text-center">
                        <span class="text-[10px] font-bold text-sky-600 uppercase block mb-1">Diverifikasi</span>
                        <span class="text-lg font-black text-sky-900">{{ $statVerified }}</span>
                    </div>
                    <div class="bg-emerald-50/50 border border-emerald-100 p-4 rounded-xl text-center">
                        <span class="text-[10px] font-bold text-emerald-600 uppercase block mb-1">Disetujui</span>
                        <span class="text-lg font-black text-emerald-900">{{ $statApproved }}</span>
                    </div>
                    <div class="bg-violet-50/50 border border-violet-100 p-4 rounded-xl text-center">
                        <span class="text-[10px] font-bold text-violet-600 uppercase block mb-1">Disalurkan</span>
                        <span class="text-lg font-black text-violet-900">{{ $statDisbursed }}</span>
                    </div>
                </div>
            </div>

            <!-- Admin Quick Actions -->
            <div class="rounded-2xl bg-slate-900 text-white p-6 flex flex-col justify-between shadow-md">
                <div class="space-y-2">
                    <span class="text-[9px] font-extrabold uppercase tracking-widest text-indigo-400">Navigasi Cepat</span>
                    <h4 class="text-sm font-bold">Rekomendasi Bantuan (SPK)</h4>
                    <p class="text-[11px] text-slate-300 leading-relaxed">Kelola dan lihat pemeringkatan kelayakan bantuan sosial menggunakan algoritma SAW secara instan.</p>
                </div>
                <a href="{{ route('admin.spk.index') }}" class="mt-4 w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-xs font-bold text-white transition shadow-md shadow-indigo-800/40">
                    Buka Halaman SPK <i class="fa-solid fa-circle-arrow-right"></i>
                </a>
            </div>
        </div>

    </div>
    @endif

    <!-- ==================== 2. VERIFIER / Petugas Dashboard ==================== -->
    @if($user->isVerifier())
    <div class="space-y-6">
        
        <!-- Section Title -->
        <div class="flex items-center justify-between border-b border-slate-200/60 pb-3">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                <i class="fa-solid fa-list-check text-emerald-500"></i> Panel Verifikasi Berkas
            </h3>
            <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-100">PETUGAS LAPANGAN</span>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pengajuan Pending (Perlu Verifikasi)</span>
                    <h4 class="text-2xl font-black text-slate-900">{{ $statPending }}</h4>
                </div>
                <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-amber-50 text-amber-500 border border-amber-100"><i class="fa-solid fa-clock-rotate-left"></i></div>
            </div>
            
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pengajuan Telah Diverifikasi</span>
                    <h4 class="text-2xl font-black text-slate-900">{{ $statVerified }}</h4>
                </div>
                <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-sky-50 text-sky-500 border border-sky-100"><i class="fa-solid fa-circle-check"></i></div>
            </div>

            <!-- Quick Action Card -->
            <div class="rounded-2xl bg-emerald-950 text-white p-5 flex flex-col justify-between shadow-sm">
                <div class="space-y-1">
                    <span class="text-[9px] font-extrabold uppercase tracking-widest text-emerald-400">Verifikasi Pengajuan</span>
                    <p class="text-[11px] text-emerald-200 leading-snug">Tinjau kesesuaian NIK, kondisi fisik, dan berkas KK pencari kerja yang memohon bantuan.</p>
                </div>
                <a href="{{ route('pengajuan-bantuan.index') }}" class="mt-3 inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-xs font-bold transition">
                    Lihat Antrean Pengajuan <i class="fa-solid fa-chevron-right text-[10px]"></i>
                </a>
            </div>
        </div>

    </div>
    @endif

    <!-- ==================== 3. EMPLOYER / Perusahaan Dashboard ==================== -->
    @if($user->isEmployer())
    <div class="space-y-6">
        
        <!-- Section Title -->
        <div class="flex items-center justify-between border-b border-slate-200/60 pb-3">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                <i class="fa-solid fa-building-user text-indigo-500"></i> Panel Perekrutan Perusahaan
            </h3>
            <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">KEMITRAAN INDUSTRI</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Active Jobs -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Lowongan Aktif Anda</span>
                    <h4 class="text-2xl font-black text-slate-900">{{ $employerJobsActive }}</h4>
                </div>
                <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-emerald-50 text-emerald-500 border border-emerald-100"><i class="fa-solid fa-circle-play"></i></div>
            </div>

            <!-- Closed Jobs -->
            <div class="rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm flex items-center justify-between">
                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Lowongan Ditutup/Arsip</span>
                    <h4 class="text-2xl font-black text-slate-900">{{ $employerJobsClosed }}</h4>
                </div>
                <div class="h-10 w-10 flex items-center justify-center rounded-xl bg-slate-100 text-slate-400 border border-slate-200/50"><i class="fa-solid fa-circle-stop"></i></div>
            </div>

            <!-- Create Job Action -->
            <div class="rounded-2xl bg-indigo-900 text-white p-5 flex flex-col justify-between shadow-sm">
                <div class="space-y-1">
                    <span class="text-[9px] font-extrabold uppercase tracking-widest text-indigo-300">Posting Baru</span>
                    <p class="text-[11px] text-indigo-100 leading-snug">Publikasikan lowongan kerja baru untuk menyerap tenaga kerja lokal dan mendapatkan pencari kerja terbaik.</p>
                </div>
                <a href="{{ route('perusahaan.lowongan.create') }}" class="mt-3 inline-flex items-center justify-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-xs font-bold transition">
                    <i class="fa-solid fa-plus text-[10px]"></i> Buat Lowongan Baru
                </a>
            </div>
        </div>

    </div>
    @endif

    <!-- ==================== 4. JOB SEEKER / Pencari Kerja Dashboard ==================== -->
    @if($user->isJobSeeker())
    <div class="space-y-6">
        
        <!-- Section Title -->
        <div class="flex items-center justify-between border-b border-slate-200/60 pb-3">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest flex items-center gap-2">
                <i class="fa-solid fa-user-tie text-amber-600"></i> Panel Pencari Kerja & Penerima Manfaat
            </h3>
            <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-0.5 rounded border border-amber-200">MEMBER AKTIF</span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Left: Profile Completion Card (2 Cols on large screen) -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Profile Status -->
                <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Status Kelengkapan Profil</h4>
                        @if($seekerProfile)
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-extrabold uppercase tracking-wide">
                                <i class="fa-solid fa-circle-check"></i> Profil Lengkap
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rose-100 text-rose-800 text-[10px] font-extrabold uppercase tracking-wide">
                                <i class="fa-solid fa-triangle-exclamation"></i> Profil Belum Diisi
                            </span>
                        @endif
                    </div>
                    
                    @if($seekerProfile)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                            <div class="space-y-1">
                                <span class="text-slate-400 font-semibold uppercase text-[9px] block">NIK</span>
                                <span class="font-bold text-slate-800">{{ $seekerProfile->nik }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="text-slate-400 font-semibold uppercase text-[9px] block">Pendidikan Terakhir</span>
                                <span class="font-bold text-slate-800">{{ $seekerProfile->pendidikan_terakhir }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="text-slate-400 font-semibold uppercase text-[9px] block">Status Kerja Saat Ini</span>
                                <span class="font-bold text-slate-800">{{ $seekerProfile->status_kerja_saat_ini }}</span>
                            </div>
                            <div class="space-y-1">
                                <span class="text-slate-400 font-semibold uppercase text-[9px] block">Status Verifikasi SPK</span>
                                <span class="font-bold flex items-center gap-1
                                    @if($seekerProfile->status_verifikasi == 'Verified') text-emerald-600
                                    @elseif($seekerProfile->status_verifikasi == 'Rejected') text-rose-600
                                    @else text-amber-500 @endif">
                                    <i class="fa-solid fa-circle-check text-[10px]"></i> {{ $seekerProfile->status_verifikasi ?? 'Unverified' }}
                                </span>
                            </div>
                        </div>
                        <div class="pt-2 border-t border-slate-100">
                            <a href="{{ route('jobseeker-profiles.edit', $seekerProfile->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-600 hover:text-indigo-800 transition">
                                <i class="fa-solid fa-pen-to-square"></i> Perbarui Data Profil Diri
                            </a>
                        </div>
                    @else
                        <div class="space-y-3">
                            <p class="text-slate-600 text-xs leading-relaxed">
                                Profil diri Anda belum diisi. Anda wajib mengisi profil lengkap terlebih dahulu agar nama Anda dapat didaftarkan sebagai kandidat penerima bantuan sosial dan dapat melamar pekerjaan.
                            </p>
                            <a href="{{ route('jobseeker.profile.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-xs font-bold text-white transition">
                                <i class="fa-solid fa-user-plus text-[10px]"></i> Isi Profil Sekarang
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Bantuan Tracker -->
                @if($seekerApplication)
                    <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider">Pelacakan Status Bantuan</h4>
                            <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-0.5 rounded border border-indigo-100 uppercase">
                                {{ str_replace('_', ' ', $seekerApplication->jenis_bantuan) }}
                            </span>
                        </div>
                        
                        <!-- Progress Steps Diagram -->
                        @php
                            $status = strtolower($seekerApplication->status);
                            $step = 1;
                            if($status == 'diverifikasi') $step = 2;
                            elseif($status == 'disetujui') $step = 3;
                            elseif($status == 'disalurkan') $step = 4;
                            elseif($status == 'ditolak') $step = -1;
                        @endphp

                        @if($step == -1)
                            <div class="p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 flex gap-3 items-center">
                                <i class="fa-solid fa-circle-xmark text-lg text-rose-500"></i>
                                <div class="text-xs">
                                    <span class="font-bold block">Mohon Maaf, Pengajuan Ditolak</span>
                                    <p class="text-rose-600/80 mt-0.5">{{ $seekerApplication->catatan_approval ?? 'Pengajuan Anda dinilai belum memenuhi kriteria prioritas ekonomi saat ini.' }}</p>
                                </div>
                            </div>
                        @else
                            <!-- Progress Bar Visual -->
                            <div class="space-y-4">
                                <div class="relative flex items-center justify-between text-[10px] font-bold text-slate-400">
                                    <!-- Bar Background -->
                                    <div class="absolute left-0 right-0 h-1 bg-slate-200 -z-10 rounded"></div>
                                    <!-- Active Bar -->
                                    <div class="absolute left-0 h-1 bg-indigo-600 -z-10 rounded transition-all duration-500" 
                                         style="width: {{ (($step - 1) / 3) * 100 }}%"></div>

                                    <div class="flex flex-col items-center gap-1.5 bg-white px-2">
                                        <div class="h-6 w-6 rounded-full flex items-center justify-center text-[10px] font-extrabold transition
                                            {{ $step >= 1 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }}">1</div>
                                        <span class="{{ $step >= 1 ? 'text-indigo-600 font-bold' : '' }}">Pending</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1.5 bg-white px-2">
                                        <div class="h-6 w-6 rounded-full flex items-center justify-center text-[10px] font-extrabold transition
                                            {{ $step >= 2 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }}">2</div>
                                        <span class="{{ $step >= 2 ? 'text-indigo-600 font-bold' : '' }}">Diverifikasi</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1.5 bg-white px-2">
                                        <div class="h-6 w-6 rounded-full flex items-center justify-center text-[10px] font-extrabold transition
                                            {{ $step >= 3 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }}">3</div>
                                        <span class="{{ $step >= 3 ? 'text-indigo-600 font-bold' : '' }}">Disetujui</span>
                                    </div>
                                    <div class="flex flex-col items-center gap-1.5 bg-white px-2">
                                        <div class="h-6 w-6 rounded-full flex items-center justify-center text-[10px] font-extrabold transition
                                            {{ $step >= 4 ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-500' }}">4</div>
                                        <span class="{{ $step >= 4 ? 'text-indigo-600 font-bold' : '' }}">Disalurkan</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="pt-2 border-t border-slate-100 flex justify-between items-center text-xs">
                            <a href="{{ route('pengajuan-bantuan.show', $seekerApplication->id) }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">
                                <i class="fa-solid fa-circle-info"></i> Lihat Rincian Pengajuan
                            </a>
                            <span class="text-slate-400 font-medium">Tanggal Pengajuan: {{ $seekerApplication->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                @endif

            </div>

            <!-- Right Sidebar: Quick Actions for Job Seeker -->
            <div class="space-y-6">
                <div class="rounded-2xl border border-slate-200/80 bg-white p-6 shadow-sm space-y-4">
                    <h4 class="text-xs font-bold text-slate-900 uppercase tracking-wider border-b border-slate-100 pb-2">Menu Navigasi</h4>
                    <div class="flex flex-col gap-2">
                        <a href="{{ route('pengajuan-bantuan.create') }}" class="flex items-center gap-2.5 p-3 rounded-xl bg-slate-50 hover:bg-indigo-50/50 border border-slate-100 hover:border-indigo-100 text-xs font-bold text-slate-700 hover:text-indigo-600 transition">
                            <i class="fa-solid fa-file-invoice-dollar text-slate-400"></i> Ajukan Bantuan Baru
                        </a>
                        <a href="{{ route('lowongan.index') }}" class="flex items-center gap-2.5 p-3 rounded-xl bg-slate-50 hover:bg-indigo-50/50 border border-slate-100 hover:border-indigo-100 text-xs font-bold text-slate-700 hover:text-indigo-600 transition">
                            <i class="fa-solid fa-briefcase text-slate-400"></i> Cari Lowongan Pekerjaan
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>
    @endif

</div>
@endsection
