@extends('layouts.app')

@section('content')
    <h2>Login</h2>

    @if ($errors->any())
        <div class="alert alert-error">
            <ul style="margin: 0; padding-left: 18px;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
        </div>

        <div class="form-group">
            <label>
                <input type="checkbox" name="remember"> Remember me
            </label>
        </div>

        <button type="submit">Login</button>
    </form>

    <p class="small">Belum punya akun? <a href="{{ route('register') }}">Register</a></p>
    
    <!-- Link Lupa Password dinonaktifkan karena route belum dibuat -->
    <p class="small text-muted">Lupa password? (Fitur belum diimplementasikan)</p>
@endsection