@extends('layouts.app')

@section('title', 'Ajukan Bantuan Baru')

@section('content')
<div class="max-w-xl mx-auto">
    <div class="bg-white border border-gray-200 rounded-2xl overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center gap-3 px-6 py-4 border-b border-gray-100">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                 style="background: #E6F1FB;">
                <svg class="w-4 h-4" style="color: #185FA5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-semibold text-gray-800">Ajukan bantuan baru</h2>
                <p class="text-xs text-gray-400 mt-0.5">Isi formulir di bawah dengan lengkap dan benar</p>
            </div>
        </div>

        {{-- Form --}}
        <form action="{{ route('pengajuan-bantuan.store') }}" method="POST" class="p-6 space-y-5">
            @csrf

            {{-- Jenis Bantuan --}}
            <div>
                <label for="jenis_bantuan" class="block text-xs font-medium text-gray-600 mb-1.5">
                    Jenis bantuan <span class="text-red-400">*</span>
                </label>
                <select name="jenis_bantuan" id="jenis_bantuan" required
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
                    <option value="">Pilih jenis bantuan</option>
                    <option value="subsidi_upah"  {{ old('jenis_bantuan') == 'subsidi_upah'  ? 'selected' : '' }}>Subsidi upah</option>
                    <option value="pelatihan"     {{ old('jenis_bantuan') == 'pelatihan'     ? 'selected' : '' }}>Pelatihan kerja</option>
                    <option value="modal_umkm"    {{ old('jenis_bantuan') == 'modal_umkm'    ? 'selected' : '' }}>Modal usaha UMKM</option>
                    <option value="lainnya"       {{ old('jenis_bantuan') == 'lainnya'       ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            {{-- Nominal --}}
            <div>
                <label for="nominal_diajukan" class="block text-xs font-medium text-gray-600 mb-1.5">
                    Nominal diajukan <span class="text-gray-400 font-normal">(opsional)</span>
                </label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-3 flex items-center text-xs font-medium text-gray-400 pointer-events-none">
                        Rp
                    </span>
                    <input type="number" name="nominal_diajukan" id="nominal_diajukan"
                           value="{{ old('nominal_diajukan') }}"
                           placeholder="0"
                           class="w-full pl-9 pr-3 py-2 text-sm border border-gray-200 rounded-lg
                                  focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
                </div>
                <p class="text-xs text-gray-400 mt-1">Kosongkan jika tidak ada nominal khusus</p>
            </div>

            {{-- Alasan --}}
            <div>
                <label for="alasan" class="block text-xs font-medium text-gray-600 mb-1.5">
                    Alasan pengajuan <span class="text-red-400">*</span>
                </label>
                <textarea name="alasan" id="alasan" rows="4" required
                          placeholder="Jelaskan alasan Anda mengajukan bantuan... (minimal 30 karakter)"
                          class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg resize-none
                                 focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">{{ old('alasan') }}</textarea>
                <p class="text-xs text-gray-400 mt-1">Minimal 30 karakter</p>
            </div>

            {{-- Actions --}}
            <div class="flex gap-2 pt-1">
                <button type="submit"
                        class="flex items-center gap-2 px-5 py-2.5 text-sm font-medium text-white rounded-lg transition"
                        style="background: #185FA5;"
                        onmouseover="this.style.background='#0C447C'"
                        onmouseout="this.style.background='#185FA5'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                    </svg>
                    Kirim pengajuan
                </button>
                <a href="{{ route('pengajuan-bantuan.index') }}"
                   class="px-5 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg transition text-center">
                    Batal
                </a>
            </div>

        </form>
    </div>
</div>
@endsection