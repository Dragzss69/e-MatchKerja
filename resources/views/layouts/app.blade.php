<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>e-MatchKerja - @yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Mobile bottom navigation */
        @media (max-width: 768px) {
            .main-content {
                padding-bottom: 70px;
            }
            .bottom-nav {
                display: flex;
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                background: white;
                box-shadow: 0 -2px 10px rgba(0,0,0,0.1);
                z-index: 50;
            }
            .sidebar-desktop {
                display: none;
            }
        }
        @media (min-width: 769px) {
            .bottom-nav {
                display: none;
            }
            .sidebar-desktop {
                display: block;
            }
        }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <button id="mobile-menu-btn" class="md:hidden mr-3 text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    <span class="text-xl font-bold text-blue-600">e-MatchKerja</span>
                </div>
                <div class="hidden md:flex space-x-6">
                    <a href="{{ url('/') }}" class="text-gray-700 hover:text-blue-600">Beranda</a>
                    <a href="{{ url('/admin/dashboard') }}" class="text-gray-700 hover:text-blue-600">Admin</a>
                    <a href="{{ url('/perusahaan/dashboard') }}" class="text-gray-700 hover:text-blue-600">Perusahaan</a>
                    <a href="{{ url('/pencari-kerja/dashboard') }}" class="text-gray-700 hover:text-blue-600">Pencari Kerja</a>
                    <a href="{{ url('/map') }}" class="text-gray-700 hover:text-blue-600">Peta Sebaran</a>
                </div>
                <div class="flex items-center space-x-3">
                    <span class="text-sm text-gray-600 hidden sm:inline">Role: </span>
                    <span class="text-sm font-semibold text-blue-600" id="user-role">Admin</span>
                </div>
            </div>
        </div>
    </nav>

    <!-- Mobile Sidebar (drawer) -->
    <div id="mobile-sidebar" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden transition-all">
        <div class="bg-white w-64 h-full p-4">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg">Menu</h3>
                <button id="close-sidebar" class="text-gray-500 text-xl">&times;</button>
            </div>
            <ul class="space-y-3">
                <li><a href="{{ url('/admin/dashboard') }}" class="block p-2 hover:bg-blue-50 rounded transition">📊 Dashboard</a></li>
                <li><a href="#" class="block p-2 hover:bg-blue-50 rounded transition">👥 Pencari Kerja</a></li>
                <li><a href="#" class="block p-2 hover:bg-blue-50 rounded transition">💼 Lowongan</a></li>
                <li><a href="#" class="block p-2 hover:bg-blue-50 rounded transition">🎁 Bantuan</a></li>
                <li><a href="#" class="block p-2 hover:bg-blue-50 rounded transition">📄 Laporan</a></li>
                <li><a href="{{ url('/map') }}" class="block p-2 hover:bg-blue-50 rounded transition">🗺️ Peta</a></li>
            </ul>
        </div>
    </div>

    <!-- Desktop Sidebar + Content -->
    <div class="flex">
        <!-- Desktop Sidebar -->
        <aside class="sidebar-desktop w-64 bg-white shadow-lg h-screen sticky top-16">
            <div class="p-4">
                <h3 class="font-bold text-gray-700 mb-4">Menu</h3>
                <ul class="space-y-2">
                    <li><a href="{{ url('/admin/dashboard') }}" class="block p-2 hover:bg-blue-50 rounded transition">📊 Dashboard</a></li>
                    <li><a href="#" class="block p-2 hover:bg-blue-50 rounded transition">👥 Pencari Kerja</a></li>
                    <li><a href="#" class="block p-2 hover:bg-blue-50 rounded transition">💼 Lowongan</a></li>
                    <li><a href="#" class="block p-2 hover:bg-blue-50 rounded transition">🎁 Bantuan</a></li>
                    <li><a href="#" class="block p-2 hover:bg-blue-50 rounded transition">📄 Laporan</a></li>
                    <li><a href="{{ url('/map') }}" class="block p-2 hover:bg-blue-50 rounded transition">🗺️ Peta Sebaran</a></li>
                </ul>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-4 md:p-6 main-content">
            @yield('content')
        </main>
    </div>

    <!-- Bottom Navigation (Mobile) -->
    <div class="bottom-nav">
        <a href="{{ url('/admin/dashboard') }}" class="flex-1 flex flex-col items-center py-2 text-gray-600 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
            </svg>
            <span class="text-xs">Beranda</span>
        </a>
        <a href="{{ url('/map') }}" class="flex-1 flex flex-col items-center py-2 text-gray-600 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span class="text-xs">Peta</span>
        </a>
        <a href="#" class="flex-1 flex flex-col items-center py-2 text-gray-600 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
            </svg>
            <span class="text-xs">Notif</span>
        </a>
        <a href="#" class="flex-1 flex flex-col items-center py-2 text-gray-600 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            <span class="text-xs">Profil</span>
        </a>
    </div>

    <script>
        // Mobile sidebar toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const sidebar = document.getElementById('mobile-sidebar');
        const closeBtn = document.getElementById('close-sidebar');
        
        if (menuBtn) {
            menuBtn.onclick = () => sidebar.classList.remove('hidden');
            closeBtn.onclick = () => sidebar.classList.add('hidden');
            sidebar.onclick = (e) => { if (e.target === sidebar) sidebar.classList.add('hidden'); }
        }
        
        // Set role
        const role = localStorage.getItem('role') || 'admin';
        document.getElementById('user-role').innerText = role;
    </script>
</body>
</html>