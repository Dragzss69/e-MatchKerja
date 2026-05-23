<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kriteria; // Pastikan kamu sudah membuat Model Kriteria sebelumnya

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_kriteria' => 'Status Kerja Saat Ini',
                'kode_kriteria' => 'C1',
                'jenis' => 'benefit',
                'bobot' => 0.25, // 25%
                'target_kolom' => 'status_kerja_saat_ini'
            ],
            [
                'nama_kriteria' => 'Lama Menganggur',
                'kode_kriteria' => 'C2',
                'jenis' => 'benefit',
                'bobot' => 0.20, // 20%
                'target_kolom' => 'lama_menganggur'
            ],
            [
                'nama_kriteria' => 'Pendapatan Bulanan',
                'kode_kriteria' => 'C3',
                'jenis' => 'cost', // Makin kecil pendapatan, makin prioritas dapat bantuan
                'bobot' => 0.25, // 25%
                'target_kolom' => 'pendapatan_bulanan'
            ],
            [
                'nama_kriteria' => 'Jumlah Tanggungan',
                'kode_kriteria' => 'C4',
                'jenis' => 'benefit', // Makin banyak tanggungan, makin prioritas
                'bobot' => 0.15, // 15%
                'target_kolom' => 'jumlah_tanggungan'
            ],
            [
                'nama_kriteria' => 'Penerima Bansos Lain',
                'kode_kriteria' => 'C5',
                'jenis' => 'cost', // Jika sudah menerima bansos lain, prioritasnya diperkecil
                'bobot' => 0.15, // 15%
                'target_kolom' => 'is_penerima_bansos_lain'
            ],
        ];

        foreach ($data ?? [] as $item) {
            Kriteria::updateOrCreate(['kode_kriteria' => $item['kode_kriteria']], $item);
        }
    }
}