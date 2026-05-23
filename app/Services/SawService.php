<?php

namespace App\Services;

use App\Models\JobSeekerProfile;
use App\Models\Kriteria;

class SawService
{
    public function hitungSAW()
    {
        // 1. Ambil kriteria dan data pencari kerja yang sudah terverifikasi petugas
        $kriterias = Kriteria::all();
        $kandidats = JobSeekerProfile::where('status_verifikasi', 'Verified')->get();

        if ($kandidats->isEmpty() || $kriterias->isEmpty()) {
            return [];
        }

        // 2. Konversi data kualitatif/kuantitatif kandidat ke dalam bentuk skor angka mentah
        $matriksKeputusan = [];
        foreach ($kandidats as $kan) {
            $matriksKeputusan[$kan->id] = [
                'profile' => $kan,
                'skor_mentah' => [
                    'C1' => $this->skorStatusKerja($kan->status_kerja_saat_ini),
                    'C2' => $this->skorLamaMenganggur($kan->lama_menganggur),
                    'C3' => (float) $kan->pendapatan_bulanan,
                    'C4' => $kan->jumlah_tanggungan,
                    'C5' => $kan->is_penerima_bansos_lain ? 1 : 0
                ]
            ];
        }

        // 3. Cari nilai Max (untuk Benefit) dan Min (untuk Cost)
        $maxMin = [];
        foreach ($kriterias as $krit) {
            $kode = $krit->kode_kriteria;
            $kumpulanNilai = collect($matriksKeputusan)->pluck("skor_mentah.$kode")->toArray();

            $maxMin[$kode] = [
                'max' => max($kumpulanNilai),
                'min' => min($kumpulanNilai) == 0 ? 1 : min($kumpulanNilai) // Hindari pembagian dengan angka 0
            ];
        }

        // 4. Proses Normalisasi & Hitung Nilai Akhir Preferensi (V)
        $hasilRanking = [];
        foreach ($matriksKeputusan as $id => $data) {
            $totalSkor = 0;

            foreach ($kriterias as $krit) {
                $kode = $krit->kode_kriteria;
                $nilaiMentah = $data['skor_mentah'][$kode];
                $nilaiNormalisasi = 0;

                if ($krit->jenis == 'benefit') {
                    $nilaiNormalisasi = $maxMin[$kode]['max'] != 0 ? ($nilaiMentah / $maxMin[$kode]['max']) : 0;
                } else {
                    $nilaiNormalisasi = $nilaiMentah != 0 ? ($maxMin[$kode]['min'] / $nilaiMentah) : 0;
                }

                // Kalikan dengan bobot kriteria
                $totalSkor += ($nilaiNormalisasi * $krit->bobot);
            }

            $hasilRanking[] = [
                'job_seeker_id' => $id,
                'nik' => $data['profile']->nik,
                'nama' => $data['profile']->nama_lengkap,
                'skor_akhir' => round($totalSkor, 4)
            ];
        }

        // 5. Urutkan dari skor tertinggi (Prioritas Utama Penerima Bantuan)
        usort($hasilRanking, function ($a, $b) {
            return $b['skor_akhir'] <=> $a['skor_akhir'];
        });

        return $hasilRanking;
    }

    // Fungsi konversi pembobotan internal (Sub-Kriteria)
    private function skorStatusKerja($status) {
        return match($status) {
            'PHK' => 3,
            'Menganggur' => 2,
            'Bekerja Serabutan' => 1,
            default => 0
        };
    }

    private function skorLamaMenganggur($bulan) {
        if ($bulan > 12) return 3; // > 1 tahun
        if ($bulan >= 6) return 2;  // 6 - 12 bulan
        if ($bulan > 0) return 1;   // < 6 bulan
        return 0;
    }
}