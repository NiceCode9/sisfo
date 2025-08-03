<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ekstrakurikuler extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_ekskul',
        'slug',
        'status',
        'deskripsi',
        'foto',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Accessor untuk status (untuk display)
    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Aktif' : 'Tidak Aktif';
    }

    // Accessor untuk foto URL
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }
        return null;
    }

    // Scope untuk data aktif
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Scope untuk data tidak aktif
    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }
}
