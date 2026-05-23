<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\LowonganKerjaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PengajuanBantuanController;
use App\Http\Controllers\SpkBantuanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Jalur halaman rekomendasi bantuan sosial berbasis risiko ekonomi
    Route::get('/admin/rekomendasi-bantuan', [SpkBantuanController::class, 'index'])->name('admin.spk.index');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('admin/jobseekers', [JobSeekerProfileController::class, 'index'])->name('admin.jobseekers.index');
    Route::get('admin/lowongan', [LowonganKerjaController::class, 'index'])->name('admin.lowongan.index');

    Route::get('jobseeker/profile/create', [JobSeekerProfileController::class, 'create'])->name('jobseeker.profile.create');
    Route::post('jobseeker/profile', [JobSeekerProfileController::class, 'store'])->name('jobseeker.profile.store');
    Route::get('jobseeker/profile/{id}/edit', [JobSeekerProfileController::class, 'edit'])->name('jobseeker-profiles.edit');
    Route::put('jobseeker/profile/{id}', [JobSeekerProfileController::class, 'update'])->name('jobseeker-profiles.update');
    Route::delete('jobseeker/profile/{id}', [JobSeekerProfileController::class, 'destroy'])->name('jobseeker-profiles.destroy');

    Route::get('lowongan', [LowonganKerjaController::class, 'index'])->name('lowongan.index');
    Route::get('lowongan/create', [LowonganKerjaController::class, 'create'])->name('perusahaan.lowongan.create');
    Route::post('lowongan', [LowonganKerjaController::class, 'store'])->name('perusahaan.lowongan.store');
    Route::get('lowongan/{id}', [LowonganKerjaController::class, 'show'])->name('lowongan.show');
    Route::get('lowongan/{id}/edit', [LowonganKerjaController::class, 'edit'])->name('lowongan.edit');
    Route::put('lowongan/{id}', [LowonganKerjaController::class, 'update'])->name('lowongan.update');
    Route::delete('lowongan/{id}', [LowonganKerjaController::class, 'destroy'])->name('lowongan.destroy');
});

// ================== PENGATURAN BANTUAN (Person 5) ==================
Route::middleware('auth')->group(function () {

    // Pengajuan Bantuan
    Route::prefix('pengajuan-bantuan')->name('pengajuan-bantuan.')->group(function () {
        Route::get('/', [App\Http\Controllers\PengajuanBantuanController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\PengajuanBantuanController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\PengajuanBantuanController::class, 'store'])->name('store');
        Route::get('/{pengajuan}', [App\Http\Controllers\PengajuanBantuanController::class, 'show'])->name('show');

        // Approval Workflow
        Route::post('/{pengajuan}/verifikasi', [App\Http\Controllers\PengajuanBantuanController::class, 'verifikasi'])->name('verifikasi');
        Route::post('/{pengajuan}/approve', [App\Http\Controllers\PengajuanBantuanController::class, 'approve'])->name('approve');
        Route::post('/{pengajuan}/tolak', [App\Http\Controllers\PengajuanBantuanController::class, 'tolak'])->name('tolak');
        Route::post('/{pengajuan}/disalurkan', [App\Http\Controllers\PengajuanBantuanController::class, 'disalurkan'])->name('disalurkan');
    });

    // Laporan Bantuan
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [App\Http\Controllers\LaporanBantuanController::class, 'index'])->name('index');
        Route::get('/export-excel', [App\Http\Controllers\LaporanBantuanController::class, 'exportExcel'])->name('export.excel');
        Route::get('/export-pdf', [App\Http\Controllers\LaporanBantuanController::class, 'exportPDF'])->name('export.pdf');
    });
});

// Route sementara untuk menghilangkan error Lupa Password
Route::get('/forgot-password', function () {
    return redirect()->back()->with('info', 'Fitur Lupa Password sedang dalam pengembangan.');
})->name('password.request');

// Notifikasi
Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
Route::get('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.markRead');

// Salurkan
Route::post('/pengajuan-bantuan/{pengajuan}/salurkan', [PengajuanBantuanController::class, 'salurkan'])->name('pengajuan-bantuan.salurkan');
