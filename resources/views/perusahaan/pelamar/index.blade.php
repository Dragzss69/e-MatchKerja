@extends('layouts.app')

@section('title', 'Daftar Pelamar')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Pelamar</h1>
            <p class="text-xs text-slate-400 font-medium mt-1">Kelola dan tinjau pelamar yang melamar di lowongan Anda</p>
        </div>
        <a href="{{ route('perusahaan.dashboard') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pelamar</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $lamarans->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Semua pelamar</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Menunggu Review</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $lamarans->where('status', 'pending')->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Perlu ditinjau</p>
                </div>
                <div class="bg-yellow-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Diterima</p>
                    <p class="text-2xl font-bold text-green-600">{{ $lamarans->where('status', 'diterima')->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Pelamar diterima</p>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Ditolak</p>
                    <p class="text-2xl font-bold text-red-600">{{ $lamarans->where('status', 'ditolak')->count() }}</p>
                    <p class="text-xs text-gray-400 mt-1">Pelamar ditolak</p>
                </div>
                <div class="bg-red-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Status -->
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm p-4">
        <div class="flex flex-wrap gap-2">
            <a href="?status=all" class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ request('status', 'all') == 'all' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                📋 Semua
            </a>
            <a href="?status=pending" class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ request('status') == 'pending' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                ⏳ Menunggu
            </a>
            <a href="?status=diterima" class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ request('status') == 'diterima' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                ✅ Diterima
            </a>
            <a href="?status=ditolak" class="px-3 py-1.5 rounded-lg text-xs font-medium transition {{ request('status') == 'ditolak' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                ❌ Ditolak
            </a>
        </div>
    </div>

    <!-- Tabel Pelamar -->
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200">
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pencari Kerja</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Lowongan</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal Lamar</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($lamarans as $index => $lamaran)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4 text-sm text-slate-500">{{ $loop->iteration }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                    <span class="text-indigo-600 font-bold text-sm">{{ substr($lamaran->user->name ?? '?', 0, 1) }}</span>
                                </div>
                                <span class="font-semibold text-slate-800">{{ $lamaran->user->name ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-600">
                            <i class="fa-solid fa-briefcase text-xs text-slate-400 mr-1"></i>
                            {{ $lamaran->lowongan->posisi ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-slate-500">
                            <i class="fa-regular fa-calendar text-xs text-slate-400 mr-1"></i>
                            {{ $lamaran->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                @if($lamaran->status == 'pending') bg-yellow-100 text-yellow-700
                                @elseif($lamaran->status == 'diterima') bg-green-100 text-green-700
                                @elseif($lamaran->status == 'ditolak') bg-red-100 text-red-700
                                @endif">
                                <i class="fa-solid fa-circle text-[6px]"></i>
                                {{ $lamaran->status == 'pending' ? 'Menunggu' : ($lamaran->status == 'diterima' ? 'Diterima' : 'Ditolak') }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('perusahaan.pelamar.show', $lamaran->id) }}" 
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-600 text-xs font-medium transition">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                                @if($lamaran->status == 'pending')
                                    <form action="{{ route('lamaran.updateStatus', $lamaran->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="diterima">
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-green-50 hover:bg-green-100 text-green-600 text-xs font-medium transition">
                                            <i class="fa-solid fa-check"></i> Terima
                                        </button>
                                    </form>
                                    <form action="{{ route('lamaran.updateStatus', $lamaran->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="status" value="ditolak">
                                        <button type="submit" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 text-xs font-medium transition" onclick="return confirm('Yakin ingin menolak?')">
                                            <i class="fa-solid fa-times"></i> Tolak
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-slate-100 flex items-center justify-center">
                                    <i class="fa-solid fa-users-slash text-2xl text-slate-400"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-slate-700">Belum Ada Pelamar</h3>
                                <p class="text-sm text-slate-400">Belum ada pelamar untuk lowongan ini.</p>
                                <p class="text-xs text-slate-400">Bagikan link lowongan Anda kepada pencari kerja.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            <table>
        </div>
    </div>

</div>
@endsection