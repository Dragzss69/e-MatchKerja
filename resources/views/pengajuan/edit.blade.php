@extends('layouts.app')

@section('title', 'Edit Pengajuan Bantuan')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('pengajuan-bantuan.show', $pengajuan->id) }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200/80 shadow-sm text-slate-600 hover:text-slate-900 transition">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Edit Pengajuan Bantuan</h1>
                <p class="text-xs text-slate-400 font-medium">Perbarui rincian pengajuan bantuan sosial Anda</p>
            </div>
        </div>
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-amber-50 text-amber-700 text-xs font-bold border border-amber-200">
            <i class="fa-solid fa-pen-to-square"></i> Status: Pending
        </span>
    </div>

    <!-- Form Container -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-8">
        <form action="{{ route('pengajuan-bantuan.update', $pengajuan->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Jenis Bantuan -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Jenis Bantuan Yang Diajukan <span class="text-rose-500">*</span></label>
                <select name="jenis_bantuan" class="rounded-xl border border-slate-200 px-4 py-3 text-sm bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required>
                    <option value="">Pilih Jenis Bantuan</option>
                    <option value="subsidi_upah" {{ old('jenis_bantuan', $pengajuan->jenis_bantuan) == 'subsidi_upah' ? 'selected' : '' }}>Subsidi Upah</option>
                    <option value="pelatihan" {{ old('jenis_bantuan', $pengajuan->jenis_bantuan) == 'pelatihan' ? 'selected' : '' }}>Pelatihan Kerja</option>
                    <option value="modal_umkm" {{ old('jenis_bantuan', $pengajuan->jenis_bantuan) == 'modal_umkm' ? 'selected' : '' }}>Modal Usaha UMKM</option>
                    <option value="lainnya" {{ old('jenis_bantuan', $pengajuan->jenis_bantuan) == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>

            <!-- Nominal Diajukan -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Nominal Anggaran Yang Diajukan (Rp)</label>
                <input type="number" name="nominal_diajukan" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" value="{{ old('nominal_diajukan', $pengajuan->nominal_diajukan) }}" placeholder="Contoh: 2500000">
            </div>

            <!-- Alasan Pengajuan -->
            <div class="flex flex-col gap-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wide">Alasan Pengajuan <span class="text-rose-500">*</span></label>
                <textarea name="alasan" rows="5" class="rounded-xl border border-slate-200 px-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500" required placeholder="Jelaskan kondisi ekonomi Anda atau tujuan penggunaan dana bantuan (Minimal 30 karakter)...">{{ old('alasan', $pengajuan->alasan) }}</textarea>
                <span class="text-[10px] text-slate-400 font-medium">Berikan alasan yang meyakinkan agar memudahkan Petugas Verifikasi dalam menilai kelayakan profil Anda.</span>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-4 pt-4 border-t border-slate-100">
                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-6 py-3 text-xs font-bold text-white shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">
                    <i class="fa-solid fa-save mr-2"></i> Update Pengajuan
                </button>
                <a href="{{ route('pengajuan-bantuan.show', $pengajuan->id) }}" class="inline-flex items-center justify-center rounded-xl bg-slate-100 px-6 py-3 text-xs font-bold text-slate-700 hover:bg-slate-200 transition">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection
