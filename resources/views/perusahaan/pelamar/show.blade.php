@extends('layouts.app')

@section('title', 'Detail Pelamar')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Navigation Back - HANYA SATU -->
    <div class="flex items-center gap-3">
        <a href="{{ route('perusahaan.dashboard') }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200/80 shadow-sm text-slate-600 hover:text-slate-900 transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Detail Pelamar</span>
    </div>

    <!-- Main Card -->
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center">
                    <span class="text-white font-bold text-2xl">{{ substr($lamaran->user->name ?? '?', 0, 1) }}</span>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-white">{{ $lamaran->user->name ?? 'Nama Tidak Diketahui' }}</h1>
                    <p class="text-indigo-100 text-sm mt-1">{{ $lamaran->user->email ?? '-' }}</p>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            
            <!-- Info Lamaran -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-1">
                    <p class="text-xs text-slate-400 font-medium">Melamar Posisi</p>
                    <p class="font-semibold text-slate-800 text-lg">{{ $lamaran->lowongan->posisi ?? '-' }}</p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs text-slate-400 font-medium">Tanggal Lamar</p>
                    <p class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="fa-regular fa-calendar text-slate-400"></i>
                        {{ $lamaran->created_at->format('d F Y, H:i') }}
                    </p>
                </div>
                <div class="space-y-1">
                    <p class="text-xs text-slate-400 font-medium">Status</p>
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

            <!-- Catatan -->
            @if($lamaran->catatan)
            <div class="border-t border-slate-100 pt-4">
                <h3 class="text-sm font-bold text-slate-700 mb-2 flex items-center gap-2">
                    <i class="fa-regular fa-message text-indigo-500"></i> Catatan Pelamar
                </h3>
                <div class="bg-slate-50 rounded-xl p-4 border border-slate-200">
                    <p class="text-slate-700 italic">"{{ $lamaran->catatan }}"</p>
                </div>
            </div>
            @endif

            <!-- File Pelamar -->
            <div class="border-t border-slate-100 pt-4">
                <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf text-red-500"></i> File Pelamar
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

            <!-- Update Status -->
            <div class="border-t border-slate-100 pt-4">
                <h3 class="text-sm font-bold text-slate-700 mb-3 flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-green-500"></i> Update Status Lamaran
                </h3>
                <div class="flex flex-wrap gap-3">
                    <form action="{{ route('lamaran.updateStatus', $lamaran->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="pending">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium transition flex items-center gap-2">
                            <i class="fa-solid fa-clock"></i> Menunggu
                        </button>
                    </form>
                    <form action="{{ route('lamaran.updateStatus', $lamaran->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="dipanggil_wawancara">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-purple-500 hover:bg-purple-600 text-white text-sm font-medium transition flex items-center gap-2">
                            <i class="fa-solid fa-phone"></i> Panggil Wawancara
                        </button>
                    </form>
                    <form action="{{ route('lamaran.updateStatus', $lamaran->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="diterima">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-green-500 hover:bg-green-600 text-white text-sm font-medium transition flex items-center gap-2">
                            <i class="fa-solid fa-check"></i> Terima Pelamar
                        </button>
                    </form>
                    <form action="{{ route('lamaran.updateStatus', $lamaran->id) }}" method="POST" class="inline">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="status" value="ditolak">
                        <button type="submit" class="px-4 py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white text-sm font-medium transition flex items-center gap-2" onclick="return confirm('Yakin ingin menolak pelamar ini?')">
                            <i class="fa-solid fa-times"></i> Tolak Pelamar
                        </button>
                    </form>
                </div>
                <p class="text-xs text-slate-400 mt-3">
                    <i class="fa-regular fa-circle-info"></i>
                    Status yang dipilih akan muncul di halaman riwayat lamaran pencari kerja.
                </p>
            </div>


        </div>
    </div>
</div>
@endsection