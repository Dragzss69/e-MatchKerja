@extends('layouts.app')

@section('title', 'Verifikasi Data Diri Pencari Kerja')

@section('content')
<div class="space-y-6">
    <!-- Header dengan Tombol Kembali -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Verifikasi Data Diri Pencari Kerja</h1>
            <p class="text-xs text-slate-400 font-medium">Periksa kelengkapan dan keabsahan dokumen (KTP, KK) pencari kerja</p>
        </div>
        <a href="{{ route('dashboard') }}" 
           class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium transition">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
        </a>
    </div>

    <!-- Table Card -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60">
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">No</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">NIK</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">File KTP</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">File KK</th>
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($profiles as $profile)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150 text-xs">
                        <td class="py-4 px-6 text-center text-slate-400 font-medium">
                            {{ $loop->iteration + ($profiles->currentPage() - 1) * $profiles->perPage() }}
                        </td>
                        <td class="py-4 px-4 font-mono font-medium text-slate-500">
                            {{ $profile->nik }}
                        </td>
                        <td class="py-4 px-4 font-bold text-slate-900 text-sm">
                            {{ $profile->nama_lengkap }}
                        </td>
                        <td class="py-4 px-4 text-center">
                            @if($profile->file_ktp)
                                <a href="{{ Storage::url($profile->file_ktp) }}" target="_blank" 
                                   class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-medium text-xs">
                                    <i class="fa-solid fa-eye"></i> Lihat
                                </a>
                            @else
                                <span class="text-red-500 text-xs">Tidak ada</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            @if($profile->file_kk)
                                <a href="{{ Storage::url($profile->file_kk) }}" target="_blank" 
                                   class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-medium text-xs">
                                    <i class="fa-solid fa-eye"></i> Lihat
                                </a>
                            @else
                                <span class="text-red-500 text-xs">Tidak ada</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-center">
                            <form action="{{ route('verifier.jobseekers.verifikasi-data-diri', $profile->id) }}" method="POST">
                                @csrf
                                <button type="submit" 
                                        class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white text-xs font-medium transition">
                                    <i class="fa-solid fa-check"></i> Verifikasi
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="fa-solid fa-id-card text-3xl text-slate-300"></i>
                                <span>Semua data diri pencari kerja sudah terverifikasi.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($profiles->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $profiles->links() }}
            </div>
        @endif
    </div>
</div>
@endsection