@extends('layouts.app')

@section('title', 'Detail Pengajuan Bantuan')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="px-6 py-5" style="background: #185FA5;">
            <h2 class="text-lg font-medium text-white">Detail pengajuan bantuan</h2>
            <p class="text-sm mt-1" style="color: #B5D4F4;">Nomor pengajuan: #{{ $pengajuan->id }}</p>
        </div>

        @php $userRole = auth()->user()->roles->pluck('name')->toArray(); @endphp

        <div class="p-6">

            {{-- Status Badge --}}
            <div class="flex justify-end mb-6">
                @php
                    $statusConfig = [
                        'pending'      => ['icon' => 'ti-clock',        'label' => 'Menunggu verifikasi', 'class' => 'bg-yellow-50 text-yellow-700 border-yellow-200'],
                        'diverifikasi' => ['icon' => 'ti-checks',        'label' => 'Terverifikasi',        'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                        'disetujui'    => ['icon' => 'ti-circle-check',  'label' => 'Disetujui',            'class' => 'bg-green-50 text-green-700 border-green-200'],
                        'ditolak'      => ['icon' => 'ti-x',             'label' => 'Ditolak',              'class' => 'bg-red-50 text-red-700 border-red-200'],
                    ];
                    $cfg = $statusConfig[$pengajuan->status] ?? ['icon' => 'ti-info-circle', 'label' => ucfirst($pengajuan->status), 'class' => 'bg-purple-50 text-purple-700 border-purple-200'];
                @endphp
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-sm font-medium border {{ $cfg['class'] }}">
                    <i class="ti {{ $cfg['icon'] }} text-sm"></i>
                    {{ $cfg['label'] }}
                </span>
            </div>

            {{-- Progress Steps --}}
            <div class="flex items-start mb-8">
                @php
                    $steps = [
                        ['label' => 'Pengajuan',   'sub' => $pengajuan->created_at->format('d/m/Y'), 'done' => true],
                        ['label' => 'Verifikasi',  'sub' => 'Menunggu', 'done' => in_array($pengajuan->status, ['diverifikasi', 'disetujui'])],
                        ['label' => 'Persetujuan', 'sub' => 'Menunggu', 'done' => $pengajuan->status === 'disetujui'],
                    ];
                @endphp
                @foreach($steps as $i => $step)
                    <div class="flex-1 flex flex-col items-center gap-1.5">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-medium z-10
                            {{ $step['done'] ? 'bg-green-50 border border-green-200 text-green-700' : 'bg-gray-50 border border-gray-200 text-gray-400' }}">
                            @if($step['done'])
                                <i class="ti ti-check text-sm"></i>
                            @else
                                {{ $i + 1 }}
                            @endif
                        </div>
                        <p class="text-xs font-medium {{ $step['done'] ? 'text-gray-700' : 'text-gray-400' }}">{{ $step['label'] }}</p>
                        <p class="text-xs text-gray-400">{{ $step['sub'] }}</p>
                    </div>
                    @if(!$loop->last)
                        <div class="flex-shrink-0 h-px w-12 bg-gray-200 mt-4.5"></div>
                    @endif
                @endforeach
            </div>

            {{-- Info Grid --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-5">
                @php
                    $fields = [
                        ['label' => 'Nama pemohon',   'value' => $pengajuan->pencariKerja->name ?? '-'],
                        ['label' => 'Jenis bantuan',  'value' => str_replace('_', ' ', ucwords($pengajuan->jenis_bantuan))],
                        ['label' => 'Nominal diajukan','value' => null, 'nominal' => true],
                        ['label' => 'Tanggal pengajuan','value' => $pengajuan->created_at->format('d F Y, H:i')],
                    ];
                @endphp
                @foreach($fields as $field)
                    <div class="px-4 py-3 bg-gray-50 rounded-lg">
                        <p class="text-xs text-gray-500 mb-1">{{ $field['label'] }}</p>
                        @if(!empty($field['nominal']))
                            <p class="text-xl font-medium" style="color: #185FA5;">
                                Rp {{ number_format($pengajuan->nominal_diajukan ?? 0, 0, ',', '.') }}
                            </p>
                        @else
                            <p class="text-sm font-medium text-gray-800">{{ $field['value'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>

            {{-- Alasan --}}
            <div class="mb-6">
                <p class="text-xs text-gray-500 mb-2">Alasan pengajuan</p>
                <div class="px-4 py-3 bg-gray-50 rounded-lg border-l-2" style="border-left-color: #185FA5;">
                    <p class="text-sm text-gray-700 leading-relaxed">{{ $pengajuan->alasan }}</p>
                </div>
            </div>

            <hr class="border-gray-100 mb-5">

            {{-- Tombol Aksi --}}
            <div class="flex flex-wrap gap-2">
                @if(in_array('job_seeker', $userRole) && $pengajuan->status == 'pending')
                    <a href="#" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-amber-50 border border-amber-200 text-amber-700 hover:bg-amber-100 transition">
                        <i class="ti ti-edit text-sm"></i> Edit pengajuan
                    </a>
                    <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengajuan ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-red-50 border border-red-200 text-red-700 hover:bg-red-100 transition">
                            <i class="ti ti-trash text-sm"></i> Hapus pengajuan
                        </button>
                    </form>
                @endif

                @if(in_array('verifier', $userRole) && $pengajuan->status == 'pending')
                    <form action="{{ route('pengajuan-bantuan.verifikasi', $pengajuan) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-green-50 border border-green-200 text-green-700 hover:bg-green-100 transition">
                            <i class="ti ti-circle-check text-sm"></i> Verifikasi data
                        </button>
                    </form>
                @endif

                @if(in_array('admin', $userRole) && $pengajuan->status == 'diverifikasi')
                    <form action="{{ route('pengajuan-bantuan.approve', $pengajuan) }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-green-50 border border-green-200 text-green-700 hover:bg-green-100 transition">
                            <i class="ti ti-circle-check text-sm"></i> Setujui pengajuan
                        </button>
                    </form>
                @endif

                @if((in_array('verifier', $userRole) || in_array('admin', $userRole)) && in_array($pengajuan->status, ['pending', 'diverifikasi']))
                    <form action="{{ route('pengajuan-bantuan.tolak', $pengajuan) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-red-50 border border-red-200 text-red-700 hover:bg-red-100 transition">
                            <i class="ti ti-x text-sm"></i> Tolak pengajuan
                        </button>
                    </form>
                @endif

                <a href="{{ route('pengajuan-bantuan.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium bg-gray-100 border border-gray-200 text-gray-600 hover:bg-gray-200 transition">
                    <i class="ti ti-arrow-left text-sm"></i> Kembali
                </a>
            </div>

        </div>
    </div>
</div>
@endsection