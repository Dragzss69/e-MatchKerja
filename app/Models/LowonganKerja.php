<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LowonganKerja extends Model
{
    use HasFactory;

    protected $table = 'lowongan_kerja';

    protected $fillable = [
        'perusahaan_id',
        'posisi',
        'deskripsi',
        'gaji_min',
        'gaji_max',
        'lokasi',
        'kecamatan',
        'skill_dibutuhkan',
        'kuota',
        'deadline',
        'status',
    ];

    protected $casts = [
        'skill_dibutuhkan' => 'array',
        'deadline'         => 'date',
    ];

    /**
     * Relasi ke perusahaan (User)
     */
    public function perusahaan()
    {
        return $this->belongsTo(User::class, 'perusahaan_id');
    }

    /**
     * Relasi ke lamaran - wajib ada agar withCount('lamaran') bekerja
     */
    public function lamaran()
    {
        return $this->hasMany(LamaranKerja::class, 'lowongan_id');
    }
}