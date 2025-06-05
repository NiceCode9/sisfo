<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Guru extends Model
{
    protected $table = 'guru';

    protected $fillable = [
        'nip',
        'biografi',
        'bidang_keahlian',
    ];

    /**
     * Get the user that owns the guru.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'guru_id');
    }

    public function mataPelajaran()
    {
        return $this->belongsToMany(MataPelajaran::class, 'guru_mata_pelajaran', 'guru_id', 'mata_pelajaran_id')
            ->withTimestamps();
    }

    public function guruMataPelajaran()
    {
        return $this->hasMany(GuruMataPelajaran::class, 'guru_id');
    }
}
