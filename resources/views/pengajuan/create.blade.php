@extends('layouts.app')

@section('title', 'Ajukan Bantuan Baru')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('pengajuan-bantuan.index') }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200/80 shadow-sm text-slate-600 hover:text-slate-900 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Ajukan Bantuan Baru</h1>
                <p class="text-xs text-slate-400 font-medium">Buat permohonan bantuan sosial baru ke instansi Dinas</p>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
            <i class="fa-solid fa-file-invoice-dollar"></i> Peran Aktif: Pencari Kerja
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

        <form action="{{ route('pengajuan-bantuan.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Jenis Bantuan -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Jenis Bantuan Yang Diperlukan <span class="text-rose-500">*</span></label>
                <select name="jenis_bantuan" class="rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                    <option value="">Pilih Jenis Bantuan</option>
                    <option value="subsidi_upah" {{ old('jenis_bantuan') == 'subsidi_upah' ? 'selected' : '' }}>Subsidi Upah</option>
                    <option value="pelatihan" {{ old('jenis_bantuan') == 'pelatihan' ? 'selected' : '' }}>Pelatihan Kerja</option>
                    <option value="modal_umkm" {{ old('jenis_bantuan') == 'modal_umkm' ? 'selected' : '' }}>Modal Usaha UMKM</option>
                    <option value="lainnya" {{ old('jenis_bantuan') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <!-- Nominal Diajukan -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Nominal Yang Diajukan (Rp)</label>
                <input type="number" name="nominal_diajukan" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('nominal_diajukan') }}" placeholder="Contoh: 2500000">
            </div>

            <!-- Alasan Pengajuan -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Alasan Detail Pengajuan Bantuan <span class="text-rose-500">*</span></label>
                <textarea name="alasan" rows="5" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required placeholder="Jelaskan kondisi ekonomi Anda atau tujuan pengajuan dana bantuan ini (Minimal 30 karakter)...">{{ old('alasan') }}</textarea>
                <span class="text-[10px] text-slate-400 font-medium">Penjelasan detail membantu Verifikator menyetujui ajuan Anda.</span>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-xs font-bold text-white shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Permohonan
                </button>
                <a href="{{ route('pengajuan-bantuan.index') }}" class="inline-flex items-center justify-center rounded-xl bg-slate-100 px-6 py-3 text-xs font-bold text-slate-700 hover:bg-slate-200 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection