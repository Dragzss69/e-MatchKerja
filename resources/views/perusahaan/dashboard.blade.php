@extends('layouts.app')

@section('title', 'Dashboard Perusahaan')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Perusahaan</h1>
        <button id="buatLowonganBtn" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Buat Lowongan Baru
        </button>
    </div>

    <!-- Statistik Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-sm">Total Lowongan</div>
                    <div class="text-2xl font-bold">5</div>
                </div>
                <div class="bg-blue-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-sm">Total Pelamar</div>
                    <div class="text-2xl font-bold">32</div>
                </div>
                <div class="bg-green-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-sm">Pelamar Direkomendasikan</div>
                    <div class="text-2xl font-bold text-green-600">8</div>
                </div>
                <div class="bg-purple-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-gray-500 text-sm">Match Rate</div>
                    <div class="text-2xl font-bold">68%</div>
                </div>
                <div class="bg-orange-100 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart: Statistik Lamaran per Lowongan -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="font-semibold text-gray-700 mb-4">Statistik Pelamar per Lowongan</h2>
        <canvas id="lamaranChart" height="150"></canvas>
    </div>

    <!-- Daftar Lowongan Aktif -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="font-semibold text-gray-700 mb-4">Lowongan Aktif</h2>
        <div class="space-y-3">
            <div class="border p-4 rounded-lg hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <span class="font-medium text-lg">Frontend Developer</span>
                        <div class="flex flex-wrap gap-2 mt-1">
                            <span class="text-sm text-gray-500">📅 Dibuat: 1 Mei 2026</span>
                            <span class="text-sm text-green-600">✅ Aktif</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">3</div>
                            <div class="text-xs text-gray-500">Pelamar</div>
                        </div>
                        <button onclick="openModalDetail('Frontend Developer', 3)" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
            <div class="border p-4 rounded-lg hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <span class="font-medium text-lg">Backend Developer</span>
                        <div class="flex flex-wrap gap-2 mt-1">
                            <span class="text-sm text-gray-500">📅 Dibuat: 10 Mei 2026</span>
                            <span class="text-sm text-green-600">✅ Aktif</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">5</div>
                            <div class="text-xs text-gray-500">Pelamar</div>
                        </div>
                        <button onclick="openModalDetail('Backend Developer', 5)" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
            <div class="border p-4 rounded-lg hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <span class="font-medium text-lg">UI/UX Designer</span>
                        <div class="flex flex-wrap gap-2 mt-1">
                            <span class="text-sm text-gray-500">📅 Dibuat: 15 Mei 2026</span>
                            <span class="text-sm text-green-600">✅ Aktif</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">2</div>
                            <div class="text-xs text-gray-500">Pelamar</div>
                        </div>
                        <button onclick="openModalDetail('UI/UX Designer', 2)" 
                                class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-600 transition">
                            Lihat Detail
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Detail Pelamar (Flowbite) -->
<div id="detailModal" tabindex="-1" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full bg-black bg-opacity-50">
    <div class="relative w-full max-w-2xl max-h-full mx-auto mt-20">
        <div class="relative bg-white rounded-lg shadow">
            <div class="flex items-center justify-between p-4 border-b rounded-t">
                <h3 class="text-xl font-semibold text-gray-900" id="modalTitle">
                    Detail Lowongan
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" onclick="closeModal()">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-6 space-y-4">
                <p class="text-gray-700" id="modalBody"></p>
                <div class="border-t pt-4">
                    <h4 class="font-semibold mb-2">Daftar Pelamar:</h4>
                    <ul id="pelamarList" class="space-y-2">
                        <!-- Dinamis -->
                    </ul>
                </div>
            </div>
            <div class="flex items-center p-4 border-t rounded-b">
                <button onclick="closeModal()" class="text-gray-500 bg-gray-100 hover:bg-gray-200 rounded-lg px-4 py-2 text-sm">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    // Chart untuk statistik lamaran
    const ctx = document.getElementById('lamaranChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Frontend Dev', 'Backend Dev', 'UI/UX Designer'],
            datasets: [{
                label: 'Jumlah Pelamar',
                data: [3, 5, 2],
                backgroundColor: 'rgb(59, 130, 246)',
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { position: 'top' }
            }
        }
    });

    // Modal functions
    function openModalDetail(jobTitle, totalPelamar) {
        document.getElementById('modalTitle').innerHTML = jobTitle;
        document.getElementById('modalBody').innerHTML = `Total pelamar: ${totalPelamar} orang`;
        
        // Mock data pelamar
        const pelamarList = [
            { nama: 'Ahmad Subekti', skor: 92, status: 'Direkomendasikan' },
            { nama: 'Budi Santoso', skor: 85, status: 'Direkomendasikan' },
            { nama: 'Citra Dewi', skor: 78, status: 'Perlu Review' }
        ];
        
        const listEl = document.getElementById('pelamarList');
        listEl.innerHTML = '';
        pelamarList.slice(0, totalPelamar).forEach(p => {
            const badgeColor = p.status === 'Direkomendasikan' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800';
            listEl.innerHTML += `
                <li class="flex justify-between items-center p-2 border rounded">
                    <span>${p.nama}</span>
                    <div class="flex items-center gap-2">
                        <span class="text-sm">Skor: ${p.skor}</span>
                        <span class="px-2 py-1 rounded text-xs ${badgeColor}">${p.status}</span>
                    </div>
                </li>
            `;
        });
        
        document.getElementById('detailModal').classList.remove('hidden');
    }
    
    function closeModal() {
        document.getElementById('detailModal').classList.add('hidden');
    }
    
    // Buat lowongan button
    document.getElementById('buatLowonganBtn')?.addEventListener('click', () => {
        alert('Fitur buat lowongan akan segera hadir!\nIntegrasi dengan Person 4 (CRUD Lowongan)');
    });
    
    // Tutup modal klik di luar
    document.getElementById('detailModal')?.addEventListener('click', (e) => {
        if (e.target === document.getElementById('detailModal')) closeModal();
    });
</script>
@endsection