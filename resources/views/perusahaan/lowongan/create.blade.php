@extends('layouts.app')

@section('title', 'Posting Lowongan Baru')

@section('content')
<div style="max-width:700px;margin:0 auto;">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <h2 style="margin:0;">Posting Lowongan Baru</h2>
        <a href="{{ route('perusahaan.dashboard') }}" style="color:#4a5568;text-decoration:none;">← Kembali ke Dashboard</a>
    </div>

    @if($errors->any())
        <div class="alert alert-error">
            <ul style="margin:0;padding-left:20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('perusahaan.lowongan.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Posisi / Jabatan <span style="color:red">*</span></label>
            <input type="text" name="posisi" value="{{ old('posisi') }}" placeholder="contoh: Staff Administrasi" required>
            @error('posisi') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Deskripsi Pekerjaan <span style="color:red">*</span></label>
            <textarea name="deskripsi" rows="5" placeholder="Jelaskan tanggung jawab dan tugas pekerjaan..." required>{{ old('deskripsi') }}</textarea>
            @error('deskripsi') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label>Gaji Minimum (Rp) <span style="color:red">*</span></label>
                <input type="number" name="gaji_min" value="{{ old('gaji_min') }}" placeholder="contoh: 3000000" min="0" required>
                @error('gaji_min') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Gaji Maksimum (Rp)</label>
                <input type="number" name="gaji_max" value="{{ old('gaji_max') }}" placeholder="contoh: 5000000" min="0">
                @error('gaji_max') <div class="field-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Lokasi <span style="color:red">*</span></label>
            <input type="text" name="lokasi" value="{{ old('lokasi') }}" placeholder="contoh: Makassar, Sulawesi Selatan" required>
            @error('lokasi') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Skill yang Dibutuhkan <span style="color:red">*</span></label>
            <div id="skill-container" style="display:flex;flex-direction:column;gap:8px;">
                <div style="display:flex;gap:8px;">
                    <input type="text" name="skill_dibutuhkan[]" placeholder="contoh: Microsoft Excel" style="flex:1;" required>
                    <button type="button" onclick="tambahSkill()" style="padding:10px 14px;background:#38a169;border-radius:8px;white-space:nowrap;">+ Tambah</button>
                </div>
            </div>
            @error('skill_dibutuhkan') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label>Kuota Pelamar <span style="color:red">*</span></label>
                <input type="number" name="kuota" value="{{ old('kuota', 1) }}" min="1" required>
                @error('kuota') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Deadline Lamaran <span style="color:red">*</span></label>
                <input type="date" name="deadline" value="{{ old('deadline') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required>
                @error('deadline') <div class="field-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div style="display:flex;gap:12px;margin-top:8px;">
            <button type="submit" style="flex:1;padding:14px;font-size:1rem;">Posting Lowongan</button>
            <a href="{{ route('perusahaan.dashboard') }}"
               style="flex:1;text-align:center;padding:14px;background:#e2e8f0;color:#4a5568;border-radius:8px;text-decoration:none;font-size:1rem;">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
function tambahSkill() {
    const container = document.getElementById('skill-container');
    const div = document.createElement('div');
    div.style.cssText = 'display:flex;gap:8px;';
    div.innerHTML = `
        <input type="text" name="skill_dibutuhkan[]" placeholder="contoh: Komunikasi" style="flex:1;" required>
        <button type="button" onclick="this.parentElement.remove()" style="padding:10px 14px;background:#e53e3e;border-radius:8px;white-space:nowrap;">Hapus</button>
    `;
    container.appendChild(div);
}
</script>
@endsection