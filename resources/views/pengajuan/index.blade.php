@extends('layouts.app')

@section('title', 'Daftar Pengajuan Bantuan')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Pengajuan Bantuan Sosial</h1>
            <p class="text-xs text-slate-400 font-medium">Lacak status verifikasi dan penyaluran permohonan bantuan sosial Anda</p>
        </div>
        @if(auth()->user()->isJobSeeker())
            <a href="{{ route('pengajuan-bantuan.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-xs font-bold text-white shadow-sm transition">
                <i class="fa-solid fa-plus text-[10px]"></i> Ajukan Bantuan Baru
            </a>
        @endif
    </div>

    <!-- Table Card -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60">
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">No</th>
                        @if(!auth()->user()->isJobSeeker())
                            <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Pencari Kerja</th>
                        @endif
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Bantuan</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nominal Diajukan</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Tanggal Pengajuan</th>
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuans as $item)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-150 text-xs">
                            <td class="py-4 px-6 text-center text-slate-400 font-medium">
                                {{ $loop->iteration + ($pengajuans->currentPage() - 1) * $pengajuans->perPage() }}
                            </td>
                            @if(!auth()->user()->isJobSeeker())
                                <td class="py-4 px-4 font-bold text-slate-900 text-sm">
                                    {{ $item->pencariKerja->name ?? '-' }}
                                </td>
                            @endif
                            <td class="py-4 px-4 font-bold text-slate-900 text-sm">
                                {{ str_replace('_', ' ', ucwords($item->jenis_bantuan)) }}
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                Rp {{ number_format($item->nominal_diajukan ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    @if($item->status == 'pending') bg-amber-50 text-amber-800 border border-amber-100/60
                                    @elseif($item->status == 'diverifikasi') bg-sky-50 text-sky-800 border border-sky-100/60
                                    @elseif($item->status == 'disetujui') bg-emerald-50 text-emerald-800 border border-emerald-100/60
                                    @elseif($item->status == 'ditolak') bg-rose-50 text-rose-800 border border-rose-100/60
                                    @else bg-purple-50 text-purple-800 border border-purple-100/60 @endif">
                                    {{ ucfirst($item->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center text-slate-500 font-medium">
                                {{ $item->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('pengajuan-bantuan.show', $item) }}" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 text-slate-600 transition font-bold">
                                    <i class="fa-solid fa-folder-open"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-sm text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-receipt text-3xl text-slate-300"></i>
                                    <span>Belum ada permohonan pengajuan bantuan sosial.</span>
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