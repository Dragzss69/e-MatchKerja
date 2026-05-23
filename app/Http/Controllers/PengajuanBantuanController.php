<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBantuan;
use App\Notifications\StatusPengajuanBerubah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanBantuanController extends Controller
{
    public function index()
    {
        if (Auth::user()->isJobSeeker()) {
            $pengajuans = PengajuanBantuan::where('pencari_kerja_id', Auth::id())
                            ->with('pencariKerja')
                            ->latest()
                            ->paginate(10);
        } elseif (Auth::user()->isAdmin()) {
            $pengajuans = PengajuanBantuan::with('pencariKerja')
                            ->where('status', '!=', 'pending')
                            ->latest()
                            ->paginate(15);
        } else {
            $pengajuans = PengajuanBantuan::with('pencariKerja')
                            ->latest()
                            ->paginate(15);
        }

        return view('pengajuan.index', compact('pengajuans'));
    }

    public function create()
    {
        if (!Auth::user()->isJobSeeker()) {
            abort(403, 'Hanya Pencari Kerja yang boleh mengajukan bantuan.');
        }

        return view('pengajuan.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->isJobSeeker()) {
            abort(403);
        }

        $request->validate([
            'jenis_bantuan'    => 'required|in:subsidi_upah,pelatihan,modal_umkm,lainnya',
            'alasan'           => 'required|min:30',
            'nominal_diajukan' => 'nullable|numeric|min:0',
        ]);

        PengajuanBantuan::create([
            'pencari_kerja_id' => Auth::id(),
            'jenis_bantuan'    => $request->jenis_bantuan,
            'alasan'           => $request->alasan,
            'nominal_diajukan' => $request->nominal_diajukan,
            'status'           => 'pending',
        ]);

        return redirect()->route('pengajuan-bantuan.index')
                         ->with('success', 'Pengajuan bantuan berhasil dikirim!');
    }

    public function show(PengajuanBantuan $pengajuan)
    {
        return view('pengajuan.show', compact('pengajuan'));
    }

    public function verifikasi(Request $request, PengajuanBantuan $pengajuan)
    {
        if (!Auth::user()->isVerifier()) {
            abort(403, 'Hanya Petugas yang bisa melakukan verifikasi.');
        }

        $pengajuan->update([
            'status'             => 'diverifikasi',
            'verified_by'        => Auth::id(),
            'catatan_verifikasi' => $request->catatan_verifikasi,
            'tanggal_verifikasi' => now(),
        ]);

        $pengajuan->pencariKerja->notify(new StatusPengajuanBerubah(
            $pengajuan,
            'Pengajuan bantuan kamu sedang dalam proses verifikasi oleh petugas.'
        ));

        return back()->with('success', 'Pengajuan berhasil diverifikasi.');
    }

    public function approve(Request $request, PengajuanBantuan $pengajuan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Hanya Admin yang bisa menyetujui pengajuan.');
        }

        $pengajuan->update([
            'status'           => 'disetujui',
            'approved_by'      => Auth::id(),
            'catatan_approval' => $request->catatan_approval,
            'tanggal_approval' => now(),
        ]);

        $pengajuan->pencariKerja->notify(new StatusPengajuanBerubah(
            $pengajuan,
            'Selamat! Pengajuan bantuan kamu telah disetujui oleh Admin.'
        ));

        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function tolak(Request $request, PengajuanBantuan $pengajuan)
    {
        if (!Auth::user()->isVerifier() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $pengajuan->update([
            'status'           => 'ditolak',
            'approved_by'      => Auth::id(),
            'catatan_approval' => $request->catatan_approval,
            'tanggal_approval' => now(),
        ]);

        $pengajuan->pencariKerja->notify(new StatusPengajuanBerubah(
            $pengajuan,
            'Maaf, pengajuan bantuan kamu telah ditolak.'
        ));

        return back()->with('success', 'Pengajuan ditolak.');
    }

    public function salurkan(Request $request, PengajuanBantuan $pengajuan)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'rekening_penerima' => 'required|string',
        ]);

        $pengajuan->update([
            'status'             => 'disalurkan',
            'tanggal_penyaluran' => now(),
        ]);

        $pengajuan->pencariKerja->notify(new StatusPengajuanBerubah(
            $pengajuan,
            'Dana bantuan kamu telah disalurkan. Silakan cek rekening kamu.'
        ));

        return back()->with('success', 'Dana telah ditandai sebagai disalurkan.');
    }
}
