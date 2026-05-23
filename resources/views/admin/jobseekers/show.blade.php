@extends('layouts.app')

@section('title', 'Detail Pencari Kerja')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Navigation Back -->
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.jobseekers.index') }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200/80 shadow-sm text-slate-600 hover:text-slate-900 transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Detail Profil Pencari Kerja</span>
    </div>

    <!-- Main Detail Card -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-8 space-y-8">
        
        <!-- Header: Avatar, Name & NIK -->
        <div class="flex flex-col sm:flex-row items-center gap-6 border-b border-slate-100 pb-6">
            <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-indigo-500 text-white font-extrabold text-3xl shadow-md">
                {{ substr($profile->nama_lengkap, 0, 1) }}
            </div>
            <div class="text-center sm:text-left space-y-1.5 flex-1">
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-none">{{ $profile->nama_lengkap }}</h2>
                <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2.5 text-xs text-slate-400 font-medium">
                    <span class="font-mono text-slate-500">NIK: {{ $profile->nik }}</span>
                    <span>•</span>
                    <span>No HP: {{ $profile->no_hp }}</span>
                    <span>•</span>
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                        @if($profile->status_verifikasi == 'Verified') bg-emerald-50 text-emerald-700 border border-emerald-100/60
                        @elseif($profile->status_verifikasi == 'Rejected') bg-rose-50 text-rose-700 border border-rose-100/60
                        @else bg-amber-50 text-amber-700 border border-amber-100/60 @endif">
                        {{ $profile->status_verifikasi ?? 'Unverified' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Information Fields Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Tanggal Lahir / Usia</span>
                <p class="font-semibold text-slate-800 text-sm">
                    {{ $profile->tanggal_lahir ? $profile->tanggal_lahir->format('d M Y') : '-' }} 
                    ({{ $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->age : '-' }} Tahun)
                </p>
            </div>
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Jenis Kelamin</span>
                <p class="font-semibold text-slate-800 text-sm">{{ $profile->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</p>
            </div>
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Pendidikan Terakhir</span>
                <p class="font-semibold text-slate-800 text-sm">{{ $profile->pendidikan_terakhir }}</p>
            </div>
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Status Kerja Saat Ini</span>
                <p class="font-semibold text-slate-800 text-sm">{{ $profile->status_kerja_saat_ini }}</p>
            </div>
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Lama Menganggur</span>
                <p class="font-semibold text-slate-800 text-sm">{{ $profile->lama_menganggur }} Bulan</p>
            </div>
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Pendapatan Bulanan</span>
                <p class="font-semibold text-slate-800 text-sm">Rp {{ number_format($profile->pendapatan_bulanan, 0, ',', '.') }}</p>
            </div>
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Jumlah Tanggungan</span>
                <p class="font-semibold text-slate-800 text-sm">{{ $profile->jumlah_tanggungan }} Orang</p>
            </div>
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Alamat KTP</span>
                <p class="font-semibold text-slate-800 text-sm leading-relaxed">{{ $profile->alamat_ktp }}</p>
            </div>
        </div>

        <!-- Document Files Preview (KTB & KK) -->
        <div class="space-y-4 pt-6 border-t border-slate-100">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest flex items-center gap-1.5">
                <i class="fa-solid fa-file-shield text-slate-400"></i> Lampiran Berkas Verifikasi
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- File KTP -->
                <div class="rounded-2xl border border-slate-200/80 p-4 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-3 text-xs">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600"><i class="fa-regular fa-id-card"></i></div>
                        <div>
                            <span class="font-bold text-slate-800 block">Kartu Tanda Penduduk</span>
                            <span class="text-[10px] text-slate-400 font-medium">Format: PDF/JPG/PNG</span>
                        </div>
                    </div>
                    @if($profile->file_ktp)
                        <a href="{{ asset('storage/' . $profile->file_ktp) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-white hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 text-xs font-bold text-slate-700 hover:text-indigo-600 transition">
                            <i class="fa-solid fa-eye"></i> Lihat
                        </a>
                    @else
                        <span class="text-[10px] text-rose-500 font-bold">Belum Diupload</span>
                    @endif
                </div>

                <!-- File KK -->
                <div class="rounded-2xl border border-slate-200/80 p-4 flex items-center justify-between bg-slate-50/50">
                    <div class="flex items-center gap-3 text-xs">
                        <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-sky-50 text-sky-600"><i class="fa-solid fa-users"></i></div>
                        <div>
                            <span class="font-bold text-slate-800 block">Kartu Keluarga</span>
                            <span class="text-[10px] text-slate-400 font-medium">Format: PDF/JPG/PNG</span>
                        </div>
                    </div>
                    @if($profile->file_kk)
                        <a href="{{ asset('storage/' . $profile->file_kk) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-xl bg-white hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 text-xs font-bold text-slate-700 hover:text-indigo-600 transition">
                            <i class="fa-solid fa-eye"></i> Lihat
                        </a>
                    @else
                        <span class="text-[10px] text-slate-400 italic font-bold">Tidak Terlampir</span>
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection