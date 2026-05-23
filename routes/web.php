<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PengajuanBantuanController;
use App\Http\Controllers\LaporanBantuanController;
use Illuminate\Support\Facades\Route;

// ================== AUTHENTICATION ROUTES (Paling Pertama) ==================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ================== HALAMAN PUBLIK ==================
Route::get('/', function () {
    if (auth()->check()) {
        $user = auth()->user();
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->hasRole('employer')) {
            return redirect()->route('perusahaan.dashboard');
        }
        if ($user->hasRole('job_seeker')) {
            return redirect()->route('pencari-kerja.dashboard');
        }
        if ($user->hasRole('verifier')) {  // <-- TAMBAHKAN INI
            return redirect()->route('pengajuan-bantuan.index');
        }
    }
    return view('welcome');
})->name('home');

// ================== DASHBOARD ROUTES ==================
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])
        ->name('admin.dashboard')
        ->middleware('role:admin');

    Route::get('/perusahaan/dashboard', [DashboardController::class, 'perusahaanDashboard'])
        ->name('perusahaan.dashboard')
        ->middleware('role:employer');

    Route::get('/pencari-kerja/dashboard', [DashboardController::class, 'pencariKerjaDashboard'])
        ->name('pencari-kerja.dashboard')
        ->middleware('role:job_seeker');

    Route::get('/peta-sebaran', [DashboardController::class, 'petaSebaran'])
        ->name('peta.sebaran');
});

// ================== PERSON 5 ROUTES ==================
Route::middleware(['auth'])->group(function () {
    Route::prefix('pengajuan-bantuan')->name('pengajuan-bantuan.')->group(function () {
        Route::get('/', [PengajuanBantuanController::class, 'index'])->name('index');
        Route::get('/create', [PengajuanBantuanController::class, 'create'])->name('create');
        Route::post('/', [PengajuanBantuanController::class, 'store'])->name('store');
        Route::get('/{pengajuan}', [PengajuanBantuanController::class, 'show'])->name('show');
        Route::post('/{pengajuan}/verifikasi', [PengajuanBantuanController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/{pengajuan}/approve', [PengajuanBantuanController::class, 'approve'])->name('approve');
        Route::post('/{pengajuan}/tolak', [PengajuanBantuanController::class, 'tolak'])->name('tolak');
        Route::post('/{pengajuan}/salurkan', [PengajuanBantuanController::class, 'salurkan'])->name('salurkan');
        Route::post('/{pengajuan}/upload-bukti', [PengajuanBantuanController::class, 'uploadBukti'])->name('upload-bukti');
    });

    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanBantuanController::class, 'index'])->name('index');
        Route::get('/export-excel', [LaporanBantuanController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-pdf', [LaporanBantuanController::class, 'exportPDF'])->name('export.pdf');
    });
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');