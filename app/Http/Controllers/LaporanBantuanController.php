<?php

namespace App\Http\Controllers;

use App\Models\PengajuanBantuan;
use Illuminate\Support\Facades\Auth;

class LaporanBantuanController extends Controller
{
    private function userHasRole(string $role): bool
    {
        return Auth::user()->roles->pluck('name')->contains($role);
    }

    private function canDownloadReport(): bool
    {
        return $this->userHasRole('admin') || $this->userHasRole('verifier');
    }

    public function index()
    {
        if ($this->userHasRole('job_seeker')) {
            $pengajuans = PengajuanBantuan::with('pencariKerja')
                ->where('pencari_kerja_id', Auth::id())
                ->latest()
                ->paginate(15);
        } else {
            $pengajuans = PengajuanBantuan::with('pencariKerja')
                ->latest()
                ->paginate(15);
        }

        return view('laporan.index', compact('pengajuans'));
    }

   public function exportExcel()
{
    if (!$this->canDownloadReport()) {
        abort(403, 'Anda tidak memiliki izin untuk mengunduh laporan ini.');
    }

    $pengajuans = PengajuanBantuan::with('pencariKerja')->latest()->get();

    $filename = 'laporan_pengajuan_bantuan_' . date('Y-m-d_His') . '.csv';

    $rows = [];

    // Header kolom
    $rows[] = implode(',', [
        'No', 'Nama Lengkap', 'NIK', 'Jenis Bantuan',
        'Nominal Diajukan', 'Alasan', 'Status',
        'Tanggal Pengajuan', 'Tanggal Verifikasi',
        'Tanggal Approval', 'Tanggal Penyaluran'
    ]);

    // Data
    foreach ($pengajuans as $key => $p) {
        $profile = $p->pencariKerja->jobSeekerProfile ?? null;

        $rows[] = implode(',', array_map(fn($val) => '"' . str_replace('"', '""', $val) . '"', [
            $key + 1,
            $profile->nama_lengkap ?? $p->pencariKerja->name ?? '-',
            $profile->nik ?? '-',
            str_replace('_', ' ', ucwords($p->jenis_bantuan)),
            'Rp ' . number_format($p->nominal_diajukan ?? 0, 0, ',', '.'),
            $p->alasan,
            ucfirst($p->status),
            $p->created_at->format('d/m/Y H:i'),
            $p->tanggal_verifikasi ? $p->tanggal_verifikasi->format('d/m/Y') : '-',
            $p->tanggal_approval ? $p->tanggal_approval->format('d/m/Y') : '-',
            $p->tanggal_penyaluran ? $p->tanggal_penyaluran->format('d/m/Y') : '-',
        ]));
    }

    $csvContent = implode("\n", $rows);

    return response($csvContent, 200, [
        'Content-Type'        => 'text/csv; charset=utf-8',
        'Content-Disposition' => 'attachment; filename="' . $filename . '"',
    ]);
}

    public function exportPDF()
    {
        if (!$this->canDownloadReport()) {
            abort(403, 'Anda tidak memiliki izin untuk mengunduh laporan ini.');
        }

        $pengajuans = PengajuanBantuan::with('pencariKerja')->latest()->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('laporan.pdf', compact('pengajuans'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('laporan_pengajuan_bantuan_' . date('Y-m-d_His') . '.pdf');
    }
}