<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatBantuan extends Model
{
    protected $table = 'riwayat_bantuan';
    protected $fillable = [
        'pengajuan_id',
        'nominal_diterima',
        'tanggal_penyaluran',
        'bukti_penyaluran',
        'keterangan'
    ];

    public function pengajuan()
    {
        return $this->belongsTo(PengajuanBantuan::class);
    }
}