<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'e-MatchKerja') - Platform SPK Penyaluran Bantuan & Karir</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Tailwind CSS & JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
    @yield('styles')
</head>
<body class="h-full flex flex-col text-slate-800 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Main Wrapper -->
    <div class="min-h-full flex flex-col">
        
        <!-- HEADER / NAVBAR -->
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/80 transition-all duration-200" x-data="{ mobileMenuOpen: false }">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    
                    <!-- Logo / Brand -->
                    <div class="flex items-center gap-3">
                        <a href="/" class="flex items-center gap-2.5 group">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 shadow-md shadow-indigo-200 transition-all duration-300 group-hover:scale-105">
                                <i class="fa-solid fa-briefcase text-white text-lg"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-lg font-bold tracking-tight text-slate-900 leading-tight group-hover:text-indigo-600 transition-colors">e-MatchKerja</span>
                                <span class="text-[10px] font-medium text-slate-500 uppercase tracking-widest leading-none">SPK & Karir</span>
                            </div>
                        </a>
                    </div>

                    <!-- Desktop Nav Menu (Centered) -->
@auth
<div class="hidden md:flex md:items-center md:space-x-1.5 bg-slate-100/80 p-1 rounded-xl border border-slate-200/50">
    
    <!-- DASHBOARD MENU (dengan active class) -->
    <a href="{{ route('dashboard') }}" 
       class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 
       {{ request()->routeIs('dashboard') || request()->routeIs('verifier.dashboard') || request()->routeIs('pencari-kerja.dashboard') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
        Dashboard
    </a>
    
    {{-- ===== ADMIN ===== --}}
    @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.spk.index') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.spk.*') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            SPK Kelayakan Bantuan
        </a>
        <a href="{{ route('admin.jobseekers.index') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.jobseekers.*') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            Data Pencari Kerja
        </a>
        <a href="{{ route('admin.lowongan.index') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.lowongan.*') || request()->routeIs('lowongan.*') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            Kelola Lowongan
        </a>
        <a href="{{ route('laporan.index') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            Laporan Bantuan
        </a>
    @endif

    {{-- ===== VERIFIER ===== --}}
    @if(auth()->user()->isVerifier())
        <a href="{{ route('admin.spk.index') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('admin.spk.*') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            Rekomendasi Kelayakan
        </a>
        <a href="{{ route('pengajuan-bantuan.index') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('pengajuan-bantuan.*') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            Verifikasi Pengajuan
        </a>
        <a href="{{ route('laporan.index') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('laporan.*') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            Laporan Bantuan
        </a>
    @endif

    {{-- ===== EMPLOYER ===== --}}
    @if(auth()->user()->isEmployer())
        <a href="{{ route('lowongan.index') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('lowongan.index') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            Daftar Lowongan Saya
        </a>
        <a href="{{ route('perusahaan.lowongan.create') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('perusahaan.lowongan.create') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            Post Lowongan Baru
        </a>
    @endif

    {{-- ===== JOB SEEKER ===== --}}
    @if(auth()->user()->isJobSeeker())
        @php $seekerProfileNav = auth()->user()->jobSeekerProfile; @endphp
        @if($seekerProfileNav)
            <a href="{{ route('jobseeker.profile.show') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('jobseeker.profile.show') || request()->routeIs('jobseeker.profile.edit') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <i class="fa-solid fa-id-card mr-1"></i> Profil Saya
            </a>
        @else
            <a href="{{ route('jobseeker.profile.create') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('jobseeker.profile.create') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
                <i class="fa-solid fa-id-card mr-1"></i> Profil Saya
                <span class="ml-1 inline-flex h-1.5 w-1.5 rounded-full bg-rose-500"></span>
            </a>
        @endif
        <a href="{{ route('pengajuan-bantuan.create') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('pengajuan-bantuan.create') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <i class="fa-solid fa-file-invoice-dollar mr-1"></i> Ajukan Bantuan
        </a>
        <a href="{{ route('pengajuan-bantuan.index') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('pengajuan-bantuan.index') || request()->routeIs('pengajuan-bantuan.show') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <i class="fa-solid fa-clock-rotate-left mr-1"></i> Riwayat Bantuan
        </a>
        <a href="{{ route('lowongan.index') }}" class="px-4 py-1.5 rounded-lg text-xs font-semibold tracking-wide transition-all duration-200 {{ request()->routeIs('lowongan.*') ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-50' }}">
            <i class="fa-solid fa-briefcase mr-1"></i> Cari Pekerjaan
        </a>
    @endif

</div>
@endauth

                    <!-- User Actions Area -->
                    <div class="flex items-center gap-4">
                        @auth
                            
                            <!-- Bell Notification Icon -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" type="button" class="relative rounded-xl p-2.5 text-slate-500 bg-slate-50 border border-slate-200/80 hover:bg-slate-100 hover:text-slate-800 transition duration-150 focus:outline-none">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>
                                    @if(auth()->user()->unreadNotifications->count() > 0)
                                        <span class="absolute top-1.5 right-1.5 flex h-2 w-2">
                                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                                            <span class="relative inline-flex rounded-full h-2 w-2 bg-rose-500"></span>
                                        </span>
                                    @endif
                                </button>

                                <!-- Notification Dropdown -->
                                <div x-show="open" @click.away="open = false" x-cloak
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 translate-y-1 scale-95"
                                     x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                     x-transition:leave-end="opacity-0 translate-y-1 scale-95"
                                     class="absolute right-0 mt-3 w-80 origin-top-right rounded-2xl bg-white p-2 shadow-xl border border-slate-200/80 ring-1 ring-black ring-opacity-5 focus:outline-none">
                                    
                                    <div class="px-4 py-2.5 flex items-center justify-between border-b border-slate-100">
                                        <span class="text-sm font-bold text-slate-900">Notifikasi Terbaru</span>
                                        @if(auth()->user()->unreadNotifications->count() > 0)
                                            <form action="{{ route('notifications.markAllRead') }}" method="POST" class="m-0">
                                                @csrf
                                                <button type="submit" class="text-[11px] font-semibold text-indigo-600 hover:text-indigo-800 transition">
                                                    Tandai Dibaca
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <div class="max-h-64 overflow-y-auto divide-y divide-slate-100">
                                        @forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notif)
                                            <a href="{{ route('notifications.markRead', $notif->id) }}" class="flex flex-col gap-1 p-3 transition hover:bg-slate-50 {{ is_null($notif->read_at) ? 'bg-indigo-50/40' : '' }}">
                                                <p class="text-xs text-slate-800 leading-snug">{{ $notif->data['pesan'] }}</p>
                                                <div class="flex items-center justify-between mt-1 text-[10px] text-slate-400">
                                                    <span>{{ $notif->created_at->diffForHumans() }}</span>
                                                    <span class="px-2 py-0.5 rounded-full font-bold uppercase tracking-wider
                                                        @if(($notif->data['status'] ?? '') == 'pending') bg-amber-100 text-amber-800
                                                        @elseif(($notif->data['status'] ?? '') == 'diverifikasi') bg-sky-100 text-sky-800
                                                        @elseif(($notif->data['status'] ?? '') == 'disetujui') bg-emerald-100 text-emerald-800
                                                        @elseif(($notif->data['status'] ?? '') == 'ditolak') bg-rose-100 text-rose-800
                                                        @else bg-purple-100 text-purple-800 @endif">
                                                        {{ $notif->data['status'] ?? 'Info' }}
                                                    </span>
                                                </div>
                                            </a>
                                        @empty
                                            <div class="py-8 text-center text-xs text-slate-400">
                                                <i class="fa-regular fa-bell text-lg mb-2 block"></i>
                                                Belum ada notifikasi
                                            </div>
                                        @endforelse
                                    </div>
                                    <div class="p-2 border-t border-slate-100 text-center">
                                        <a href="{{ route('notifications.index') }}" class="block w-full py-1.5 text-center text-xs font-semibold text-slate-600 hover:text-indigo-600 transition bg-slate-50 hover:bg-indigo-50/50 rounded-lg">
                                            Lihat Semua Notifikasi
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Profile Dropdown -->
                            <div class="relative" x-data="{ profileOpen: false }">
                                <button @click="profileOpen = !profileOpen" type="button" class="flex items-center gap-2.5 rounded-xl border border-slate-200 bg-white pl-2 pr-3 py-1.5 hover:bg-slate-50 transition focus:outline-none">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-indigo-500 text-white font-bold text-sm">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                    <div class="hidden sm:flex flex-col text-left leading-none">
                                        <span class="text-xs font-bold text-slate-800">{{ auth()->user()->name }}</span>
                                        <span class="text-[9px] text-slate-400 font-semibold tracking-wider uppercase mt-0.5">
                                            @if(auth()->user()->isAdmin()) Admin
                                            @elseif(auth()->user()->isVerifier()) Verifikator
                                            @elseif(auth()->user()->isEmployer()) Perusahaan
                                            @elseif(auth()->user()->isJobSeeker()) Pencari Kerja
                                            @else Pengguna
                                            @endif
                                        </span>
                                    </div>
                                    <i class="fa-solid fa-angle-down text-slate-400 text-[10px] ml-1"></i>
                                </button>

                                <div x-show="profileOpen" @click.away="profileOpen = false" x-cloak
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2.5 w-48 origin-top-right rounded-2xl bg-white p-1.5 shadow-xl border border-slate-200 ring-1 ring-black/5">
                                    <div class="px-3.5 py-2.5 border-b border-slate-100">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Email Anda</p>
                                        <p class="text-xs font-semibold text-slate-800 truncate mt-1 leading-none">{{ auth()->user()->email }}</p>
                                    </div>
                                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-700 hover:text-indigo-600 hover:bg-indigo-50/50 rounded-xl transition">
                                        <i class="fa-solid fa-chart-line text-sm text-slate-400"></i>
                                        Dashboard
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="m-0 border-t border-slate-100 mt-1 pt-1">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2.5 px-3 py-2 text-xs font-semibold text-rose-600 hover:bg-rose-50 rounded-xl transition text-left">
                                            <i class="fa-solid fa-arrow-right-from-bracket text-sm"></i>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>

                        @else
                            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 hover:text-indigo-600 px-3 py-2 transition">
                                Login
                            </a>
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-2 text-xs font-bold text-white shadow-sm shadow-indigo-100 hover:bg-indigo-700 transition">
                                Register
                            </a>
                        @endauth
                        
                        <!-- Mobile Menu Button -->
                        <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden rounded-xl p-2.5 text-slate-500 bg-slate-50 border border-slate-200/80 hover:bg-slate-100 focus:outline-none">
                            <i class="fa-solid" :class="mobileMenuOpen ? 'fa-xmark' : 'fa-bars'"></i>
                        </button>
                    </div>

                </div>
            </div>

            <!-- Mobile Nav Menu -->
            <div x-show="mobileMenuOpen" x-cloak @click.away="mobileMenuOpen = false" x-transition class="md:hidden border-b border-slate-200 bg-white">
                <div class="space-y-1.5 px-4 pb-4 pt-2">
                    @auth
                        <a href="{{ route('dashboard') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                            <i class="fa-solid fa-gauge-high mr-2 text-slate-400"></i> Dashboard
                        </a>

                        {{-- ADMIN mobile --}}
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.spk.index') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.spk.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-star-half-stroke mr-2 text-slate-400"></i> SPK Kelayakan Bantuan
                            </a>
                            <a href="{{ route('admin.jobseekers.index') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.jobseekers.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-users mr-2 text-slate-400"></i> Data Pencari Kerja
                            </a>
                            <a href="{{ route('admin.lowongan.index') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.lowongan.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-briefcase mr-2 text-slate-400"></i> Kelola Lowongan
                            </a>
                            <a href="{{ route('laporan.index') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('laporan.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-chart-bar mr-2 text-slate-400"></i> Laporan Bantuan
                            </a>
                        @endif

                        {{-- VERIFIER mobile --}}
                        @if(auth()->user()->isVerifier())
                            <a href="{{ route('admin.spk.index') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.spk.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-star-half-stroke mr-2 text-slate-400"></i> Rekomendasi Kelayakan
                            </a>
                            <a href="{{ route('pengajuan-bantuan.index') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('pengajuan-bantuan.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-list-check mr-2 text-slate-400"></i> Verifikasi Pengajuan
                            </a>
                            <a href="{{ route('laporan.index') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('laporan.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-chart-bar mr-2 text-slate-400"></i> Laporan Bantuan
                            </a>
                        @endif

                        {{-- EMPLOYER mobile --}}
                        @if(auth()->user()->isEmployer())
                            <a href="{{ route('lowongan.index') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('lowongan.index') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-list mr-2 text-slate-400"></i> Daftar Lowongan Saya
                            </a>
                            <a href="{{ route('perusahaan.lowongan.create') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('perusahaan.lowongan.create') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
                                <i class="fa-solid fa-plus mr-2 text-slate-400"></i> Post Lowongan Baru
                            </a>
                        @endif

                        {{-- JOB SEEKER mobile --}}
