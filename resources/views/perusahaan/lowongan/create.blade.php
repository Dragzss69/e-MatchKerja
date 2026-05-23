@extends('layouts.app')

@section('title', 'Posting Lowongan Kerja')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('lowongan.index') }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200/80 shadow-sm text-slate-600 hover:text-slate-900 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Buat Lowongan Kerja Baru</h1>
                <p class="text-xs text-slate-400 font-medium">Pasang lowongan baru untuk memikat talenta terbaik</p>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-150">
            <i class="fa-solid fa-briefcase"></i> Peran Aktif: Perusahaan
        </span>
    </div>

    <!-- Form Container -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-8">
        <form action="{{ route('perusahaan.lowongan.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Row 1: Posisi & Kuota -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Posisi / Jabatan Pekerjaan <span class="text-rose-500">*</span></label>
                    <input type="text" name="posisi" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('posisi') }}" required placeholder="Contoh: Admin Kantor / HR Manager">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Kuota Kebutuhan (Orang) <span class="text-rose-500">*</span></label>
                    <input type="number" name="kuota" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('kuota', 1) }}" required min="1">
                </div>
            </div>

            <!-- Row 2: Gaji Minimum & Maksimum -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Gaji Minimum (Rp) <span class="text-rose-500">*</span></label>
                    <input type="number" name="gaji_min" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('gaji_min') }}" required placeholder="Contoh: 3000000">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Gaji Maksimum (Rp)</label>
                    <input type="number" name="gaji_max" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('gaji_max') }}" placeholder="Contoh: 6000000">
                </div>
            </div>

            <!-- Row 3: Lokasi & Deadline -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Lokasi Kantor / Penempatan <span class="text-rose-500">*</span></label>
                    <input type="text" name="lokasi" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('lokasi') }}" required placeholder="Contoh: Jl. Diponegoro No. 4, Palu">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Deadline Pendaftaran <span class="text-rose-500">*</span></label>
                    <input type="date" name="deadline" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('deadline') }}" required>
                </div>
            </div>

            <!-- Row 4: Kecamatan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Kecamatan Penempatan</label>
                    <input type="text" name="kecamatan" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('kecamatan') }}" placeholder="Contoh: Palu Timur">
                </div>
            </div>

            <!-- Deskripsi Pekerjaan -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Deskripsi Pekerjaan & Kualifikasi <span class="text-rose-500">*</span></label>
                <textarea name="deskripsi" rows="5" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required placeholder="Jelaskan secara detail mengenai deskripsi pekerjaan ini...">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- Skill yang dibutuhkan -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Skill Kunci Yang Dibutuhkan</label>
                <select name="skill_dibutuhkan[]" class="rounded-xl border border-slate-200 p-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" multiple size="6">
                    <option value="Microsoft Office" {{ in_array('Microsoft Office', old('skill_dibutuhkan', [])) ? 'selected' : '' }}>Microsoft Office</option>
                    <option value="Laravel" {{ in_array('Laravel', old('skill_dibutuhkan', [])) ? 'selected' : '' }}>Laravel</option>
                    <option value="PHP" {{ in_array('PHP', old('skill_dibutuhkan', [])) ? 'selected' : '' }}>PHP</option>
                    <option value="MySQL" {{ in_array('MySQL', old('skill_dibutuhkan', [])) ? 'selected' : '' }}>MySQL</option>
                    <option value="Desain Grafis" {{ in_array('Desain Grafis', old('skill_dibutuhkan', [])) ? 'selected' : '' }}>Desain Grafis</option>
                    <option value="Bahasa Inggris" {{ in_array('Bahasa Inggris', old('skill_dibutuhkan', [])) ? 'selected' : '' }}>Bahasa Inggris</option>
                    <option value="Administrasi" {{ in_array('Administrasi', old('skill_dibutuhkan', [])) ? 'selected' : '' }}>Administrasi</option>
                </select>
                <span class="text-[10px] text-slate-400 font-medium">Tekan **Ctrl** (Windows) atau **Command** (Mac) untuk memilih lebih dari satu skill.</span>
            </div>

            <!-- Form Action -->
            <div class="flex gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-xs font-bold text-white shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Publikasikan Lowongan
                </button>
                <a href="{{ route('lowongan.index') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-100 px-6 py-3 text-xs font-bold text-slate-700 hover:bg-slate-200 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection