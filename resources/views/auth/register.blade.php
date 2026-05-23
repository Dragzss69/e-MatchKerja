@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="max-w-md mx-auto my-10">
    <div class="rounded-3xl bg-white border border-slate-200/80 shadow-sm overflow-hidden p-8 sm:p-10 space-y-6">
        
        <!-- Header -->
        <div class="text-center space-y-2">
            <h2 class="text-2xl font-black text-slate-900 tracking-tight">Daftar Akun Baru</h2>
            <p class="text-xs text-slate-400 font-semibold uppercase tracking-wider">Lengkapi data untuk bergabung ke e-MatchKerja</p>
        </div>

        <!-- Validation Errors -->
        @if ($errors->any())
            <div class="rounded-2xl bg-rose-50 p-4 border border-rose-200/80 text-rose-800 space-y-1">
                <div class="flex gap-2 items-center text-xs font-bold mb-1">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-sm"></i>
                    <span>Terdapat beberapa kesalahan:</span>
                </div>
                <ul class="text-[11px] list-disc list-inside text-rose-700 leading-relaxed pl-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Register Form -->
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Name -->
            <div class="flex flex-col gap-1.5">
                <label for="name" class="text-xs font-bold text-slate-500 uppercase tracking-wide">Nama Lengkap <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-sm pointer-events-none">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                           class="w-full rounded-xl border border-slate-200 pl-10 pr-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                           placeholder="Nama Lengkap Anda">
                </div>
            </div>

            <!-- Email Address -->
            <div class="flex flex-col gap-1.5">
                <label for="email" class="text-xs font-bold text-slate-500 uppercase tracking-wide">Alamat Email <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-sm pointer-events-none">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                           class="w-full rounded-xl border border-slate-200 pl-10 pr-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                           placeholder="nama@email.com">
                </div>
            </div>

            <!-- Role Selection -->
            <div class="flex flex-col gap-1.5">
                <label for="role" class="text-xs font-bold text-slate-500 uppercase tracking-wide">Daftar Sebagai <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-sm pointer-events-none">
                        <i class="fa-solid fa-users-gear"></i>
                    </span>
                    <select id="role" name="role" required
                            class="w-full rounded-xl border border-slate-200 pl-10 pr-4 py-3 text-sm bg-white focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500">
                        @foreach ($roles as $roleKey => $roleLabel)
                            <option value="{{ $roleKey }}" {{ old('role') === $roleKey ? 'selected' : '' }}>{{ $roleLabel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-1.5">
                <label for="password" class="text-xs font-bold text-slate-500 uppercase tracking-wide">Password <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-sm pointer-events-none">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input id="password" type="password" name="password" required
                           class="w-full rounded-xl border border-slate-200 pl-10 pr-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                           placeholder="Minimal 8 karakter">
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="flex flex-col gap-1.5">
                <label for="password_confirmation" class="text-xs font-bold text-slate-500 uppercase tracking-wide">Konfirmasi Password <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400 text-sm pointer-events-none">
                        <i class="fa-solid fa-circle-check"></i>
                    </span>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="w-full rounded-xl border border-slate-200 pl-10 pr-4 py-3 text-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500"
                           placeholder="Ketik ulang password">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full inline-flex items-center justify-center rounded-xl bg-indigo-600 px-4 py-3 text-xs font-bold text-white shadow-md shadow-indigo-100 hover:bg-indigo-700 transition">
                <i class="fa-solid fa-user-plus mr-2"></i> Register Sekarang
            </button>
        </form>

        <!-- Login Link -->
        <div class="text-center pt-4 border-t border-slate-100">
            <p class="text-xs text-slate-500 font-medium">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="font-bold text-indigo-600 hover:text-indigo-800 transition">Login Sekarang</a>
            </p>
        </div>

    </div>
</div>
@endsection
