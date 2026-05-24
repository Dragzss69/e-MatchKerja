<?php

namespace App\Http\Controllers;

use App\Models\JobSeekerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class JobSeekerProfileController extends Controller
{
    /**
     * Show form to create profile (first time)
     */
    public function create()
    {
        if (!Auth::user()->isJobSeeker()) {
            abort(403);
        }

        $profile = Auth::user()->jobSeekerProfile;

        return view('profile.create', compact('profile'));
    }

    /**
     * Store new profile
     */
    public function store(Request $request)
    {
        if (!Auth::user()->isJobSeeker()) {
            abort(403);
        }

        // Cek apakah sudah punya profile
        $existingProfile = Auth::user()->jobSeekerProfile;
        if ($existingProfile) {
            return redirect()->route('jobseeker.profile.edit')
                             ->with('info', 'Anda sudah memiliki profil. Silakan edit jika perlu.');
        }

        $request->validate([
            'nik'                    => 'required|digits:16',
            'nama_lengkap'           => 'required|string|max:255',
            'tanggal_lahir'          => 'required|date|before:today',
            'jenis_kelamin'          => 'required|in:L,P',
            'alamat_ktp'             => 'required|string|max:500',
            'no_hp'                  => 'required|string|max:20',
            'pendidikan_terakhir'    => 'required|in:sd,smp,sma,d3,s1,s2,s3',
            'status_kerja_saat_ini'  => 'required|in:menganggur,bekerja_paruh_waktu,bekerja_penuh,wirausaha',
            'lama_menganggur'        => 'nullable|integer|min:0',
            'pendapatan_bulanan'     => 'nullable|numeric|min:0',
            'jumlah_tanggungan'      => 'required|integer|min:0',
            'is_penerima_bansos_lain' => 'nullable|boolean',
            'file_ktp'               => 'nullable|mimes:pdf|max:2048',
            'file_kk'                => 'nullable|mimes:pdf|max:2048',
        ]);

        $data = $request->except(['file_ktp', 'file_kk', '_token']);
        $data['user_id'] = Auth::id();
        $data['is_penerima_bansos_lain'] = $request->boolean('is_penerima_bansos_lain');
        
        // Konversi jenis_kelamin (nilai sudah L/P)
        $data['jenis_kelamin'] = $request->jenis_kelamin;
        
        // Konversi status kerja
        $statusKerja = $request->status_kerja_saat_ini;
        if (in_array($statusKerja, ['bekerja_paruh_waktu', 'bekerja_penuh'])) {
            $data['status_kerja_saat_ini'] = 'Bekerja';
        } elseif ($statusKerja == 'menganggur') {
            $data['status_kerja_saat_ini'] = 'Menganggur';
        } elseif ($statusKerja == 'wirausaha') {
            $data['status_kerja_saat_ini'] = 'Wirausaha';
        }
        
        // Set nilai default untuk lama_menganggur
        if ($data['status_kerja_saat_ini'] == 'Bekerja' || $data['status_kerja_saat_ini'] == 'Wirausaha') {
            $data['lama_menganggur'] = 0;
        } elseif ($data['status_kerja_saat_ini'] == 'Menganggur') {
            $data['lama_menganggur'] = $request->lama_menganggur ?? 0;
        } else {
            $data['lama_menganggur'] = 0;
        }

        // Upload file KTP
        if ($request->hasFile('file_ktp')) {
            $data['file_ktp'] = $request->file('file_ktp')->store('dokumen/ktp', 'public');
        }

        // Upload file KK
        if ($request->hasFile('file_kk')) {
            $data['file_kk'] = $request->file('file_kk')->store('dokumen/kk', 'public');
        }

        JobSeekerProfile::create($data);

        return redirect()->route('jobseeker.profile.show')
                         ->with('success', 'Profil berhasil disimpan!');
    }
    
    /**
     * Show profile (read-only)
     */
    public function show()
    {
        if (!Auth::user()->isJobSeeker()) {
            abort(403);
        }

        $profile = Auth::user()->jobSeekerProfile;
        
        if (!$profile) {
            return redirect()->route('jobseeker.profile.create')
                            ->with('info', 'Silakan isi profil Anda terlebih dahulu.');
        }

        return view('profile.show', compact('profile'));
    }

    /**
     * Show form edit profile
     */
    public function edit()
    {
        if (!Auth::user()->isJobSeeker()) {
            abort(403);
        }

        $profile = Auth::user()->jobSeekerProfile;
        
        if (!$profile) {
            return redirect()->route('jobseeker.profile.create')
                            ->with('info', 'Silakan isi profil Anda terlebih dahulu.');
        }

        return view('profile.edit', compact('profile'));
    }

    /**
     * Update profile
     */
    public function update(Request $request)
{
    if (!Auth::user()->isJobSeeker()) {
        abort(403);
    }

    $profile = Auth::user()->jobSeekerProfile;
    
    if (!$profile) {
        return redirect()->route('jobseeker.profile.create')
                        ->with('error', 'Profil tidak ditemukan.');
    }
    
    $request->validate([
        'nik'                    => 'required|digits:16|unique:job_seeker_profiles,nik,' . $profile->id,
        'nama_lengkap'           => 'required|string|max:255',
        'tanggal_lahir'          => 'required|date|before:today',
        'jenis_kelamin'          => 'required|in:L,P',
        'alamat_ktp'             => 'required|string|max:500',
        'no_hp'                  => 'required|string|max:20',
        'pendidikan_terakhir'    => 'required|in:sd,smp,sma,d3,s1,s2,s3',
        'status_kerja_saat_ini'  => 'required|in:menganggur,bekerja_paruh_waktu,bekerja_penuh,wirausaha',
        'lama_menganggur'        => 'nullable|integer|min:0',
        'pendapatan_bulanan'     => 'nullable|numeric|min:0',
        'jumlah_tanggungan'      => 'required|integer|min:0',
        'is_penerima_bansos_lain' => 'nullable|boolean',
        'file_ktp'               => 'nullable|mimes:pdf|max:2048',
        'file_kk'                => 'nullable|mimes:pdf|max:2048',
    ]);
    
    $data = $request->except(['file_ktp', 'file_kk', '_token', '_method']);
    $data['is_penerima_bansos_lain'] = $request->boolean('is_penerima_bansos_lain');
    $data['jenis_kelamin'] = $request->jenis_kelamin;
    
    // Konversi status kerja
    $statusKerja = $request->status_kerja_saat_ini;
    if (in_array($statusKerja, ['bekerja_paruh_waktu', 'bekerja_penuh'])) {
        $data['status_kerja_saat_ini'] = 'Bekerja';
    } elseif ($statusKerja == 'menganggur') {
        $data['status_kerja_saat_ini'] = 'Menganggur';
    } elseif ($statusKerja == 'wirausaha') {
        $data['status_kerja_saat_ini'] = 'Wirausaha';
    }
    
    // Set lama_menganggur
    if ($data['status_kerja_saat_ini'] == 'Bekerja' || $data['status_kerja_saat_ini'] == 'Wirausaha') {
        $data['lama_menganggur'] = 0;
    } else {
        $data['lama_menganggur'] = $request->lama_menganggur ?? 0;
    }
    
    // ========== UPLOAD FILE BERDASARKAN STATUS VERIFIKASI ==========
    // Jika akun sudah diverifikasi, file TIDAK BISA diubah
    if ($profile->status_verifikasi != 'Verified') {
        // Hanya upload jika status belum verified
        if ($request->hasFile('file_ktp')) {
            if ($profile->file_ktp) {
                Storage::disk('public')->delete($profile->file_ktp);
            }
            $data['file_ktp'] = $request->file('file_ktp')->store('dokumen/ktp', 'public');
        }
        
        if ($request->hasFile('file_kk')) {
            if ($profile->file_kk) {
                Storage::disk('public')->delete($profile->file_kk);
            }
            $data['file_kk'] = $request->file('file_kk')->store('dokumen/kk', 'public');
        }
    } else {
        // Jika sudah verified, pertahankan file lama
        $data['file_ktp'] = $profile->file_ktp;
        $data['file_kk'] = $profile->file_kk;
    }
    // ==================================================================
    
    $profile->update($data);
    
    return redirect()->route('jobseeker.profile.show')
                    ->with('success', 'Profil berhasil diperbarui!');
}

    /**
     * Delete profile
     */
    public function destroy()
    {
        if (!Auth::user()->isJobSeeker()) {
            abort(403);
        }

        $profile = Auth::user()->jobSeekerProfile;
        
        if (!$profile) {
            return redirect()->route('jobseeker.profile.create')
                            ->with('error', 'Profil tidak ditemukan.');
        }

        // Delete files
        if ($profile->file_ktp) {
            Storage::disk('public')->delete($profile->file_ktp);
        }
        if ($profile->file_kk) {
            Storage::disk('public')->delete($profile->file_kk);
        }
        
        $profile->delete();
        
        return redirect()->route('jobseeker.profile.create')
                         ->with('success', 'Profil berhasil dihapus.');
    }
    /**
     * Show profile for admin (with ID parameter) - untuk halaman SPK dan admin
     */
    public function showAdminProfile($id)
    {
        // Hanya admin yang bisa akses
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya Admin yang dapat melihat detail profil.');
        }
        
        $profile = JobSeekerProfile::with('user')->findOrFail($id);
        
        return view('admin.jobseekers.show', compact('profile'));
    }
    public function index(Request $request)
    {
        // Hanya admin yang bisa akses
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }
        
        // ========== TAMBAHKAN STATISTIK ==========
    $statistik = [
        'total' => JobSeekerProfile::count(),
        'menganggur' => JobSeekerProfile::where('status_kerja_saat_ini', 'Menganggur')->count(),
        'bekerja' => JobSeekerProfile::where('status_kerja_saat_ini', 'Bekerja')->count(),
    ];
    
    // Hitung persentase
    $statistik['persen_menganggur'] = $statistik['total'] > 0 
        ? round(($statistik['menganggur'] / $statistik['total']) * 100) 
        : 0;
    $statistik['persen_bekerja'] = $statistik['total'] > 0 
        ? round(($statistik['bekerja'] / $statistik['total']) * 100) 
        : 0;
    // =========================================

        $query = JobSeekerProfile::with('user');
        
        // Filter search (NIK, Nama, No HP)
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nik', 'like', '%' . $request->search . '%')
                ->orWhere('nama_lengkap', 'like', '%' . $request->search . '%')
                ->orWhere('no_hp', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter status kerja
        if ($request->has('status_kerja') && $request->status_kerja) {
            $query->where('status_kerja_saat_ini', $request->status_kerja);
        }
        
        // Filter pendidikan
        if ($request->has('pendidikan') && $request->pendidikan) {
            $query->where('pendidikan_terakhir', $request->pendidikan);
        }
        
        $profiles = $query->latest()->paginate(15);
        
        return view('admin.jobseekers.index', compact('profiles', 'statistik'));
    }
    public function pendingVerification()
{
    // Cek apakah user adalah verifier
    if (!Auth::user()->isVerifier()) {
        abort(403, 'Anda tidak memiliki akses ke halaman ini.');
    }
    
    $profiles = JobSeekerProfile::where('status_verifikasi', 'Unverified')
                    ->with('user')
                    ->latest()
                    ->paginate(15);
    
    // Ubah dari 'admin.jobseekers.pending' menjadi 'verifier.jobseekers.pending'
    return view('verifier.jobseekers.pending', compact('profiles'));
}

