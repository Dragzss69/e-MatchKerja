@extends('layouts.app')

@section('title', $lowongan->posisi ?? 'Detail Lowongan')

@section('content')
<div class="max-w-5xl mx-auto space-y-8">
    
    <!-- Navigation Back -->
    <div class="flex items-center gap-3">
        <a href="{{ route('lowongan.index') }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200/80 shadow-sm text-slate-600 hover:text-slate-900 transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Detail Lowongan Pekerjaan</span>
    </div>

    <!-- Main Job Detail Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Job Details Card (Left - 2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-8 space-y-6">
                
                <!-- Title & Company -->
                <div class="space-y-2">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                        @if($lowongan->status == 'aktif') bg-emerald-50 text-emerald-700 border border-emerald-100
                        @else bg-slate-100 text-slate-500 border border-slate-200 @endif">
                        {{ $lowongan->status == 'aktif' ? 'Terbuka' : 'Ditutup' }}
                    </span>
                    <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">{{ $lowongan->posisi }}</h1>
                    <p class="text-sm font-semibold text-indigo-600 flex items-center gap-1.5">
                        <i class="fa-solid fa-building text-indigo-400"></i> {{ $lowongan->perusahaan->name ?? 'Perusahaan' }}
                    </p>
                </div>

                <!-- Salary, Location, Deadline Row -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6 p-5 rounded-2xl bg-slate-50 border border-slate-100">
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Estimasi Gaji</span>
                        <span class="text-xs font-extrabold text-slate-900 leading-none">
                            Rp {{ number_format($lowongan->gaji_min, 0, ',', '.') }} - {{ $lowongan->gaji_max ? number_format($lowongan->gaji_max, 0, ',', '.') : 'Sesuai' }}
                        </span>
                    </div>
                    <div class="space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Penempatan</span>
                        <span class="text-xs font-bold text-slate-700 flex items-center gap-1">
                            <i class="fa-solid fa-location-dot text-slate-400"></i> {{ $lowongan->lokasi }}
                        </span>
                    </div>
                    <div class="space-y-1 col-span-2 sm:col-span-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Batas Pendaftaran</span>
                        <span class="text-xs font-bold text-slate-700 flex items-center gap-1">
                            <i class="fa-regular fa-calendar-days text-slate-400"></i> {{ $lowongan->deadline ? $lowongan->deadline->format('d M Y') : 'N/A' }}
                        </span>
                    </div>
                </div>

                <!-- Job Description -->
                <div class="space-y-3">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Deskripsi Pekerjaan</h3>
                    <div class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">
                        {{ $lowongan->deskripsi }}
                    </div>
                </div>

                <!-- Required Skills (DIPERBAIKI) -->
                <div class="space-y-3 pt-4 border-t border-slate-100">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider">Skill yang Dibutuhkan</h3>
                    <div class="flex flex-wrap gap-2">
                        @php
                            // Decode skill dari database
                            $skills = [];
                            if (is_array($lowongan->skill_dibutuhkan)) {
                                $skills = $lowongan->skill_dibutuhkan;
                            } elseif (is_string($lowongan->skill_dibutuhkan)) {
                                $decoded = json_decode($lowongan->skill_dibutuhkan, true);
                                $skills = is_array($decoded) ? $decoded : [];
                            }
                        @endphp
                        
                        @if(count($skills) > 0)
                            @foreach($skills as $skill)
                                <span class="inline-flex items-center rounded-lg bg-indigo-50 border border-indigo-100/60 px-3 py-1.5 text-xs font-bold text-indigo-700 shadow-sm">
                                    <i class="fa-solid fa-code text-[10px] mr-1.5 opacity-60"></i> {{ trim($skill) }}
                                </span>
                            @endforeach
                        @else
                            <span class="text-xs text-slate-400 italic">Tidak ada spesifikasi skill khusus</span>
                        @endif
                    </div>
                </div>

            </div>
        </div>

        <!-- Sidebar Actions (Right - 1 Col) -->
        <div class="space-y-6">
            
            <!-- Quick Apply Info -->
            <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-6 space-y-5">
                <h3 class="text-sm font-bold text-slate-900 border-b border-slate-100 pb-3">Informasi Tambahan</h3>
                
                <div class="space-y-4">
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-semibold text-slate-400">Kuota Disediakan</span>
                        <span class="font-bold text-slate-800">{{ $lowongan->kuota }} Lowongan</span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-semibold text-slate-400">Tanggal Posting</span>
                        <span class="font-bold text-slate-800">{{ $lowongan->created_at->format('d M Y') }}</span>
                    </div>
                </div>

                @if(auth()->check())
    @if(auth()->user()->isJobSeeker())
        @php
            $profile = auth()->user()->jobSeekerProfile;
            $isVerified = $profile && $profile->status_verifikasi == 'Verified';
        @endphp
        
        @if($lowongan->status == 'aktif')
            @if(!$isVerified)
                <div class="w-full rounded-xl bg-yellow-50 border border-yellow-200 text-yellow-700 px-4 py-3 text-center text-sm font-semibold">
                    <i class="fa-solid fa-triangle-exclamation mr-2"></i> 
                    Data diri Anda belum diverifikasi. Silakan hubungi petugas verifikasi sebelum dapat melamar.
                </div>
                <div class="text-center mt-3">
                    <a href="{{ route('jobseeker.profile.show') }}" class="text-indigo-600 hover:underline text-sm">
                        Lihat Status Profil Saya
                    </a>
                </div>
            @elseif($sudahLamar)
                <div class="w-full rounded-xl bg-green-50 border border-green-200 text-green-700 px-4 py-3 text-center text-sm font-semibold">
                    <i class="fa-solid fa-check-circle mr-2"></i> Anda sudah melamar lowongan ini
                </div>
                <a href="{{ route('lamaran.riwayat') }}" class="w-full inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-xs font-bold text-white shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-clock-rotate-left mr-2"></i> Lihat Riwayat Lamaran
                </a>
            @else
                <form action="{{ route('lamaran.store', $lowongan->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700">Upload CV <span class="text-rose-500">*</span></label>
                        <input type="file" name="cv" accept=".pdf" required
                               class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:border-indigo-500">
                        <p class="text-[10px] text-slate-400">Format: PDF, JPG, PNG. Maks: 2MB</p>
                    </div>
                    
                    <div class="space-y-2">
                        <label class="text-xs font-bold text-slate-700">Catatan / Pesan (Opsional)</label>
                        <textarea name="catatan" rows="3" 
                                  class="w-full rounded-xl border border-slate-200 px-4 py-2 text-sm focus:border-indigo-500"
                                  placeholder="Tulis pesan singkat untuk perusahaan...">{{ old('catatan') }}</textarea>
                    </div>
                    
                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-xs font-bold text-white shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">
                        <i class="fa-regular fa-paper-plane mr-2"></i> Kirim Lamaran
                    </button>
                </form>
            @endif
        @else
            <button disabled class="w-full inline-flex items-center justify-center rounded-xl bg-slate-100 px-4 py-3 text-xs font-bold text-slate-400 cursor-not-allowed">
                Lowongan Sudah Ditutup
            </button>
        @endif
    @elseif(auth()->user()->isEmployer() && $lowongan->perusahaan_id === auth()->id())
        <div class="grid grid-cols-2 gap-3 border-t border-slate-100 pt-4">
            <a href="{{ route('lowongan.edit', $lowongan->id) }}" class="inline-flex items-center justify-center rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-700 px-4 py-2.5 text-xs font-bold transition">
                <i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit
            </a>
            <form action="{{ route('lowongan.destroy', $lowongan->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-700 px-4 py-2.5 text-xs font-bold transition">
                    <i class="fa-regular fa-trash-can mr-1.5"></i> Hapus
                </button>
            </form>
        </div>
    @endif
@else
    <div class="text-center p-4 bg-slate-50 rounded-xl">
        <p class="text-sm text-slate-600 mb-3">Silakan login untuk melamar posisi ini</p>
        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white hover:bg-indigo-700">
            Login Sekarang
        </a>
    </div>
@endif

            </div>

            <!-- Recruitment banner -->
            <div class="rounded-3xl bg-gradient-to-tr from-indigo-900 to-slate-900 p-6 text-white space-y-3">
                <span class="text-[9px] font-extrabold uppercase tracking-widest text-indigo-400 bg-indigo-500/10 px-2.5 py-1 rounded-md border border-indigo-500/20">Panduan Melamar</span>
                <h4 class="text-xs font-bold">Bagaimana cara mengirim berkas?</h4>
                <p class="text-[11px] text-slate-300 leading-relaxed">
                    Pastikan Anda telah mengisi <strong>Profil Saya</strong> terlebih dahulu sebelum melamar agar CV dan NIK Anda dapat ditinjau oleh perusahaan secara terpadu melalui platform e-MatchKerja.
                </p>
            </div>
        </div>

    </div>

</div>
@endsection