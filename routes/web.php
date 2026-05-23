<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobSeekerProfileController;
use App\Http\Controllers\LowonganKerjaController;
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