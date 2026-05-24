<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LamaranKerja extends Model
{
    use HasFactory;

    protected $table = 'lamaran_kerja';

    protected $fillable = [
        'user_id',
        'lowongan_id',
        'cv_path',
        'portofolio_path',
        'catatan',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lowongan()
    {
        return $this->belongsTo(LowonganKerja::class);
    }
}