<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ====================== AKUN TESTING ======================

        // 1. Admin Dinas
        User::create([
            'name' => 'Admin Dinas',
            'email' => 'admin@ematchkerja.test',
            'password' => Hash::make('password'),
            // 'role' => 'admin'   ← dihapus karena kolomnya belum ada
        ]);



        // 3. Perusahaan
        User::create([
            'name' => 'PT Maju Jaya Abadi',
            'email' => 'hrd@majujaya.test',
            'password' => Hash::make('password'),
        ]);

        echo "✅ 3 Akun testing berhasil dibuat!\n";
        echo "Admin      : admin@ematchkerja.test / password\n";
        echo "Pencari    : andi@ematchkerja.test / password\n";
        echo "Perusahaan : hrd@majujaya.test / password\n";
    }
}