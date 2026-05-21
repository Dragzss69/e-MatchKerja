@extends('layouts.app')

@section('content')
    <h2>Register</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="form-group">
            <label for="name">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="role">Daftar Sebagai</label>
            <select id="role" name="role" required>
                @foreach ($roles as $roleKey => $roleLabel)
                    <option value="{{ $roleKey }}" {{ old('role') === $roleKey ? 'selected' : '' }}>{{ $roleLabel }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Register</button>
    </form>

    <p class="small">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
@endsection
