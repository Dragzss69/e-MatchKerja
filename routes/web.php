<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\LowonganKerjaController;
use App\Http\Controllers\LamaranKerjaController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// ====================== AUTH ======================
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // ====================== DASHBOARD ======================
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole(Role::EMPLOYER)) {
            return redirect()->route('perusahaan.dashboard');
        } elseif ($user->hasRole(Role::ADMIN)) {
            return redirect()->route('admin.jobseekers.index');
        }

        return redirect()->route('lowongan.index');
    })->name('dashboard');

    // Dashboard Perusahaan
    Route::get('/perusahaan/dashboard', [LowonganKerjaController::class, 'perusahaanDashboard'])
         ->name('perusahaan.dashboard');

    // ====================== LOWONGAN KERJA ======================
    Route::get('/lowongan', [LowonganKerjaController::class, 'index'])
         ->name('lowongan.index');

    Route::get('/lowongan-saya', [LowonganKerjaController::class, 'create'])
         ->name('perusahaan.lowongan.create');

    Route::post('/lowongan-saya', [LowonganKerjaController::class, 'store'])
         ->name('perusahaan.lowongan.store');

    Route::resource('lowongan', LowonganKerjaController::class)
         ->except(['create', 'store']);

    // ====================== LAMARAN KERJA ======================
    // Pencari kerja: submit lamaran
    Route::post('/lamaran/{lowongan_id}', [LamaranKerjaController::class, 'store'])
         ->name('lamaran.store');

    // Perusahaan: lihat pelamar per lowongan
    Route::get('/lowongan/{lowongan_id}/pelamar', [LamaranKerjaController::class, 'pelamar'])
         ->name('perusahaan.pelamar.index');

    // Perusahaan: detail 1 pelamar
    Route::get('/lamaran/{id}/detail', [LamaranKerjaController::class, 'show'])
         ->name('perusahaan.pelamar.show');

    // Perusahaan: download CV atau portofolio
    Route::get('/lamaran/{id}/download/{type}', [LamaranKerjaController::class, 'download'])
         ->name('lamaran.download');

    // Perusahaan: update status pelamar
    Route::put('/lamaran/{id}/status', [LamaranKerjaController::class, 'updateStatus'])
         ->name('lamaran.updateStatus');

    // Pencari kerja: riwayat lamaran sendiri
    Route::get('/riwayat-lamaran', [LamaranKerjaController::class, 'riwayat'])
         ->name('lamaran.riwayat');
});