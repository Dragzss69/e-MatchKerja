@extends('layouts.app')

@section('title', 'Dashboard Pencari Kerja')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Pencari Kerja</h1>

    <!-- Profile Summary Card -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-semibold">Ahmad Subekti</h2>
                <p class="text-blue-100 mt-1">NIK: 3273********1234</p>
                <p class="text-blue-100">Jakarta Selatan, DKI Jakarta</p>
            </div>
            <div class="text-center bg-white/20 rounded-lg px-4 py-2">
                <div class="text-2xl font-bold">82</div>
                <div class="text-xs">Skor Kerentanan</div>
                <div class="text-xs text-yellow-200">Prioritas Tinggi</div>
            </div>
        </div>
    </div>

    <!-- Status & Progress -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-yellow-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Status Bantuan</div>
                    <div class="font-semibold text-yellow-600">Dalam Verifikasi</div>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-yellow-500 h-2 rounded-full" style="width: 50%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Proses verifikasi sedang berlangsung</p>
        </div>

        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-green-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Profil Kelengkapan</div>
                    <div class="font-semibold text-green-600">85%</div>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Lengkapi CV untuk meningkatkan match rate</p>
        </div>
    </div>

    <!-- Rekomendasi Lowongan -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-gray-700">Rekomendasi Lowongan untuk Anda</h2>
            <button id="refreshLowongan" class="text-blue-600 text-sm hover:underline">Refresh ↻</button>
        </div>
        <div class="space-y-3">
            <div class="border p-4 rounded-lg hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <span class="font-medium text-lg">Web Developer</span>
                        <div class="flex flex-wrap gap-2 mt-1">
                            <span class="text-sm text-gray-500">🏢 PT Maju Jaya</span>
                            <span class="text-sm text-gray-500">📍 8 km dari Anda</span>
                            <span class="text-sm text-green-600">💰 Rp 5-7 Juta</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-center bg-blue-100 rounded-lg px-3 py-1">
                            <span class="text-blue-600 font-bold">85%</span>
                            <div class="text-xs text-gray-600">Match</div>
                        </div>
                        <button onclick="showApplyAlert()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                            Lamar
                        </button>
                    </div>
                </div>
            </div>
            <div class="border p-4 rounded-lg hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <span class="font-medium text-lg">Admin</span>
                        <div class="flex flex-wrap gap-2 mt-1">
                            <span class="text-sm text-gray-500">🏢 PT Sejahtera</span>
                            <span class="text-sm text-gray-500">📍 3 km dari Anda</span>
                            <span class="text-sm text-green-600">💰 Rp 4-5 Juta</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-center bg-blue-100 rounded-lg px-3 py-1">
                            <span class="text-blue-600 font-bold">78%</span>
                            <div class="text-xs text-gray-600">Match</div>
                        </div>
                        <button onclick="showApplyAlert()" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                            Lamar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Rekomendasi Bantuan -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="font-semibold text-gray-700 mb-4">Rekomendasi Bantuan</h2>
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-start gap-3">
                    <div class="text-2xl">🎓</div>
                    <div>
                        <h3 class="font-semibold text-blue-800">Pelatihan Digital Marketing</h3>
                        <p class="text-sm text-gray-600 mt-1">Program pelatihan gratis 3 bulan untuk meningkatkan skill digital Anda.</p>
                        <div class="flex gap-2 mt-2">
                            <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Kuota: 50 peserta</span>
                            <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Deadline: 30 Juni 2026</span>
                        </div>
                    </div>
                </div>
                <button id="daftarBantuanBtn" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">
                    Daftar Sekarang
                </button>
            </div>
        </div>
    </div>

    <!-- Riwayat Lamaran -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="font-semibold text-gray-700 mb-4">Riwayat Lamaran</h2>
        <div class="space-y-2">
            <div class="flex justify-between items-center p-3 border rounded">
                <div>
                    <span class="font-medium">Frontend Developer</span>
                    <p class="text-sm text-gray-500">PT Maju Jaya • Dilamar: 15 Mei 2026</p>
                </div>
                <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Dalam Review</span>
            </div>
            <div class="flex justify-between items-center p-3 border rounded">
                <div>
                    <span class="font-medium">Backend Developer</span>
                    <p class="text-sm text-gray-500">PT Sejahtera • Dilamar: 10 Mei 2026</p>
                </div>
                <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-xs">Ditolak</span>
            </div>
        </div>
    </div>
</div>

<script>
    function showApplyAlert() {
        alert('Lamaran berhasil dikirim!\nSelanjutnya, perusahaan akan melakukan review.');
    }
    
    document.getElementById('refreshLowongan')?.addEventListener('click', () => {
        alert('Menyegarkan rekomendasi lowongan...');
    });
    
    document.getElementById('daftarBantuanBtn')?.addEventListener('click', () => {
        alert('Pendaftaran pelatihan berhasil!\nSilakan cek email untuk informasi lebih lanjut.');
    });
</script>
@endsection