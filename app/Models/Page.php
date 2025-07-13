<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'template',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'schema_data',
        'status',
        'sort_order'
    ];

    protected $casts = [
        'schema_data' => 'array',
        'sort_order' => 'integer'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function getUrlAttribute()
    {
        return route('page.show', $this->slug);
    }
}
