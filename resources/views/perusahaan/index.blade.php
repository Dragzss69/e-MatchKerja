@extends('layouts.app')

@section('title', 'Daftar Pelamar - ' . $lowongan->posisi)

@section('content')
<div class="container mt-4">
    <h3>Daftar Pelamar - {{ $lowongan->posisi }}</h3>
    <p class="text-muted">Lowongan ID: #{{ $lowongan->id }}</p>

    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Nama Pencari Kerja</th>
                <th>Status Lamaran</th>
                <th>Tanggal Lamar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lamarans as $lamaran)
            <tr>
                <td>{{ $lamaran->user->name ?? 'Tidak ada nama' }}</td>
                <td>
                    <span class="badge 
                        @if($lamaran->status == 'pending') bg-warning
                        @elseif($lamaran->status == 'dipanggil_wawancara') bg-info
                        @elseif($lamaran->status == 'diterima') bg-success
                        @else bg-danger @endif">
                        {{ ucfirst(str_replace('_', ' ', $lamaran->status)) }}
                    </span>
                </td>
                <td>{{ $lamaran->created_at->format('d M Y H:i') }}</td>
                <td>
                    <a href="#" class="btn btn-info btn-sm">Detail</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-4">Belum ada pelamar untuk lowongan ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection