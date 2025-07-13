<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtikelImage extends Model
{
    protected $fillable = [
        'article_id',
        'image_path',
        'alt_text',
        'caption',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Artikel::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
