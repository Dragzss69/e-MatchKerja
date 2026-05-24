@extends('layouts.app')

@section('title', 'Pengajuan Bantuan Sosial')

@section('content')
<div class="space-y-6">
    <!-- Header dengan Tombol Kembali -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pengajuan Bantuan Sosial</h1>
            <p class="text-xs text-slate-400 font-medium">Lacak status verifikasi dan penyaluran permohonan bantuan sosial Anda</p>
        </div>
        <div class="flex gap-3">
            @if(auth()->user()->isJobSeeker())
                <a href="{{ route('pengajuan-bantuan.create') }}" 
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition shadow-sm">
                    <i class="fa-solid fa-plus"></i> Ajukan Bantuan
                </a>
            @endif
            <a href="{{ route('dashboard') }}" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium transition">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- Tabel Pengajuan (sama seperti sebelumnya) -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60">
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">No</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pencari Kerja</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Bantuan</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Nominal Diajukan</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Tanggal Pengajuan</th>
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuans as $pengajuan)
                    <tr class="hover:bg-slate-50/50 transition-colors duration-150 text-xs">
                        <td class="py-4 px-6 text-center text-slate-400 font-medium">
                            {{ $loop->iteration + ($pengajuans->currentPage() - 1) * $pengajuans->perPage() }}
                        </td>
                        <td class="py-4 px-4 font-semibold text-slate-800">
                            {{ $pengajuan->pencariKerja->name ?? '-' }}
                        </td>
                        <td class="py-4 px-4 text-slate-600">
                            {{ str_replace('_', ' ', ucwords($pengajuan->jenis_bantuan)) }}
                        </td>
                        <td class="py-4 px-4 text-right font-medium text-slate-700">
                            Rp {{ number_format($pengajuan->nominal_diajukan ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                @if($pengajuan->status == 'pending') bg-amber-50 text-amber-700 border border-amber-100
                                @elseif($pengajuan->status == 'diverifikasi') bg-blue-50 text-blue-700 border border-blue-100
                                @elseif($pengajuan->status == 'disetujui') bg-emerald-50 text-emerald-700 border border-emerald-100
                                @elseif($pengajuan->status == 'disalurkan') bg-purple-50 text-purple-700 border border-purple-100
                                @elseif($pengajuan->status == 'ditolak') bg-red-50 text-red-700 border border-red-100
                                @endif">
                                {{ ucfirst($pengajuan->status) }}
                            </span>
                        </td>
                        <td class="py-4 px-4 text-center text-slate-500">
                            {{ $pengajuan->created_at->format('d M Y') }}
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('pengajuan-bantuan.show', $pengajuan->id) }}" 
                               class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-medium text-xs">
                                <i class="fa-solid fa-circle-info"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="fa-solid fa-file-invoice-dollar text-3xl text-slate-300"></i>
                                <span>Belum ada pengajuan bantuan.</span>
                                @if(auth()->user()->isJobSeeker())
                                    <a href="{{ route('pengajuan-bantuan.create') }}" class="mt-2 text-indigo-600 hover:underline">
                                        Ajukan bantuan sekarang
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengajuans->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $pengajuans->links() }}
            </div>
        @endif
    </div>
</div>
@endsection