<?php

namespace App\Http\Controllers;

use App\Models\JobSeekerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobSeekerProfileController extends Controller
{
    public function index()
    {
        $query = JobSeekerProfile::with('user');

        // Search by NIK, Nama, atau No HP
        if (request('search')) {
            $search = request('search');
            $query->where(function($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%");
            });
        }

        // Filter Status Kerja
        if (request('status_kerja')) {
            $query->where('status_kerja_saat_ini', request('status_kerja'));
        }

        // Filter Pendidikan Terakhir
        if (request('pendidikan')) {
            $query->where('pendidikan_terakhir', request('pendidikan'));
        }

        // Filter Lama Menganggur
        if (request('lama_menganggur')) {
            $query->where('lama_menganggur', '>=', request('lama_menganggur'));
        }

        // Filter Jumlah Tanggungan
        if (request('jumlah_tanggungan')) {
            $query->where('jumlah_tanggungan', '>=', request('jumlah_tanggungan'));
        }

        $profiles = $query->latest()->paginate(15)->withQueryString();

        return view('admin.jobseekers.index', compact('profiles'));
    }

    public function create()
    {
        return view('jobseeker.profile.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:job_seeker_profiles,nik',
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_ktp' => 'required',
            'no_hp' => 'required',
            'pendidikan_terakhir' => 'required',
            'status_kerja_saat_ini' => 'required',
            'lama_menganggur' => 'nullable|integer',
            'pendapatan_bulanan' => 'nullable|numeric',
            'jumlah_tanggungan' => 'nullable|integer',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::id();

        if ($request->hasFile('file_ktp')) {
            $data['file_ktp'] = $request->file('file_ktp')->store('ktp', 'public');
        }

        if ($request->hasFile('file_kk')) {
            $data['file_kk'] = $request->file('file_kk')->store('kk', 'public');
        }

        JobSeekerProfile::create($data);

        return redirect()->route('jobseeker.profile.create')
                         ->with('success', 'Profil berhasil disimpan!');
    }

    public function show($id)
    {
        $profile = JobSeekerProfile::findOrFail($id);
        return view('admin.jobseekers.show', compact('profile'));
    }

    public function edit($id)
    {
        $profile = JobSeekerProfile::findOrFail($id);
        
        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit profil ini.');
        }

        return view('jobseeker.profile.edit', compact('profile'));
    }

    public function update(Request $request, $id)
    {
        $profile = JobSeekerProfile::findOrFail($id);

        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit profil ini.');
        }

        $request->validate([
            'nik' => 'required|unique:job_seeker_profiles,nik,' . $id,
            'nama_lengkap' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat_ktp' => 'required',
            'no_hp' => 'required',
            'pendidikan_terakhir' => 'required',
            'status_kerja_saat_ini' => 'required',
            'lama_menganggur' => 'nullable|integer',
            'pendapatan_bulanan' => 'nullable|numeric',
            'jumlah_tanggungan' => 'nullable|integer',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_ktp')) {
            $data['file_ktp'] = $request->file('file_ktp')->store('ktp', 'public');
        }

        if ($request->hasFile('file_kk')) {
            $data['file_kk'] = $request->file('file_kk')->store('kk', 'public');
        }

        $profile->update($data);

        return redirect()->route('jobseeker.profile.create')
                         ->with('success', 'Profil berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $profile = JobSeekerProfile::findOrFail($id);

        if ($profile->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus profil ini.');
        }

        $profile->delete();

        return redirect()->route('admin.jobseekers.index')
                         ->with('success', 'Data pencari kerja berhasil dihapus!');
    }
}