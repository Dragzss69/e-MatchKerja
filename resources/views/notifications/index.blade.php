@extends('layouts.app')

@section('title', 'Notifikasi Saya')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Notifikasi Saya</h1>
            <p class="text-xs text-slate-400 font-medium">Melacak riwayat perubahan status permohonan bantuan sosial Anda</p>
        </div>
        
        @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.markAllRead') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl border border-slate-200 bg-white hover:bg-slate-50 text-xs font-bold text-slate-700 transition">
                    <i class="fa-solid fa-check-double text-[10px] text-slate-400"></i> Tandai Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    <!-- Notification Cards List -->
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-6 space-y-3">
        @forelse($notifications as $notif)
            <a href="{{ route('notifications.markRead', $notif->id) }}" 
               class="block p-5 rounded-2xl border transition duration-150 text-xs relative group
                      {{ is_null($notif->read_at) ? 'bg-indigo-50/40 border-indigo-200 hover:bg-indigo-50/60' : 'bg-white border-slate-200/60 hover:bg-slate-50/50' }}">
                
                <div class="flex justify-between items-start gap-4">
                    <div class="space-y-1.5">
                        <p class="text-slate-800 font-bold leading-normal text-sm group-hover:text-indigo-600 transition">
                            {{ $notif->data['pesan'] }}
                        </p>
                        
                        <div class="flex flex-wrap items-center gap-2 text-[10px] text-slate-400 font-semibold uppercase tracking-wider">
                            <span>Bantuan: {{ str_replace('_', ' ', $notif->data['jenis_bantuan'] ?? 'Info') }}</span>
                            <span>•</span>
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-bold uppercase tracking-wider
                                @if(($notif->data['status'] ?? '') == 'pending') bg-amber-100 text-amber-800
                                @elseif(($notif->data['status'] ?? '') == 'diverifikasi') bg-sky-100 text-sky-800
                                @elseif(($notif->data['status'] ?? '') == 'disetujui') bg-emerald-100 text-emerald-800
                                @elseif(($notif->data['status'] ?? '') == 'ditolak') bg-rose-100 text-rose-800
                                @else bg-purple-100 text-purple-800 @endif">
                                {{ $notif->data['status'] ?? 'Info' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="text-right shrink-0 flex flex-col items-end gap-1.5">
                        <span class="text-[10px] font-medium text-slate-400">{{ $notif->created_at->diffForHumans() }}</span>
                        @if(is_null($notif->read_at))
                            <span class="inline-block h-2 w-2 rounded-full bg-indigo-600 shadow-sm shadow-indigo-200"></span>
                        @endif
                    </div>
                </div>
            </a>
        @empty
            <div class="py-16 text-center text-slate-400">
                <i class="fa-regular fa-bell text-4xl text-slate-300 mb-3 block"></i>
                <p class="text-sm font-bold">Belum ada notifikasi masuk</p>
                <p class="text-xs text-slate-400 max-w-xs mx-auto mt-1">Anda akan menerima pemberitahuan di sini ketika terdapat perubahan status pada berkas Anda.</p>
            </div>
        @endforelse

        @if($notifications->hasPages())
            <div class="pt-4 border-t border-slate-100">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>

</div>
@endsection