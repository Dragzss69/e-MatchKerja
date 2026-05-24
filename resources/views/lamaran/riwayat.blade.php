@extends('layouts.app')

@section('title', 'Riwayat Lamaran Saya')

@section('content')
<div class="container mt-4">
    <h2>Riwayat Lamaran Saya</h2>
    <p class="text-muted">Semua lamaran kerja yang pernah Anda kirim</p>

    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Posisi Lowongan</th>
                    <th>Perusahaan</th>
                    <th>Tanggal Lamar</th>
                    <th>Status Lamaran</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lamarans as $lamaran)
                <tr>
                    <td><strong>{{ $lamaran->lowongan->posisi }}</strong></td>
                    <td>{{ $lamaran->lowongan->perusahaan->name ?? '-' }}</td>
                    <td>{{ $lamaran->created_at->format('d M Y H:i') }}</td>
                    <td>
                        @php
                            $statusClass = match($lamaran->status) {
                                'pending' => 'bg-warning',
                                'dipanggil_wawancara' => 'bg-info',
                                'diterima' => 'bg-success',
                                'ditolak' => 'bg-danger',
                                default => 'bg-secondary'
                            };
                        @endphp
                        <span class="badge {{ $statusClass }} px-3 py-2">
                            {{ ucfirst(str_replace('_', ' ', $lamaran->status)) }}
                        </span>
                    </td>
                    <td>{{ $lamaran->catatan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5">
                        Anda belum pernah melamar lowongan apapun.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection