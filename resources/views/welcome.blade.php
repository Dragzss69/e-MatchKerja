<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>AnoJobs - Platform SPK Penyaluran Bantuan & Karir</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- FontAwesome for Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Tailwind CSS & JS via Vite -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Plus Jakarta Sans', 'Outfit', sans-serif;
            }
        </style>
    </head>
    <body class="h-full flex flex-col text-slate-800 antialiased selection:bg-indigo-500 selection:text-white bg-slate-50">

        <!-- Header / Navigation -->
        <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-200/80 transition-all duration-200">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 justify-between items-center">
                    
                    <!-- Logo / Brand -->
                    <div class="flex items-center gap-3">
                        <a href="/" class="flex items-center gap-2.5 group">
                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-500 shadow-md shadow-indigo-200 transition-all duration-300 group-hover:scale-105">
                                <i class="fa-solid fa-briefcase text-white text-lg"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-lg font-bold tracking-tight text-slate-900 leading-tight">AnoJobs</span>
                                <span class="text-[10px] font-medium text-slate-500 uppercase tracking-widest leading-none">SPK & Karir</span>
                            </div>
                        </a>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-5 py-2 text-xs font-bold text-white shadow-sm hover:bg-indigo-700 transition">
                                Dashboard Saya
                            </a>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="text-xs font-bold text-slate-600 hover:text-rose-600 px-3 py-2 transition">
                                    Logout
                                </button>
                            </form>
                        @else
                            <!-- HANYA LOGO, TANPA TOMBOL LOGIN/REGISTER DI NAVBAR -->
                        @endauth
                    </div>

                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col justify-center py-12 sm:py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 w-full">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                    
                    <!-- Left Hero Section -->
                    <div class="lg:col-span-7 space-y-6">
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-indigo-50 px-3 py-1 text-xs font-bold text-indigo-700 border border-indigo-100">
                            <i class="fa-solid fa-sparkles text-[10px]"></i> Penyaluran Bantuan Tepat Sasaran
                        </span>
                        <h1 class="text-4xl sm:text-5xl font-black tracking-tight text-slate-900 leading-tight">
                            Solusi Keadilan Sosial <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-500">Berbasis Data Akurat</span>
                        </h1>
                        <p class="text-base text-slate-600 leading-relaxed max-w-2xl">
                            AnoJobs mengintegrasikan portal karir pencarian lowongan kerja lokal dengan Sistem Pendukung Keputusan (SPK) berbasis algoritma SAW untuk memprioritaskan penerima bantuan sosial secara objektif, adil, dan transparan.
                        </p>

                        <div class="flex flex-wrap gap-4 pt-2">
                            @guest
                                <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-7 py-3.5 text-xs font-bold text-white shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                                    Daftar Sekarang <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                                </a>
                                <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-xl bg-white border border-slate-200/80 px-7 py-3.5 text-xs font-bold text-slate-700 hover:bg-slate-50 transition">
                                    Masuk ke Akun
                                </a>
                            @else
                                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-xl bg-indigo-600 px-7 py-3.5 text-xs font-bold text-white shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition">
                                    Buka Dashboard Karir <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                                </a>
                            @endguest
                        </div>
                    </div>

                    <!-- Right Features Card -->
                    <div class="lg:col-span-5 rounded-3xl bg-slate-900 text-white p-8 sm:p-10 shadow-xl space-y-6 relative overflow-hidden">
                        <div class="absolute -right-20 -top-20 h-48 w-48 rounded-full bg-indigo-500/10 blur-2xl"></div>
                        
                        <div class="space-y-2 relative">
                            <h3 class="text-lg font-bold">Fitur Unggulan Platform</h3>
                            <p class="text-xs text-slate-400">Efisiensi rekrutmen dan transparansi bantuan sosial</p>
                        </div>

                        <ul class="space-y-4 relative text-xs">
                            <li class="flex items-start gap-3">
                                <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-indigo-500/20 text-indigo-400 shrink-0"><i class="fa-solid fa-calculator"></i></div>
                                <div class="space-y-0.5">
                                    <span class="font-bold text-white block">SPK SAW Terintegrasi</span>
                                    <p class="text-slate-400 leading-relaxed">Kalkulasi kelayakan bansos berbasis parameter multi-kriteria secara objektif.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-sky-500/20 text-sky-400 shrink-0"><i class="fa-solid fa-briefcase"></i></div>
                                <div class="space-y-0.5">
                                    <span class="font-bold text-white block">Portal Karir Terpadu</span>
                                    <p class="text-slate-400 leading-relaxed">Pencarian lowongan kerja serta kualifikasi keahlian terpadu untuk pencari kerja.</p>
                                </div>
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-500/20 text-emerald-400 shrink-0"><i class="fa-solid fa-bell"></i></div>
                                <div class="space-y-0.5">
                                    <span class="font-bold text-white block">Sistem Notifikasi Real-time</span>
                                    <p class="text-slate-400 leading-relaxed">Notifikasi otomatis di database untuk melacak status verifikasi & approval bansos.</p>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-slate-200/80 py-6 text-center text-slate-400 text-xs font-medium">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-3">
                <p>&copy; {{ date('Y') }} AnoJobs. Hak Cipta Dilindungi.</p>
                <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-md border border-indigo-100">BANTUAN SOSIAL SPK SAW</span>
            </div>
        </footer>

    </body>
</html>