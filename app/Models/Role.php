<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'name',
        'label',
        'description',
    ];

    public const ADMIN = 'admin';
    public const VERIFIER = 'verifier';
    public const EMPLOYER = 'employer';
    public const JOB_SEEKER = 'job_seeker';

    public static function defaultRoles(): array
    {
        return [
            self::ADMIN => 'Admin Dinas',
            self::VERIFIER => 'Petugas Verifikasi',
            self::EMPLOYER => 'Perusahaan / Employer',
            self::JOB_SEEKER => 'Pencari Kerja / Masyarakat',
        ];
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
