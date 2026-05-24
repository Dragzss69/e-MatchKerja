@extends('layouts.app')

@section('title', 'Riwayat Lamaran Saya')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div>
        <h1 class="text-2xl font-bold text-slate-900">Riwayat Lamaran Saya</h1>
        <p class="text-xs text-slate-400 font-medium mt-1">Semua lamaran kerja yang pernah Anda kirim</p>
    </div>

    <!-- Statistik Singkat -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Lamaran</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $lamarans->count() }}</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fa-solid fa-briefcase text-blue-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Diproses</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $lamarans->where('status', 'pending')->count() }}</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <i class="fa-solid fa-clock text-yellow-600"></i>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Diterima</p>
                    <p class="text-2xl font-bold text-green-600">{{ $lamarans->where('status', 'diterima')->count() }}</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <i class="fa-solid fa-circle-check text-green-600"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Lamaran -->
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        @forelse($lamarans as $lamaran)
        <div class="border-b border-slate-100 last:border-0 hover:bg-slate-50/50 transition">
            <div class="p-6">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <!-- Info Kiri -->
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-indigo-100 flex items-center justify-center">
                                <i class="fa-solid fa-briefcase text-indigo-600"></i>
                            </div>
                            <div>
                                <h3 class="font-bold text-slate-800 text-base">{{ $lamaran->lowongan->posisi ?? 'Lowongan' }}</h3>
                                <p class="text-sm text-slate-500 flex items-center gap-2 mt-0.5">
                                    <i class="fa-solid fa-building text-slate-400 text-xs"></i>
                                    {{ $lamaran->lowongan->perusahaan->name ?? 'Perusahaan' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Badge -->
                    <div>
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

                <!-- Info Detail -->
                <div class="mt-4 flex flex-wrap gap-4 text-xs text-slate-500">
                    <div class="flex items-center gap-1.5">
                        <i class="fa-regular fa-calendar text-slate-400"></i>
                        <span>Dilamar: {{ $lamaran->created_at->setTimezone('Asia/Makassar')->format('d F Y, H:i') }}</span>
                    </div>
                    @if($lamaran->catatan)
                    <div class="flex items-center gap-1.5">
                        <i class="fa-regular fa-message text-slate-400"></i>
                        <span class="text-slate-600">{{ $lamaran->catatan }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="py-12 text-center">
            <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center mx-auto mb-3">
                <i class="fa-solid fa-briefcase-slash text-2xl text-slate-400"></i>
            </div>
            <h3 class="text-base font-semibold text-slate-700">Belum Ada Lamaran</h3>
            <p class="text-sm text-slate-400 mt-1">Anda belum pernah melamar pekerjaan apapun.</p>
            <a href="{{ route('lowongan.index') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition">
                <i class="fa-solid fa-search"></i> Cari Lowongan Sekarang
            </a>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($lamarans->hasPages())
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm p-4">
        {{ $lamarans->links() }}
    </div>
    @endif

</div>
@endsection