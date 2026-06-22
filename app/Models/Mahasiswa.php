<?php

namespace App\Models;

use Database\Factories\MahasiswaFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class Mahasiswa extends Authenticatable
{
    /** @use HasFactory<MahasiswaFactory> */
    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nama',
        'nim',
        'email',
        'no_hp',
        'password',
        'foto',
        'angkatan',
        'role',
        'last_login_at',
        'last_activity_at',
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
            'role' => 'string',
            'last_login_at' => 'datetime',
            'last_activity_at' => 'datetime',
        ];
    }

    public function fotoUrl(): string
    {
        return $this->foto ? Storage::disk('public')->url($this->foto) : '';
    }

    public function isAdministrator(): bool
    {
        return $this->role === 'administrator';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['admin', 'administrator']);
    }

    public function isAnggota(): bool
    {
        return $this->role === 'anggota';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    public function isAtLeast(string $role): bool
    {
        $hierarchy = ['anggota' => 0, 'admin' => 1, 'administrator' => 2];
        $userLevel = $hierarchy[$this->role] ?? -1;
        $requiredLevel = $hierarchy[$role] ?? -1;

        return $userLevel >= $requiredLevel;
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id');
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class, 'user_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'user_id');
    }
}
