<?php

namespace App\Http\Controllers;

use App\Models\BuktiPengembalian;
use App\Models\PengajuanBantuan;
use App\Notifications\StatusPengajuanBerubah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengajuanBantuanController extends Controller
{
    private function userHasRole(string $role): bool
    {
        return Auth::user()->roles->pluck('name')->contains($role);
    }

    public function index()
    {
        if ($this->userHasRole('job_seeker')) {
            $pengajuans = PengajuanBantuan::where('pencari_kerja_id', Auth::id())
                            ->with('pencariKerja')
                            ->latest()
                            ->paginate(10);
        } elseif ($this->userHasRole('admin')) {
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
        if (!$this->userHasRole('job_seeker')) {
            abort(403, 'Hanya Pencari Kerja yang boleh mengajukan bantuan.');
        }

        return view('pengajuan.create');
    }

    public function store(Request $request)
    {
        if (!$this->userHasRole('job_seeker')) {
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
        $rekeningPemerintah = [
            'bank'      => 'Bank BRI',
            'rekening'  => '1234-5678-9012-3456',
            'atas_nama' => 'Dinas Sosial Kota',
        ];

        $buktiPengembalian = $pengajuan->buktiPengembalian()->latest()->get();

        return view('pengajuan.show', compact('pengajuan', 'rekeningPemerintah', 'buktiPengembalian'));
    }

    public function verifikasi(Request $request, PengajuanBantuan $pengajuan)
    {
        if (!$this->userHasRole('verifier')) {
            abort(403, 'Hanya Petugas yang bisa melakukan verifikasi.');
        }

        $pengajuan->update([
            'status'             => 'diverifikasi',
            'verified_by'        => Auth::id(),
            'catatan_verifikasi' => $request->catatan_verifikasi,
            'tanggal_verifikasi' => now(),
        ]);

        // Notifikasi ke pencari kerja
        $pengajuan->pencariKerja->notify(new StatusPengajuanBerubah(
            $pengajuan,
            'Pengajuan bantuan kamu sedang dalam proses verifikasi.'
        ));

        return back()->with('success', 'Pengajuan berhasil diverifikasi.');
    }

    public function approve(Request $request, PengajuanBantuan $pengajuan)
    {
        if (!$this->userHasRole('admin')) {
            abort(403, 'Hanya Admin yang bisa menyetujui pengajuan.');
        }

        $pengajuan->update([
            'status'           => 'disetujui',
            'approved_by'      => Auth::id(),
            'catatan_approval' => $request->catatan_approval,
            'tanggal_approval' => now(),
        ]);

        // Notifikasi ke pencari kerja
        $pengajuan->pencariKerja->notify(new StatusPengajuanBerubah(
            $pengajuan,
            'Selamat! Pengajuan bantuan kamu telah disetujui.'
        ));

        return back()->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function tolak(Request $request, PengajuanBantuan $pengajuan)
    {
        if (!$this->userHasRole('verifier') && !$this->userHasRole('admin')) {
            abort(403);
        }

        $pengajuan->update([
            'status'           => 'ditolak',
            'approved_by'      => Auth::id(),
            'catatan_approval' => $request->catatan_approval,
            'tanggal_approval' => now(),
        ]);

        // Notifikasi ke pencari kerja
        $pengajuan->pencariKerja->notify(new StatusPengajuanBerubah(
            $pengajuan,
            'Maaf, pengajuan bantuan kamu ditolak.'
        ));

        return back()->with('success', 'Pengajuan ditolak.');
    }

    public function salurkan(Request $request, PengajuanBantuan $pengajuan)
    {
        if (!$this->userHasRole('admin')) {
            abort(403);
        }

        $request->validate([
            'rekening_penerima'    => 'required|string',
            'tenggat_pengembalian' => 'required|date|after:today',
        ]);

        $pengajuan->update([
            'status'               => 'disalurkan',
            'tanggal_disalurkan'   => now(),
            'rekening_penerima'    => $request->rekening_penerima,
            'tenggat_pengembalian' => $request->tenggat_pengembalian,
        ]);

        // Notifikasi ke pencari kerja
        $pengajuan->pencariKerja->notify(new StatusPengajuanBerubah(
            $pengajuan,
            'Dana bantuan kamu telah disalurkan. Silakan cek rekening kamu.'
        ));

        return back()->with('success', 'Dana telah ditandai sebagai disalurkan.');
    }

    public function uploadBukti(Request $request, PengajuanBantuan $pengajuan)
    {
        if (!$this->userHasRole('job_seeker')) {
            abort(403);
        }

        $request->validate([
            'foto_bukti'           => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'nominal_dikembalikan' => 'required|numeric|min:1',
            'catatan'              => 'nullable|string|max:500',
        ]);

        $path = $request->file('foto_bukti')->store('bukti_pengembalian', 'public');

        BuktiPengembalian::create([
            'pengajuan_id'         => $pengajuan->id,
            'foto_bukti'           => $path,
            'nominal_dikembalikan' => $request->nominal_dikembalikan,
            'catatan'              => $request->catatan,
            'status'               => 'menunggu',
        ]);

        return back()->with('success', 'Bukti pengembalian berhasil dikirim.');
    }

    public function konfirmasiBukti(Request $request, BuktiPengembalian $bukti)
    {
        if (!$this->userHasRole('admin')) {
            abort(403);
        }

        $bukti->update(['status' => 'dikonfirmasi']);

        return back()->with('success', 'Bukti pengembalian dikonfirmasi.');
    }

    public function tolakBukti(Request $request, BuktiPengembalian $bukti)
    {
        if (!$this->userHasRole('admin')) {
            abort(403);
        }

        $bukti->update(['status' => 'ditolak']);

        return back()->with('success', 'Bukti pengembalian ditolak.');
    }
}