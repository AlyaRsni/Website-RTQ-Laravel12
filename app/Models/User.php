<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Role helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isUstadzPpdb(): bool
    {
        return $this->role === 'ustadz_ppdb';
    }

    public function isCalonSantri(): bool
    {
        return $this->role === 'calon_santri';
    }

    public function isUstadzHalaqah(): bool
    {
        return $this->role === 'ustadz_halaqah';
    }

    public function isSantri(): bool
    {
        return $this->role === 'santri';
    }

    // Relations
    public function ppdbRegistration()
    {
        return $this->hasOne(PpdbRegistration::class);
    }

    public function santri()
    {
        return $this->hasOne(Santri::class);
    }

    public function ustadzHalaqah()
    {
        return $this->hasOne(UstadzHalaqah::class);
    }
}
