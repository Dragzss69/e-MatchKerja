<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployerProfile extends Model
{
    use HasFactory;

    protected $table = 'employer_profiles';

    protected $fillable = [
        'user_id',
        'nama_perusahaan',
        'nib_atau_ijin',
        'kategori_industri',
        'skala_perusahaan',
        'deskripsi_singkat',
        'alamat_kantor',
        'wilayah_id',
        'website',
        'no_telp_hrd',
        'email_rekrutmen',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
