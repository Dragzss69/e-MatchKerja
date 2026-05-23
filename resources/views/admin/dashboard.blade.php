@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-500 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}</p>
        </div>
        
        <div class="flex gap-2">
            <select id="periodeFilter" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                <option value="6">6 Bulan Terakhir</option>
                <option value="12">12 Bulan Terakhir</option>
                <option value="24">24 Bulan Terakhir</option>
            </select>
            <button id="exportBtn" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm transition flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export Laporan
            </button>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Pencari Kerja</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($totalPencariKerja ?? 0) }}</p>
                    <p class="text-xs text-green-600 mt-1">↑ 12% dari bulan lalu</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Lowongan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($totalLowongan ?? 0) }}</p>
                    <p class="text-xs text-green-600 mt-1">↑ 5 lowongan baru</p>
                </div>
                <div class="bg-purple-100 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Success Rate Matching</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $successRate ?? 0 }}%</p>
                    <p class="text-xs text-green-600 mt-1">↑ 8% dari target</p>
                </div>
                <div class="bg-green-100 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Bantuan Tersalurkan</p>
                    <p class="text-2xl font-bold text-gray-800">{{ number_format($bantuanTersalurkan ?? 0) }}</p>
                    <p class="text-xs text-green-600 mt-1">Rp {{ number_format($totalDanaTersalurkan ?? 0, 0, ',', '.') }}</p>
                </div>
                <div class="bg-orange-100 p-3 rounded-xl">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistik Pengajuan Bantuan -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 text-center border border-yellow-200">
            <div class="text-2xl mb-1">⏳</div>
            <div class="text-2xl font-bold text-yellow-700">{{ $statistikPengajuan['pending'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Menunggu Verifikasi</div>
        </div>
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-4 text-center border border-blue-200">
            <div class="text-2xl mb-1">✓</div>
            <div class="text-2xl font-bold text-blue-700">{{ $statistikPengajuan['diverifikasi'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Terverifikasi</div>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 text-center border border-green-200">
            <div class="text-2xl mb-1">✅</div>
            <div class="text-2xl font-bold text-green-700">{{ $statistikPengajuan['disetujui'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Disetujui</div>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-4 text-center border border-purple-200">
            <div class="text-2xl mb-1">💰</div>
            <div class="text-2xl font-bold text-purple-700">{{ $statistikPengajuan['disalurkan'] ?? 0 }}</div>
            <div class="text-xs text-gray-600 mt-1">Disalurkan</div>
        </div>
    </div>

    <!-- Pengajuan Menunggu Verifikasi -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-gray-800">📋 Pengajuan Bantuan Menunggu Verifikasi</h2>
                <a href="{{ route('pengajuan-bantuan.index') }}" class="text-blue-600 text-sm hover:underline">Lihat Semua →</a>
            </div>
        </div>
        
        <div class="p-4">
            @if(isset($pengajuanPending) && count($pengajuanPending) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemohon</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Bantuan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($pengajuanPending as $pengajuan)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-600">{{ $pengajuan->created_at->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 font-medium text-gray-800">{{ $pengajuan->pencariKerja->name ?? '-' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600">
                                    @if($pengajuan->jenis_bantuan == 'subsidi_upah') 💰 Subsidi Upah
                                    @elseif($pengajuan->jenis_bantuan == 'pelatihan') 📚 Pelatihan
                                    @elseif($pengajuan->jenis_bantuan == 'modal_umkm') 🏪 Modal UMKM
                                    @else 📝 Lainnya @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-600">Rp {{ number_format($pengajuan->nominal_diajukan ?? 0, 0, ',', '.') }}</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('pengajuan-bantuan.show', $pengajuan->id) }}" 
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-medium transition inline-flex items-center gap-1">
                                        🔍 Verifikasi
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <div class="text-4xl mb-2">✅</div>
                    <p class="text-gray-500">Tidak ada pengajuan yang menunggu verifikasi.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="font-semibold text-gray-800 mb-4">📈 Tren Pengangguran</h2>
            <canvas id="trenChart" height="200"></canvas>
            <p class="text-xs text-gray-400 text-center mt-3" id="lastUpdate">Update: {{ now()->format('d/m/Y H:i') }}</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="font-semibold text-gray-800 mb-4">🎯 Success Rate Matching</h2>
            <canvas id="successChart" height="200"></canvas>
            <div class="mt-4 text-center">
                <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-1"></span>
                <span class="text-sm text-gray-600">Berhasil: {{ $successRate ?? 0 }}%</span>
                <span class="inline-block w-3 h-3 bg-red-500 rounded-full ml-3 mr-1"></span>
                <span class="text-sm text-gray-600">Belum: {{ 100 - ($successRate ?? 0) }}%</span>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="font-semibold text-gray-800 mb-4">📊 Jenis Bantuan Yang Diajukan</h2>
            <canvas id="bantuanChart" height="200"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <h2 class="font-semibold text-gray-800 mb-4">🏘️ Statistik per Kecamatan</h2>
            <canvas id="sebaranChart" height="200"></canvas>
        </div>
    </div>

    <!-- Alert Info -->
    <div id="alertInfo" class="fixed bottom-5 right-5 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg shadow-lg hidden z-50">
        <div class="flex items-center gap-3">
            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-sm text-blue-700" id="alertMessage">Data berhasil dimuat!</p>
            <button id="closeAlert" class="text-blue-500 hover:text-blue-700">&times;</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let charts = {};

        // Data dari backend
        const chartTrenPengangguran = <?php echo json_encode($chartTrenPengangguran ?? ['labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'], 'data' => [120, 115, 108, 102, 95, 88]]); ?>;
        const chartJenisBantuan = <?php echo json_encode($chartJenisBantuan ?? ['labels' => ['Subsidi Upah', 'Pelatihan', 'Modal UMKM'], 'data' => [0, 0, 0]]); ?>;
        const chartSebaran = <?php echo json_encode($chartSebaran ?? ['labels' => ['Kec. A', 'Kec. B', 'Kec. C', 'Kec. D'], 'data' => [0, 0, 0, 0]]); ?>;
        const successRate = {{ $successRate ?? 0 }};

        function renderCharts() {
            if (charts.trenChart) charts.trenChart.destroy();
            if (document.getElementById('trenChart')) {
                charts.trenChart = new Chart(document.getElementById('trenChart'), {
                    type: 'line',
                    data: {
                        labels: chartTrenPengangguran.labels,
                        datasets: [{
                            label: 'Jumlah Pengangguran',
                            data: chartTrenPengangguran.data,
                            borderColor: '#3b82f6',
                            backgroundColor: 'rgba(59, 130, 246, 0.05)',
                            fill: true,
                            tension: 0.3,
                            pointBackgroundColor: '#3b82f6',
                            pointBorderColor: '#fff',
                            pointRadius: 4
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: true }
                });
            }

            if (charts.successChart) charts.successChart.destroy();
            if (document.getElementById('successChart')) {
                charts.successChart = new Chart(document.getElementById('successChart'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Berhasil Matching', 'Belum Matching'],
                        datasets: [{
                            data: [successRate, 100 - successRate],
                            backgroundColor: ['#22c55e', '#ef4444'],
                            borderWidth: 0
                        }]
                    },
                    options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
                });
            }

            if (charts.bantuanChart) charts.bantuanChart.destroy();
            if (document.getElementById('bantuanChart')) {
                charts.bantuanChart = new Chart(document.getElementById('bantuanChart'), {
                    type: 'bar',
                    data: {
                        labels: chartJenisBantuan.labels,
                        datasets: [{
                            label: 'Jumlah Pengajuan',
                            data: chartJenisBantuan.data,
                            backgroundColor: '#3b82f6',
                            borderRadius: 8
                        }]
                    },
                    options: { responsive: true, plugins: { legend: { position: 'top' } } }
                });
            }

            if (charts.sebaranChart) charts.sebaranChart.destroy();
            if (document.getElementById('sebaranChart')) {
                charts.sebaranChart = new Chart(document.getElementById('sebaranChart'), {
                    type: 'bar',
                    data: {
                        labels: chartSebaran.labels,
                        datasets: [{
                            label: 'Pengajuan Bantuan',
                            data: chartSebaran.data,
                            backgroundColor: '#a855f7',
                            borderRadius: 8
                        }]
                    },
                    options: { indexAxis: 'y', responsive: true, plugins: { legend: { position: 'top' } } }
                });
            }
        }

        function showAlert(message) {
            const alertBox = document.getElementById('alertInfo');
            const alertMsg = document.getElementById('alertMessage');
            if (!alertBox) return;
            alertMsg.textContent = message;
            alertBox.classList.remove('hidden');
            setTimeout(() => alertBox.classList.add('hidden'), 3000);
        }

        document.getElementById('exportBtn')?.addEventListener('click', () => {
            window.location.href = "{{ route('laporan.index') }}";
        });

        document.getElementById('closeAlert')?.addEventListener('click', () => {
            document.getElementById('alertInfo')?.classList.add('hidden');
        });

        renderCharts();
    });
</script>
@endsection