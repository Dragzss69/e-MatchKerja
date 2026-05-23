<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'e-MatchKerja') }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0; 
            background: #f7fafc; 
            color: #1a202c; 
        }
        .container { 
            max-width: 1200px; 
            margin: 30px auto; 
            padding: 20px; 
        }
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            background: #2b6cb0; 
            color: white; 
            padding: 15px 25px; 
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .header h1 { margin: 0; font-size: 1.5rem; }
        .nav a { 
            color: white; 
            margin-left: 20px; 
            text-decoration: none; 
            font-weight: 500;
        }
        .nav a:hover { text-decoration: underline; }
        .alert { 
            padding: 12px 16px; 
            border-radius: 8px; 
            margin-bottom: 20px; 
        }
        .alert-success { background: #c6f6d5; color: #22543d; }
        .alert-danger { background: #fed7d7; color: #9b2c2c; }
    </style>
</head>
<body>
    <div class="container">
        
        <!-- HEADER / NAVBAR -->
        <div class="header">
            <h1>e-MatchKerja</h1>
            
            <div class="nav">
                @auth
                    @if (Auth::user()->hasRole('admin') || true) <!-- sementara semua bisa akses -->
                        <a href="{{ route('admin.jobseekers.index') }}">Pencari Kerja</a>
                        <a href="{{ route('admin.lowongan.index') }}">Lowongan</a>
                    @endif

                    <a href="{{ route('jobseeker.profile.create') }}">Profil Saya</a>
                    <a href="{{ route('perusahaan.lowongan.create') }}">Posting Lowongan</a>

                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none; border:none; color:white; cursor:pointer;">
                            Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>

        <!-- Pesan Success / Error -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @yield('content')

    </div>
</body>
</html>