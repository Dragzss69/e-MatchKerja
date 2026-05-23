<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\LaporanBantuanController;
use App\Http\Controllers\LowonganKerjaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PengajuanBantuanController;
use App\Http\Controllers\SpkBantuanController;
use Illuminate\Support\Facades\Route;


// ==================== HALAMAN PUBLIK ====================
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
        if ($user->hasRole('verifier')) {
            return redirect()->route('pengajuan-bantuan.index');
        }
    }
    return view('welcome');
})->name('home');

// ==================== AUTHENTICATION (Person 1) ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/forgot-password', function () {
    return redirect()->back()->with('info', 'Fitur Lupa Password sedang dalam pengembangan.');
})->name('password.request');

// ==================== DASHBOARD (Person 3) ====================
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

// ==================== SPK BANTUAN (Person 2) ====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/rekomendasi-bantuan', [SpkBantuanController::class, 'index'])
        ->name('admin.spk.index');
});

// ==================== PENGAJUAN BANTUAN (Person 5) ====================
Route::middleware(['auth'])->prefix('pengajuan-bantuan')->name('pengajuan-bantuan.')->group(function () {
    Route::get('/', [PengajuanBantuanController::class, 'index'])->name('index');
    Route::get('/create', [PengajuanBantuanController::class, 'create'])->name('create');
    Route::post('/', [PengajuanBantuanController::class, 'store'])->name('store');
    Route::get('/{pengajuan}', [PengajuanBantuanController::class, 'show'])->name('show');
    
    // Approval Workflow
    Route::post('/{pengajuan}/verifikasi', [PengajuanBantuanController::class, 'verifikasi'])->name('verifikasi');
    Route::post('/{pengajuan}/approve', [PengajuanBantuanController::class, 'approve'])->name('approve');
    Route::post('/{pengajuan}/tolak', [PengajuanBantuanController::class, 'tolak'])->name('tolak');
    Route::post('/{pengajuan}/salurkan', [PengajuanBantuanController::class, 'salurkan'])->name('salurkan');
});

// ==================== LAPORAN (Person 5) ====================
Route::middleware(['auth'])->prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/', [LaporanBantuanController::class, 'index'])->name('index');
    Route::get('/export-excel', [LaporanBantuanController::class, 'exportExcel'])->name('export.excel');
    Route::get('/export-pdf', [LaporanBantuanController::class, 'exportPDF'])->name('export.pdf');
});

// ==================== NOTIFIKASI (Person 1) ====================
Route::middleware(['auth'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])->name('markAllRead');
    Route::get('/{id}/read', [NotificationController::class, 'markRead'])->name('markRead');
});

// ==================== DATA PENCARI KERJA (Person 4) ====================
Route::middleware(['auth'])->group(function () {
    // Job Seeker Profile
    Route::get('/profil-saya', [JobSeekerProfileController::class, 'create'])
        ->name('jobseeker.profile.create')
        ->middleware('role:job_seeker');
    
    Route::post('/profil-saya', [JobSeekerProfileController::class, 'store'])
        ->name('jobseeker.profile.store')
        ->middleware('role:job_seeker');
    
    Route::resource('jobseeker-profiles', JobSeekerProfileController::class)
        ->except(['create', 'store'])
        ->middleware('role:admin');
    
    Route::get('/admin/jobseekers', [JobSeekerProfileController::class, 'index'])
        ->name('admin.jobseekers.index')
        ->middleware('role:admin');
});

// ==================== LOWONGAN KERJA (Person 4) ====================
Route::middleware(['auth'])->group(function () {
    // Untuk Perusahaan
    Route::get('/lowongan-saya', [LowonganKerjaController::class, 'create'])
        ->name('perusahaan.lowongan.create')
        ->middleware('role:employer');
    
    Route::post('/lowongan-saya', [LowonganKerjaController::class, 'store'])
        ->name('perusahaan.lowongan.store')
        ->middleware('role:employer');
    
    // Untuk Admin
    Route::get('/admin/lowongan', [LowonganKerjaController::class, 'index'])
        ->name('admin.lowongan.index')
        ->middleware('role:admin');
    
    // Resource Route untuk umum
    Route::resource('lowongan', LowonganKerjaController::class)
        ->except(['create', 'store']);
});