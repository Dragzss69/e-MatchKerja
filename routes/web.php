<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\LowonganKerjaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpkBantuanController;

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
Route::middleware(['auth'])->group(function () {
    // Jalur halaman rekomendasi bantuan sosial berbasis risiko ekonomi
    Route::get('/admin/rekomendasi-bantuan', [SpkBantuanController::class, 'index'])->name('admin.spk.index');
});

=======
// ====================== AUTH ======================
>>>>>>> origin/person4-data
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
<<<<<<< HEAD
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
=======

    // ====================== JOB SEEKER PROFILE (Person 4) ======================
    Route::get('/profil-saya', [JobSeekerProfileController::class, 'create'])
         ->name('jobseeker.profile.create');
         
    Route::post('/profil-saya', [JobSeekerProfileController::class, 'store'])
         ->name('jobseeker.profile.store');

    Route::resource('jobseeker-profiles', JobSeekerProfileController::class)
         ->except(['create', 'store']);

    Route::get('admin/jobseekers', [JobSeekerProfileController::class, 'index'])
         ->name('admin.jobseekers.index');

    // ====================== LOWONGAN KERJA (Person 4) ======================
    
    // Untuk Perusahaan memposting lowongan
    Route::get('/lowongan-saya', [LowonganKerjaController::class, 'create'])
         ->name('perusahaan.lowongan.create');
         
    Route::post('/lowongan-saya', [LowonganKerjaController::class, 'store'])
         ->name('perusahaan.lowongan.store');

    // Resource Route untuk Admin / Umum
    Route::resource('lowongan', LowonganKerjaController::class)
         ->except(['create', 'store']);   // create & store sudah di atas

    // Route tambahan untuk Admin
    Route::get('admin/lowongan', [LowonganKerjaController::class, 'index'])
         ->name('admin.lowongan.index');
});
>>>>>>> origin/person4-data
