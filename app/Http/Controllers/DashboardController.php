<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PengajuanBantuan;
use App\Models\JobSeekerProfile;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function adminDashboard()
    {
        if (!Auth::user()->hasRole('admin')) {
            abort(403);
        }
        
        // Data untuk chart dari Person 5
        $statistikPengajuan = [
            'pending' => PengajuanBantuan::where('status', 'pending')->count(),
            'diverifikasi' => PengajuanBantuan::where('status', 'diverifikasi')->count(),
            'disetujui' => PengajuanBantuan::where('status', 'disetujui')->count(),
            'disalurkan' => PengajuanBantuan::where('status', 'disalurkan')->count(),
        ];
        
        // Pengajuan pending untuk verifikasi
        $pengajuanPending = PengajuanBantuan::with('pencariKerja')
                            ->where('status', 'pending')
                            ->latest()
                            ->take(10)
                            ->get();
        
        return view('admin.dashboard', compact('statistikPengajuan', 'pengajuanPending'));
    }

    public function perusahaanDashboard()
    {
        if (!Auth::user()->hasRole('employer')) {
            abort(403);
        }
        
        return view('perusahaan.dashboard');
    }

    public function pencariKerjaDashboard()
    {
        if (!Auth::user()->hasRole('job_seeker')) {
            abort(403);
        }
        
        $userId = Auth::id();
        
        // Ambil data dari Person 5
        $pengajuanTerbaru = PengajuanBantuan::where('pencari_kerja_id', $userId)
                            ->latest()
                            ->first();
        
        $riwayatPengajuan = PengajuanBantuan::where('pencari_kerja_id', $userId)
                            ->latest()
                            ->take(5)
                            ->get();
        
        // Ambil profil dari Person 4
        $profil = JobSeekerProfile::where('user_id', $userId)->first();
        
        // Data sementara (nanti dari Person 2)
        $skorKerentanan = 82;
        $rekomendasiLowongan = [];
        $rekomendasiBantuan = null;
        $profilKelengkapan = $profil ? 85 : 50;
        
        return view('pencari-kerja.dashboard', compact(
            'pengajuanTerbaru',
            'riwayatPengajuan',
            'skorKerentanan',
            'rekomendasiLowongan',
            'rekomendasiBantuan',
            'profilKelengkapan'
        ));
    }

    public function petaSebaran()
    {
        return view('map.index');
    }
}