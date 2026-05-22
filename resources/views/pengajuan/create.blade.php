@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto mt-10">
    <div class="bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-2xl font-bold mb-6">Ajukan Bantuan Baru</h2>

        <form action="{{ route('pengajuan-bantuan.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Jenis Bantuan</label>
                <select name="jenis_bantuan" class="w-full border border-gray-300 rounded-lg px-4 py-3" required>
                    <option value="">Pilih Jenis Bantuan</option>
                    <option value="subsidi_upah">Subsidi Upah</option>
                    <option value="pelatihan">Pelatihan Kerja</option>
                    <option value="modal_umkm">Modal Usaha UMKM</option>
                    <option value="lainnya">Lainnya</option>
                </select>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Nominal Diajukan (Rp)</label>
                <input type="number" name="nominal_diajukan" 
                       class="w-full border border-gray-300 rounded-lg px-4 py-3" 
                       placeholder="Contoh: 2500000">
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium mb-2">Alasan Pengajuan <span class="text-red-500">*</span></label>
                <textarea name="alasan" rows="5" 
                          class="w-full border border-gray-300 rounded-lg px-4 py-3" 
                          placeholder="Jelaskan alasan Anda mengajukan bantuan..." required></textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium">
                    Kirim Pengajuan
                </button>
                <a href="{{ route('pengajuan-bantuan.index') }}" 
                   class="bg-gray-300 hover:bg-gray-400 px-8 py-3 rounded-lg font-medium">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection