@extends('layouts.app')

@section('title', 'Detail Pelamar')

@section('content')
<div style="max-width:700px;margin:0 auto;">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <h2 style="margin:0;">Detail Pelamar</h2>
        <a href="{{ route('perusahaan.dashboard') }}" style="color:#4a5568;text-decoration:none;">← Kembali ke Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    {{-- Info Pelamar --}}
    <div style="background:#f7fafc;border-radius:12px;padding:24px;margin-bottom:24px;border:1px solid #e2e8f0;">
        <h3 style="margin:0 0 16px;">{{ $lamaran->user->name }}</h3>
        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <td style="padding:8px 0;color:#4a5568;width:160px;">Email</td>
                <td style="padding:8px 0;font-weight:600;">{{ $lamaran->user->email }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#4a5568;">Melamar Posisi</td>
                <td style="padding:8px 0;font-weight:600;">{{ $lamaran->lowongan->posisi }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#4a5568;">Tanggal Lamar</td>
                <td style="padding:8px 0;">{{ $lamaran->created_at->format('d M Y, H:i') }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#4a5568;">Status</td>
                <td style="padding:8px 0;">
                    @php
                        $badgeColor = match($lamaran->status) {
                            'pending'             => '#d69e2e',
                            'dipanggil_wawancara' => '#3182ce',
                            'diterima'            => '#38a169',
                            'ditolak'             => '#e53e3e',
                            default               => '#718096',
                        };
                        $badgeLabel = match($lamaran->status) {
                            'pending'             => 'Menunggu Review',
                            'dipanggil_wawancara' => 'Dipanggil Wawancara',
                            'diterima'            => 'Diterima',
                            'ditolak'             => 'Ditolak',
                            default               => ucfirst($lamaran->status),
                        };
                    @endphp
                    <span style="background:{{ $badgeColor }};color:#fff;padding:4px 12px;border-radius:20px;font-size:0.85rem;">
                        {{ $badgeLabel }}
                    </span>
                </td>
            </tr>
            @if($lamaran->catatan)
            <tr>
                <td style="padding:8px 0;color:#4a5568;vertical-align:top;">Catatan</td>
                <td style="padding:8px 0;">{{ $lamaran->catatan }}</td>
            </tr>
            @endif
        </table>
    </div>

    {{-- Download File --}}
    <div style="background:#fff;border-radius:12px;padding:24px;margin-bottom:24px;border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 16px;">File Pelamar</h4>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">
            @if($lamaran->cv_path)
                <a href="{{ route('lamaran.download', [$lamaran->id, 'cv']) }}"
                   style="display:inline-flex;align-items:center;gap:8px;background:#2b6cb0;color:#fff;padding:12px 20px;border-radius:8px;text-decoration:none;font-weight:500;">
                    ⬇ Download CV (PDF)
                </a>
            @else
                <span style="color:#a0aec0;padding:12px 0;">Tidak ada file CV</span>
            @endif

            @if($lamaran->portofolio_path)
                <a href="{{ route('lamaran.download', [$lamaran->id, 'portofolio']) }}"
                   style="display:inline-flex;align-items:center;gap:8px;background:#38a169;color:#fff;padding:12px 20px;border-radius:8px;text-decoration:none;font-weight:500;">
                    ⬇ Download Portofolio
                </a>
            @else
                <span style="color:#a0aec0;padding:12px 0;">Tidak ada file portofolio</span>
            @endif
        </div>
    </div>

    {{-- Tombol Update Status --}}
    <div style="background:#fff;border-radius:12px;padding:24px;border:1px solid #e2e8f0;">
        <h4 style="margin:0 0 16px;">Update Status Lamaran</h4>
        <div style="display:flex;gap:12px;flex-wrap:wrap;">

            {{-- Tombol Dipanggil Wawancara --}}
            <form action="{{ route('lamaran.updateStatus', $lamaran->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="dipanggil_wawancara">
                <button type="submit"
                        style="background:#3182ce;color:#fff;border:none;padding:12px 20px;border-radius:8px;cursor:pointer;font-size:0.95rem;"
                        {{ $lamaran->status === 'dipanggil_wawancara' ? 'disabled' : '' }}>
                    📅 Panggil Wawancara
                </button>
            </form>

            {{-- Tombol Diterima --}}
            <form action="{{ route('lamaran.updateStatus', $lamaran->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="diterima">
                <button type="submit"
                        style="background:#38a169;color:#fff;border:none;padding:12px 20px;border-radius:8px;cursor:pointer;font-size:0.95rem;"
                        {{ $lamaran->status === 'diterima' ? 'disabled' : '' }}>
                    ✅ Terima Pelamar
                </button>
            </form>

            {{-- Tombol Ditolak --}}
            <form action="{{ route('lamaran.updateStatus', $lamaran->id) }}" method="POST"
                  onsubmit="return confirm('Yakin menolak pelamar ini?')">
                @csrf
                @method('PUT')
                <input type="hidden" name="status" value="ditolak">
                <button type="submit"
                        style="background:#e53e3e;color:#fff;border:none;padding:12px 20px;border-radius:8px;cursor:pointer;font-size:0.95rem;"
                        {{ $lamaran->status === 'ditolak' ? 'disabled' : '' }}>
                    ❌ Tolak Pelamar
                </button>
            </form>

        </div>
        <p style="color:#718096;font-size:0.85rem;margin-top:12px;">
            * Status yang dipilih akan muncul di halaman riwayat lamaran pencari kerja.
        </p>
    </div>

</div>
@endsection