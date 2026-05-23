@extends('layouts.app')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-2xl p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold">Semua Notifikasi</h2>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                @csrf
                <button type="submit"
                        class="text-sm text-blue-600 hover:underline">
                    Tandai semua dibaca
                </button>
            </form>
            @endif
        </div>

        <div class="space-y-3">
            @forelse($notifications as $notif)
            <a href="{{ route('notifications.markRead', $notif->id) }}"
               class="block p-4 rounded-xl border transition hover:bg-gray-50
                      {{ is_null($notif->read_at) ? 'bg-blue-50 border-blue-200' : 'bg-white border-gray-200' }}">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            {{ $notif->data['pesan'] }}
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ str_replace('_', ' ', ucwords($notif->data['jenis_bantuan'])) }}
                            •
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs
                                @if($notif->data['status'] == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($notif->data['status'] == 'diverifikasi') bg-blue-100 text-blue-800
                                @elseif($notif->data['status'] == 'disetujui') bg-green-100 text-green-800
                                @elseif($notif->data['status'] == 'ditolak') bg-red-100 text-red-800
                                @elseif($notif->data['status'] == 'disalurkan') bg-purple-100 text-purple-800
                                @endif">
                                {{ ucfirst($notif->data['status']) }}
                            </span>
                        </p>
                    </div>
                    <div class="text-right shrink-0 ml-4">
                        <p class="text-xs text-gray-400">{{ $notif->created_at->diffForHumans() }}</p>
                        @if(is_null($notif->read_at))
                        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full mt-1"></span>
                        @endif
                    </div>
                </div>
            </a>
            @empty
            <div class="text-center py-12 text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-3 text-gray-300"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <p>Belum ada notifikasi</p>
            </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $notifications->links() }}
        </div>
    </div>
</div>
@endsection