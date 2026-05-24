@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto">
    

    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5 flex justify-between items-center">
            <div>
                <h1 class="text-xl font-bold text-white">Profil Saya</h1>
                <p class="text-indigo-100 text-sm mt-1">Data diri Anda sebagai pencari kerja</p>
            </div>
            <a href="{{ route('jobseeker.profile.edit') }}" 
               class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-xl text-sm font-bold transition flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square"></i> Edit Profil
            </a>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            
            <!-- Informasi Pribadi -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-slate-700 border-b pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-user text-indigo-500"></i> Informasi Pribadi
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">NIK</label>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ $profile->nik ?? '-' }}</p>
                    </div>
                    
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Nama Lengkap</label>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ $profile->nama_lengkap ?? '-' }}</p>
                    </div>
                    
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Tanggal Lahir</label>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->format('d F Y') : '-' }}</p>
                    </div>
                    
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Jenis Kelamin</label>
                        <p class="text-sm font-semibold text-slate-800 mt-1">
                            @if($profile->jenis_kelamin == 'L') Laki-laki
                            @elseif($profile->jenis_kelamin == 'P') Perempuan
                            @else - @endif
                        </p>
                    </div>
                </div>
                
                <div class="bg-slate-50 rounded-xl p-3">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Alamat KTP</label>
                    <p class="text-sm font-semibold text-slate-800 mt-1">{{ $profile->alamat_ktp ?? '-' }}</p>
                </div>
                
                <div class="bg-slate-50 rounded-xl p-3">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Nomor HP</label>
                    <p class="text-sm font-semibold text-slate-800 mt-1">{{ $profile->no_hp ?? '-' }}</p>
                </div>
            </div>

            <!-- Pendidikan & Pekerjaan -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-slate-700 border-b pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-indigo-500"></i> Pendidikan & Pekerjaan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Pendidikan Terakhir</label>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ strtoupper($profile->pendidikan_terakhir ?? '-') }}</p>
                    </div>
                    
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Status Kerja Saat Ini</label>
                        <p class="text-sm font-semibold text-slate-800 mt-1">
                            @if($profile->status_kerja_saat_ini == 'Menganggur') Menganggur
                            @elseif($profile->status_kerja_saat_ini == 'Bekerja') Bekerja
                            @elseif($profile->status_kerja_saat_ini == 'Wirausaha') Wirausaha
                            @else - @endif
                        </p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Lama Menganggur</label>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ $profile->lama_menganggur ?? 0 }} bulan</p>
                    </div>
                    
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Pendapatan Bulanan</label>
                        <p class="text-sm font-semibold text-slate-800 mt-1">Rp {{ number_format($profile->pendapatan_bulanan ?? 0, 0, ',', '.') }}</p>
                    </div>
                    
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Jumlah Tanggungan</label>
                        <p class="text-sm font-semibold text-slate-800 mt-1">{{ $profile->jumlah_tanggungan ?? 0 }} orang</p>
                    </div>
                </div>
            </div>

            <!-- Dokumen -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-slate-700 border-b pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf text-red-500"></i> Dokumen
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">File KTP</label>
                        @if($profile->file_ktp)
    <a href="{{ Storage::url($profile->file_ktp) }}" target="_blank" class="text-sm font-semibold text-indigo-600 hover:underline mt-1 inline-flex items-center gap-1">
        <i class="fa-solid fa-eye"></i> Lihat File KTP
    </a>
@endif
                    </div>
                    
                    <div class="bg-slate-50 rounded-xl p-3">
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">File Kartu Keluarga</label>
                        @if($profile->file_kk)
    <a href="{{ Storage::url($profile->file_kk) }}" target="_blank" class="text-sm font-semibold text-indigo-600 hover:underline mt-1 inline-flex items-center gap-1">
        <i class="fa-solid fa-eye"></i> Lihat File KK
    </a>
@endif
                    </div>
                </div>
            </div>

            <!-- Status Verifikasi -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-slate-700 border-b pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-shield-check text-indigo-500"></i> Status Verifikasi
                </h3>
                
                <div class="bg-slate-50 rounded-xl p-3">
                    <div class="flex items-center justify-between">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Status Data</label>
                            <p class="text-sm font-semibold mt-1">
                                @if($profile->status_verifikasi == 'Verified')
                                    <span class="text-green-600">✓ Telah Diverifikasi</span>
                                @elseif($profile->status_verifikasi == 'Rejected')
                                    <span class="text-red-600">✗ Ditolak</span>
                                @else
                                    <span class="text-yellow-600">⏳ Menunggu Verifikasi</span>
                                @endif
                            </p>
                        </div>
                        @if($profile->is_penerima_bansos_lain)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-700">
                                Penerima Bansos Lain
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 border-t flex gap-3">
                <a href="{{ route('dashboard') }}" class="px-6 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold transition">
                    Kembali ke Dashboard
                </a>
            </div>
        </div>
    </div>
</div>
@endsection