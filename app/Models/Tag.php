<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    // Relationships
    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Artikel::class, 'artikel_tag', 'tag_id', 'article_id');
    }

    public function publishedArticles(): BelongsToMany
    {
        return $this->belongsToMany(Artikel::class)->where('status', 'published');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // SEO Methods
    public function getUrlAttribute()
    {
        return route('tag.show', $this->slug);
    }
}
