<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JobSeekerProfile extends Model
{
    use HasFactory;

    protected $table = 'job_seeker_profiles';

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
        'status_kerja_saat_ini',
        'lama_menganggur',
        'pendapatan_bulanan',
        'jumlah_tanggungan',
        'is_penerima_bansos_lain',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'skills_tags' => 'array',
        'pendapatan_bulanan' => 'decimal:2',
        'is_penerima_bansos_lain' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(JobSeekerVerification::class, 'pencari_kerja_id');
    }
}
