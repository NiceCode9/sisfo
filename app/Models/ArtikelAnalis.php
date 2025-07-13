<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtikelAnalis extends Model
{
    protected $fillable = [
        'article_id',
        'date',
        'views',
        'unique_views',
        'bounce_rate',
        'avg_time_on_page',
        'referrer_data',
        'search_keywords'
    ];

    protected $casts = [
        'date' => 'date',
        'views' => 'integer',
        'unique_views' => 'integer',
        'bounce_rate' => 'integer',
        'avg_time_on_page' => 'integer',
        'referrer_data' => 'array',
        'search_keywords' => 'array'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Artikel::class);
    }
}
