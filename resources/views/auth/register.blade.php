@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4 py-8">
    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-2xl p-8">

        <h1 class="text-lg font-semibold mb-1" style="color: #185FA5; letter-spacing: -0.3px;">
            e-Match<span style="color: #1D9E75;">Kerja</span>
        </h1>
        <p class="text-xs text-gray-500 mb-6">Buat akun baru</p>

        @if ($errors->any())
            <div class="text-xs text-red-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2.5 mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-xs font-medium text-gray-600 mb-1.5">Nama lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                       placeholder="Nama Anda"
                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-xs font-medium text-gray-600 mb-1.5">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       placeholder="nama@email.com"
                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
            </div>

            <div class="mb-4">
                <label for="role" class="block text-xs font-medium text-gray-600 mb-1.5">Daftar sebagai</label>
                <select name="role" id="role" required
                        class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg
                               focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
                    <option value="job_seeker" {{ old('role') == 'job_seeker' ? 'selected' : '' }}>
                        Pencari kerja / masyarakat
                    </option>
                    <option value="perusahaan" {{ old('role') == 'perusahaan' ? 'selected' : '' }}>
                        Perusahaan / employer
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-xs font-medium text-gray-600 mb-1.5">Password</label>
                <input type="password" name="password" id="password" required
                       placeholder="••••••••"
                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
            </div>

            <div class="mb-6">
                <label for="password_confirmation" class="block text-xs font-medium text-gray-600 mb-1.5">Konfirmasi password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                       placeholder="••••••••"
                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
            </div>

            <button type="submit"
                    class="w-full py-2.5 text-sm font-medium text-white rounded-lg transition"
                    style="background: #185FA5;"
                    onmouseover="this.style.background='#0C447C'"
                    onmouseout="this.style.background='#185FA5'">
                Daftar
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-5">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="font-medium" style="color: #185FA5;">Masuk</a>
        </p>
    </div>
</div>
@endsection