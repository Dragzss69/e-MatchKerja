@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
        
        <!-- Filter & Export Buttons -->
        <div class="flex gap-2">
            <select id="periodeFilter" class="border rounded-lg px-3 py-2 text-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="6">6 Bulan Terakhir</option>
                <option value="12">12 Bulan Terakhir</option>
                <option value="24">24 Bulan Terakhir</option>
            </select>
            <button id="exportBtn" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-green-700 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                </svg>
                Export
            </button>
        </div>
    </div>

    <!-- Statistik Cards dengan Loading State -->
    <div id="statsContainer">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Card 1 -->
            <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm">Total Pencari Kerja</div>
                        <div class="text-2xl font-bold" id="total-pencari">1,240</div>
                        <div class="text-xs text-green-600 mt-1">↑ 12% dari bulan lalu</div>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm">Total Lowongan</div>
                        <div class="text-2xl font-bold" id="total-lowongan">87</div>
                        <div class="text-xs text-green-600 mt-1">↑ 5 lowongan baru</div>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm">Success Rate Matching</div>
                        <div class="text-2xl font-bold" id="success-rate">65%</div>
                        <div class="text-xs text-green-600 mt-1">↑ 8% dari target</div>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Card 4 -->
            <div class="bg-white rounded-lg shadow p-4 hover:shadow-lg transition">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-gray-500 text-sm">Bantuan Tersalurkan</div>
                        <div class="text-2xl font-bold" id="bantuan">342</div>
                        <div class="text-xs text-green-600 mt-1">Rp 2.5M total dana</div>
                    </div>
                    <div class="bg-orange-100 p-3 rounded-full">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Line Chart -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="font-semibold text-gray-700">Tren Pengangguran</h2>
                <div class="text-xs text-gray-500" id="lastUpdate">Last update: today</div>
            </div>
            <canvas id="trenChart" height="200"></canvas>
        </div>

        <!-- Doughnut Chart -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="font-semibold text-gray-700 mb-4">Success Rate Matching</h2>
            <canvas id="successChart" height="200"></canvas>
            <div class="mt-4 text-center text-sm text-gray-600">
                <span class="inline-block w-3 h-3 bg-green-500 rounded-full mr-1"></span> Berhasil: 65%
                <span class="inline-block w-3 h-3 bg-red-500 rounded-full ml-3 mr-1"></span> Belum: 35%
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="font-semibold text-gray-700 mb-4">Jenis Bantuan Tersalurkan</h2>
            <canvas id="bantuanChart" height="200"></canvas>
        </div>

        <!-- Horizontal Bar -->
        <div class="bg-white rounded-lg shadow p-4">
            <h2 class="font-semibold text-gray-700 mb-4">Sebaran Pengangguran per Kecamatan</h2>
            <canvas id="sebaranChart" height="200"></canvas>
        </div>
    </div>

    <!-- Ranking Table -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-gray-700">Top 5 Prioritas Penerima Bantuan</h2>
            <button id="refreshRanking" class="text-blue-600 text-sm hover:underline">Refresh ↻</button>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="p-3 text-left">#</th>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Skor Kerentanan</th>
                        <th class="p-3 text-left">Rekomendasi Bantuan</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>
                <tbody id="ranking-table">
                    <!-- Data akan diisi JavaScript -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Alert Info -->
    <div id="alertInfo" class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded hidden">
        <div class="flex items-center">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-blue-700" id="alertMessage">Data berhasil dimuat!</p>
            </div>
            <button id="closeAlert" class="ml-auto text-blue-500">&times;</button>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let charts = {}; // Store chart instances
        
        // Mock Data (nanti diganti dengan API)
        const mockData = {
            trenPengangguran: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
                data: [120, 115, 108, 102, 95, 88]
            },
            successRate: {
                berhasil: 65,
                belum: 35
            },
            jenisBantuan: {
                labels: ['Subsidi Upah', 'Pelatihan', 'Modal UMKM'],
                data: [45, 30, 25]
            },
            sebaranKecamatan: {
                labels: ['Kec. A', 'Kec. B', 'Kec. C', 'Kec. D'],
                data: [50, 42, 35, 28]
            },
            ranking: [
                { id: 1, nama: 'Ahmad Subekti', skor: 92, rekomendasi: 'Modal UMKM', status: 'Menunggu' },
                { id: 2, nama: 'Siti Aminah', skor: 88, rekomendasi: 'Pelatihan Digital', status: 'Disetujui' },
                { id: 3, nama: 'Budi Santoso', skor: 85, rekomendasi: 'Subsidi Upah', status: 'Proses' },
                { id: 4, nama: 'Dewi Lestari', skor: 79, rekomendasi: 'Pelatihan Digital', status: 'Menunggu' },
                { id: 5, nama: 'Eko Prasetyo', skor: 74, rekomendasi: 'Subsidi Upah', status: 'Disetujui' }
            ]
        };

        // Fungsi untuk render semua chart
        function renderCharts(data) {
            // Line Chart
            if (charts.trenChart) charts.trenChart.destroy();
            charts.trenChart = new Chart(document.getElementById('trenChart'), {
                type: 'line',
                data: {
                    labels: data.trenPengangguran.labels,
                    datasets: [{
                        label: 'Jumlah Pengangguran',
                        data: data.trenPengangguran.data,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: { mode: 'index', intersect: false }
                    }
                }
            });

            // Doughnut Chart
            if (charts.successChart) charts.successChart.destroy();
            charts.successChart = new Chart(document.getElementById('successChart'), {
                type: 'doughnut',
                data: {
                    labels: ['Berhasil Matching', 'Belum Matching'],
                    datasets: [{
                        data: [data.successRate.berhasil, data.successRate.belum],
                        backgroundColor: ['rgb(34, 197, 94)', 'rgb(239, 68, 68)']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });

            // Bar Chart
            if (charts.bantuanChart) charts.bantuanChart.destroy();
            charts.bantuanChart = new Chart(document.getElementById('bantuanChart'), {
                type: 'bar',
                data: {
                    labels: data.jenisBantuan.labels,
                    datasets: [{
                        label: 'Jumlah',
                        data: data.jenisBantuan.data,
                        backgroundColor: 'rgb(59, 130, 246)',
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'top' } }
                }
            });

            // Horizontal Bar Chart
            if (charts.sebaranChart) charts.sebaranChart.destroy();
            charts.sebaranChart = new Chart(document.getElementById('sebaranChart'), {
                type: 'bar',
                data: {
                    labels: data.sebaranKecamatan.labels,
                    datasets: [{
                        label: 'Pengangguran',
                        data: data.sebaranKecamatan.data,
                        backgroundColor: 'rgb(168, 85, 247)',
                        borderRadius: 8
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    plugins: { legend: { position: 'top' } }
                }
            });
        }

        // Fungsi render tabel ranking
        function renderRanking(rankingData) {
            const rankingBody = document.getElementById('ranking-table');
            rankingBody.innerHTML = '';
            
            rankingData.forEach((item, index) => {
                const statusColor = {
                    'Menunggu': 'bg-yellow-100 text-yellow-800',
                    'Disetujui': 'bg-green-100 text-green-800',
                    'Proses': 'bg-blue-100 text-blue-800'
                }[item.status] || 'bg-gray-100 text-gray-800';
                
                const row = `<tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3">${index + 1}</td>
                    <td class="p-3 font-medium">${item.nama}</td>
                    <td class="p-3">
                        <div class="flex items-center gap-2">
                            <div class="w-16 bg-gray-200 rounded-full h-2">
                                <div class="bg-red-500 h-2 rounded-full" style="width: ${item.skor}%"></div>
                            </div>
                            <span class="text-sm font-semibold">${item.skor}</span>
                        </div>
                    </td>
                    <td class="p-3">
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">${item.rekomendasi}</span>
                    </td>
                    <td class="p-3">
                        <span class="px-2 py-1 rounded text-xs ${statusColor}">${item.status}</span>
                    </td>
                </tr>`;
                rankingBody.innerHTML += row;
            });
        }

        // Tampilkan alert
        function showAlert(message, isError = false) {
            const alertBox = document.getElementById('alertInfo');
            const alertMsg = document.getElementById('alertMessage');
            alertMsg.textContent = message;
            alertBox.classList.remove('hidden');
            if (isError) {
                alertBox.classList.remove('bg-blue-50', 'border-blue-500');
                alertBox.classList.add('bg-red-50', 'border-red-500');
            } else {
                alertBox.classList.remove('bg-red-50', 'border-red-500');
                alertBox.classList.add('bg-blue-50', 'border-blue-500');
            }
            setTimeout(() => alertBox.classList.add('hidden'), 3000);
        }

        // Load semua data
        function loadDashboard() {
            showAlert('Memuat data dashboard...', false);
            
            // Simulasi loading (nanti ganti dengan fetch API)
            setTimeout(() => {
                renderCharts(mockData);
                renderRanking(mockData.ranking);
                showAlert('Data berhasil dimuat!', false);
                
                // Update last update time
                const now = new Date();
                document.getElementById('lastUpdate').innerHTML = `Last update: ${now.toLocaleTimeString()}`;
            }, 500);
        }

        // Refresh ranking
        document.getElementById('refreshRanking')?.addEventListener('click', () => {
            showAlert('Refreshing data ranking...', false);
            setTimeout(() => {
                renderRanking(mockData.ranking);
                showAlert('Ranking berhasil di-refresh!', false);
            }, 500);
        });

        // Export button
        document.getElementById('exportBtn')?.addEventListener('click', () => {
            showAlert('Fitur export akan segera terintegrasi dengan Person 5 (Excel/PDF)', false);
            // Nanti panggil API dari Person 5
        });

        // Filter periode
        document.getElementById('periodeFilter')?.addEventListener('change', (e) => {
            const periode = e.target.value;
            showAlert(`Menampilkan data ${periode} bulan terakhir`, false);
            // Nanti panggil API dengan parameter periode
        });

        // Close alert
        document.getElementById('closeAlert')?.addEventListener('click', () => {
            document.getElementById('alertInfo').classList.add('hidden');
        });

        // Initial load
        loadDashboard();
    });
</script>
@endsection