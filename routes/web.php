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
// Person 3 Routes
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});

Route::get('/perusahaan/dashboard', function () {
    return view('perusahaan.dashboard');
});

Route::get('/pencari-kerja/dashboard', function () {
    return view('pencari-kerja.dashboard');
});

Route::get('/map', function () {
    return view('map.index');
});