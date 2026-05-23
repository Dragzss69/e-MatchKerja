@extends('layouts.app')

@section('title', 'Pengajuan Bantuan Saya')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Pengajuan Bantuan Saya</h1>
        <a href="{{ route('pengajuan-bantuan.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Ajukan Bantuan Baru
        </a>
    </div>

    <!-- Statistik Singkat -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-yellow-50 rounded-xl p-4 text-center border border-yellow-100">
            <div class="text-2xl font-bold text-yellow-600">{{ $pengajuans->where('status', 'pending')->count() }}</div>
            <div class="text-xs text-gray-600">Menunggu</div>
        </div>
        <div class="bg-blue-50 rounded-xl p-4 text-center border border-blue-100">
            <div class="text-2xl font-bold text-blue-600">{{ $pengajuans->where('status', 'diverifikasi')->count() }}</div>
            <div class="text-xs text-gray-600">Diverifikasi</div>
        </div>
        <div class="bg-green-50 rounded-xl p-4 text-center border border-green-100">
            <div class="text-2xl font-bold text-green-600">{{ $pengajuans->where('status', 'disetujui')->count() }}</div>
            <div class="text-xs text-gray-600">Disetujui</div>
        </div>
        <div class="bg-red-50 rounded-xl p-4 text-center border border-red-100">
            <div class="text-2xl font-bold text-red-600">{{ $pengajuans->where('status', 'ditolak')->count() }}</div>
            <div class="text-xs text-gray-600">Ditolak</div>
        </div>
    </div>

    <!-- Tabel Pengajuan -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis Bantuan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nominal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pengajuans as $item)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-3 text-sm text-gray-600">{{ $loop->iteration }}</td>
                        <td class="px-6 py-3 font-medium text-gray-800">{{ str_replace('_', ' ', ucwords($item->jenis_bantuan)) }}</td>
                        <td class="px-6 py-3 text-sm text-gray-600">Rp {{ number_format($item->nominal_diajukan ?? 0, 0, ',', '.') }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($item->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($item->status == 'diverifikasi') bg-blue-100 text-blue-800
                                @elseif($item->status == 'disetujui') bg-green-100 text-green-800
                                @elseif($item->status == 'ditolak') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-3 text-sm text-gray-500">{{ $item->created_at->format('d M Y') }}</td>
                        <td class="px-6 py-3">
                            <a href="{{ route('pengajuan-bantuan.show', $item) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">Detail →</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            Belum ada pengajuan bantuan
                            <div class="mt-2">
                                <a href="{{ route('pengajuan-bantuan.create') }}" class="text-blue-600 hover:underline">Ajukan sekarang</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="px-6 py-4 border-t">
            {{ $pengajuans->links() }}
        </div>
    </div>
</div>
@endsection