<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobSeekerProfileControlleR;
use App\Http\Controllers\LamaranKerjaController;
use App\Http\Controllers\LaporanBantuanController;
use App\Http\Controllers\LowonganKerjaController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PengajuanBantuanController;
use App\Http\Controllers\SpkBantuanController;
use App\Models\Role;
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

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // ==================== DASHBOARD ====================
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->hasRole(Role::EMPLOYER)) {
            return redirect()->route('perusahaan.dashboard');
        } elseif ($user->hasRole(Role::ADMIN)) {
            return redirect()->route('admin.jobseekers.index');
        } elseif ($user->hasRole(Role::VERIFIER)) {
            return redirect()->route('verifier.dashboard');
        } elseif ($user->hasRole(Role::JOB_SEEKER)) {
        return redirect()->route('pencari-kerja.dashboard'); // ← UBAH KE DASHBOARD PENCAKAR KERJA
    }

        return redirect()->route('lowongan.index');
    })->name('dashboard');
    // ==================== VERIFIER MODULES ====================
    Route::middleware(['auth', 'role:verifier'])->group(function () {
        Route::get('/verifier/dashboard', function () {
            $statUnverifiedProfile = \App\Models\JobSeekerProfile::where('status_verifikasi', 'Unverified')->count();
            $statPending = \App\Models\PengajuanBantuan::where('status', 'pending')->count();
            $statVerified = \App\Models\PengajuanBantuan::where('status', 'diverifikasi')->count();
            
            return view('dashboard', compact('statUnverifiedProfile', 'statPending', 'statVerified'));
        })->name('verifier.dashboard');

        Route::get('verifier/jobseekers/pending-verification', [JobSeekerProfileController::class, 'pendingVerification'])
            ->name('verifier.jobseekers.pending-verification');
        Route::post('verifier/jobseekers/{id}/verifikasi-data-diri', [JobSeekerProfileController::class, 'verifikasiDataDiri'])
            ->name('verifier.jobseekers.verifikasi-data-diri');
    });

    // ==================== JOB SEEKER MODULES ====================
    Route::middleware(['auth', 'role:job_seeker'])->group(function () {
        Route::get('/pencari-kerja/dashboard', function () {
            return view('dashboard'); // Pakai dashboard utama yang sudah lengkap
        })->name('pencari-kerja.dashboard');

        Route::get('/profil-saya', [JobSeekerProfileController::class, 'show'])
            ->name('jobseeker.profile.show');
        Route::get('/profil-saya/create', [JobSeekerProfileController::class, 'create'])
            ->name('jobseeker.profile.create');
        Route::post('/profil-saya', [JobSeekerProfileController::class, 'store'])
            ->name('jobseeker.profile.store');
        Route::get('/profil-saya/edit', [JobSeekerProfileController::class, 'edit'])
            ->name('jobseeker.profile.edit');
        Route::put('/profil-saya', [JobSeekerProfileController::class, 'update'])
            ->name('jobseeker.profile.update');
        Route::delete('/profil-saya', [JobSeekerProfileController::class, 'destroy'])
            ->name('jobseeker.profile.destroy');

        Route::get('/lamaran-saya/{id}', [LamaranKerjaController::class, 'showForJobSeeker'])
            ->name('lamaran.jobseeker.show');
    });

    // Dashboard Perusahaan
    Route::get('/perusahaan/dashboard', [LowonganKerjaController::class, 'perusahaanDashboard'])
        ->name('perusahaan.dashboard');

    // SPK Rekomendasi Bantuan (Person 2)
    Route::get('/admin/rekomendasi-bantuan', [SpkBantuanController::class, 'index'])
        ->name('admin.spk.index')
        ->middleware('role:admin');
});

// ==================== ADMIN DATA MANAGEMENT ====================
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Data Pencari Kerja untuk Admin
    Route::get('admin/jobseekers', [JobSeekerProfileController::class, 'index'])
        ->name('admin.jobseekers.index');
    Route::get('admin/jobseekers/export-statistik', [JobSeekerProfileController::class, 'exportStatistikPDF'])
        ->name('admin.jobseekers.export-statistik');
    Route::get('admin/jobseekers/{id}', [JobSeekerProfileController::class, 'showAdminProfile'])
        ->name('jobseeker-profiles.show');
    
    // Kelola Lowongan untuk Admin
    Route::get('admin/lowongan', [LowonganKerjaController::class, 'index'])
        ->name('admin.lowongan.index');
});


// ==================== LOWONGAN KERJA ====================
Route::middleware(['auth'])->group(function () {
    // Umum
    Route::get('/lowongan', [LowonganKerjaController::class, 'index'])
        ->name('lowongan.index');
    Route::get('/lowongan/{id}', [LowonganKerjaController::class, 'show'])
        ->name('lowongan.show');
});

