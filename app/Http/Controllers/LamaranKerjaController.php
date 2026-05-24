<?php

namespace App\Http\Controllers;

use App\Models\LamaranKerja;
use App\Models\LowonganKerja;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LamaranKerjaController extends Controller
{
    /**
     * Pencari kerja: submit lamaran
     */
     public function store(Request $request, int $lowongan_id): RedirectResponse
    {
        $lowongan = LowonganKerja::findOrFail($lowongan_id);
        
        // ========== CEK APAKAH DATA DIRI SUDAH DIVERIFIKASI ==========
        $profile = Auth::user()->jobSeekerProfile;
        
        if (!$profile || $profile->status_verifikasi != 'Verified') {
            return redirect()->back()->with('error', 'Anda belum dapat melamar. Data diri Anda harus diverifikasi terlebih dahulu oleh petugas. Silakan hubungi petugas verifikasi.');
        }
        // =============================================================

        $request->validate([
            'cv'         => 'required|file|mimes:pdf|max:5120',
            'portofolio' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'catatan'    => 'nullable|string|max:500',
        ]);

        $sudahLamar = LamaranKerja::where('user_id', Auth::id())
                        ->where('lowongan_id', $lowongan_id)
                        ->exists();

        if ($sudahLamar) {
            return redirect()->back()->with('error', 'Anda sudah melamar lowongan ini.');
        }

        $data = [
            'user_id'     => Auth::id(),
            'lowongan_id' => $lowongan_id,
            'catatan'     => $request->catatan,
            'status'      => 'pending',
        ];

        if ($request->hasFile('cv')) {
            $data['cv_path'] = $request->file('cv')->store('lamaran/cv', 'public');
        }

        if ($request->hasFile('portofolio')) {
            $data['portofolio_path'] = $request->file('portofolio')->store('lamaran/portofolio', 'public');
        }

        LamaranKerja::create($data);

        return redirect()->back()->with('success', 'Lamaran berhasil dikirim!');
    }

    /**
     * Perusahaan: lihat semua pelamar di 1 lowongan
     */
    /**
 * Perusahaan: lihat semua pelamar di 1 lowongan dengan filter status
 */
public function pelamar(int $lowongan_id): View
{
    $lowongan = LowonganKerja::findOrFail($lowongan_id);

    if ($lowongan->perusahaan_id !== Auth::id()) {
        abort(403);
    }

    $query = LamaranKerja::with('user')
                ->where('lowongan_id', $lowongan_id);

    // Filter berdasarkan status
    $status = request('status', 'all');
    if ($status != 'all') {
        $query->where('status', $status);
    }

    $lamarans = $query->latest()->get();

    return view('perusahaan.pelamar.index', compact('lowongan', 'lamarans', 'status'));
}

    /**
     * Perusahaan: lihat detail 1 pelamar
     */
    public function show(int $id): View
    {
        $lamaran = LamaranKerja::with(['user', 'lowongan'])->findOrFail($id);

        if ($lamaran->lowongan->perusahaan_id !== Auth::id()) {
            abort(403);
        }

        return view('perusahaan.pelamar.show', compact('lamaran'));
    }

    /**
     * Perusahaan: download file CV atau portofolio pelamar
     */
    public function download(int $id, string $type): \Symfony\Component\HttpFoundation\BinaryFileResponse|RedirectResponse
    {
        $lamaran = LamaranKerja::with(['user', 'lowongan'])->findOrFail($id);

        if ($lamaran->lowongan->perusahaan_id !== Auth::id()) {
            abort(403);
        }

        if ($type === 'cv' && $lamaran->cv_path) {
            $path = storage_path('app/public/' . $lamaran->cv_path);
            return response()->download($path, 'CV-' . $lamaran->user->name . '.pdf');
        }

        if ($type === 'portofolio' && $lamaran->portofolio_path) {
            $ext  = pathinfo($lamaran->portofolio_path, PATHINFO_EXTENSION);
            $path = storage_path('app/public/' . $lamaran->portofolio_path);
            return response()->download($path, 'Portofolio-' . $lamaran->user->name . '.' . $ext);
        }

        return redirect()->back()->with('error', 'File tidak ditemukan.');
    }

    /**
     * Perusahaan: update status pelamar
     */
    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $lamaran = LamaranKerja::with('lowongan')->findOrFail($id);

        if ($lamaran->lowongan->perusahaan_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,dipanggil_wawancara,diterima,ditolak',
        ]);

        $lamaran->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Status lamaran berhasil diubah!');
    }

    /**
     * Pencari kerja: riwayat lamaran sendiri
     */
    public function riwayat(): View
    {
        $lamarans = LamaranKerja::with(['lowongan.perusahaan'])
                        ->where('user_id', Auth::id())
                        ->latest()
                        ->get();

        return view('lamaran.riwayat', compact('lamarans'));
    }
}