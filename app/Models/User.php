<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method bool hasRole(string $role)
 * @method self assignRole(string|Role $role)
 * @method self removeRole(string|Role $role)
 */
#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function jobSeekerProfile(): HasOne
    {
        return $this->hasOne(JobSeekerProfile::class);
    }

    public function employerProfile(): HasOne
    {
        return $this->hasOne(EmployerProfile::class);
    }

    public function verifications(): HasMany
    {
        return $this->hasMany(JobSeekerVerification::class, 'petugas_id');
    }

    public function hasRole(string $role): bool
    {
        return $this->roles->contains('name', $role);
    }

    public function assignRole(string|Role $role): self
    {
        if (is_string($role)) {
            $role = Role::firstWhere('name', $role);
        }

        if ($role) {
            $this->roles()->syncWithoutDetaching([$role->id]);
        }

        return $this;
    }

    public function removeRole(string|Role $role): self
    {
        if (is_string($role)) {
            $role = Role::firstWhere('name', $role);
        }

        if ($role) {
            $this->roles()->detach($role->id);
        }

        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(Role::ADMIN);
    }

    public function isVerifier(): bool
    {
        return $this->hasRole(Role::VERIFIER);
    }

    public function isEmployer(): bool
    {
        return $this->hasRole(Role::EMPLOYER);
    }

    public function isJobSeeker(): bool
    {
        return $this->hasRole(Role::JOB_SEEKER);
    }

    // Relasi: perusahaan punya banyak lowongan
    public function lowongans(): HasMany
    {
        return $this->hasMany(LowonganKerja::class, 'perusahaan_id');
    }

    // Relasi: pencari kerja punya banyak lamaran
    public function lamarans(): HasMany
    {
        return $this->hasMany(LamaranKerja::class, 'user_id');
    }
}