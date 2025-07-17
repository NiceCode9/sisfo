<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Komentar extends Model
{
    protected $table = 'komentar';
    protected $fillable = [
        'article_id',
        'parent_id',
        'author_name',
        'author_email',
        'author_website',
        'content',
        'ip_address',
        'user_agent',
        'status'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Artikel::class, 'article_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Komentar::class, 'parent_id');
    }

    public function replies(): HasMany
    {
        // return $this->hasMany(Komentar::class, 'parent_id');
        return $this->hasMany(Komentar::class, 'parent_id')->with('replies');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }
}
