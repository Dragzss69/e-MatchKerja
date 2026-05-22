@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-8">
        <h2 class="text-3xl font-bold mb-8 text-center">Detail Pengajuan Bantuan</h2>

        @php
            $userRole = auth()->user()->roles->pluck('name')->toArray();
        @endphp

        <div class="grid grid-cols-2 gap-x-8 gap-y-6 mb-10">
            <div>
                <p class="text-gray-500 text-sm">Nama</p>
                <p class="font-semibold text-xl">{{ $pengajuan->pencariKerja->name ?? '-' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Status</p>
                <span class="inline-block px-5 py-2 rounded-full text-sm font-medium
                    @if(strtolower($pengajuan->status) == 'pending') bg-yellow-100 text-yellow-800
                    @elseif(strtolower($pengajuan->status) == 'diverifikasi') bg-blue-100 text-blue-800
                    @elseif(strtolower($pengajuan->status) == 'disetujui') bg-green-100 text-green-800
                    @elseif(strtolower($pengajuan->status) == 'ditolak') bg-red-100 text-red-800
                    @else bg-purple-100 text-purple-800 @endif">
                    {{ ucfirst($pengajuan->status) }}
                </span>
            </div>
        </div>

        <div class="space-y-6">
            <div>
                <p class="text-gray-500 text-sm">Jenis Bantuan</p>
                <p class="font-medium">{{ str_replace('_', ' ', ucwords($pengajuan->jenis_bantuan)) }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Nominal Diajukan</p>
                <p class="text-2xl font-semibold">Rp {{ number_format($pengajuan->nominal_diajukan ?? 0, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Alasan Pengajuan</p>
                <p class="bg-gray-50 p-6 rounded-xl text-gray-700">{{ $pengajuan->alasan }}</p>
            </div>
        </div>

        <hr class="my-10">

        <!-- TOMBOL AKSI -->
        <div class="flex flex-wrap gap-4">

            {{-- Pencari Kerja: Edit & Hapus (hanya saat pending) --}}
            @if(in_array('job_seeker', $userRole) && strtolower($pengajuan->status) == 'pending')
                <a href="{{ route('pengajuan-bantuan.edit', $pengajuan) }}"
                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-8 py-4 rounded-xl font-medium flex items-center gap-2 transition">
                    ✏️ Edit Pengajuan
                </a>
                <form action="{{ route('pengajuan-bantuan.destroy', $pengajuan) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white px-8 py-4 rounded-xl font-medium flex items-center gap-2 transition">
                        🗑️ Hapus Pengajuan
                    </button>
                </form>
            @endif

            {{-- Petugas Verifikasi: Verifikasi (hanya saat pending) --}}
            @if(in_array('verifier', $userRole) && strtolower($pengajuan->status) == 'pending')
                <form action="{{ route('pengajuan-bantuan.verifikasi', $pengajuan) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-xl font-medium flex items-center gap-2 transition">
                        ✅ Verifikasi Data
                    </button>
                </form>
            @endif

            {{-- Admin: Setujui (hanya saat diverifikasi) --}}
            @if(in_array('admin', $userRole) && strtolower($pengajuan->status) == 'diverifikasi')
                <form action="{{ route('pengajuan-bantuan.approve', $pengajuan) }}" method="POST">
                    @csrf
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-8 py-4 rounded-xl font-medium flex items-center gap-2 transition">
                        ✅ Setujui Pengajuan
                    </button>
                </form>
            @endif

            {{-- Verifier atau Admin: Tolak --}}
            @if(array_intersect(['verifier', 'admin'], $userRole) && in_array(strtolower($pengajuan->status), ['pending', 'diverifikasi']))
                <form action="{{ route('pengajuan-bantuan.tolak', $pengajuan) }}" method="POST"
                      onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">
                    @csrf
                    <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white px-8 py-4 rounded-xl font-medium flex items-center gap-2 transition">
                        ❌ Tolak Pengajuan
                    </button>
                </form>
            @endif

            {{-- Tombol Kembali (semua role) --}}
            <a href="{{ route('pengajuan-bantuan.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-8 py-4 rounded-xl font-medium flex items-center gap-2 transition">
                ← Kembali
            </a>

        </div>
    </div>
</div>
@endsection