<?php

namespace App\Http\Controllers;

use App\Models\LamaranKerja;
use App\Models\LowonganKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganKerjaController extends Controller
{
    /**
     * Daftar lowongan aktif (untuk pencari kerja)
     */
    /**
 * Daftar lowongan aktif (untuk pencari kerja) dengan filter
 */
public function index(Request $request)
{
    $query = LowonganKerja::with('perusahaan')
                    ->where('status', 'aktif')
                    ->where('deadline', '>=', now());

    // Filter search (posisi atau nama perusahaan)
    if ($request->has('search') && $request->search) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('posisi', 'like', '%' . $search . '%')
              ->orWhereHas('perusahaan', function($subq) use ($search) {
                  $subq->where('name', 'like', '%' . $search . '%');
              });
        });
    }

    // Filter lokasi
    if ($request->has('lokasi') && $request->lokasi) {
        $query->where('lokasi', 'like', '%' . $request->lokasi . '%');
    }

    // Filter gaji minimum
    if ($request->has('gaji_min') && $request->gaji_min) {
        $query->where('gaji_min', '>=', $request->gaji_min);
    }

    $lowongans = $query->latest()->paginate(12);

    return view('lowongan.index', compact('lowongans'));
}

    /**
     * Detail lowongan + form lamar (pencari kerja)
     */
    public function show($id)
    {
        $lowongan = LowonganKerja::with('perusahaan')->findOrFail($id);

        $sudahLamar = false;
        if (Auth::check()) {
            $sudahLamar = LamaranKerja::where('user_id', Auth::id())
                            ->where('lowongan_id', $id)
                            ->exists();
        }

        return view('lowongan.show', compact('lowongan', 'sudahLamar'));
    }

    /**
     * Form buat lowongan baru (perusahaan)
     */
    public function create()
    {
        return view('perusahaan.lowongan.create');
    }

    /**
     * Simpan lowongan baru (perusahaan)
     */
    public function store(Request $request)
{
    $request->validate([
        'posisi'           => 'required|string|max:255',
        'deskripsi'        => 'required',
        'gaji_min'         => 'required|numeric',
        'gaji_max'         => 'nullable|numeric|gt:gaji_min',
        'lokasi'           => 'required|string',
        'skill_dibutuhkan' => 'nullable|string',
        'kuota'            => 'required|integer|min:1',
        'deadline'         => 'required|date|after:today',
    ]);

    // Decode JSON dari hidden input
    $skills = json_decode($request->skill_dibutuhkan, true);
    
    // Jika tidak ada skill atau decode gagal, set empty array
    if (!is_array($skills)) {
        $skills = [];
    }

    // Debug: cek apakah skill masuk (hapus setelah berhasil)
    \Log::info('Skills yang disimpan:', $skills);

    LowonganKerja::create([
        'perusahaan_id'    => Auth::id(),
        'posisi'           => $request->posisi,
        'deskripsi'        => $request->deskripsi,
        'gaji_min'         => $request->gaji_min,
        'gaji_max'         => $request->gaji_max,
        'lokasi'           => $request->lokasi,
        'skill_dibutuhkan' => json_encode($skills), // Simpan sebagai JSON string
        'kuota'            => $request->kuota,
        'deadline'         => $request->deadline,
        'status'           => 'aktif',
    ]);

    return redirect()->route('perusahaan.dashboard')
                     ->with('success', 'Lowongan berhasil diposting!');
}

    /**
     * Form edit lowongan (perusahaan)
     */
    public function edit($id)
    {
        $lowongan = LowonganKerja::findOrFail($id);

        if ($lowongan->perusahaan_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak mengedit lowongan ini.');
        }

        return view('perusahaan.lowongan.edit', compact('lowongan'));
    }

    /**
     * Update lowongan (perusahaan)
     */
    public function update(Request $request, $id)
{
    $lowongan = LowonganKerja::findOrFail($id);

    if ($lowongan->perusahaan_id !== Auth::id()) {
        abort(403);
    }

    $request->validate([
        'posisi'           => 'required|string|max:255',
        'deskripsi'        => 'required',
        'gaji_min'         => 'required|numeric',
        'gaji_max'         => 'nullable|numeric|gt:gaji_min',
        'lokasi'           => 'required|string',
        'skill_dibutuhkan' => 'nullable|string',
        'kuota'            => 'required|integer|min:1',
        'deadline'         => 'required|date|after:today',
        'status'           => 'required|in:aktif,nonaktif',
    ]);

    // Decode JSON skill
    $skills = json_decode($request->skill_dibutuhkan, true);
    if (!is_array($skills)) {
        $skills = [];
    }

    $lowongan->update([
        'posisi'           => $request->posisi,
        'deskripsi'        => $request->deskripsi,
        'gaji_min'         => $request->gaji_min,
        'gaji_max'         => $request->gaji_max,
        'lokasi'           => $request->lokasi,
        'kecamatan'        => $request->kecamatan,
        'skill_dibutuhkan' => json_encode($skills),
        'kuota'            => $request->kuota,
        'deadline'         => $request->deadline,
        'status'           => $request->status,
    ]);

    return redirect()->route('perusahaan.dashboard')
                     ->with('success', 'Lowongan berhasil diperbarui!');
}

    /**
     * Hapus lowongan (perusahaan)
     */
    public function destroy($id)
    {
        $lowongan = LowonganKerja::findOrFail($id);

        if ($lowongan->perusahaan_id !== Auth::id()) {
            abort(403, 'Anda tidak berhak menghapus lowongan ini.');
        }

        $lowongan->delete();

        return redirect()->route('perusahaan.dashboard')
                         ->with('success', 'Lowongan berhasil dihapus!');
    }

    /**
     * Dashboard perusahaan
     * Menampilkan semua pelamar yang sudah submit CV, skill, portofolio
     */
    public function perusahaanDashboard()
    {
        // Semua lowongan milik perusahaan ini
        $lowongans = LowonganKerja::where('perusahaan_id', Auth::id())
                        ->withCount('lamaran')
                        ->latest()
                        ->get();

        // Semua pelamar yang melamar ke lowongan perusahaan ini
        $allApplicants = LamaranKerja::with(['user', 'lowongan'])
                        ->whereHas('lowongan', function ($q) {
                            $q->where('perusahaan_id', Auth::id());
                        })
                        ->latest()
                        ->get();

        return view('perusahaan.dashboard', compact('lowongans', 'allApplicants'));
    }
}