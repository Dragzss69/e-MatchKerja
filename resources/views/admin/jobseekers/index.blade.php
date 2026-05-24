@extends('layouts.app')

@section('title', 'Daftar Pencari Kerja')

@section('content')
<div class="space-y-6">
    
    <!-- Header dengan Tombol Export PDF -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Daftar Pencari Kerja</h1>
            <p class="text-xs text-slate-400 font-medium">Tinjau profil dan kualifikasi pencari kerja terdaftar di platform</p>
        </div>
        <div class="flex gap-2">
            <select id="exportFilter" class="rounded-xl border border-slate-200 px-3 py-2 text-sm bg-white focus:border-indigo-500">
                <option value="all">📊 Semua Data</option>
                <option value="menganggur">⚠️ Pengangguran Saja</option>
                <option value="bekerja">✅ Bekerja Saja</option>
            </select>
            <a href="#" id="exportBtn" 
               class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-red-600 hover:bg-red-700 text-white text-sm font-medium transition shadow-sm">
                <i class="fa-solid fa-file-pdf"></i> Export Statistik PDF
            </a>
        </div>
    </div>

    <!-- ========== GRAFIK BATANG (BAR CHART) - UKURAN KECIL ========== -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-3">
    <div class="flex justify-between items-center mb-2">
        <h3 class="text-xs font-bold text-slate-700">Grafik Status Pekerjaan</h3>
        <div class="flex gap-3 text-[10px]">
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                <span>Pengangguran: <strong class="text-orange-600">{{ $statistik['menganggur'] }}</strong></span>
            </div>
            <div class="flex items-center gap-1">
                <div class="w-2 h-2 rounded-full bg-green-500"></div>
                <span>Bekerja: <strong class="text-green-600">{{ $statistik['bekerja'] }}</strong></span>
            </div>
        </div>
    </div>
    <canvas id="barChart" height="100"></canvas>
</div>

    <!-- Info Total -->
    <div class="bg-blue-50 rounded-xl p-2 text-center border border-blue-200">
        <p class="text-xs text-blue-800">
            <i class="fa-solid fa-users mr-1"></i> 
            Total Pencari Kerja: <strong>{{ $statistik['total'] }}</strong> orang
        </p>
    </div>

    <!-- Search & Filter Card -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm p-6">
        <form method="GET" action="{{ route('admin.jobseekers.index') }}" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
            <!-- Search -->
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Cari Kata Kunci</label>
                <input type="text" name="search" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" 
                       placeholder="NIK, Nama, atau No HP" 
                       value="{{ request('search') }}">
            </div>

            <!-- Filter Status Kerja -->
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Status Pekerjaan</label>
                <select name="status_kerja" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="Menganggur" {{ request('status_kerja') == 'Menganggur' ? 'selected' : '' }}>Menganggur</option>
                    <option value="Bekerja" {{ request('status_kerja') == 'Bekerja' ? 'selected' : '' }}>Bekerja</option>
                    <option value="Wirausaha" {{ request('status_kerja') == 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                </select>
            </div>

            <!-- Filter Pendidikan -->
            <div class="flex flex-col gap-1.5">
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Pendidikan Terakhir</label>
                <select name="pendidikan" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                    <option value="">Semua Pendidikan</option>
                    <option value="sd" {{ request('pendidikan') == 'sd' ? 'selected' : '' }}>SD</option>
                    <option value="smp" {{ request('pendidikan') == 'smp' ? 'selected' : '' }}>SMP</option>
                    <option value="sma" {{ request('pendidikan') == 'sma' ? 'selected' : '' }}>SMA/SMK</option>
                    <option value="d3" {{ request('pendidikan') == 'd3' ? 'selected' : '' }}>D3</option>
                    <option value="s1" {{ request('pendidikan') == 's1' ? 'selected' : '' }}>S1</option>
                    <option value="s2" {{ request('pendidikan') == 's2' ? 'selected' : '' }}>S2</option>
                </select>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 hover:bg-indigo-700 text-xs font-bold text-white py-3 shadow-sm transition">
                <i class="fa-solid fa-filter mr-1.5 text-[10px]"></i> Terapkan Filter
            </button>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-200/60">
                        <th class="py-3.5 px-6 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">No</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">NIK</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Usia</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Pendidikan</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status Kerja</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Lama Menganggur</th>
                        <th class="py-3.5 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Status Verifikasi</th>
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
                        <td class="py-4 px-4 text-center font-semibold text-slate-700">
                            {{ $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->age : '-' }} Tahun
                        </td>
                        <td class="py-4 px-4 text-center text-slate-600 font-medium">
                            {{ strtoupper($profile->pendidikan_terakhir) }}
                        </td>
                        <td class="py-4 px-4 text-center text-slate-600">
                            {{ ucfirst($profile->status_kerja_saat_ini ?? '-') }}
                        </td>
                        <td class="py-4 px-4 text-center font-bold text-slate-700">
                            {{ $profile->lama_menganggur }} Bulan
                        </td>
                        <td class="py-4 px-4 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                                @if($profile->status_verifikasi == 'Verified') bg-emerald-50 text-emerald-700 border border-emerald-100/60
                                @elseif($profile->status_verifikasi == 'Rejected') bg-rose-50 text-rose-700 border border-rose-100/60
                                @else bg-amber-50 text-amber-700 border border-amber-100/60 @endif">
                                {{ $profile->status_verifikasi ?? 'Unverified' }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a href="{{ route('jobseeker-profiles.show', $profile->id) }}" 
                               class="inline-flex items-center gap-1 text-indigo-600 hover:text-indigo-800 font-medium text-xs">
                                <i class="fa-solid fa-circle-info"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center gap-2">
                                <i class="fa-solid fa-users-slash text-3xl text-slate-300"></i>
                                <span>Tidak ada data pencari kerja ditemukan.</span>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menganggur = {{ $statistik['menganggur'] }};
        const bekerja = {{ $statistik['bekerja'] }};
        
        // Bar Chart (Grafik Batang)
        const ctx = document.getElementById('barChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Pengangguran', 'Bekerja'],
        datasets: [{
            data: [menganggur, bekerja],
            backgroundColor: ['#f97316', '#22c55e'],
            borderRadius: 4,
            barPercentage: 0.4,
            categoryPercentage: 0.6
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: { display: false },
            tooltip: { 
                callbacks: {
                    label: function(context) { return context.parsed.y + ' orang'; }
                }
            }
        },
        scales: {
            y: { 
                beginAtZero: true, 
                ticks: { stepSize: 1, font: { size: 8 } },
                grid: { color: '#e5e7eb', lineWidth: 0.5 }
            },
            x: { 
                ticks: { font: { size: 9, weight: 'bold' } }
            }
        },
        layout: {
            padding: { top: 5, bottom: 5, left: 0, right: 0 }
        }
    }
        });
        
        // Export PDF dengan filter
        document.getElementById('exportBtn').addEventListener('click', function(e) {
            e.preventDefault();
            let filter = document.getElementById('exportFilter').value;
            window.location.href = "{{ route('admin.jobseekers.export-statistik') }}?filter=" + filter;
        });
    });
</script>
@endsection