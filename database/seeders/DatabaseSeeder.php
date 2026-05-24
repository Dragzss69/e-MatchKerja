<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Kriteria;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    private function assignRole(User $user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();
        if ($role && !$user->roles->contains($role->id)) {
            $user->roles()->attach($role->id);
        }
    }

    public function run(): void
    {
        // ==================== PANGGIL SEEDER LAIN ====================
        $this->call([
            RoleSeeder::class,
            KriteriaSeeder::class,
        ]);

        // ==================== ADMIN ====================
        $admin = User::firstOrCreate(
            ['email' => 'admin@ematchkerja.test'],
            ['name' => 'Admin Dinas', 'password' => bcrypt('password')]
        );
        $this->assignRole($admin, 'admin');

        // ==================== PETUGAS VERIFIKASI ====================
        $petugas = User::firstOrCreate(
            ['email' => 'petugas@ematchkerja.test'],
            ['name' => 'Petugas Verifikasi', 'password' => bcrypt('password')]
        );
        $this->assignRole($petugas, 'verifier');

        // ==================== PERUSAHAAN ====================
        $perusahaan = User::firstOrCreate(
            ['email' => 'hrd@majujaya.test'],
            ['name' => 'PT Maju Jaya Abadi', 'password' => bcrypt('password')]
        );
        $this->assignRole($perusahaan, 'employer');

        // ==================== PENCAKER KERJA (5 orang default) ====================
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(
                ['email' => "pencari{$i}@ematchkerja.test"],
                ['name' => "Pencari Kerja {$i}", 'password' => bcrypt('password')]
            );
            $this->assignRole($user, 'job_seeker');

            // Berikan profile default agar bisa masuk ke data admin/petugas
            \App\Models\JobSeekerProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'nik' => '720' . $i . rand(100000, 999999) . '1234',
                    'nama_lengkap' => $user->name,
                    'tanggal_lahir' => '1995-05-1' . $i,
                    'jenis_kelamin' => $i % 2 === 0 ? 'P' : 'L',
                    'alamat_ktp' => 'Jl. Merdeka No. ' . $i . ', Palu',
                    'no_hp' => '08123456789' . $i,
                    'pendidikan_terakhir' => 'S1',
                    'status_kerja_saat_ini' => 'Menganggur',
                    'lama_menganggur' => 6 + $i,
                    'pendapatan_bulanan' => 0,
                    'jumlah_tanggungan' => 2,
                    'status_verifikasi' => $i % 2 === 0 ? 'Verified' : 'Unverified',
                ]
            );
        }

        // ==================== PENCAKER KERJA TAMBAHAN (Andi, Siti, Budi, Dewi) ====================
        $this->call(JobSeekerProfileSeeder::class);

        // ==================== PENGAJUAN BANTUAN ====================
        $this->call(PengajuanBantuanSeeder::class);

        $this->command->info('✅ Database seeding selesai!');
        $this->command->info('Akun yang tersedia:');
        $this->command->info('Admin      : admin@ematchkerja.test / password');
        $this->command->info('Petugas    : petugas@ematchkerja.test / password');
        $this->command->info('Perusahaan : hrd@majujaya.test / password');
        $this->command->info('Pencari 1-5: pencari1@ematchkerja.test / password (dst)');
    }
}