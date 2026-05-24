@extends('layouts.app')

@section('title', 'Dashboard Perusahaan')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard Perusahaan</h1>
            <p class="text-xs text-slate-400 font-medium mt-1">Kelola lowongan dan pelamar perusahaan Anda</p>
        </div>
        <a href="{{ route('perusahaan.lowongan.create') }}" 
           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition shadow-sm">
            <i class="fa-solid fa-plus"></i> Posting Lowongan Baru
        </a>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Lowongan</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $lowongans->count() }}</p>
                    <p class="text-xs text-slate-400 mt-1">Semua lowongan yang diposting</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Total Pelamar</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $allApplicants->count() }}</p>
                    <p class="text-xs text-slate-400 mt-1">Pelamar ke semua lowongan</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-slate-500">Lowongan Aktif</p>
                    <p class="text-3xl font-bold text-slate-800 mt-1">{{ $lowongans->where('status', 'aktif')->count() }}</p>
                    <p class="text-xs text-slate-400 mt-1">Lowongan yang masih terbuka</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Daftar Lowongan -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
            <h2 class="font-semibold text-slate-800">
                <i class="fa-solid fa-briefcase mr-2 text-indigo-500"></i> Daftar Lowongan Anda
            </h2>
            <span class="text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded-full">{{ $lowongans->count() }} lowongan</span>
        </div>
        
        @if($lowongans->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Posisi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Lokasi</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Kuota</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Pelamar</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($lowongans as $lowongan)
                    <tr class="hover:bg-slate-50 transition">
                        <td class="px-6 py-4">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $lowongan->posisi }}</p>
                                <p class="text-xs text-slate-400 mt-0.5">Deadline: {{ \Carbon\Carbon::parse($lowongan->deadline)->format('d/m/Y') }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600">
                            <i class="fa-solid fa-location-dot text-xs text-slate-400 mr-1"></i>
                            {{ $lowongan->lokasi }}
                        </td>
                        <td class="px-6 py-4 text-center text-slate-600">{{ $lowongan->kuota }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center justify-center gap-1 px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 text-xs font-medium">
                                <i class="fa-solid fa-user"></i> {{ $lowongan->lamaran_count ?? 0 }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                                {{ $lowongan->status == 'aktif' ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                <i class="fa-solid fa-circle text-[6px]"></i>
                                {{ $lowongan->status == 'aktif' ? 'Aktif' : 'Ditutup' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('lowongan.edit', $lowongan->id) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 text-xs font-medium transition"
                                   title="Edit Lowongan">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </a>
                                <a href="{{ route('perusahaan.pelamar.index', $lowongan->id) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 text-xs font-medium transition"
                                   title="Lihat Pelamar">
                                    <i class="fa-solid fa-users"></i> Pelamar
                                </a>
                                <form action="{{ route('lowongan.destroy', $lowongan->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus lowongan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium transition" title="Hapus Lowongan">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="py-12 text-center">
            <div class="flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                    <i class="fa-solid fa-briefcase-slash text-2xl text-slate-400"></i>
                </div>
                <h3 class="text-base font-semibold text-slate-700">Belum Ada Lowongan</h3>
                <p class="text-sm text-slate-400">Anda belum memposting lowongan apapun.</p>
                <a href="{{ route('perusahaan.lowongan.create') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition mt-2">
                    <i class="fa-solid fa-plus"></i> Posting Lowongan Pertama
                </a>
            </div>
        </div>
        @endif
    </div>

    <!-- Daftar Pelamar Terbaru -->
@if($allApplicants->count() > 0)
<div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center">
        <h2 class="font-semibold text-slate-800">
            <i class="fa-solid fa-user-plus mr-2 text-green-500"></i> Pelamar Terbaru
        </h2>
        <span class="text-xs text-slate-400 bg-slate-100 px-2 py-1 rounded-full">{{ $allApplicants->count() }} total</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Lowongan</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($allApplicants->take(10) as $lamaran)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                <span class="text-indigo-600 font-bold text-sm">{{ substr($lamaran->user->name ?? '?', 0, 1) }}</span>
                            </div>
                            <span class="font-medium text-slate-800">{{ $lamaran->user->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="font-medium text-slate-700">{{ $lamaran->lowongan->posisi }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-medium
                            @if($lamaran->status == 'pending') bg-yellow-50 text-yellow-700
                            @elseif($lamaran->status == 'dipanggil_wawancara') bg-purple-50 text-purple-700
                            @elseif($lamaran->status == 'diterima') bg-green-50 text-green-700
                            @else bg-red-50 text-red-700 @endif">
                            <i class="fa-solid fa-circle text-[6px]"></i>
                            {{ $lamaran->status == 'pending' ? 'Menunggu' : ($lamaran->status == 'dipanggil_wawancara' ? 'Dipanggil' : ($lamaran->status == 'diterima' ? 'Diterima' : 'Ditolak')) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center text-slate-500 text-xs">{{ $lamaran->created_at->format('d/m/Y') }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('perusahaan.pelamar.show', $lamaran->id) }}" 
                           class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-xs font-medium transition">
                            <i class="fa-solid fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

</div>
@endsection