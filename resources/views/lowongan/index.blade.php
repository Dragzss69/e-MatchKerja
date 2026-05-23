@extends('layouts.app')

@section('title', 'Daftar Lowongan Kerja')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Lowongan Kerja</h2>
    </div>

    <!-- Search -->
    <div class="mb-4">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari posisi, perusahaan, atau lokasi...">
    </div>

    <div class="row" id="lowonganContainer">
        @forelse($lowongans as $lowongan)
        <div class="col-md-6 col-lg-4 mb-4 lowongan-card">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">{{ $lowongan->posisi }}</h5>
                    <p class="text-muted">
                        <strong>{{ $lowongan->perusahaan->name ?? 'Perusahaan' }}</strong>
                    </p>
                    
                    <p><strong>Gaji:</strong> Rp {{ number_format($lowongan->gaji_min) }} 
                       @if($lowongan->gaji_max) - Rp {{ number_format($lowongan->gaji_max) }} @endif
                    </p>
                    <p><strong>Lokasi:</strong> {{ $lowongan->lokasi }}</p>
                    <p><strong>Batas Pendaftaran:</strong> <span class="text-danger">{{ $lowongan->deadline->format('d M Y') }}</span></p>

                    <a href="{{ route('lowongan.show', $lowongan->id) }}" class="btn btn-primary w-100 mt-3">
                        Lihat Detail & Lamar
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <p>Belum ada lowongan kerja yang tersedia saat ini.</p>
        </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $lowongans->links() }}
    </div>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let cards = document.querySelectorAll('.lowongan-card');
        cards.forEach(card => {
            let content = card.textContent.toLowerCase();
            card.style.display = content.includes(filter) ? '' : 'none';
        });
    });
</script>
@endsection
