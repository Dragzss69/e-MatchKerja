<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\SawService;
use Illuminate\Http\Request;

class SpkBantuanController extends Controller
{
    protected $sawService;

    // Masukkan SawService ke dalam controller melalui Constructor Injection
    public function __construct(SawService $sawService)
    {
        $this->sawService = $sawService;
    }

    /**
     * Menampilkan Halaman Hasil Peringkat Kelayakan Bantuan
     */
    public function index()
    {
        // Jalankan kalkulasi pintar SAW yang ada di file Service
        $daftarRanking = $this->sawService->hitungSAW();

        // Oper hasilnya ke file view Blade milik anak Frontend (Person 3)
        return view('admin.spk.index', compact('daftarRanking'));
    }
}