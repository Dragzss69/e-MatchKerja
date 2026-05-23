@extends('layouts.app')

@section('title', 'Daftar Lowongan Kerja')

@section('content')
<div class="space-y-6">
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Lowongan Kerja</h1>
            <p class="text-xs text-slate-400 font-medium">Lihat dan kelola semua lowongan pekerjaan yang aktif di sistem</p>
        </div>
        @if(auth()->user()->isEmployer())
            <a href="{{ route('perusahaan.lowongan.create') }}" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-xs font-bold text-white shadow-sm transition">
                <i class="fa-solid fa-plus text-[10px]"></i> Tambah Lowongan Kerja
            </a>
        @endif
    </div>

    <!-- Table Container -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60">
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">No</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Jabatan / Posisi</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Perusahaan</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Gaji Penawaran</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Penempatan</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Kuota</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Batas Pendaftaran</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status</th>
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($lowongans as $lowongan)
                        <tr class="hover:bg-slate-50/50 transition-colors duration-150 text-xs">
                            <td class="py-4 px-6 text-center text-slate-400 font-medium">
                                {{ $loop->iteration + ($lowongans->currentPage() - 1) * $lowongans->perPage() }}
                            </td>
                            <td class="py-4 px-4 font-bold text-slate-900 text-sm">
                                {{ $lowongan->posisi }}
                            </td>
                            <td class="py-4 px-4 font-medium text-slate-600">
                                {{ $lowongan->perusahaan->name ?? 'N/A' }}
                            </td>
                            <td class="py-4 px-4 font-semibold text-slate-800">
                                Rp {{ number_format($lowongan->gaji_min, 0, ',', '.') }} - {{ $lowongan->gaji_max ? number_format($lowongan->gaji_max, 0, ',', '.') : 'Sesuai' }}
                            </td>
                            <td class="py-4 px-4 text-slate-500">
                                <i class="fa-solid fa-location-dot mr-1"></i> {{ $lowongan->lokasi }}
                            </td>
                            <td class="py-4 px-4 text-center font-bold text-slate-800">
                                {{ $lowongan->kuota }} Orang
                            </td>
                            <td class="py-4 px-4 text-center text-slate-500 font-medium">
                                {{ $lowongan->deadline ? $lowongan->deadline->format('d M Y') : 'N/A' }}
                            </td>
                            <td class="py-4 px-4 text-center">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                    @if($lowongan->status == 'aktif') bg-emerald-50 text-emerald-700 border border-emerald-100/60
                                    @else bg-slate-100 text-slate-500 border border-slate-200/50 @endif">
                                    {{ $lowongan->status == 'aktif' ? 'Aktif' : 'Ditutup' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('lowongan.show', $lowongan->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-indigo-50 hover:text-indigo-600 hover:border-indigo-200 text-slate-600 transition">
                                        <i class="fa-solid fa-circle-info"></i> Detail
                                    </a>
                                    
                                    @if(auth()->user()->isAdmin() || (auth()->user()->isEmployer() && $lowongan->perusahaan_id === auth()->id()))
                                        <a href="{{ route('lowongan.edit', $lowongan->id) }}" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-amber-50 hover:text-amber-600 hover:border-amber-200 text-slate-600 transition">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        
                                        <form action="{{ route('lowongan.destroy', $lowongan->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin menghapus lowongan kerja ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg border border-slate-200 bg-slate-50 hover:bg-rose-50 hover:text-rose-600 hover:border-rose-200 text-slate-600 transition">
                                                <i class="fa-regular fa-trash-can"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="py-12 text-center text-sm text-slate-400">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <i class="fa-solid fa-briefcase text-3xl text-slate-300"></i>
                                    <span>Belum ada lowongan pekerjaan terdaftar.</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($lowongans->hasPages())
            <div class="px-6 py-4 border-t border-slate-100">
                {{ $lowongans->links() }}
            </div>
        @endif
    </div>

</div>
@endsection