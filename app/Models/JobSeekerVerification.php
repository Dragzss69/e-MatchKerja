<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobSeekerVerification extends Model
{
    use HasFactory;

    protected $table = 'job_seeker_verifications';

    protected $fillable = [
        'pencari_kerja_id',
        'petugas_id',
        'is_nik_valid',
        'tempatis_kondisi_ekonomi_sesuai',
        'catatan_petugas',
        'status_hasil',
        'tanggal_verifikasi',
    ];

    protected $casts = [
        'is_nik_valid' => 'boolean',
        'tempatis_kondisi_ekonomi_sesuai' => 'boolean',
        'tanggal_verifikasi' => 'datetime',
    ];

    public function jobSeekerProfile(): BelongsTo
    {
        return $this->belongsTo(JobSeekerProfile::class, 'pencari_kerja_id');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}
