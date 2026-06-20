<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StrukturKelas extends Model
{
    protected $fillable = [
        'jabatan',
        'user_id',
        'foto',
        'urutan',
        'deskripsi',
        'parent_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'user_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(StrukturKelas::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(StrukturKelas::class, 'parent_id')->orderBy('urutan');
    }
}