/**
 * Verifikasi data diri pencari kerja
 */
public function verifikasiDataDiri(Request $request, $id)
{
    if (!Auth::user()->isVerifier()) {
        abort(403, 'Hanya Petugas Verifikasi yang dapat memverifikasi data diri.');
    }
    
    $profile = JobSeekerProfile::findOrFail($id);
    
    $profile->update([
        'status_verifikasi' => 'Verified',
        'verified_by' => Auth::id(),
        'tanggal_verifikasi' => now(),
    ]);
    
    // PERBAIKI: Ubah dari 'admin.jobseekers.pending-verification' menjadi 'verifier.jobseekers.pending-verification'
    return redirect()->route('verifier.jobseekers.pending-verification')
                     ->with('success', 'Data diri pencari kerja berhasil diverifikasi.');
}

public static function getDashboardStats()
{
    $statUnverifiedProfile = JobSeekerProfile::where('status_verifikasi', 'Unverified')->count();
    return $statUnverifiedProfile;
}

public function exportStatistikPDF(Request $request)
{
    // Hanya admin yang bisa akses
    if (!Auth::user()->isAdmin()) {
        abort(403);
    }
    
    $filter = $request->get('filter', 'all');
    
    // Query berdasarkan filter
    $query = JobSeekerProfile::query();
    
    if ($filter == 'menganggur') {
        $query->where('status_kerja_saat_ini', 'Menganggur');
        $title = 'LAPORAN PENGGANGGURAN';
        $subtitle = 'Data Pencari Kerja yang Sedang Menganggur';
    } elseif ($filter == 'bekerja') {
        $query->where('status_kerja_saat_ini', 'Bekerja');
        $title = 'LAPORAN PEKERJA';
        $subtitle = 'Data Pencari Kerja yang Sudah Bekerja';
    } else {
        $title = 'LAPORAN STATISTIK PENGGANGGURAN';
        $subtitle = 'Data Seluruh Pencari Kerja';
    }
    
    // Ambil data
    $profiles = $query->with('user')->latest()->get();
    
    // Statistik berdasarkan filter
    $statistik = [
        'total' => $profiles->count(),
        'menganggur' => $filter == 'menganggur' ? $profiles->count() : ($filter == 'bekerja' ? 0 : JobSeekerProfile::where('status_kerja_saat_ini', 'Menganggur')->count()),
        'bekerja' => $filter == 'bekerja' ? $profiles->count() : ($filter == 'menganggur' ? 0 : JobSeekerProfile::where('status_kerja_saat_ini', 'Bekerja')->count()),
    ];
    
    // Hitung persentase (hanya untuk statistik keseluruhan)
    if ($filter == 'all') {
        $totalAll = JobSeekerProfile::count();
        $statistik['persen_menganggur'] = $totalAll > 0 ? round(($statistik['menganggur'] / $totalAll) * 100) : 0;
        $statistik['persen_bekerja'] = $totalAll > 0 ? round(($statistik['bekerja'] / $totalAll) * 100) : 0;
    } else {
        $statistik['persen_menganggur'] = 0;
        $statistik['persen_bekerja'] = 0;
    }
    
    $data = [
        'profiles' => $profiles,
        'statistik' => $statistik,
        'title' => $title,
        'subtitle' => $subtitle,
        'filter' => $filter,
        'tanggal_cetak' => now()->format('d F Y H:i:s'),
        'petugas' => Auth::user()->name
    ];
    
    $pdf = Pdf::loadView('admin.jobseekers.statistik-pdf', $data);
    $pdf->setPaper('A4', 'portrait');
    
    $filename = 'laporan_' . $filter . '_' . date('Y-m-d_H-i-s') . '.pdf';
    return $pdf->download($filename);
}
}