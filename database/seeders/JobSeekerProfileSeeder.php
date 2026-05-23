<?php

namespace Database\Seeders;

use App\Models\JobSeekerProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobSeekerProfileSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Andi Saputra',
                'email' => 'andi@example.com',
                'jenis_kelamin' => 'L',
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti@example.com',
                'jenis_kelamin' => 'P',
            ],
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'jenis_kelamin' => 'L',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@example.com',
                'jenis_kelamin' => 'P',
            ],
        ];

        foreach ($data as $item) {
            $user = User::firstOrCreate(
                ['email' => $item['email']],
                [
                    'name' => $item['name'],
                    'password' => bcrypt('password'),
                ]
            );

            JobSeekerProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nik' => '72' . rand(1000000000, 9999999999),
                    'nama_lengkap' => $item['name'],
                    'tanggal_lahir' => '199' . rand(0,9) . '-0' . rand(1,9) . '-' . rand(10,28),
                    'jenis_kelamin' => $item['jenis_kelamin'],   // ← Ini yang diperbaiki
                    'alamat_ktp' => 'Jl. Contoh No.' . rand(10,99) . ', Palu',
                    'no_hp' => '08' . rand(10000000, 99999999),
                    'pendidikan_terakhir' => ['SMA/SMK', 'D3', 'S1'][rand(0,2)],
                    'status_kerja_saat_ini' => ['Menganggur', 'Bekerja Serabutan', 'PHK'][rand(0,2)],
                    'lama_menganggur' => rand(0, 24),
                    'pendapatan_bulanan' => rand(500000, 5000000),
                    'jumlah_tanggungan' => rand(0, 5),
                ]
            );
        }

        echo "✅ Dummy data Job Seeker berhasil dibuat!\n";
    }
}