@if(auth()->user()->isJobSeeker())
    @php $seekerProfileNavMob = auth()->user()->jobSeekerProfile; @endphp
    @if($seekerProfileNavMob)
        <a href="{{ route('jobseeker.profile.show') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('jobseeker.profile.show') || request()->routeIs('jobseeker.profile.edit') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
            <i class="fa-solid fa-id-card mr-2 text-slate-400"></i> Profil Saya
        </a>
    @else
        <a href="{{ route('jobseeker.profile.create') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold text-rose-600 bg-rose-50 hover:bg-rose-100">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i> Lengkapi Profil
        </a>
    @endif
    <a href="{{ route('pengajuan-bantuan.create') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('pengajuan-bantuan.create') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
        <i class="fa-solid fa-file-invoice-dollar mr-2 text-slate-400"></i> Ajukan Bantuan
    </a>
    <a href="{{ route('pengajuan-bantuan.index') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('pengajuan-bantuan.index') || request()->routeIs('pengajuan-bantuan.show') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
        <i class="fa-solid fa-clock-rotate-left mr-2 text-slate-400"></i> Riwayat Bantuan
    </a>
    <a href="{{ route('lowongan.index') }}" class="block px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('lowongan.*') ? 'bg-indigo-50 text-indigo-600' : 'text-slate-700 hover:bg-slate-50' }}">
        <i class="fa-solid fa-briefcase mr-2 text-slate-400"></i> Cari Pekerjaan
    </a>
