<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <title>{{ config('app.name', 'Laravel') }}</title>

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <style>
                body {
                    font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
                }
            </style>
        @endif
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <div class="mx-auto flex min-h-screen max-w-6xl flex-col px-4 py-8 sm:px-6 lg:px-8">
            <header class="flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white/80 p-6 shadow-lg shadow-slate-200/50 backdrop-blur-sm sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <a href="/" class="text-3xl font-bold tracking-tight text-slate-950">e-MatchKerja</a>
                    <p class="mt-2 text-sm text-slate-600">Platform pencarian kerja sederhana untuk pencari kerja dan perusahaan.</p>
                </div>
                <div class="flex flex-wrap items-center gap-3">
                    @auth
                        <a href="{{ url('/profil-saya') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-slate-950 px-5 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Profil Saya
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-slate-50 px-5 py-2 text-sm font-semibold text-slate-950 shadow-sm transition hover:bg-slate-100">
                                Logout
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-5 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-5 py-2 text-sm font-semibold text-slate-950 transition hover:bg-slate-100">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            </header>
            <main class="mt-10 grid gap-10 lg:grid-cols-[1.4fr_0.9fr] lg:items-center">
                <section class="space-y-8 rounded-[2rem] bg-white p-8 shadow-lg shadow-slate-200/50">
                    <div class="space-y-4">
                        <p class="text-sm font-semibold uppercase tracking-[0.35em] text-slate-500">Selamat datang</p>
                        <h1 class="text-4xl font-semibold tracking-tight text-slate-950 sm:text-5xl">
                            Temukan pekerjaan impianmu dengan mudah.
                        </h1>
                        <p class="max-w-2xl text-lg leading-8 text-slate-600">
                            e-MatchKerja membantu pencari kerja dan perusahaan bertemu lebih cepat.
                            Buat akun sekarang atau login untuk mulai mencari lowongan dan mengatur profilmu.
                        </p>
                    </div>
                    @guest
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center rounded-full bg-slate-950 px-7 py-3 text-base font-semibold text-white shadow-lg shadow-slate-900/10 transition hover:bg-slate-800">
                                Daftar Sekarang
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full border border-slate-300 bg-white px-7 py-3 text-base font-semibold text-slate-950 transition hover:bg-slate-50">
                                Login
                            </a>
                        </div>
                    @endguest
                </section>
                <section class="space-y-6 rounded-[2rem] bg-slate-950 p-8 text-white shadow-lg shadow-slate-950/20">
                    <div class="space-y-2">
                        <h2 class="text-2xl font-semibold">Fitur Utama</h2>
                        <p class="text-slate-300">Semua fitur penting untuk membantu proses pencarian kerja dan perekrutan.</p>
                    </div>
                    <ul class="space-y-4 text-slate-200">
                        <li class="flex gap-3">
                            <span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                            <span>Mencari dan melamar lowongan dengan cepat.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                            <span>Profil pencari kerja dan lowongan perusahaan terpusat.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="mt-1 inline-flex h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                            <span>Antarmuka sederhana untuk melihat informasi utama.</span>
                        </li>
                    </ul>
                </section>
            </main>
        </div>
    </body>
</html>
