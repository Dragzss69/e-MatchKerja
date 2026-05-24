@extends('layouts.app')

@section('title', 'Lengkapi Profil Pencari Kerja')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Lengkapi Profil Diri</h1>
            <p class="text-xs text-slate-400 font-medium mt-1">Lengkapi biodata diri Anda untuk pendaftaran bantuan sosial & karir</p>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
            <i class="fa-solid fa-user-plus"></i> Peran Aktif: Pencari Kerja
        </span>
    </div>

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="rounded-2xl bg-rose-50 p-4 border border-rose-200/80 text-rose-800 space-y-1">
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

    <!-- Form Container -->
    <div class="rounded-2xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-6 md:p-8">
        <form action="{{ route('jobseeker.profile.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Informasi Pribadi -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                    <div class="p-1.5 rounded-lg bg-indigo-100">
                        <i class="fa-solid fa-user text-indigo-600 text-sm"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Informasi Pribadi</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">NIK <span class="text-rose-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik') }}" 
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                               placeholder="16 digit NIK" maxlength="16" required>
                        @error('nik') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" 
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                               placeholder="Nama lengkap sesuai KTP" required>
                        @error('nama_lengkap') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" 
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        @error('tanggal_lahir') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="jenis_kelamin" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Alamat KTP <span class="text-rose-500">*</span></label>
                    <textarea name="alamat_ktp" rows="3" 
                              class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                              placeholder="Alamat lengkap sesuai KTP" required>{{ old('alamat_ktp') }}</textarea>
                    @error('alamat_ktp') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1.5">Nomor HP / WhatsApp <span class="text-rose-500">*</span></label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp') }}" 
                           class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                           placeholder="Contoh: 081234567890" required>
                    @error('no_hp') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Pendidikan & Pekerjaan -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                    <div class="p-1.5 rounded-lg bg-emerald-100">
                        <i class="fa-solid fa-graduation-cap text-emerald-600 text-sm"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Pendidikan & Pekerjaan</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Pendidikan Terakhir <span class="text-rose-500">*</span></label>
                        <select name="pendidikan_terakhir" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                            <option value="">Pilih Pendidikan</option>
                            <option value="sd" {{ old('pendidikan_terakhir') == 'sd' ? 'selected' : '' }}>SD / Sederajat</option>
                            <option value="smp" {{ old('pendidikan_terakhir') == 'smp' ? 'selected' : '' }}>SMP / Sederajat</option>
                            <option value="sma" {{ old('pendidikan_terakhir') == 'sma' ? 'selected' : '' }}>SMA / SMK</option>
                            <option value="d3" {{ old('pendidikan_terakhir') == 'd3' ? 'selected' : '' }}>D3</option>
                            <option value="s1" {{ old('pendidikan_terakhir') == 's1' ? 'selected' : '' }}>S1</option>
                            <option value="s2" {{ old('pendidikan_terakhir') == 's2' ? 'selected' : '' }}>S2</option>
                            <option value="s3" {{ old('pendidikan_terakhir') == 's3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('pendidikan_terakhir') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Status Kerja Saat Ini <span class="text-rose-500">*</span></label>
                        <select name="status_kerja_saat_ini" class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                            <option value="">Pilih Status</option>
                            <option value="menganggur" {{ old('status_kerja_saat_ini') == 'menganggur' ? 'selected' : '' }}>Menganggur</option>
                            <option value="bekerja_paruh_waktu" {{ old('status_kerja_saat_ini') == 'bekerja_paruh_waktu' ? 'selected' : '' }}>Bekerja Paruh Waktu</option>
                            <option value="bekerja_penuh" {{ old('status_kerja_saat_ini') == 'bekerja_penuh' ? 'selected' : '' }}>Bekerja Penuh</option>
                            <option value="wirausaha" {{ old('status_kerja_saat_ini') == 'wirausaha' ? 'selected' : '' }}>Wirausaha</option>
                        </select>
                        @error('status_kerja_saat_ini') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Lama Menganggur (bulan)</label>
                        <input type="number" name="lama_menganggur" value="{{ old('lama_menganggur', 0) }}" 
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                               min="0" placeholder="0">
                        @error('lama_menganggur') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Pendapatan Bulanan (Rp)</label>
                        <input type="number" name="pendapatan_bulanan" value="{{ old('pendapatan_bulanan', 0) }}" 
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                               min="0" placeholder="0">
                        @error('pendapatan_bulanan') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Jumlah Tanggungan</label>
                        <input type="number" name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan', 0) }}" 
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                               min="0" placeholder="0">
                        @error('jumlah_tanggungan') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Upload Dokumen -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                    <div class="p-1.5 rounded-lg bg-orange-100">
                        <i class="fa-solid fa-file-pdf text-orange-600 text-sm"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Upload Dokumen</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Scan Kartu Tanda Penduduk (KTP) <span class="text-rose-500">*</span></label>
                        <input type="file" name="file_ktp" accept=".pdf,.jpg,.jpeg,.png" 
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm bg-slate-50 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                        <p class="text-[10px] text-slate-400 mt-1">Format: PDF, JPG, PNG. Maks: 2MB</p>
                        @error('file_ktp') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5">Scan Kartu Keluarga (KK)</label>
                        <input type="file" name="file_kk" accept=".pdf,.jpg,.jpeg,.png" 
                               class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm bg-slate-50 focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        <p class="text-[10px] text-slate-400 mt-1">Format: PDF, JPG, PNG. Maks: 2MB</p>
                        @error('file_kk') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="space-y-4">
                <div class="flex items-center gap-2 pb-2 border-b border-slate-200">
                    <div class="p-1.5 rounded-lg bg-purple-100">
                        <i class="fa-solid fa-chart-line text-purple-600 text-sm"></i>
                    </div>
                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Informasi Tambahan</h3>
                </div>
                
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_penerima_bansos_lain" value="1" 
                               {{ old('is_penerima_bansos_lain') ? 'checked' : '' }}
                               class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-slate-700">Saya saat ini sedang menerima bantuan sosial dari program lain</span>
                    </label>
                    @error('is_penerima_bansos_lain') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-200">
                <div class="flex flex-col sm:flex-row gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-save"></i> Simpan Profil
                    </button>
                    <a href="{{ route('dashboard') }}" class="px-6 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 rounded-xl transition text-center">
                        Batal
                    </a>
                </div>
                <p class="text-xs text-slate-400 text-center mt-4">
                    <i class="fa-regular fa-circle-info"></i>
                    Data Anda akan diverifikasi oleh petugas sebelum dapat mengajukan bantuan.
                </p>
            </div>

        </form>
    </div>
</div>
@endsection