@endif
                    @endauth
                </div>
            </div>
        </nav>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-1 py-8">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                
                <!-- Alerts / Sessions -->
                @if (session('success'))
                    <div class="mb-6 rounded-2xl bg-emerald-50 p-4 border border-emerald-200/80 text-emerald-800 flex gap-3 items-center shadow-sm">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                        <div class="text-xs font-bold leading-tight">{{ session('success') }}</div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 rounded-2xl bg-rose-50 p-4 border border-rose-200/80 text-rose-800 flex gap-3 items-center shadow-sm">
                        <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                        <div class="text-xs font-bold leading-tight">{{ session('error') }}</div>
                    </div>
                @endif

                @if (session('info'))
                    <div class="mb-6 rounded-2xl bg-indigo-50 p-4 border border-indigo-100 text-indigo-800 flex gap-3 items-center shadow-sm">
                        <i class="fa-solid fa-circle-info text-indigo-500 text-lg"></i>
                        <div class="text-xs font-bold leading-tight">{{ session('info') }}</div>
                    </div>
                @endif

                @yield('content')
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="mt-auto bg-white border-t border-slate-200/80 py-6 text-center text-slate-400 text-xs font-medium">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p>&copy; {{ date('Y') }} e-MatchKerja. Hak Cipta Dilindungi.</p>
                <div class="flex items-center gap-4">
                    <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-md border border-indigo-100">BANTUAN SOSIAL SPK SAW</span>
                </div>
            </div>
        </footer>

    </div>

    @yield('scripts')
</body>
</html>