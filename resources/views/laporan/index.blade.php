@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Laporan Pengajuan Bantuan</h1>
    
    <div class="mb-6">
        <a href="{{ route('laporan.export.excel') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-lg inline-block">
            📥 Export ke Excel (CSV)
        </a>
        <a href="{{ route('laporan.export.pdf') }}" 
   class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-lg inline-block ml-3">
    📄 Export ke PDF
</a>
    </div>

    <table class="w-full border-collapse border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border p-3">Nama</th>
                <th class="border p-3">Jenis Bantuan</th>
                <th class="border p-3">Status</th>
                <th class="border p-3">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengajuans as $p)
            <tr>
                <td class="border p-3">{{ $p->pencariKerja->name ?? '-' }}</td>
                <td class="border p-3">{{ str_replace('_', ' ', ucwords($p->jenis_bantuan)) }}</td>
                <td class="border p-3">{{ ucfirst($p->status) }}</td>
                <td class="border p-3">{{ $p->created_at->format('d M Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="4" class="text-center p-8">Belum ada data</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection