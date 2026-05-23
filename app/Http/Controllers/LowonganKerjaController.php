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
    public function index()
    {
        $lowongans = LowonganKerja::with('perusahaan')
                        ->where('status', 'aktif')
                        ->where('deadline', '>=', now())
                        ->latest()
                        ->paginate(12);

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
            'skill_dibutuhkan' => 'required|array',
            'kuota'            => 'required|integer|min:1',
            'deadline'         => 'required|date|after:today',
        ]);

        LowonganKerja::create([
            'perusahaan_id'    => Auth::id(),
            'posisi'           => $request->posisi,
            'deskripsi'        => $request->deskripsi,
            'gaji_min'         => $request->gaji_min,
            'gaji_max'         => $request->gaji_max,
            'lokasi'           => $request->lokasi,
            'skill_dibutuhkan' => json_encode($request->skill_dibutuhkan),
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
            abort(403, 'Anda tidak berhak mengedit lowongan ini.');
        }

        $request->validate([
            'posisi'           => 'required|string|max:255',
            'deskripsi'        => 'required',
            'gaji_min'         => 'required|numeric',
            'gaji_max'         => 'nullable|numeric|gt:gaji_min',
            'lokasi'           => 'required|string',
            'skill_dibutuhkan' => 'required|array',
            'kuota'            => 'required|integer|min:1',
            'deadline'         => 'required|date|after:today',
        ]);

        $lowongan->update([
            'posisi'           => $request->posisi,
            'deskripsi'        => $request->deskripsi,
            'gaji_min'         => $request->gaji_min,
            'gaji_max'         => $request->gaji_max,
            'lokasi'           => $request->lokasi,
            'skill_dibutuhkan' => json_encode($request->skill_dibutuhkan),
            'kuota'            => $request->kuota,
            'deadline'         => $request->deadline,
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