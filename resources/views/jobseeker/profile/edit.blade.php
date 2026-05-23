@extends('layouts.app')

@section('title', 'Perbarui Profil Diri')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('dashboard') }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200/80 shadow-sm text-slate-600 hover:text-slate-900 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Perbarui Profil Diri</h1>
                <p class="text-xs text-slate-400 font-medium">Ubah rincian biodata diri Anda untuk pendaftaran bantuan sosial & karir</p>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
            <i class="fa-solid fa-pen-to-square"></i> Peran Aktif: Pencari Kerja
        </span>
    </div>

    <!-- Form Container -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-8">
        
        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="rounded-2xl bg-rose-50 p-4 border border-rose-200/80 text-rose-800 space-y-1 mb-6">
                <div class="flex gap-2 items-center text-xs font-bold mb-1">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm"></i>
                    <span>Terdapat beberapa kesalahan input:</span>
                </div>
                <ul class="text-[11px] list-disc list-inside text-rose-700 leading-relaxed pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('jobseeker-profiles.update', $profile->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Row 1: NIK & Nama Lengkap -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Nomor Induk Kependudukan (NIK) <span class="text-rose-500">*</span></label>
                    <input type="text" name="nik" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('nik', $profile->nik) }}" required placeholder="16 Digit NIK Anda" maxlength="16">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Nama Lengkap (Sesuai KTP) <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama_lengkap" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('nama_lengkap', $profile->nama_lengkap) }}" required placeholder="Nama Lengkap Anda">
                </div>
            </div>

            <!-- Row 2: Tanggal Lahir & Jenis Kelamin -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Tanggal Lahir <span class="text-rose-500">*</span></label>
                    <input type="date" name="tanggal_lahir" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('tanggal_lahir', $profile->tanggal_lahir?->format('Y-m-d')) }}" required>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <select name="jenis_kelamin" class="rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        <option value="L" {{ old('jenis_kelamin', $profile->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ old('jenis_kelamin', $profile->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>

            <!-- Row 3: No HP & Pendidikan Terakhir -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Nomor Telepon / WhatsApp <span class="text-rose-500">*</span></label>
                    <input type="text" name="no_hp" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('no_hp', $profile->no_hp) }}" required placeholder="Contoh: 08123456789">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Pendidikan Terakhir <span class="text-rose-500">*</span></label>
                    <select name="pendidikan_terakhir" class="rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        <option value="SD" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'SD' ? 'selected' : '' }}>SD</option>
                        <option value="SMP" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'SMP' ? 'selected' : '' }}>SMP</option>
                        <option value="SMA/SMK" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'SMA/SMK' ? 'selected' : '' }}>SMA/SMK</option>
                        <option value="D3" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'D3' ? 'selected' : '' }}>D3</option>
                        <option value="S1" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'S1' ? 'selected' : '' }}>S1</option>
                        <option value="S2" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'S2' ? 'selected' : '' }}>S2</option>
                    </select>
                </div>
            </div>

            <!-- Row 4: Status Kerja & Lama Menganggur -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Status Kerja Saat Ini <span class="text-rose-500">*</span></label>
                    <select name="status_kerja_saat_ini" class="rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        <option value="Menganggur" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'Menganggur' ? 'selected' : '' }}>Menganggur</option>
                        <option value="Bekerja" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'Bekerja' ? 'selected' : '' }}>Bekerja</option>
                        <option value="Freelance" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                        <option value="Wirausaha" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                    </select>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Lama Menganggur (Bulan)</label>
                    <input type="number" name="lama_menganggur" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('lama_menganggur', $profile->lama_menganggur) }}" min="0">
                </div>
            </div>

            <!-- Row 5: Pendapatan & Tanggungan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Pendapatan Bulanan (Rp)</label>
                    <input type="number" name="pendapatan_bulanan" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('pendapatan_bulanan', intval($profile->pendapatan_bulanan)) }}" min="0">
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Jumlah Tanggungan (Orang)</label>
                    <input type="number" name="jumlah_tanggungan" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('jumlah_tanggungan', $profile->jumlah_tanggungan) }}" min="0">
                </div>
            </div>

            <!-- Alamat KTP -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Alamat Lengkap (Sesuai KTP) <span class="text-rose-500">*</span></label>
                <textarea name="alamat_ktp" rows="3" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required placeholder="Jelaskan secara lengkap alamat tempat tinggal Anda...">{{ old('alamat_ktp', $profile->alamat_ktp) }}</textarea>
            </div>

            <!-- Documents Upload Section (Optional for update) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Upload KTP Baru (Opsional)</label>
                    <input type="file" name="file_ktp" class="rounded-xl border border-slate-200 px-4 py-3 text-xs bg-slate-50 focus:border-indigo-500 focus:outline-none">
                    <span class="text-[10px] text-slate-400 font-medium">Pilih berkas jika ingin mengganti KTP. Max: 5MB</span>
                </div>
                <div class="flex flex-col gap-1.5">
                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Upload KK Baru (Opsional)</label>
                    <input type="file" name="file_kk" class="rounded-xl border border-slate-200 px-4 py-3 text-xs bg-slate-50 focus:border-indigo-500 focus:outline-none">
                    <span class="text-[10px] text-slate-400 font-medium">Pilih berkas jika ingin mengganti Kartu Keluarga. Max: 5MB</span>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-xs font-bold text-white shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan Profil
                </button>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-100 px-6 py-3 text-xs font-bold text-slate-700 hover:bg-slate-200 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection