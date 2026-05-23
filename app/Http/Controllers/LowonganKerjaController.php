<?php

namespace App\Http\Controllers;

use App\Models\LowonganKerja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LowonganKerjaController extends Controller
{
    public function index()
    {
        $lowongans = LowonganKerja::with('perusahaan')->latest()->paginate(10);
        return view('admin.lowongan.index', compact('lowongans'));
    }

    public function create()
    {
        return view('perusahaan.lowongan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'posisi' => 'required|string|max:255',
            'deskripsi' => 'required',
            'gaji_min' => 'required|numeric',
            'gaji_max' => 'nullable|numeric|gt:gaji_min',
            'lokasi' => 'required',
            'skill_dibutuhkan' => 'required|array',
            'kuota' => 'required|integer|min:1',
            'deadline' => 'required|date|after:today',
        ]);

        $data = $request->all();
        $data['perusahaan_id'] = Auth::id();
        $data['skill_dibutuhkan'] = $request->skill_dibutuhkan; // Laravel otomatis menyimpan array

        LowonganKerja::create($data);

        return redirect()->route('perusahaan.lowongan.create')
                         ->with('success', 'Lowongan kerja berhasil diposting!');
    }

    public function show($id)
    {
        $lowongan = LowonganKerja::with('perusahaan')->findOrFail($id);
        return view('lowongan.show', compact('lowongan'));
    }

    public function edit($id)
    {
        $lowongan = LowonganKerja::findOrFail($id);
        
        // Hanya perusahaan pemilik yang boleh edit
        if ($lowongan->perusahaan_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        return view('perusahaan.lowongan.edit', compact('lowongan'));
    }

    public function update(Request $request, $id)
    {
        $lowongan = LowonganKerja::findOrFail($id);

        if ($lowongan->perusahaan_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'posisi' => 'required|string|max:255',
            'deskripsi' => 'required',
            'gaji_min' => 'required|numeric',
            'gaji_max' => 'nullable|numeric|gt:gaji_min',
            'lokasi' => 'required',
            'skill_dibutuhkan' => 'required|array',
            'kuota' => 'required|integer|min:1',
            'deadline' => 'required|date|after:today',
            'status' => 'required|in:aktif,ditutup',
        ]);

        $data = $request->all();
        $data['skill_dibutuhkan'] = $request->skill_dibutuhkan;

        $lowongan->update($data);

        return redirect()->route('lowongan.index')
                         ->with('success', 'Lowongan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $lowongan = LowonganKerja::findOrFail($id);

        if ($lowongan->perusahaan_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $lowongan->delete();

        return redirect()->route('lowongan.index')
                         ->with('success', 'Lowongan berhasil dihapus!');
    }
}