@extends('layouts.app')

@section('title', 'Edit Profil Pencari Kerja')

@section('content')
<div class="max-w-4xl mx-auto">


    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 px-6 py-5">
            <h1 class="text-xl font-bold text-white">✏️ Edit Profil Anda</h1>
            <p class="text-indigo-100 text-sm mt-1">Perbarui data diri Anda</p>
        </div>

        <!-- Form -->
        <form action="{{ route('jobseeker.profile.update') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            @method('PUT')

            <!-- Informasi Pribadi -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-slate-700 border-b pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-user text-indigo-500"></i> Informasi Pribadi
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">NIK <span class="text-rose-500">*</span></label>
                        <input type="text" name="nik" value="{{ old('nik', $profile->nik) }}" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                               maxlength="16" required>
                        @error('nik') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Nama Lengkap <span class="text-rose-500">*</span></label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $profile->nama_lengkap) }}" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                               required>
                        @error('nama_lengkap') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Tanggal Lahir <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal_lahir" 
                               value="{{ old('tanggal_lahir', $profile->tanggal_lahir ? \Carbon\Carbon::parse($profile->tanggal_lahir)->format('Y-m-d') : '') }}" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                               required>
                        @error('tanggal_lahir') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Jenis Kelamin <span class="text-rose-500">*</span></label>
                        <select name="jenis_kelamin" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            <option value="">Pilih</option>
                            <option value="L" {{ old('jenis_kelamin', $profile->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $profile->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Alamat KTP <span class="text-rose-500">*</span></label>
                    <textarea name="alamat_ktp" rows="3" 
                              class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                              required>{{ old('alamat_ktp', $profile->alamat_ktp) }}</textarea>
                    @error('alamat_ktp') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-xs font-bold text-slate-600 mb-1">Nomor HP <span class="text-rose-500">*</span></label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp', $profile->no_hp) }}" 
                           class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                           required>
                    @error('no_hp') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Pendidikan & Pekerjaan -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-slate-700 border-b pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-graduation-cap text-indigo-500"></i> Pendidikan & Pekerjaan
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Pendidikan Terakhir <span class="text-rose-500">*</span></label>
                        <select name="pendidikan_terakhir" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
                            <option value="">Pilih</option>
                            <option value="sd" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'sd' ? 'selected' : '' }}>SD</option>
                            <option value="smp" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'smp' ? 'selected' : '' }}>SMP</option>
                            <option value="sma" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'sma' ? 'selected' : '' }}>SMA/SMK</option>
                            <option value="d3" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 'd3' ? 'selected' : '' }}>D3</option>
                            <option value="s1" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 's1' ? 'selected' : '' }}>S1</option>
                            <option value="s2" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 's2' ? 'selected' : '' }}>S2</option>
                            <option value="s3" {{ old('pendidikan_terakhir', $profile->pendidikan_terakhir) == 's3' ? 'selected' : '' }}>S3</option>
                        </select>
                        @error('pendidikan_terakhir') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
    <label class="block text-xs font-bold text-slate-600 mb-1">Status Kerja Saat Ini <span class="text-rose-500">*</span></label>
    <select name="status_kerja_saat_ini" class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm" required>
        <option value="">Pilih</option>
        <option value="menganggur" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'Menganggur' ? 'selected' : '' }}>Menganggur</option>
        <option value="bekerja_paruh_waktu" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'Bekerja' ? 'selected' : '' }}>Bekerja Paruh Waktu</option>
        <option value="bekerja_penuh" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'Bekerja' ? 'selected' : '' }}>Bekerja Penuh</option>
        <option value="wirausaha" {{ old('status_kerja_saat_ini', $profile->status_kerja_saat_ini) == 'Wirausaha' ? 'selected' : '' }}>Wirausaha</option>
    </select>
    @error('status_kerja_saat_ini') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Lama Menganggur (bulan)</label>
                        <input type="number" name="lama_menganggur" value="{{ old('lama_menganggur', $profile->lama_menganggur) }}" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                               min="0">
                        @error('lama_menganggur') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Pendapatan Bulanan (Rp)</label>
                        <input type="number" name="pendapatan_bulanan" value="{{ old('pendapatan_bulanan', $profile->pendapatan_bulanan) }}" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                               min="0">
                        @error('pendapatan_bulanan') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">Jumlah Tanggungan <span class="text-rose-500">*</span></label>
                        <input type="number" name="jumlah_tanggungan" value="{{ old('jumlah_tanggungan', $profile->jumlah_tanggungan) }}" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm"
                               min="0" required>
                        @error('jumlah_tanggungan') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Upload Dokumen -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-slate-700 border-b pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf text-red-500"></i> Upload Dokumen (Opsional)
                </h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">File KTP (PDF, maks 2MB)</label>
                        <input type="file" name="file_ktp" accept=".pdf" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @if($profile->file_ktp)
                            <p class="text-xs text-green-600 mt-1">✅ File KTP sudah ada</p>
                        @endif
                        @error('file_ktp') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1">File Kartu Keluarga (PDF, maks 2MB)</label>
                        <input type="file" name="file_kk" accept=".pdf" 
                               class="w-full rounded-xl border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        @if($profile->file_kk)
                            <p class="text-xs text-green-600 mt-1">✅ File KK sudah ada</p>
                        @endif
                        @error('file_kk') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="space-y-4">
                <h3 class="text-sm font-bold text-slate-700 border-b pb-2 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-indigo-500"></i> Informasi Tambahan
                </h3>
                
                <div>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_penerima_bansos_lain" value="1" 
                               {{ old('is_penerima_bansos_lain', $profile->is_penerima_bansos_lain) ? 'checked' : '' }}
                               class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-slate-700">Saya saat ini sedang menerima bantuan sosial dari program lain</span>
                    </label>
                    @error('is_penerima_bansos_lain') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t">
                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                        <i class="fa-solid fa-save"></i> Update Profil
                    </button>
                    <a href="{{ route('jobseeker.profile.show') }}" class="px-6 bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-3 rounded-xl transition flex items-center justify-center">
                        Batal
                    </a>
                </div>
                <p class="text-xs text-slate-400 text-center mt-3">
                    Pastikan data yang Anda masukkan sudah benar sebelum menyimpan.
                </p>
            </div>
        </form>
    </div>
</div>
@endsection