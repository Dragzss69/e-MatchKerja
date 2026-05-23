<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
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