Route::middleware(['auth', 'role:employer'])->group(function () {
    Route::get('/lowongan-perusahaan', [LowonganKerjaController::class, 'perusahaanLowongan'])
        ->name('perusahaan.lowongan.index');
    Route::get('/lowongan-saya', [LowonganKerjaController::class, 'create'])
        ->name('perusahaan.lowongan.create');
    Route::post('/lowongan-saya', [LowonganKerjaController::class, 'store'])
        ->name('perusahaan.lowongan.store');
    Route::get('/lowongan/{id}/edit', [LowonganKerjaController::class, 'edit'])
        ->name('lowongan.edit');
    Route::put('/lowongan/{id}', [LowonganKerjaController::class, 'update'])
        ->name('lowongan.update');
    Route::delete('/lowongan/{id}', [LowonganKerjaController::class, 'destroy'])
        ->name('lowongan.destroy');
});

// ==================== LAMARAN KERJA ====================
Route::middleware(['auth'])->group(function () {
    // Perusahaan: lihat pelamar per lowongan
    Route::get('/lowongan/{lowongan_id}/pelamar', [LamaranKerjaController::class, 'pelamar'])
        ->name('perusahaan.pelamar.index');
    
    // Perusahaan: detail 1 pelamar
    Route::get('/lamaran/{id}/detail', [LamaranKerjaController::class, 'show'])
        ->name('perusahaan.pelamar.show');
    
    // Perusahaan: update status pelamar
    Route::put('/lamaran/{id}/status', [LamaranKerjaController::class, 'updateStatus'])
        ->name('lamaran.updateStatus');
    
    // Perusahaan: download CV atau portofolio
    Route::get('/lamaran/{id}/download/{type}', [LamaranKerjaController::class, 'download'])
        ->name('lamaran.download');
    
    // Pencari kerja: submit lamaran
    Route::post('/lamaran/{lowongan_id}', [LamaranKerjaController::class, 'store'])
        ->name('lamaran.store');
    
    // Pencari kerja: riwayat lamaran
    Route::get('/riwayat-lamaran', [LamaranKerjaController::class, 'riwayat'])
        ->name('lamaran.riwayat');
});

// ==================== PENGAJUAN BANTUAN (Person 5) ====================
Route::middleware(['auth'])->group(function () {
    Route::prefix('pengajuan-bantuan')->name('pengajuan-bantuan.')->group(function () {
        Route::get('/', [PengajuanBantuanController::class, 'index'])
            ->name('index');
        Route::get('/create', [PengajuanBantuanController::class, 'create'])
            ->name('create');
        Route::post('/', [PengajuanBantuanController::class, 'store'])
            ->name('store');
        Route::get('/{pengajuan}', [PengajuanBantuanController::class, 'show'])
            ->name('show');
        Route::get('/{pengajuan}/edit', [PengajuanBantuanController::class, 'edit'])
            ->name('edit');
        Route::put('/{pengajuan}', [PengajuanBantuanController::class, 'update'])
            ->name('update');
        Route::delete('/{pengajuan}', [PengajuanBantuanController::class, 'destroy'])
            ->name('destroy');

        // Approval Workflow
        Route::post('/{pengajuan}/verifikasi', [PengajuanBantuanController::class, 'verifikasi'])
            ->name('verifikasi');
        Route::post('/{pengajuan}/approve', [PengajuanBantuanController::class, 'approve'])
            ->name('approve');
        Route::post('/{pengajuan}/tolak', [PengajuanBantuanController::class, 'tolak'])
            ->name('tolak');
        Route::post('/{pengajuan}/salurkan', [PengajuanBantuanController::class, 'salurkan'])
            ->name('salurkan');
    });
});

// ==================== LAPORAN BANTUAN (Person 5) ====================
Route::middleware(['auth'])->prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/', [LaporanBantuanController::class, 'index'])
        ->name('index');
    Route::get('/export-excel', [LaporanBantuanController::class, 'exportExcel'])
        ->name('export.excel');
    Route::get('/export-pdf', [LaporanBantuanController::class, 'exportPDF'])
        ->name('export.pdf');
});

// ==================== NOTIFIKASI (Person 1) ====================
Route::middleware(['auth'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])
        ->name('index');
    Route::post('/mark-all-read', [NotificationController::class, 'markAllRead'])
        ->name('markAllRead');
    Route::get('/{id}/read', [NotificationController::class, 'markRead'])
        ->name('markRead');
});

// ==================== LUPA PASSWORD (Sementara) ====================
Route::get('/forgot-password', function () {
    return redirect()->back()->with('info', 'Fitur Lupa Password sedang dalam pengembangan.');
})->name('password.request');