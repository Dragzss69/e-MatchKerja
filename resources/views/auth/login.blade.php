@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 px-4">
    <div class="w-full max-w-sm bg-white border border-gray-200 rounded-2xl p-8">

        <h1 class="text-lg font-semibold mb-1" style="color: #185FA5; letter-spacing: -0.3px;">
            e-Match<span style="color: #1D9E75;">Kerja</span>
        </h1>
        <p class="text-xs text-gray-500 mb-6">Masuk ke akun Anda</p>

        @if ($errors->any())
            <div class="text-xs text-red-700 bg-red-50 border border-red-200 rounded-lg px-3 py-2.5 mb-4">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        @if(session('success'))
            <div class="text-xs text-green-700 bg-green-50 border border-green-200 rounded-lg px-3 py-2.5 mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-xs font-medium text-gray-600 mb-1.5">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       required autofocus placeholder="nama@email.com"
                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
            </div>

            <div class="mb-5">
                <label for="password" class="block text-xs font-medium text-gray-600 mb-1.5">Password</label>
                <input id="password" type="password" name="password"
                       required placeholder="••••••••"
                       class="w-full px-3 py-2 text-sm border border-gray-200 rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500 transition">
            </div>

            <div class="flex items-center justify-between mb-5">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600">
                    <span class="text-xs text-gray-500">Ingat saya</span>
                </label>
                <a href="{{ route('password.request') }}" class="text-xs font-medium" style="color: #185FA5;">
                    Lupa password?
                </a>
            </div>

            <button type="submit"
                    class="w-full py-2.5 text-sm font-medium text-white rounded-lg transition"
                    style="background: #185FA5;"
                    onmouseover="this.style.background='#0C447C'"
                    onmouseout="this.style.background='#185FA5'">
                Masuk
            </button>
        </form>

        <p class="text-center text-xs text-gray-500 mt-5">
            Belum punya akun?
            <a href="{{ route('register') }}" class="font-medium" style="color: #185FA5;">Daftar</a>
        </p>
    </div>
</div>
@endsection