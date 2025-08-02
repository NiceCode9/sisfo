<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'siswa_id',
        'guru_id',
        'name',
        'username',
        'email',
        'password',
        'slug',
        'bio',
        'fb',
        'ig',
        'x',
        'li',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }

    public function logStatusPendaftaran()
    {
        return $this->hasMany(LogStatusPendaftaran::class);
    }

    // Relationships
    public function articles(): HasMany
    {
        return $this->hasMany(Artikel::class);
    }

    public function publishedArticles(): HasMany
    {
        return $this->hasMany(Artikel::class)->where('status', 'published');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    // Methods
    // public function getUrlAttribute()
    // {
    //     return route('author.show', $this->slug);
    // }
}
