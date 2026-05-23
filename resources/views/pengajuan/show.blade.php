@extends('layouts.app')

@section('title', 'Detail Pengajuan Bantuan')

@section('content')
@php
    $userRole = auth()->user()->roles->pluck('name')->toArray();
    $status = strtolower($pengajuan->status);
@endphp

<div class="max-w-4xl mx-auto space-y-6">
    
    <!-- Navigation Back -->
    <div class="flex items-center gap-3">
        <a href="{{ route('pengajuan-bantuan.index') }}" class="flex h-10 w-10 items-center justify-center rounded-xl bg-white border border-slate-200/80 shadow-sm text-slate-600 hover:text-slate-900 transition">
            <i class="fa-solid fa-arrow-left"></i>
        </a>
        <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Detail Pengajuan Bantuan</span>
    </div>

    <!-- Details Card -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-8 space-y-8">
        
        <!-- Header Info -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-slate-100 pb-6">
            <div class="space-y-1.5">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pencari Kerja / Pemohon</span>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 leading-none">{{ $pengajuan->pencariKerja->name ?? '-' }}</h2>
            </div>
            
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                @if($status == 'pending') bg-amber-50 text-amber-800 border border-amber-100/60
                @elseif($status == 'diverifikasi') bg-sky-50 text-sky-800 border border-sky-100/60
                @elseif($status == 'disetujui') bg-emerald-50 text-emerald-800 border border-emerald-100/60
                @elseif($status == 'ditolak') bg-rose-50 text-rose-800 border border-rose-100/60
                @else bg-purple-50 text-purple-800 border border-purple-100/60 @endif">
                {{ ucfirst($pengajuan->status) }}
            </span>
        </div>

        <!-- Metadata Info Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6">
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Jenis Bantuan</span>
                <p class="font-semibold text-slate-800 text-sm">{{ str_replace('_', ' ', ucwords($pengajuan->jenis_bantuan)) }}</p>
            </div>
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Nominal Diajukan</span>
                <p class="font-bold text-indigo-600 text-base">Rp {{ number_format($pengajuan->nominal_diajukan ?? 0, 0, ',', '.') }}</p>
            </div>
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Tanggal Pengajuan</span>
                <p class="font-semibold text-slate-800 text-sm">{{ $pengajuan->created_at->format('d M Y H:i') }}</p>
            </div>
            <div class="space-y-1 text-xs">
                <span class="font-bold text-slate-400 uppercase tracking-wider">Kecamatan Penempatan</span>
                <p class="font-semibold text-slate-800 text-sm">{{ $pengajuan->pencariKerja->jobSeekerProfile->alamat_ktp ?? '-' }}</p>
            </div>
        </div>

        <!-- Alasan -->
        <div class="space-y-2 text-xs">
            <span class="font-bold text-slate-400 uppercase tracking-wider">Alasan Pengajuan</span>
            <p class="text-sm text-slate-700 bg-slate-50 border border-slate-100/80 rounded-2xl p-5 leading-relaxed font-medium">
                {{ $pengajuan->alasan }}
            </p>
        </div>

        <!-- Log & Verification Statuses -->
        @if($pengajuan->catatan_verifikasi || $pengajuan->catatan_approval)
            <div class="space-y-4 pt-6 border-t border-slate-100">
                <h3 class="text-xs font-bold text-slate-900 uppercase tracking-widest flex items-center gap-1.5">
                    <i class="fa-solid fa-clipboard-list text-slate-400"></i> Catatan Riwayat Proses
                </h3>
                
                <div class="space-y-3">
                    @if($pengajuan->catatan_verifikasi)
                        <div class="rounded-xl border border-slate-100 p-4 bg-slate-50/50 text-xs space-y-1">
                            <div class="flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase">
                                <span>Petugas Verifikasi: {{ $pengajuan->verifier->name ?? 'Petugas' }}</span>
                                <span>{{ $pengajuan->tanggal_verifikasi ? $pengajuan->tanggal_verifikasi->format('d M Y') : '' }}</span>
                            </div>
                            <p class="text-slate-600 font-semibold mt-1">{{ $pengajuan->catatan_verifikasi }}</p>
                        </div>
                    @endif

                    @if($pengajuan->catatan_approval)
                        <div class="rounded-xl border border-slate-100 p-4 bg-slate-50/50 text-xs space-y-1">
                            <div class="flex justify-between items-center text-[10px] font-bold text-slate-400 uppercase">
                                <span>Keputusan Admin: {{ $pengajuan->approver->name ?? 'Admin' }}</span>
                                <span>{{ $pengajuan->tanggal_approval ? $pengajuan->tanggal_approval->format('d M Y') : '' }}</span>
                            </div>
                            <p class="text-slate-600 font-semibold mt-1">{{ $pengajuan->catatan_approval }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        <!-- Action / Forms Area (Depends on User Role) -->
        <div class="pt-6 border-t border-slate-100 space-y-4">
            
            <!-- 1. JOb Seeker Actions (Pending status only) -->
            @if(in_array('job_seeker', $userRole) && $status == 'pending')
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('pengajuan-bantuan.edit', $pengajuan->id) }}" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-amber-50 hover:bg-amber-100 border border-amber-200 text-amber-700 text-xs font-bold transition">
                        <i class="fa-solid fa-pen-to-square"></i> Edit Pengajuan
                    </a>
                    
                    <form action="{{ route('pengajuan-bantuan.destroy', $pengajuan->id) }}" method="POST" class="m-0" onsubmit="return confirm('Yakin ingin membatalkan pengajuan bantuan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-700 text-xs font-bold transition">
                            <i class="fa-regular fa-trash-can"></i> Batalkan Pengajuan
                        </button>
                    </form>
                </div>
            @endif

            <!-- 2. Verifier Actions (Pending status only) -->
            @if(in_array('verifier', $userRole) && $status == 'pending')
                <div class="rounded-2xl border border-slate-200/80 p-5 bg-slate-50/50 space-y-4">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-user-shield text-slate-400"></i> Tindakan Petugas Verifikasi
                    </h4>
                    
                    <form action="{{ route('pengajuan-bantuan.verifikasi', $pengajuan->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Catatan Hasil Verifikasi Lapangan</label>
                            <textarea name="catatan_verifikasi" rows="2" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs bg-white focus:border-indigo-500 focus:outline-none" placeholder="Tuliskan catatan detail mengenai kebenaran NIK dan kondisi ekonomi..."></textarea>
                        </div>
                        <div class="flex gap-3">
                            <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-xs font-bold text-white transition">
                                <i class="fa-solid fa-circle-check"></i> Verifikasi Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- 3. Admin Actions (Diverifikasi status only) -->
            @if(in_array('admin', $userRole) && $status == 'diverifikasi')
                <div class="rounded-2xl border border-slate-200/80 p-5 bg-slate-50/50 space-y-4">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-check text-indigo-500"></i> Keputusan Persetujuan Admin Dinas
                    </h4>
                    
                    <div class="space-y-4">
                        <form action="{{ route('pengajuan-bantuan.approve', $pengajuan->id) }}" method="POST" class="space-y-3">
                            @csrf
                            <div class="flex flex-col gap-1.5">
                                <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Catatan Persetujuan Bantuan</label>
                                <textarea name="catatan_approval" rows="2" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs bg-white focus:border-indigo-500 focus:outline-none" placeholder="Tuliskan alasan persetujuan atau catatan pencairan..."></textarea>
                            </div>
                            <div class="flex gap-3">
                                <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-xs font-bold text-white transition">
                                    <i class="fa-solid fa-check"></i> Setujui Pengajuan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- 4. Verifier & Admin: Tolak Action (Pending / Diverifikasi status only) -->
            @if(array_intersect(['verifier', 'admin'], $userRole) && in_array($status, ['pending', 'diverifikasi']))
                <div class="rounded-2xl border border-slate-200/80 p-5 bg-slate-50/50 space-y-4">
                    <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-circle-xmark text-rose-500"></i> Tolak Pengajuan
                    </h4>
                    <form action="{{ route('pengajuan-bantuan.tolak', $pengajuan->id) }}" method="POST" class="space-y-3" onsubmit="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                        @csrf
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Alasan Penolakan</label>
                            <textarea name="catatan_approval" rows="2" class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs bg-white focus:border-indigo-500 focus:outline-none" placeholder="Jelaskan alasan penolakan berkas atau kriteria yang belum terpenuhi..."></textarea>
                        </div>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-xs font-bold text-white transition">
                            <i class="fa-solid fa-ban"></i> Tolak Pengajuan
                        </button>
                    </form>
                </div>
            @endif

            <!-- 5. Admin: Salurkan Action (Disetujui status only) -->
            @if(in_array('admin', $userRole) && $status == 'disetujui')
                <div class="rounded-2xl border border-indigo-200 p-5 bg-indigo-50/30 space-y-4">
                    <h4 class="text-xs font-bold text-indigo-900 uppercase tracking-wider flex items-center gap-1.5">
                        <i class="fa-solid fa-file-invoice-dollar text-indigo-500"></i> Penyaluran Dana Bantuan (Disbursement)
                    </h4>
                    
                    <form action="{{ route('pengajuan-bantuan.salurkan', $pengajuan->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="flex flex-col gap-1.5">
                            <label class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Nomor Rekening Penerima & Bank <span class="text-rose-500">*</span></label>
                            <input type="text" name="rekening_penerima" required class="rounded-xl border border-slate-200 px-4 py-2.5 text-xs bg-white focus:border-indigo-500 focus:outline-none" placeholder="Contoh: Bank Mandiri - 1234567890 (a.n. Penerima)">
                        </div>
                        <button type="submit" class="inline-flex items-center gap-1.5 px-5 py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-xs font-bold text-white transition">
                            <i class="fa-solid fa-money-bill-transfer"></i> Tandai Telah Disalurkan
                        </button>
                    </form>
                </div>
            @endif

        </div>

    </div>

</div>
@endsection