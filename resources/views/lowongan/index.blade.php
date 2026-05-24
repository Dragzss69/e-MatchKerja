@extends('layouts.app')

@section('title', 'Daftar Lowongan Kerja')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Daftar Lowongan Kerja</h1>
        <p class="text-xs text-slate-400 font-medium mt-1">Temukan pekerjaan impian yang sesuai dengan kualifikasi Anda</p>
    </div>

    <!-- Search & Filter Card -->
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm p-5">
        <form method="GET" action="{{ route('lowongan.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                    <i class="fa-solid fa-magnifying-glass text-[10px]"></i> Cari Posisi / Perusahaan
                </label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                       placeholder="Contoh: Web Developer, PT Maju Jaya">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                    <i class="fa-solid fa-location-dot text-[10px]"></i> Lokasi
                </label>
                <input type="text" name="lokasi" value="{{ request('lokasi') }}" 
                       class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                       placeholder="Contoh: Jakarta, Makassar, Surabaya">
            </div>
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider flex items-center gap-1">
                    <i class="fa-solid fa-coins text-[10px]"></i> Gaji Minimum (Rp)
                </label>
                <input type="number" name="gaji_min" value="{{ request('gaji_min') }}" 
                       class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                       placeholder="Minimal gaji">
            </div>
            <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 transition shadow-sm">
                <i class="fa-solid fa-search text-xs"></i> Cari Lowongan
            </button>
        </form>
    </div>

    <!-- Hasil Pencarian Info -->
    <div class="flex justify-between items-center">
        <p class="text-xs text-slate-500">
            <i class="fa-solid fa-briefcase mr-1"></i> 
            Menampilkan <span class="font-bold text-indigo-600">{{ $lowongans->total() }}</span> lowongan pekerjaan
        </p>
        @if(request('search') || request('lokasi') || request('gaji_min'))
            <a href="{{ route('lowongan.index') }}" class="text-xs text-indigo-600 hover:underline">Reset Filter</a>
        @endif
    </div>

    <!-- Grid Lowongan -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($lowongans as $lowongan)
        <div class="group rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden hover:shadow-md transition-all duration-300 hover:border-indigo-200">
            
            <!-- Header Card -->
            <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-5 py-4">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="text-lg font-bold text-white truncate">{{ $lowongan->posisi }}</h3>
                        <p class="text-indigo-100 text-xs mt-1 flex items-center gap-1">
                            <i class="fa-solid fa-building text-[10px]"></i> {{ $lowongan->perusahaan->name ?? 'Perusahaan' }}
                        </p>
                    </div>
                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider bg-emerald-400/20 text-emerald-100 border border-emerald-300/30">
                        <i class="fa-solid fa-circle-check text-[8px]"></i> {{ $lowongan->status == 'aktif' ? 'TERBUKA' : 'DITUTUP' }}
                    </span>
                </div>
            </div>
            
            <!-- Body Card -->
            <div class="p-5 space-y-3">
                <!-- Gaji -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                        <i class="fa-solid fa-money-bill-wave text-emerald-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-medium">Gaji</p>
                        <p class="font-bold text-slate-800 text-sm">
                            Rp {{ number_format($lowongan->gaji_min, 0, ',', '.') }}
                            @if($lowongan->gaji_max)
                            - Rp {{ number_format($lowongan->gaji_max, 0, ',', '.') }}
                            @endif
                        </p>
                    </div>
                </div>
                
                <!-- Lokasi -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fa-solid fa-location-dot text-blue-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-medium">Lokasi</p>
                        <p class="font-semibold text-slate-700 text-sm">{{ $lowongan->lokasi }}</p>
                    </div>
                </div>
                
                <!-- Deadline -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center">
                        <i class="fa-regular fa-calendar text-orange-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-medium">Batas Pendaftaran</p>
                        <p class="font-semibold text-slate-700 text-sm">
                            {{ \Carbon\Carbon::parse($lowongan->deadline)->translatedFormat('d F Y') }}
                            @if(\Carbon\Carbon::parse($lowongan->deadline)->isPast())
                                <span class="text-rose-500 text-[10px] ml-1">(Lewat)</span>
                            @endif
                        </p>
                    </div>
                </div>

                <!-- Kuota -->
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                        <i class="fa-solid fa-users text-purple-600 text-sm"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-400 font-medium">Kuota</p>
                        <p class="font-semibold text-slate-700 text-sm">{{ $lowongan->kuota }} orang</p>
                    </div>
                </div>
            </div>
            
            <!-- Footer Card - Tombol -->
            <div class="px-5 pb-5 pt-2">
                <a href="{{ route('lowongan.show', $lowongan->id) }}" 
                   class="w-full inline-flex items-center justify-center gap-2 rounded-xl bg-indigo-50 hover:bg-indigo-600 border border-indigo-200 hover:border-indigo-600 text-indigo-600 hover:text-white font-bold py-2.5 text-sm transition-all duration-200">
                    <i class="fa-regular fa-eye"></i> Lihat Detail & Lamar
                </a>
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
                    <p class="text-sm text-slate-400">Belum ada lowongan pekerjaan yang tersedia saat ini.</p>
                    @if(auth()->user()->isEmployer())
                        <a href="{{ route('perusahaan.lowongan.create') }}" class="mt-2 inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-medium hover:bg-indigo-700">
                            <i class="fa-solid fa-plus"></i> Posting Lowongan
                        </a>
                    @endif
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