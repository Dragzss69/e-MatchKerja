<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    private function assignRole(User $user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();
        if ($role && !$user->roles->contains($role->id)) {
            $user->roles()->attach($role->id);
        }
    }

    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            KriteriaSeeder::class,
        ]);

        // Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@ematchkerja.test'],
            ['name' => 'Admin Dinas', 'password' => bcrypt('password')]
        );
        $this->assignRole($admin, 'admin');

        // Petugas Verifikasi
        $petugas = User::firstOrCreate(
            ['email' => 'petugas@ematchkerja.test'],
            ['name' => 'Petugas Verifikasi', 'password' => bcrypt('password')]
        );
        $this->assignRole($petugas, 'verifier'); // ← diperbaiki dari 'petugas'

        // Pencari Kerja (5 orang)
        for ($i = 1; $i <= 5; $i++) {
            $user = User::firstOrCreate(
                ['email' => "pencari{$i}@ematchkerja.test"],
                ['name' => "Pencari Kerja {$i}", 'password' => bcrypt('password')]
            );
            $this->assignRole($user, 'job_seeker'); // ← diperbaiki dari 'pencari_kerja'

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

        // Jalankan Profile Seeder Tambahan (Andi, Siti, Budi, Dewi)
        $this->call(JobSeekerProfileSeeder::class);

        // Jalankan Seeder Pengajuan Bantuan
        $this->call(PengajuanBantuanSeeder::class);

        $this->command->info('✅ Database seeding selesai!');
    }
}