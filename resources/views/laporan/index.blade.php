@extends('layouts.app')

@section('title', 'Laporan Pengajuan Bantuan')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Laporan Penyaluran Bantuan</h1>
            <p class="text-xs text-slate-400 font-medium">Rekapitulasi berkas pengajuan bantuan sosial yang masuk di sistem</p>
        </div>
        
        <!-- Export Actions (Admin/Verifier only) -->
        @if(auth()->user()->isAdmin() || auth()->user()->isVerifier())
            <div class="flex flex-wrap gap-2.5">
                <a href="{{ route('laporan.export.excel') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-xs font-bold text-white shadow-sm transition">
                    <i class="fa-solid fa-file-csv"></i> Export CSV (Excel)
                </a>
                <a href="{{ route('laporan.export.pdf') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-xs font-bold text-white shadow-sm transition">
                    <i class="fa-solid fa-file-pdf"></i> Unduh Laporan (PDF)
                </a>
            </div>
        @endif
    </div>

    <!-- Table Card -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60">
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">No</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Pemohon</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jenis Bantuan</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nominal Bantuan</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status Akhir</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Tanggal Pengajuan</th>
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Rincian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($pengajuans as $p)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-150 text-xs">
                            <td class="py-4 px-6 text-center text-slate-400 font-medium">
                                {{ $loop->iteration + ($pengajuans->currentPage() - 1) * $pengajuans->perPage() }}
                            </td>
                            <td class="py-4 px-4 font-bold text-slate-900 text-sm">
                                {{ $p->pencariKerja->name ?? '-' }}
                            </td>
                            <td class="py-4 px-4 font-medium text-slate-700">
                                {{ str_replace('_', ' ', ucwords($p->jenis_bantuan)) }}
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                Rp {{ number_format($p->nominal_diajukan ?? 0, 0, ',', '.') }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    @if($p->status == 'pending') bg-slate-100 text-slate-600 border border-slate-200/50
                                    @elseif($p->status == 'diverifikasi') bg-sky-50 text-sky-800 border border-sky-100/60
                                    @elseif($p->status == 'disetujui') bg-emerald-50 text-emerald-800 border border-emerald-100/60
                                    @elseif($p->status == 'ditolak') bg-rose-50 text-rose-800 border border-rose-100/60
                                    @else bg-purple-50 text-purple-800 border border-purple-100/60 @endif">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-center text-slate-500 font-medium">
                                {{ $p->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-6 text-right">
                                <a href="{{ route('pengajuan-bantuan.show', $p->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 text-slate-600 transition font-bold">
                                    <i class="fa-solid fa-eye"></i> Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-sm text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-receipt text-3xl text-slate-300"></i>
                                    <span>Belum ada data laporan penyaluran bantuan sosial.</span>
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