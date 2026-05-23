@extends('layouts.app')

@section('title', 'Edit Lowongan')

@section('content')
<div style="max-width:700px;margin:0 auto;">

    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:24px;">
        <h2 style="margin:0;">Edit Lowongan</h2>
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

    <form action="{{ route('lowongan.update', $lowongan->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Posisi / Jabatan <span style="color:red">*</span></label>
            <input type="text" name="posisi" value="{{ old('posisi', $lowongan->posisi) }}" required>
            @error('posisi') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Deskripsi Pekerjaan <span style="color:red">*</span></label>
            <textarea name="deskripsi" rows="5" required>{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
            @error('deskripsi') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label>Gaji Minimum (Rp) <span style="color:red">*</span></label>
                <input type="number" name="gaji_min" value="{{ old('gaji_min', $lowongan->gaji_min) }}" min="0" required>
                @error('gaji_min') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Gaji Maksimum (Rp)</label>
                <input type="number" name="gaji_max" value="{{ old('gaji_max', $lowongan->gaji_max) }}" min="0">
                @error('gaji_max') <div class="field-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Lokasi <span style="color:red">*</span></label>
            <input type="text" name="lokasi" value="{{ old('lokasi', $lowongan->lokasi) }}" required>
            @error('lokasi') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label>Skill yang Dibutuhkan <span style="color:red">*</span></label>
            <div id="skill-container" style="display:flex;flex-direction:column;gap:8px;">
                @php
                    $skills = is_array($lowongan->skill_dibutuhkan)
                        ? $lowongan->skill_dibutuhkan
                        : json_decode($lowongan->skill_dibutuhkan, true) ?? [];
                @endphp
                @foreach($skills as $index => $skill)
                <div style="display:flex;gap:8px;">
                    <input type="text" name="skill_dibutuhkan[]" value="{{ $skill }}" style="flex:1;" required>
                    @if($index === 0)
                        <button type="button" onclick="tambahSkill()" style="padding:10px 14px;background:#38a169;border-radius:8px;white-space:nowrap;">+ Tambah</button>
                    @else
                        <button type="button" onclick="this.parentElement.remove()" style="padding:10px 14px;background:#e53e3e;border-radius:8px;white-space:nowrap;">Hapus</button>
                    @endif
                </div>
                @endforeach
                @if(empty($skills))
                <div style="display:flex;gap:8px;">
                    <input type="text" name="skill_dibutuhkan[]" style="flex:1;" required>
                    <button type="button" onclick="tambahSkill()" style="padding:10px 14px;background:#38a169;border-radius:8px;white-space:nowrap;">+ Tambah</button>
                </div>
                @endif
            </div>
            @error('skill_dibutuhkan') <div class="field-error">{{ $message }}</div> @enderror
        </div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;">
            <div class="form-group">
                <label>Kuota Pelamar <span style="color:red">*</span></label>
                <input type="number" name="kuota" value="{{ old('kuota', $lowongan->kuota) }}" min="1" required>
                @error('kuota') <div class="field-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label>Deadline Lamaran <span style="color:red">*</span></label>
                <input type="date" name="deadline" value="{{ old('deadline', $lowongan->deadline->format('Y-m-d')) }}" required>
                @error('deadline') <div class="field-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label>Status Lowongan</label>
            <select name="status">
                <option value="aktif" {{ $lowongan->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                <option value="nonaktif" {{ $lowongan->status == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
        </div>

        <div style="display:flex;gap:12px;margin-top:8px;">
            <button type="submit" style="flex:1;padding:14px;font-size:1rem;">Simpan Perubahan</button>
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
        <input type="text" name="skill_dibutuhkan[]" style="flex:1;" required>
        <button type="button" onclick="this.parentElement.remove()" style="padding:10px 14px;background:#e53e3e;border-radius:8px;white-space:nowrap;">Hapus</button>
    `;
    container.appendChild(div);
}
</script>
@endsection