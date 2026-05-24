<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\LowonganKerjaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PengajuanBantuanController;
use App\Http\Controllers\SpkBantuanController;
use App\Http\Controllers\LaporanBantuanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// ==================== HALAMAN PUBLIK ====================
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

// ==================== AUTHENTICATION ====================
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// ==================== DASHBOARD & SPK ====================
Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // SPK Rekomendasi Bantuan (Person 2)
    Route::get('/admin/rekomendasi-bantuan', [SpkBantuanController::class, 'index'])->name('admin.spk.index');
});

// ==================== ADMIN DATA MANAGEMENT ====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Data Pencari Kerja untuk Admin
    Route::get('admin/jobseekers', [JobSeekerProfileController::class, 'index'])->name('admin.jobseekers.index');
    Route::get('admin/jobseekers/export-statistik', [JobSeekerProfileController::class, 'exportStatistikPDF'])->name('admin.jobseekers.export-statistik');
    Route::get('admin/jobseekers/{id}', [JobSeekerProfileController::class, 'showAdminProfile'])->name('jobseeker-profiles.show');
    
    // Kelola Lowongan untuk Admin
    Route::get('admin/lowongan', [LowonganKerjaController::class, 'index'])->name('admin.lowongan.index');
});

// ==================== VERIFIER DATA MANAGEMENT ====================
Route::middleware(['auth', 'role:verifier'])->group(function () {
    // Verifikasi Data Diri Pencari Kerja
    Route::get('verifier/jobseekers/pending-verification', [JobSeekerProfileController::class, 'pendingVerification'])
        ->name('verifier.jobseekers.pending-verification');
    Route::post('verifier/jobseekers/{id}/verifikasi-data-diri', [JobSeekerProfileController::class, 'verifikasiDataDiri'])
        ->name('verifier.jobseekers.verifikasi-data-diri');
});

// ==================== JOB SEEKER PROFILE (Pencari Kerja) ====================
Route::middleware(['auth', 'role:job_seeker'])->group(function () {
    Route::get('/profil-saya', [JobSeekerProfileController::class, 'show'])->name('jobseeker.profile.show');
    Route::get('/profil-saya/create', [JobSeekerProfileController::class, 'create'])->name('jobseeker.profile.create');
    Route::post('/profil-saya', [JobSeekerProfileController::class, 'store'])->name('jobseeker.profile.store');
    Route::get('/profil-saya/edit', [JobSeekerProfileController::class, 'edit'])->name('jobseeker.profile.edit');
    Route::put('/profil-saya', [JobSeekerProfileController::class, 'update'])->name('jobseeker.profile.update');
    Route::delete('/profil-saya', [JobSeekerProfileController::class, 'destroy'])->name('jobseeker.profile.destroy');
});

// ==================== LOWONGAN KERJA (Umum & Perusahaan) ====================
Route::middleware(['auth'])->group(function () {
    Route::get('lowongan', [LowonganKerjaController::class, 'index'])->name('lowongan.index');
    Route::get('lowongan/{id}', [LowonganKerjaController::class, 'show'])->name('lowongan.show');
});

Route::middleware(['auth', 'role:employer'])->group(function () {
    Route::get('lowongan/create', [LowonganKerjaController::class, 'create'])->name('perusahaan.lowongan.create');
    Route::post('lowongan', [LowonganKerjaController::class, 'store'])->name('perusahaan.lowongan.store');
    Route::get('lowongan/{id}/edit', [LowonganKerjaController::class, 'edit'])->name('lowongan.edit');
    Route::put('lowongan/{id}', [LowonganKerjaController::class, 'update'])->name('lowongan.update');
    Route::delete('lowongan/{id}', [LowonganKerjaController::class, 'destroy'])->name('lowongan.destroy');
});

// ==================== PENGAJUAN BANTUAN (Person 5) ====================
Route::middleware(['auth'])->group(function () {
    Route::prefix('pengajuan-bantuan')->name('pengajuan-bantuan.')->group(function () {
        Route::get('/', [PengajuanBantuanController::class, 'index'])->name('index');
        Route::get('/create', [PengajuanBantuanController::class, 'create'])->name('create');
        Route::post('/', [PengajuanBantuanController::class, 'store'])->name('store');
        Route::get('/{pengajuan}', [PengajuanBantuanController::class, 'show'])->name('show');
        Route::get('/{pengajuan}/edit', [PengajuanBantuanController::class, 'edit'])->name('edit');
        Route::put('/{pengajuan}', [PengajuanBantuanController::class, 'update'])->name('update');
        Route::delete('/{pengajuan}', [PengajuanBantuanController::class, 'destroy'])->name('destroy');

        // Approval Workflow
        Route::post('/{pengajuan}/verifikasi', [PengajuanBantuanController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/{pengajuan}/approve', [PengajuanBantuanController::class, 'approve'])->name('approve');
        Route::post('/{pengajuan}/tolak', [PengajuanBantuanController::class, 'tolak'])->name('tolak');
        Route::post('/{pengajuan}/salurkan', [PengajuanBantuanController::class, 'salurkan'])->name('salurkan');
    });
});

// ==================== LAPORAN BANTUAN (Person 5) ====================
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

// ==================== LUPA PASSWORD (Sementara) ====================
Route::get('/forgot-password', function () {
    return redirect()->back()->with('info', 'Fitur Lupa Password sedang dalam pengembangan.');
})->name('password.request');