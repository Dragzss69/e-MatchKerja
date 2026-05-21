<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 1. Gate untuk Admin Dinas (Memanggil fungsi isAdmin() dari model User)
        Gate::define('admin-dinas', function (User $user) {
            return $user->isAdmin();
        });

        // 2. Gate untuk Petugas Verifikasi
        Gate::define('petugas-verifikasi', function (User $user) {
            return $user->isVerifier();
        });

        // 3. Gate untuk Perusahaan / Employer
        Gate::define('perusahaan', function (User $user) {
            return $user->isEmployer();
        });

        // 4. Gate untuk Pencari Kerja / Job Seeker
        Gate::define('pencari-kerja', function (User $user) {
            return $user->isJobSeeker();
        });
    }
}