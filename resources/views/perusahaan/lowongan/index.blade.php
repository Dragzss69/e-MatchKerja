@extends('layouts.app')

@section('title', 'Daftar Lowongan Saya')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Lowongan Saya</h1>
            <p class="text-xs text-slate-400 font-medium mt-1">Kelola lowongan yang telah Anda posting</p>
        </div>
        <a href="{{ route('perusahaan.lowongan.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition shadow-sm">
            <i class="fa-solid fa-plus"></i> Posting Lowongan Baru
        </a>
    </div>

    <!-- Daftar Lowongan (Hanya milik perusahaan ini) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($lowongans as $lowongan)
        <div class="group rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300">
            
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-5 py-4">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-white truncate">{{ $lowongan->posisi }}</h3>
                        <p class="text-indigo-100 text-xs mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-building text-[10px]"></i> {{ $lowongan->perusahaan->name ?? 'Perusahaan Anda' }}
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider 
                        {{ $lowongan->status == 'aktif' ? 'bg-emerald-400/20 text-emerald-100 border border-emerald-300/30' : 'bg-slate-400/20 text-slate-100 border border-slate-300/30' }}">
                        <i class="fa-solid fa-circle-check text-[8px]"></i> {{ $lowongan->status == 'aktif' ? 'TERBUKA' : 'DITUTUP' }}
                    </span>
                </div>
            </div>
            
            <!-- Body Card -->
            <div class="p-5 space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                        <i class="fa-solid fa-money-bill-wave text-emerald-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-medium">Gaji</p>
                        <p class="font-bold text-slate-800 text-sm">
                            Rp {{ number_format($lowongan->gaji_min, 0, ',', '.') }}
                            @if($lowongan->gaji_max) - Rp {{ number_format($lowongan->gaji_max, 0, ',', '.') }} @endif
                        </p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fa-solid fa-location-dot text-blue-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-medium">Lokasi</p>
                        <p class="font-semibold text-slate-700 text-sm">{{ $lowongan->lokasi }}</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center">
                        <i class="fa-regular fa-calendar text-orange-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-medium">Deadline</p>
                        <p class="font-semibold text-slate-700 text-sm">
                            {{ \Carbon\Carbon::parse($lowongan->deadline)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fa-solid fa-users text-purple-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-medium">Pelamar</p>
                        <p class="font-bold text-slate-800 text-sm">{{ $lowongan->lamaran_count ?? 0 }} orang</p>
                    </div>
                </div>
            </div>
            
            <!-- Footer Card - Tombol Aksi -->
            <div class="px-5 pb-5 pt-2 flex gap-2">
                <a href="{{ route('lowongan.show', $lowongan->id) }}" 
                   class="flex-1 inline-flex items-center justify-center gap-1 rounded-xl bg-indigo-50 hover:bg-indigo-600 border border-indigo-200 hover:border-indigo-600 text-indigo-600 hover:text-white font-bold py-2 text-xs transition">
                    <i class="fa-solid fa-eye"></i> Lihat
                </a>
                <a href="{{ route('lowongan.edit', $lowongan->id) }}" 
                   class="flex-1 inline-flex items-center justify-center gap-1 rounded-xl bg-amber-50 hover:bg-amber-600 border border-amber-200 hover:border-amber-600 text-amber-600 hover:text-white font-bold py-2 text-xs transition">
                    <i class="fa-solid fa-pen"></i> Edit
                </a>
                <form action="{{ route('lowongan.destroy', $lowongan->id) }}" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-1 rounded-xl bg-red-50 hover:bg-red-600 border border-red-200 hover:border-red-600 text-red-600 hover:text-white font-bold py-2 text-xs transition">
                        <i class="fa-solid fa-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm p-12 text-center">
                <div class="flex flex-col items-center justify-center gap-3">
                    <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                        <i class="fa-solid fa-briefcase-slash text-2xl text-slate-400"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-slate-700">Belum Ada Lowongan</h3>
                    <p class="text-sm text-slate-400">Anda belum memposting lowongan apapun.</p>
                    <a href="{{ route('perusahaan.lowongan.create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                        <i class="fa-solid fa-plus"></i> Posting Lowongan Pertama
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($lowongans->hasPages())
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm p-4">
        {{ $lowongans->links() }}
    </div>
    @endif

</div>
@endsection