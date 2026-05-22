@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Pengajuan Bantuan Saya</h1>
    
    <a href="{{ route('pengajuan-bantuan.create') }}" class="bg-blue-600 text-white px-5 py-3 rounded-lg mb-6 inline-block">
        + Ajukan Bantuan Baru
    </a>

    <table class="w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border p-3">No</th>
                <th class="border p-3">Jenis Bantuan</th>
                <th class="border p-3">Nominal</th>
                <th class="border p-3">Status</th>
                <th class="border p-3">Tanggal</th>
                <th class="border p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $item)
            <tr class="border-t hover:bg-gray-50">
                <td class="border p-3">{{ $loop->iteration }}</td>
                <td class="border p-3">{{ str_replace('_', ' ', ucwords($item->jenis_bantuan)) }}</td>
                <td class="border p-3">Rp {{ number_format($item->nominal_diajukan ?? 0) }}</td>
                <td class="border p-3">
                    <span class="px-3 py-1 rounded-full text-sm
                        @if($item->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($item->status == 'diverifikasi') bg-blue-100 text-blue-800
                        @elseif($item->status == 'disetujui') bg-green-100 text-green-800
                        @elseif($item->status == 'ditolak') bg-red-100 text-red-800
                        @else bg-purple-100 text-purple-800 @endif">
                        {{ ucfirst($item->status) }}
                    </span>
                </td>
                <td class="border p-3">{{ $item->created_at->format('d M Y') }}</td>
                <td class="border p-3">
                    <a href="{{ route('pengajuan-bantuan.show', $item) }}" class="text-blue-600 hover:underline">Detail</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="6" class="text-center py-10">Belum ada pengajuan</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection