<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobSeekerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'tanggal_lahir',
        'jenis_kelamin',
        'alamat_ktp',
        'file_ktp',
        'file_kk',
        'domisili_wilayah_id',
        'no_hp',
        'status_verifikasi',
        'pendidikan_terakhir',
        'skills_tags',
        'pengalaman_kerja',
        'file_cv',
        'status_kerja_saat_ini',
        'lama_menganggur',
        'pendapatan_bulanan',
        'jumlah_tanggungan',
        'is_penerima_bansos_lain',
    ];

    protected $casts = [
        'tanggal_lahir'          => 'date',
        'skills_tags'            => 'array',
        'is_penerima_bansos_lain' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUsiaAttribute(): int
    {
        return $this->tanggal_lahir
            ? $this->tanggal_lahir->age
            : 0;
    }
}