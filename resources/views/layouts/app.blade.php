<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'e-MatchKerja') }}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background: #f7fafc; 
            color: #1a202c; 
        }
        .container { 
            max-width: 1200px; 
            margin: 30px auto; 
            padding: 20px; 
        }
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            background: #2b6cb0; 
            color: white; 
            padding: 15px 25px; 
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .header h1 { margin: 0; font-size: 1.5rem; }
        .nav a { 
            color: white; 
            margin-left: 20px; 
            text-decoration: none; 
            font-weight: 500;
        }
        .nav a:hover { text-decoration: underline; }
        .alert { 
            padding: 12px 16px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
        }
        .alert-success { background: #c6f6d5; color: #22543d; }
        .small { font-size: 0.95rem; color: #4a5568; }
        .field-error { color: #c53030; font-size: 0.9rem; margin-top: 4px; }

        /* Notifikasi */
        .notif-wrapper { position: relative; display: inline-block; margin-left: 16px; vertical-align: middle; }
        .notif-btn { background: none; border: none; cursor: pointer; padding: 6px; position: relative; color: #4a5568; }
        .notif-btn:hover { color: #1a202c; background: none; }
        .notif-badge { position: absolute; top: 0; right: 0; background: #e53e3e; color: #fff;
                       font-size: 0.65rem; font-weight: 700; border-radius: 9999px;
                       padding: 1px 5px; line-height: 1.4; }
        .notif-dropdown { position: absolute; right: 0; top: calc(100% + 8px); width: 320px;
                          background: #fff; border-radius: 12px; box-shadow: 0 8px 30px rgba(0,0,0,0.12);
                          border: 1px solid #e2e8f0; z-index: 999; overflow: hidden; }
        .notif-header { display: flex; justify-content: space-between; align-items: center;
                        padding: 12px 16px; border-bottom: 1px solid #e2e8f0; background: #f7fafc; }
        .notif-header span { font-weight: 600; font-size: 0.95rem; color: #2d3748; }
        .notif-header-actions { display: flex; gap: 12px; }
        .notif-header-actions a,
        .notif-header-actions button { font-size: 0.78rem; color: #2b6cb0; background: none;
                                       border: none; cursor: pointer; padding: 0; text-decoration: none; }
        .notif-header-actions a:hover,
        .notif-header-actions button:hover { text-decoration: underline; }
        .notif-list { max-height: 320px; overflow-y: auto; }
        .notif-item { display: block; padding: 12px 16px; border-bottom: 1px solid #f0f0f0;
                      text-decoration: none; color: inherit; transition: background 0.15s; }
        .notif-item:hover { background: #f7fafc; }
        .notif-item.unread { background: #ebf8ff; }
        .notif-item .notif-pesan { font-size: 0.875rem; color: #2d3748; margin-bottom: 4px; }
        .notif-item .notif-meta { display: flex; justify-content: space-between; align-items: center; }
        .notif-item .notif-time { font-size: 0.75rem; color: #a0aec0; }
        .notif-status { font-size: 0.7rem; padding: 2px 8px; border-radius: 9999px; font-weight: 600; }
        .notif-status.pending    { background: #fefcbf; color: #744210; }
        .notif-status.diverifikasi { background: #bee3f8; color: #2c5282; }
        .notif-status.disetujui  { background: #c6f6d5; color: #22543d; }
        .notif-status.ditolak    { background: #fed7d7; color: #9b2c2c; }
        .notif-status.disalurkan { background: #e9d8fd; color: #553c9a; }
        .notif-empty { padding: 32px 16px; text-align: center; color: #a0aec0; font-size: 0.875rem; }
        .notif-dot { width: 8px; height: 8px; background: #3182ce; border-radius: 9999px; display: inline-block; }
        .alert-danger { background: #fed7d7; color: #9b2c2c; }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- HEADER / NAVBAR -->
        <div class="header">
            <div>
                <h1>{{ config('app.name', 'e-MatchKerja') }}</h1>
                <p class="small">Sistem autentikasi dan manajemen akun</p>
            </div>
            <div style="display:flex; align-items:center;">
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <a href="{{ url('/laporan') }}">Laporan Bantuan</a>

                    {{-- Bell Notifikasi --}}
                    <div class="notif-wrapper" x-data="{ open: false }">
                        <button class="notif-btn" @click="open = !open" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                 fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                            </svg>
                            @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="notif-badge">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                            @endif
                        </button>

                        <div class="notif-dropdown" x-show="open" @click.away="open = false" x-transition>
                            <div class="notif-header">
                                <span>Notifikasi</span>
                                <div class="notif-header-actions">
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                    <form action="{{ route('notifications.markAllRead') }}" method="POST">
                                        @csrf
                                        <button type="submit">Tandai dibaca</button>
                                    </form>
                                    @endif
                                    <a href="{{ route('notifications.index') }}">Lihat semua</a>
                                </div>
                            </div>

                            <div class="notif-list">
                                @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notif)
                                <a href="{{ route('notifications.markRead', $notif->id) }}"
                                   class="notif-item {{ is_null($notif->read_at) ? 'unread' : '' }}">
                                    <p class="notif-pesan">{{ $notif->data['pesan'] }}</p>
                                    <div class="notif-meta">
                                        <span class="notif-status {{ $notif->data['status'] }}">
                                            {{ ucfirst($notif->data['status']) }}
                                        </span>
                                        <div style="display:flex; align-items:center; gap:6px;">
                                            <span class="notif-time">{{ $notif->created_at->diffForHumans() }}</span>
                                            @if(is_null($notif->read_at))
                                            <span class="notif-dot"></span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                                @empty
                                <div class="notif-empty">Belum ada notifikasi</div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="nav">
                        <a href="{{ route('admin.jobseekers.index') }}">Pencari Kerja</a>
                        <a href="{{ route('admin.lowongan.index') }}">Lowongan</a>
                        <a href="{{ route('jobseeker.profile.create') }}">Profil Saya</a>
                        <a href="{{ route('perusahaan.lowongan.create') }}">Posting Lowongan</a>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline; margin-left:16px;">
                            @csrf
                            <button type="submit" style="background:none; border:none; color:white; cursor:pointer;">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>

        <!-- Pesan Success / Error -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')

    </div>
</body>
</html>