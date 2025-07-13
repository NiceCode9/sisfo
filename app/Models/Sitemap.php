<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sitemap extends Model
{
    protected $fillable = [
        'url',
        'type',
        'reference_id',
        'changefreq',
        'priority',
        'last_modified'
    ];

    protected $casts = [
        'reference_id' => 'integer',
        'priority' => 'decimal:1',
        'last_modified' => 'datetime'
    ];

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
