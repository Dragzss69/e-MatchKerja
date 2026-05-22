<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanBantuan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_bantuan';

    protected $fillable = [
        'pencari_kerja_id',
        'jenis_bantuan',
        'alasan',
        'nominal_diajukan',
        'status',
        'verified_by',
        'catatan_verifikasi',
        'tanggal_verifikasi',
        'approved_by',
        'catatan_approval',
        'tanggal_approval',
        'tanggal_penyaluran'
    ];

    // ← Tambahkan ini
    protected $casts = [
        'tanggal_verifikasi' => 'datetime',
        'tanggal_approval'   => 'datetime',
        'tanggal_penyaluran' => 'datetime',
    ];

    public function pencariKerja()
    {
        return $this->belongsTo(User::class, 'pencari_kerja_id');
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}