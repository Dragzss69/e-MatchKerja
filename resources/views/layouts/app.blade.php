<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>e-MatchKerja — @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        :root {
            --primary: #185FA5;
            --primary-light: #E6F1FB;
            --primary-text: #0C447C;
            --surface: #ffffff;
            --bg: #f4f6f9;
            --border: #e5e7eb;
            --text: #111827;
            --muted: #6b7280;
            --radius: 10px;
            --radius-lg: 14px;
            --sidebar-w: 240px;
            --navbar-h: 58px;
        }

        html, body {
            height: 100%;
            overflow: hidden;
            font-family: 'Inter', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            font-size: 14px;
            -webkit-font-smoothing: antialiased;
        }

        body { display: flex; flex-direction: column; }
        a { text-decoration: none; color: inherit; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

        /* ── NAVBAR ── */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 40;
            height: var(--navbar-h);
            flex-shrink: 0;
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            padding: 0 1.25rem;
            gap: 1rem;
        }

        .brand {
            font-size: 1.1rem;
            font-weight: 600;
            letter-spacing: -0.4px;
            color: var(--primary);
            white-space: nowrap;
        }

        .brand-accent { color: #1D9E75; }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 2px;
            flex: 1;
        }

        .nav-link {
            padding: 6px 12px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            transition: background .15s, color .15s;
        }

        .nav-link:hover { background: var(--primary-light); color: var(--primary-text); }

        /* User button */
        .user-btn {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 10px 5px 5px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            background: var(--surface);
            cursor: pointer;
            transition: background .15s;
            margin-left: auto;
        }

        .user-btn:hover { background: #f9fafb; }

        .user-avatar {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: var(--primary-light);
            color: var(--primary-text);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
            flex-shrink: 0;
        }

        .user-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text);
            max-width: 120px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        /* Dropdown */
        .dropdown-wrap { position: relative; }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 8px);
            width: 200px;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            box-shadow: 0 8px 24px rgba(0,0,0,.08);
            overflow: hidden;
            z-index: 50;
        }

        .dropdown-menu.hidden { display: none; }

        .dropdown-header {
            padding: 12px 14px;
            border-bottom: 1px solid var(--border);
        }

        .dropdown-header-name { font-weight: 600; font-size: 13px; }
        .dropdown-header-email { font-size: 12px; color: var(--muted); margin-top: 2px; }

        .dropdown-item {
            width: 100%;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            font-size: 13px;
            color: var(--text);
            background: none;
            border: none;
            cursor: pointer;
            transition: background .15s;
            text-align: left;
        }

        .dropdown-item:hover { background: #f3f4f6; }
        .dropdown-item.danger { color: #991b1b; }
        .dropdown-item.danger:hover { background: #fef2f2; }

        /* ── LAYOUT ── */
        .main-wrapper {
            display: flex;
            flex: 1;
            overflow: hidden;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            overflow-y: auto;
            flex-shrink: 0;
            display: flex;
            flex-direction: column;
            padding: 1rem 0.75rem;
            gap: 8px;
        }

        .sidebar-section { margin-bottom: 6px; }

        .sidebar-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 0 10px;
            margin-bottom: 6px;
            display: block;
        }

        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: var(--radius);
            color: #374151;
            font-size: 13px;
            font-weight: 500;
            transition: background .15s, color .15s;
            margin-bottom: 1px;
        }

        .sidebar-item svg,
        .sidebar-item i { font-size: 17px; flex-shrink: 0; opacity: .75; }

        .sidebar-item:hover {
            background: #f3f4f6;
            color: var(--text);
        }

        .sidebar-item:hover svg,
        .sidebar-item:hover i { opacity: 1; }

        .sidebar-item.active {
            background: var(--primary-light);
            color: var(--primary-text);
        }

        .sidebar-item.active svg,
        .sidebar-item.active i { opacity: 1; }

        .sidebar-badge {
            margin-left: auto;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 999px;
            background: #FAEEDA;
            color: #854F0B;
        }

        .sidebar-divider {
            height: 1px;
            background: var(--border);
            margin: 6px 0;
        }

        /* ── MAIN CONTENT ── */
        .main-content {
            flex: 1;
            overflow-y: auto;
            padding: 1.5rem;
            background: var(--bg);
        }

        /* ── MOBILE SIDEBAR ── */
        #mobile-sidebar {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.45);
            z-index: 9999;
        }

        #mobile-sidebar.hidden { display: none; }

        .mobile-sidebar-panel {
            width: 260px;
            height: 100%;
            background: var(--surface);
            padding: 1.25rem 0.75rem;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .mobile-sidebar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 8px;
            margin-bottom: 1rem;
        }

        .mobile-close {
            width: 30px;
            height: 30px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            border: none;
            cursor: pointer;
            color: var(--muted);
            font-size: 18px;
        }

        .mobile-close:hover { background: #e5e7eb; }

        .mobile-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: var(--radius);
            color: #374151;
            font-size: 13px;
            font-weight: 500;
            transition: background .15s;
        }

        .mobile-link i { font-size: 17px; opacity: .75; }
        .mobile-link:hover { background: #f3f4f6; }

        /* ── BOTTOM NAV ── */
        .bottom-nav {
            background: var(--surface);
            border-top: 1px solid var(--border);
            display: none;
        }

        .bottom-link {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            padding: 8px 0;
            flex: 1;
            color: var(--muted);
            font-size: 11px;
            font-weight: 500;
            transition: color .15s;
        }

        .bottom-link i { font-size: 20px; }
        .bottom-link:hover { color: var(--primary); }
        .bottom-link.active { color: var(--primary); }

        /* ── AUTH BUTTONS ── */
        .btn-ghost {
            padding: 6px 14px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            color: var(--muted);
            transition: color .15s, background .15s;
        }

        .btn-ghost:hover { color: var(--primary); background: var(--primary-light); }

        .btn-primary {
            padding: 7px 16px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            background: var(--primary);
            color: #fff;
            transition: background .15s;
        }

        .btn-primary:hover { background: #0C447C; }

        /* ── LEAFLET FIX ── */
        .leaflet-container { z-index: 1 !important; }
        body.sidebar-open .leaflet-container { pointer-events: none; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .sidebar { display: none; }
            .nav-links { display: none; }

            .main-content {
                padding: 1rem;
                padding-bottom: calc(65px + 1rem);
            }

            .bottom-nav {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                z-index: 50;
                padding-bottom: env(safe-area-inset-bottom);
            }
        }

        @media (min-width: 769px) {
            #mobile-menu-btn { display: none; }
        }
    </style>
</head>

<body>

{{-- ── NAVBAR ── --}}
<nav class="navbar">

    <div class="flex items-center gap-3">
        <button id="mobile-menu-btn" class="md:hidden p-1.5 rounded-lg text-gray-500 hover:bg-gray-100 transition"
            aria-label="Buka menu">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>

        <a href="/" class="brand">
            e-Match<span class="brand-accent">Kerja</span>
        </a>
    </div>

    {{-- Desktop nav --}}
    <div class="nav-links hidden md:flex">
        @auth
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('pengajuan-bantuan.index') }}" class="nav-link">Verifikasi</a>
                <a href="{{ route('laporan.index') }}" class="nav-link">Laporan</a>
                <a href="{{ route('peta.sebaran') }}" class="nav-link">Peta sebaran</a>
            @endif
            @if(auth()->user()->hasRole('job_seeker'))
                <a href="{{ route('pencari-kerja.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('pengajuan-bantuan.index') }}" class="nav-link">Pengajuan bantuan</a>
                <a href="{{ route('peta.sebaran') }}" class="nav-link">Peta sebaran</a>
            @endif
            @if(auth()->user()->hasRole('perusahaan'))
                <a href="{{ route('perusahaan.dashboard') }}" class="nav-link">Dashboard</a>
                <a href="{{ route('peta.sebaran') }}" class="nav-link">Peta sebaran</a>
            @endif
        @endauth
    </div>

    {{-- Right side --}}
    <div class="flex items-center gap-2" style="margin-left: auto;">
        @auth
            <div class="dropdown-wrap">
                <button id="profileDropdownBtn" class="user-btn" aria-label="Menu profil">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <span class="user-name hidden md:block">{{ auth()->user()->name }}</span>
                    <svg class="w-3.5 h-3.5 text-gray-400 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                <div id="profileDropdown" class="dropdown-menu hidden">
                    <div class="dropdown-header">
                        <p class="dropdown-header-name">{{ auth()->user()->name }}</p>
                        <p class="dropdown-header-email">{{ auth()->user()->email }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item danger">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        @endauth

        @guest
            <a href="{{ route('login') }}" class="btn-ghost">Masuk</a>
            <a href="{{ route('register') }}" class="btn-primary">Daftar</a>
        @endguest
    </div>
</nav>

{{-- ── MOBILE SIDEBAR ── --}}
<div id="mobile-sidebar" class="hidden" role="dialog" aria-modal="true" aria-label="Menu navigasi">
    <div class="mobile-sidebar-panel">
        <div class="mobile-sidebar-header">
            <span class="brand">e-Match<span class="brand-accent">Kerja</span></span>
            <button id="close-sidebar" class="mobile-close" aria-label="Tutup menu">&times;</button>
        </div>

        @auth
            @if(auth()->user()->hasRole('admin'))
                <span class="sidebar-label">Menu admin</span>
                <a href="{{ route('admin.dashboard') }}" class="mobile-link">
                    <i class="ti ti-layout-dashboard" aria-hidden="true"></i> Dashboard
                </a>
                <a href="{{ route('pengajuan-bantuan.index') }}" class="mobile-link">
                    <i class="ti ti-clipboard-check" aria-hidden="true"></i> Verifikasi bantuan
                </a>
                <a href="{{ route('laporan.index') }}" class="mobile-link">
                    <i class="ti ti-file-analytics" aria-hidden="true"></i> Laporan
                </a>
                <a href="{{ route('peta.sebaran') }}" class="mobile-link">
                    <i class="ti ti-map" aria-hidden="true"></i> Peta sebaran
                </a>
            @endif

            @if(auth()->user()->hasRole('job_seeker'))
                <span class="sidebar-label">Menu saya</span>
                <a href="{{ route('pencari-kerja.dashboard') }}" class="mobile-link">
                    <i class="ti ti-home" aria-hidden="true"></i> Dashboard saya
                </a>
                <a href="{{ route('pengajuan-bantuan.index') }}" class="mobile-link">
                    <i class="ti ti-clipboard-list" aria-hidden="true"></i> Pengajuan bantuan
                </a>
                <a href="{{ route('peta.sebaran') }}" class="mobile-link">
                    <i class="ti ti-map" aria-hidden="true"></i> Peta sebaran
                </a>
            @endif

            @if(auth()->user()->hasRole('perusahaan'))
                <span class="sidebar-label">Menu perusahaan</span>
                <a href="{{ route('perusahaan.dashboard') }}" class="mobile-link">
                    <i class="ti ti-building" aria-hidden="true"></i> Dashboard
                </a>
                <a href="{{ route('peta.sebaran') }}" class="mobile-link">
                    <i class="ti ti-map" aria-hidden="true"></i> Peta sebaran
                </a>
            @endif

            <div class="sidebar-divider"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="mobile-link w-full" style="color: #991b1b; background: none; border: none; cursor: pointer; text-align: left;">
                    <i class="ti ti-logout" aria-hidden="true"></i> Logout
                </button>
            </form>
        @endauth
    </div>
</div>

{{-- ── MAIN WRAPPER ── --}}
<div class="main-wrapper">

    {{-- Desktop sidebar --}}
    <aside class="sidebar" id="sidebar-desktop">

        @auth
            @if(auth()->user()->hasRole('admin'))
                <div class="sidebar-section">
                    <span class="sidebar-label">Menu utama</span>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="ti ti-layout-dashboard" aria-hidden="true"></i> Dashboard
                    </a>
                    <a href="{{ route('pengajuan-bantuan.index') }}" class="sidebar-item {{ request()->routeIs('pengajuan-bantuan.*') ? 'active' : '' }}">
                        <i class="ti ti-clipboard-check" aria-hidden="true"></i> Verifikasi bantuan
                        {{-- Opsional: tambahkan badge count dari controller --}}
                    </a>
                    <a href="{{ route('laporan.index') }}" class="sidebar-item {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i class="ti ti-file-analytics" aria-hidden="true"></i> Laporan
                    </a>
                    <a href="{{ route('peta.sebaran') }}" class="sidebar-item {{ request()->routeIs('peta.*') ? 'active' : '' }}">
                        <i class="ti ti-map" aria-hidden="true"></i> Peta sebaran
                    </a>
                </div>
            @endif

            @if(auth()->user()->hasRole('job_seeker'))
                <div class="sidebar-section">
                    <span class="sidebar-label">Menu saya</span>
                    <a href="{{ route('pencari-kerja.dashboard') }}" class="sidebar-item {{ request()->routeIs('pencari-kerja.dashboard') ? 'active' : '' }}">
                        <i class="ti ti-home" aria-hidden="true"></i> Dashboard saya
                    </a>
                    <a href="{{ route('pengajuan-bantuan.index') }}" class="sidebar-item {{ request()->routeIs('pengajuan-bantuan.*') ? 'active' : '' }}">
                        <i class="ti ti-clipboard-list" aria-hidden="true"></i> Pengajuan bantuan
                    </a>
                    <a href="{{ route('peta.sebaran') }}" class="sidebar-item {{ request()->routeIs('peta.*') ? 'active' : '' }}">
                        <i class="ti ti-map" aria-hidden="true"></i> Peta sebaran
                    </a>
                </div>
            @endif

            @if(auth()->user()->hasRole('perusahaan'))
                <div class="sidebar-section">
                    <span class="sidebar-label">Menu perusahaan</span>
                    <a href="{{ route('perusahaan.dashboard') }}" class="sidebar-item {{ request()->routeIs('perusahaan.dashboard') ? 'active' : '' }}">
                        <i class="ti ti-building" aria-hidden="true"></i> Dashboard
                    </a>
                    <a href="{{ route('peta.sebaran') }}" class="sidebar-item {{ request()->routeIs('peta.*') ? 'active' : '' }}">
                        <i class="ti ti-map" aria-hidden="true"></i> Peta sebaran
                    </a>
                </div>
            @endif

            <div style="margin-top: auto; padding-top: 1rem;">
                <div class="sidebar-divider"></div>
                <div class="sidebar-section" style="margin-top: 6px;">
                    <div class="sidebar-item" style="cursor: default; opacity: .7;">
                        <i class="ti ti-user-circle" aria-hidden="true"></i>
                        <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>
        @endauth

    </aside>

    {{-- Content --}}
    <main class="main-content">
        @yield('content')
    </main>

</div>

{{-- ── BOTTOM NAV (mobile) ── --}}
<nav class="bottom-nav" aria-label="Navigasi bawah">
    @auth
        @if(auth()->user()->hasRole('admin'))
            <a href="{{ route('admin.dashboard') }}" class="bottom-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="ti ti-home" aria-hidden="true"></i> Beranda
            </a>
            <a href="{{ route('pengajuan-bantuan.index') }}" class="bottom-link {{ request()->routeIs('pengajuan-bantuan.*') ? 'active' : '' }}">
                <i class="ti ti-clipboard-check" aria-hidden="true"></i> Verifikasi
            </a>
            <a href="{{ route('laporan.index') }}" class="bottom-link {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                <i class="ti ti-file-analytics" aria-hidden="true"></i> Laporan
            </a>
            <a href="{{ route('peta.sebaran') }}" class="bottom-link {{ request()->routeIs('peta.*') ? 'active' : '' }}">
                <i class="ti ti-map" aria-hidden="true"></i> Peta
            </a>
        @elseif(auth()->user()->hasRole('job_seeker'))
            <a href="{{ route('pencari-kerja.dashboard') }}" class="bottom-link {{ request()->routeIs('pencari-kerja.dashboard') ? 'active' : '' }}">
                <i class="ti ti-home" aria-hidden="true"></i> Beranda
            </a>
            <a href="{{ route('pengajuan-bantuan.index') }}" class="bottom-link {{ request()->routeIs('pengajuan-bantuan.*') ? 'active' : '' }}">
                <i class="ti ti-clipboard-list" aria-hidden="true"></i> Bantuan
            </a>
            <a href="{{ route('peta.sebaran') }}" class="bottom-link {{ request()->routeIs('peta.*') ? 'active' : '' }}">
                <i class="ti ti-map" aria-hidden="true"></i> Peta
            </a>
        @elseif(auth()->user()->hasRole('perusahaan'))
            <a href="{{ route('perusahaan.dashboard') }}" class="bottom-link">
                <i class="ti ti-building" aria-hidden="true"></i> Dashboard
            </a>
            <a href="{{ route('peta.sebaran') }}" class="bottom-link">
                <i class="ti ti-map" aria-hidden="true"></i> Peta
            </a>
        @endif
    @endauth
</nav>

{{-- ── SCRIPTS ── --}}
<script>
    (function () {
        const menuBtn   = document.getElementById('mobile-menu-btn');
        const sidebar   = document.getElementById('mobile-sidebar');
        const closeBtn  = document.getElementById('close-sidebar');
        const profileBtn = document.getElementById('profileDropdownBtn');
        const dropdown   = document.getElementById('profileDropdown');

        if (menuBtn) {
            menuBtn.addEventListener('click', () => {
                sidebar.classList.remove('hidden');
                document.body.classList.add('sidebar-open');
            });
        }

        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                sidebar.classList.add('hidden');
                document.body.classList.remove('sidebar-open');
            });
        }

        if (sidebar) {
            sidebar.addEventListener('click', (e) => {
                if (e.target === sidebar) {
                    sidebar.classList.add('hidden');
                    document.body.classList.remove('sidebar-open');
                }
            });
        }

        if (profileBtn) {
            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                dropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', (e) => {
                if (!profileBtn.contains(e.target) && !dropdown.contains(e.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') dropdown.classList.add('hidden');
            });
        }
    })();
</script>

</body>
</html>