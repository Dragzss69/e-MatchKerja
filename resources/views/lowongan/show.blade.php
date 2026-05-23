@extends('layouts.app')

@section('title', $lowongan->posisi ?? 'Detail Lowongan')

@section('content')
<div style="max-width:700px;margin:0 auto;">

    {{-- Info Lowongan --}}
    <div style="background:#fff;border-radius:12px;padding:24px;margin-bottom:24px;border:1px solid #e2e8f0;">
        <h2 style="margin:0 0 4px;">{{ $lowongan->posisi }}</h2>
        <p style="color:#4a5568;margin:0 0 20px;">{{ $lowongan->perusahaan->name ?? 'Tidak diketahui' }}</p>

        <table style="width:100%;border-collapse:collapse;">
            <tr>
                <td style="padding:8px 0;color:#718096;width:140px;">Lokasi</td>
                <td style="padding:8px 0;font-weight:600;">{{ $lowongan->lokasi }}</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#718096;">Gaji</td>
                <td style="padding:8px 0;font-weight:600;">
                    Rp {{ number_format($lowongan->gaji_min) }}
                    @if($lowongan->gaji_max) – Rp {{ number_format($lowongan->gaji_max) }} @endif
                </td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#718096;">Kuota</td>
                <td style="padding:8px 0;">{{ $lowongan->kuota }} orang</td>
            </tr>
            <tr>
                <td style="padding:8px 0;color:#718096;">Deadline</td>
                <td style="padding:8px 0;">{{ $lowongan->deadline->format('d M Y') }}</td>
            </tr>
        </table>

        <hr style="margin:20px 0;border:none;border-top:1px solid #e2e8f0;">

        <h5 style="margin:0 0 8px;">Deskripsi Pekerjaan</h5>
        <p style="color:#4a5568;line-height:1.7;">{{ $lowongan->deskripsi }}</p>

        <h5 style="margin:16px 0 8px;">Skill yang Dibutuhkan</h5>
        <div style="display:flex;flex-wrap:wrap;gap:8px;">
            @php
                $skills = is_array($lowongan->skill_dibutuhkan)
                    ? $lowongan->skill_dibutuhkan
                    : json_decode($lowongan->skill_dibutuhkan, true) ?? [];
            @endphp
            @foreach($skills as $skill)
                <span style="background:#ebf4ff;color:#2b6cb0;padding:4px 12px;border-radius:20px;font-size:0.85rem;">
                    {{ $skill }}
                </span>
            @endforeach
        </div>
    </div>

    {{-- Form Lamar --}}
    @auth
        @if(auth()->user()->hasRole('job_seeker'))
            @if($sudahLamar)
                <div class="alert alert-success" style="text-align:center;">
                    ✅ Anda sudah melamar posisi ini. Pantau status di <a href="{{ route('lamaran.riwayat') }}">Riwayat Lamaran</a>.
                </div>
            @else
                <div style="background:#fff;border-radius:12px;padding:24px;border:1px solid #e2e8f0;">
                    <h4 style="margin:0 0 20px;">Form Lamaran</h4>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-error">{{ session('error') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-error">
                            <ul style="margin:0;padding-left:20px;">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('lamaran.store', $lowongan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Upload CV <span style="color:red">*</span> <small style="color:#718096;">(PDF, maks 5MB)</small></label>
                            <input type="file" name="cv" accept=".pdf" required>
                            @error('cv') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Upload Portofolio <small style="color:#718096;">(PDF/DOC, maks 10MB, opsional)</small></label>
                            <input type="file" name="portofolio" accept=".pdf,.doc,.docx">
                            @error('portofolio') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <div class="form-group">
                            <label>Catatan / Pesan (opsional)</label>
                            <textarea name="catatan" rows="3" placeholder="Tulis pesan singkat untuk perusahaan...">{{ old('catatan') }}</textarea>
                            @error('catatan') <div class="field-error">{{ $message }}</div> @enderror
                        </div>

                        <button type="submit" style="width:100%;padding:14px;font-size:1rem;">
                            Kirim Lamaran
                        </button>
                    </form>
                </div>
            @endif
        @endif
    @else
        <div style="text-align:center;padding:24px;background:#fff;border-radius:12px;border:1px solid #e2e8f0;">
            <p style="margin:0 0 12px;color:#4a5568;">Silakan login untuk melamar posisi ini.</p>
            <a href="{{ route('login') }}" style="background:#2b6cb0;color:#fff;padding:12px 24px;border-radius:8px;text-decoration:none;">
                Login Sekarang
            </a>
        </div>
    @endauth

</div>
@endsection