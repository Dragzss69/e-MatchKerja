@extends('layouts.app')

@section('title', 'Rekomendasi Bantuan (SPK SAW)')

@section('content')
<div class="space-y-8">
    
    <!-- Hero / Title -->
    <div class="relative overflow-hidden rounded-3xl bg-slate-900 px-6 py-10 shadow-xl sm:px-12 sm:py-14">
        <!-- Background decorative elements -->
        <div class="absolute -right-16 -top-16 h-48 w-48 rounded-full bg-indigo-500/10 blur-2xl"></div>
        <div class="absolute -left-16 -bottom-16 h-48 w-48 rounded-full bg-violet-500/10 blur-2xl"></div>
        
        <div class="relative max-w-2xl">
            <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-500/10 px-3 py-1 text-xs font-bold text-indigo-400 border border-indigo-500/20">
                <i class="fa-solid fa-graduation-cap"></i> Sistem Pendukung Keputusan (SPK)
            </span>
            <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-white sm:text-4xl">Rekomendasi Penerima Bantuan Sosial</h1>
            <p class="mt-2 text-sm text-slate-300">
                Pemeringkatan kelayakan bantuan sosial berbasis risiko ekonomi menggunakan algoritma <strong>Simple Additive Weighting (SAW)</strong>. Hanya menampilkan pencari kerja yang status profilnya telah diverifikasi oleh Petugas.
            </p>
        </div>
    </div>

    <!-- Grid: Ranking & Criteria Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- SPK Ranking Table (Left - 2 Cols) -->
        <div class="lg:col-span-2 space-y-6">
            <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-base font-bold text-slate-900">Hasil Pemeringkatan Kelayakan</h2>
                        <p class="text-[11px] text-slate-400 font-medium">Diurutkan berdasarkan skor preferensi akhir (V) tertinggi</p>
                    </div>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100">
                        <i class="fa-solid fa-users"></i> {{ count($daftarRanking) }} Kandidat Terverifikasi
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200/60">
                                <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Rank</th>
                                <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                                <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">NIK</th>
                                <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Skor Akhir (V)</th>
                                <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($daftarRanking as $index => $item)
                                <tr class="hover:bg-slate-50/50 transition-colors duration-150">
                                    <td class="py-4 px-6 text-center">
                                        <div class="inline-flex h-7 w-7 items-center justify-center rounded-lg font-bold text-xs shadow-sm
                                            @if($index == 0) bg-amber-500 text-white shadow-amber-200
                                            @elseif($index == 1) bg-slate-400 text-white shadow-slate-100
                                            @elseif($index == 2) bg-amber-700 text-white shadow-amber-200
                                            @else bg-slate-100 text-slate-700 @endif">
                                            {{ $index + 1 }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 font-bold text-slate-900 text-sm">
                                        {{ $item['nama'] }}
                                    </td>
                                    <td class="py-4 px-4 text-xs font-mono text-slate-500">
                                        {{ $item['nik'] }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <div class="inline-flex items-center gap-1 text-sm font-extrabold text-indigo-600 bg-indigo-50/50 border border-indigo-100/60 px-3 py-1 rounded-xl">
                                            <i class="fa-solid fa-square-poll-vertical text-indigo-400 text-xs"></i>
                                            {{ number_format($item['skor_akhir'], 4) }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('jobseeker-profiles.show', $item['job_seeker_id']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-bold text-slate-600 hover:text-indigo-600 bg-slate-50 hover:bg-indigo-50 border border-slate-200 hover:border-indigo-200 rounded-xl transition">
                                                <i class="fa-solid fa-user-gear"></i> Detail Profil
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-sm text-slate-400">
                                        <div class="flex flex-col items-center justify-center gap-2">
                                            <i class="fa-solid fa-users-slash text-3xl text-slate-300"></i>
                                            <span>Belum ada data pencari kerja terverifikasi.</span>
                                            <p class="text-xs text-slate-400 max-w-xs mt-1">Pastikan petugas verifikator telah melakukan verifikasi berkas NIK dan kondisi ekonomi terlebih dahulu.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- SPK Rules Info (Right - 1 Col) -->
        <div class="space-y-6">
            
            <!-- Kriteria Bobot Card -->
            <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-6">
                <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-sliders text-indigo-500"></i> Bobot Kriteria Penilaian
                </h3>
                <div class="space-y-4">
                    
                    <!-- C1 -->
                    <div class="flex items-start justify-between gap-3 text-xs">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-800">C1: Status Kerja Saat Ini</span>
                            <span class="text-[10px] text-slate-400 font-medium">PHK (Skor 3), Menganggur (2), Serabutan (1)</span>
                        </div>
                        <div class="text-right">
                            <span class="font-extrabold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">25%</span>
                            <span class="block text-[9px] text-emerald-500 font-bold uppercase tracking-wider mt-1">Benefit</span>
                        </div>
                    </div>
                    
                    <!-- C2 -->
                    <div class="flex items-start justify-between gap-3 text-xs">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-800">C2: Lama Menganggur</span>
                            <span class="text-[10px] text-slate-400 font-medium">&gt; 12 bln (3), 6-12 bln (2), &lt; 6 bln (1)</span>
                        </div>
                        <div class="text-right">
                            <span class="font-extrabold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">20%</span>
                            <span class="block text-[9px] text-emerald-500 font-bold uppercase tracking-wider mt-1">Benefit</span>
                        </div>
                    </div>

                    <!-- C3 -->
                    <div class="flex items-start justify-between gap-3 text-xs">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-800">C3: Pendapatan Bulanan</span>
                            <span class="text-[10px] text-slate-400 font-medium">Makin kecil pendapatan bulanan, makin prioritas</span>
                        </div>
                        <div class="text-right">
                            <span class="font-extrabold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">25%</span>
                            <span class="block text-[9px] text-rose-500 font-bold uppercase tracking-wider mt-1">Cost</span>
                        </div>
                    </div>

                    <!-- C4 -->
                    <div class="flex items-start justify-between gap-3 text-xs">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-800">C4: Jumlah Tanggungan</span>
                            <span class="text-[10px] text-slate-400 font-medium">Makin banyak orang yang ditanggung, makin prioritas</span>
                        </div>
                        <div class="text-right">
                            <span class="font-extrabold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">15%</span>
                            <span class="block text-[9px] text-emerald-500 font-bold uppercase tracking-wider mt-1">Benefit</span>
                        </div>
                    </div>

                    <!-- C5 -->
                    <div class="flex items-start justify-between gap-3 text-xs">
                        <div class="flex flex-col">
                            <span class="font-bold text-slate-800">C5: Penerima Bansos Lain</span>
                            <span class="text-[10px] text-slate-400 font-medium">Mendapat bansos lain memperkecil prioritas</span>
                        </div>
                        <div class="text-right">
                            <span class="font-extrabold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded border border-indigo-100">15%</span>
                            <span class="block text-[9px] text-rose-500 font-bold uppercase tracking-wider mt-1">Cost</span>
                        </div>
                    </div>

                </div>
            </div>
            
            <!-- SAW Info Banner Card -->
            <div class="rounded-3xl bg-indigo-50/50 border border-indigo-100 p-6 space-y-3">
                <h4 class="text-xs font-bold text-indigo-950 uppercase tracking-widest flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-info text-indigo-500"></i> Informasi SAW
                </h4>
                <p class="text-slate-600 text-xs leading-relaxed">
                    Setiap kriteria memiliki tipe **Benefit** (nilai lebih tinggi = prioritas lebih baik) dan **Cost** (nilai lebih rendah = prioritas lebih baik).
                </p>
                <p class="text-slate-600 text-xs leading-relaxed">
                    Sistem otomatis menormalisasi semua data mentah pencari kerja menjadi matriks ternormalisasi [0-1], kemudian mengalikannya dengan bobot kriteria untuk mendapatkan nilai prioritas absolut.
                </p>
            </div>
        </div>

    </div>

</div>
@endsection
