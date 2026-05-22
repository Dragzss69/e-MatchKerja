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
        $this->call(RoleSeeder::class);

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
        }

        $this->call(PengajuanBantuanSeeder::class);

        $this->command->info('✅ Database seeding selesai!');
    }
}