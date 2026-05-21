<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'e-MatchKerja') }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 0; background: #f7fafc; color: #1a202c; }
        .container { max-width: 760px; margin: 40px auto; padding: 24px; background: #fff; border-radius: 12px; box-shadow: 0 12px 30px rgba(0,0,0,0.08); }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; }
        .header a { text-decoration: none; color: #2b6cb0; margin-left: 16px; }
        .form-group { margin-bottom: 16px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; }
        input, select, textarea { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e0; border-radius: 8px; }
        button { background: #2b6cb0; color: #fff; border: none; padding: 12px 20px; border-radius: 8px; cursor: pointer; }
        button:hover { background: #2c5282; }
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; }
        .alert-error { background: #fed7d7; color: #9b2c2c; }
        .alert-success { background: #c6f6d5; color: #22543d; }
        .small { font-size: 0.95rem; color: #4a5568; }
        .field-error { color: #c53030; font-size: 0.9rem; margin-top: 4px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>{{ config('app.name', 'e-MatchKerja') }}</h1>
                <p class="small">Sistem autentikasi dan manajemen akun</p>
            </div>
            <div>
                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>

        @if (session('status'))
            <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        @yield('content')
    </div>
</body>
</html>
