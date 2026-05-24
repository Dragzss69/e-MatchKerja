@extends('layouts.app')

@section('title', 'Detail Lamaran Saya')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Navigation Back -->
    <div class="flex items-center gap-3">
        <a href="{{ route('lamaran.riwayat') }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200/80 shadow-sm text-slate-600 hover:text-slate-900 transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Detail Lamaran Saya</span>
    </div>

    <!-- Main Card -->
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">
                    <i class="fa-solid fa-briefcase text-white text-2xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white">{{ $lamaran->lowongan->posisi ?? 'Lowongan' }}</h1>
                    <p class="text-indigo-100 text-sm mt-1">{{ $lamaran->lowongan->perusahaan->name ?? 'Perusahaan' }}</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            
            <!-- Info Lamaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <p class="text-xs text-slate-400 font-medium">Tanggal Melamar</p>
                    <p class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="fa-regular fa-calendar text-slate-400"></i>
                        {{ $lamaran->created_at->setTimezone('Asia/Makassar')->format('d F Y, H:i') }}
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs text-slate-400 font-medium">Status Lamaran</p>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                        @if($lamaran->status == 'pending') bg-yellow-100 text-yellow-700
                        @elseif($lamaran->status == 'dipanggil_wawancara') bg-purple-100 text-purple-700
                        @elseif($lamaran->status == 'diterima') bg-green-100 text-green-700
                        @elseif($lamaran->status == 'ditolak') bg-red-100 text-red-700
                        @endif">
                        <i class="fa-solid fa-circle text-[6px]"></i>
                        {{ $lamaran->status == 'pending' ? 'Menunggu Review' : ($lamaran->status == 'dipanggil_wawancara' ? 'Dipanggil Wawancara' : ($lamaran->status == 'diterima' ? 'Diterima' : 'Ditolak')) }}
                    </span>
                </div>
            </div>

            <!-- Informasi Lowongan -->
            <div class="border-t border-slate-100 pt-4">
                <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-indigo-500"></i> Informasi Lowongan
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-slate-500">Posisi</p>
                        <p class="font-semibold text-slate-800">{{ $lamaran->lowongan->posisi }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500">Perusahaan</p>
                        <p class="font-semibold text-slate-800">{{ $lamaran->lowongan->perusahaan->name }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500">Lokasi</p>
                        <p class="font-semibold text-slate-800">{{ $lamaran->lowongan->lokasi }}</p>
                    </div>
                    <div>
                        <p class="text-slate-500">Estimasi Gaji</p>
                        <p class="font-semibold text-slate-800">
                            Rp {{ number_format($lamaran->lowongan->gaji_min, 0, ',', '.') }}
                            @if($lamaran->lowongan->gaji_max)
                            - Rp {{ number_format($lamaran->lowongan->gaji_max, 0, ',', '.') }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            @if($lamaran->catatan)
            <div class="border-t border-slate-100 pt-4">
                <h3 class="text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                    <i class="fa-regular fa-message text-indigo-500"></i> Catatan Saya
                </h3>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                    <p class="text-slate-700 italic">"{{ $lamaran->catatan }}"</p>
                </div>
            </div>
            @endif

            <!-- File CV -->
            <div class="border-t border-slate-100 pt-4">
                <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf text-red-500"></i> File CV
                </h3>
                <div class="flex flex-wrap gap-3">
                    @if($lamaran->cv_path)
                    <a href="{{ route('lamaran.download', ['id' => $lamaran->id, 'type' => 'cv']) }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-sm font-medium transition">
                        <i class="fa-solid fa-download"></i> Download CV
                    </a>
                    @else
                    <span class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-gray-100 text-gray-400 text-sm">
                        <i class="fa-solid fa-times"></i> CV tidak tersedia
                    </span>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection