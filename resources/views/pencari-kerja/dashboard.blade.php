@extends('layouts.app')

@section('title', 'Dashboard Pencari Kerja')

@section('content')
<div class="space-y-6">
    <h1 class="text-2xl font-bold text-gray-800">Dashboard Pencari Kerja</h1>

    <!-- Profile Summary Card -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow p-6 text-white">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h2 class="text-xl font-semibold">{{ Auth::user()->name ?? 'Pencari Kerja' }}</h2>
                <p class="text-blue-100 mt-1">NIK: {{ Auth::user()->nik ?? 'Belum diisi' }}</p>
                <p class="text-blue-100">{{ Auth::user()->alamat ?? 'Alamat belum diisi' }}</p>
            </div>
            <div class="text-center bg-white/20 rounded-lg px-4 py-2">
                <div class="text-2xl font-bold">{{ $skorKerentanan ?? '78' }}</div>
                <div class="text-xs">Skor Kerentanan</div>
                <div class="text-xs {{ ($skorKerentanan ?? 78) > 75 ? 'text-yellow-200' : 'text-green-200' }}">
                    {{ ($skorKerentanan ?? 78) > 75 ? 'Prioritas Tinggi' : 'Prioritas Normal' }}
                </div>
            </div>
        </div>
    </div>

    <!-- Status & Progress -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Status Bantuan (INTEGRASI DENGAN PERSON 5) -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-yellow-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Status Bantuan Terakhir</div>
                    <div class="font-semibold 
                        @if($pengajuanTerbaru)
                            @switch($pengajuanTerbaru->status)
                                @case('pending') text-yellow-600 @break
                                @case('diverifikasi') text-blue-600 @break
                                @case('disetujui') text-green-600 @break
                                @case('ditolak') text-red-600 @break
                                @default text-gray-600
                            @endswitch
                        @else
                            text-gray-600
                        @endif
                    ">
                        @if($pengajuanTerbaru)
                            @switch($pengajuanTerbaru->status)
                                @case('pending') Menunggu Verifikasi @break
                                @case('diverifikasi') Terverifikasi @break
                                @case('disetujui') Disetujui @break
                                @case('ditolak') Ditolak @break
                                @default {{ ucfirst($pengajuanTerbaru->status) }}
                            @endswitch
                        @else
                            Belum Ada Pengajuan
                        @endif
                    </div>
                </div>
            </div>
            @if($pengajuanTerbaru)
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="h-2 rounded-full 
                        @switch($pengajuanTerbaru->status)
                            @case('pending') bg-yellow-500 @break
                            @case('diverifikasi') bg-blue-500 @break
                            @case('disetujui') bg-green-500 @break
                            @case('ditolak') bg-red-500 @break
                            @default bg-gray-500
                        @endswitch
                    " style="width: {{ 
                        match($pengajuanTerbaru->status) {
                            'pending' => '25',
                            'diverifikasi' => '50',
                            'disetujui' => '75',
                            'ditolak' => '100',
                            default => '0'
                        }
                    }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2">
                    Pengajuan: {{ $pengajuanTerbaru->created_at->format('d/m/Y') }}
                </p>
                <a href="{{ route('pengajuan-bantuan.show', $pengajuanTerbaru->id) }}" 
                   class="text-blue-600 text-sm mt-2 inline-block hover:underline">
                    Lihat Detail →
                </a>
            @else
                <div class="mt-2">
                    <a href="{{ route('pengajuan-bantuan.create') }}" 
                       class="text-blue-600 text-sm hover:underline">
                        + Ajukan Bantuan Sekarang
                    </a>
                </div>
            @endif
        </div>

        <!-- Profil Kelengkapan -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex items-center gap-3 mb-3">
                <div class="bg-green-100 p-2 rounded-full">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <div class="text-gray-500 text-sm">Profil Kelengkapan</div>
                    <div class="font-semibold text-green-600">{{ $profilKelengkapan ?? '85' }}%</div>
                </div>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2">
                <div class="bg-green-500 h-2 rounded-full" style="width: {{ $profilKelengkapan ?? '85' }}%"></div>
            </div>
            <p class="text-xs text-gray-500 mt-2">Lengkapi CV dan data diri untuk meningkatkan match rate</p>
        </div>
    </div>

    <!-- Rekomendasi Lowongan (INTEGRASI DENGAN PERSON 2) -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-gray-700">Rekomendasi Lowongan untuk Anda</h2>
            <button id="refreshLowongan" class="text-blue-600 text-sm hover:underline">Refresh ↻</button>
        </div>
        <div class="space-y-3" id="rekomendasiLowonganContainer">
            @forelse($rekomendasiLowongan ?? [] as $lowongan)
            <div class="border p-4 rounded-lg hover:shadow-md transition">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <span class="font-medium text-lg">{{ $lowongan['posisi'] ?? $lowongan->posisi ?? 'Lowongan' }}</span>
                        <div class="flex flex-wrap gap-2 mt-1">
                            <span class="text-sm text-gray-500">🏢 {{ $lowongan['perusahaan'] ?? $lowongan->perusahaan ?? 'Perusahaan' }}</span>
                            <span class="text-sm text-gray-500">📍 {{ $lowongan['jarak'] ?? $lowongan->jarak ?? '?' }} km dari Anda</span>
                            <span class="text-sm text-green-600">💰 {{ $lowongan['gaji'] ?? $lowongan->gaji ?? 'Rp 4-7 Juta' }}</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="text-center bg-blue-100 rounded-lg px-3 py-1">
                            <span class="text-blue-600 font-bold">{{ $lowongan['matchScore'] ?? $lowongan->match_score ?? '80' }}%</span>
                            <div class="text-xs text-gray-600">Match</div>
                        </div>
                        <button onclick="showApplyAlert('{{ $lowongan['posisi'] ?? $lowongan->posisi ?? 'Lowongan' }}')" 
                                class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                            Lamar
                        </button>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-6">
                <p class="text-gray-500">Belum ada rekomendasi lowongan.</p>
                <p class="text-xs text-gray-400 mt-1">Lengkapi profil Anda untuk mendapatkan rekomendasi.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Rekomendasi Bantuan (INTEGRASI DENGAN PERSON 2) -->
    <div class="bg-white rounded-lg shadow p-4">
        <h2 class="font-semibold text-gray-700 mb-4">Rekomendasi Bantuan</h2>
        @if($rekomendasiBantuan)
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-lg p-4">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="flex items-start gap-3">
                        <div class="text-2xl">
                            @if($rekomendasiBantuan['jenis'] == 'pelatihan') 🎓
                            @elseif($rekomendasiBantuan['jenis'] == 'subsidi_upah') 💰
                            @elseif($rekomendasiBantuan['jenis'] == 'modal_umkm') 🏪
                            @else 📝 @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-blue-800">{{ $rekomendasiBantuan['judul'] ?? 'Pelatihan Digital Marketing' }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $rekomendasiBantuan['deskripsi'] ?? 'Program pelatihan gratis untuk meningkatkan skill digital Anda.' }}</p>
                            <div class="flex gap-2 mt-2">
                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Kuota: {{ $rekomendasiBantuan['kuota'] ?? '50' }} peserta</span>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">Deadline: {{ $rekomendasiBantuan['deadline'] ?? '30 Juni 2026' }}</span>
                            </div>
                        </div>
                    </div>
                    <button id="daftarBantuanBtn" 
                            data-jenis="{{ $rekomendasiBantuan['jenis'] ?? 'pelatihan' }}"
                            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition whitespace-nowrap">
                        Daftar Sekarang
                    </button>
                </div>
            </div>
        @else
            <div class="text-center py-6 bg-gray-50 rounded-lg">
                <p class="text-gray-500">Belum ada rekomendasi bantuan.</p>
            </div>
        @endif
    </div>

    <!-- Riwayat Pengajuan Bantuan (INTEGRASI DENGAN PERSON 5) -->
    <div class="bg-white rounded-lg shadow p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold text-gray-700">Riwayat Pengajuan Bantuan</h2>
            <a href="{{ route('pengajuan-bantuan.index') }}" class="text-blue-600 text-sm hover:underline">Lihat Semua →</a>
        </div>
        <div class="space-y-2">
            @forelse($riwayatPengajuan ?? [] as $pengajuan)
            <div class="flex justify-between items-center p-3 border rounded hover:bg-gray-50">
                <div>
                    <span class="font-medium">
                        @if($pengajuan->jenis_bantuan == 'subsidi_upah') 💰 Subsidi Upah
                        @elseif($pengajuan->jenis_bantuan == 'pelatihan') 📚 Pelatihan
                        @elseif($pengajuan->jenis_bantuan == 'modal_umkm') 🏪 Modal UMKM
                        @else 📝 Lainnya @endif
                    </span>
                    <p class="text-sm text-gray-500">Diajukan: {{ $pengajuan->created_at->format('d/m/Y') }}</p>
                </div>
                <div class="flex items-center gap-3">
                    @php
                        $statusClass = [
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'diverifikasi' => 'bg-blue-100 text-blue-800',
                            'disetujui' => 'bg-green-100 text-green-800',
                            'ditolak' => 'bg-red-100 text-red-800',
                        ][$pengajuan->status] ?? 'bg-gray-100 text-gray-800';
                        
                        $statusText = [
                            'pending' => 'Menunggu',
                            'diverifikasi' => 'Diverifikasi',
                            'disetujui' => 'Disetujui',
                            'ditolak' => 'Ditolak',
                        ][$pengajuan->status] ?? $pengajuan->status;
                    @endphp
                    <span class="px-2 py-1 rounded text-xs {{ $statusClass }}">{{ $statusText }}</span>
                    <a href="{{ route('pengajuan-bantuan.show', $pengajuan->id) }}" 
                       class="text-blue-600 text-sm hover:underline">Detail</a>
                </div>
            </div>
            @empty
            <div class="text-center py-4">
                <p class="text-gray-500">Belum ada riwayat pengajuan bantuan.</p>
                <a href="{{ route('pengajuan-bantuan.create') }}" class="text-blue-600 text-sm hover:underline mt-1 inline-block">
                    + Ajukan Bantuan
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    function showApplyAlert(jobTitle) {
        alert('Lamaran untuk ' + jobTitle + ' berhasil dikirim!\nSelanjutnya, perusahaan akan melakukan review.');
    }
    
    document.getElementById('refreshLowongan')?.addEventListener('click', () => {
        alert('Menyegarkan rekomendasi lowongan...');
        location.reload();
    });
    
    document.getElementById('daftarBantuanBtn')?.addEventListener('click', function() {
        const jenis = this.dataset.jenis;
        alert('Pendaftaran ' + jenis + ' berhasil!\nSilakan cek email untuk informasi lebih lanjut.');
    });
</script>
@endsection