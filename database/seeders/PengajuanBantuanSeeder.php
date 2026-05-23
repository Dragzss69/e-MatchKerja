<?php

namespace Database\Seeders;

use App\Models\PengajuanBantuan;
use App\Models\User;
use Illuminate\Database\Seeder;

class PengajuanBantuanSeeder extends Seeder
{
    public function run()
    {
        $users = User::with('roles')->get();

        foreach ($users as $user) {
            // Hanya buat pengajuan untuk job_seeker
            if (!$user->roles->pluck('name')->contains('job_seeker')) {
                continue;
            }

            PengajuanBantuan::create([
                'pencari_kerja_id' => $user->id,
                'jenis_bantuan'    => 'subsidi_upah',
                'alasan'           => 'Saya sudah menganggur selama 6 bulan dan memiliki tanggungan keluarga.',
                'nominal_diajukan' => 2500000,
                'status'           => 'pending',
            ]);

            PengajuanBantuan::create([
                'pencari_kerja_id' => $user->id,
                'jenis_bantuan'    => 'modal_umkm',
                'alasan'           => 'Ingin membuka usaha kecil warung makan untuk menambah penghasilan.',
                'nominal_diajukan' => 5000000,
                'status'           => 'diverifikasi',
            ]);
        }

        $this->command->info('✅ Dummy data pengajuan bantuan berhasil dibuat!');
    }
}