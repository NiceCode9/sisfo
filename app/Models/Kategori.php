<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kategori extends Model
{
    use Sluggable;

    protected $table = 'kategori';
    protected $fillable = [
        'name',
        'slug',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'image',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn($value) => ucfirst($value),
        );
    }

    // Relationships
    public function articles(): HasMany
    {
        return $this->hasMany(Artikel::class, 'category_id');
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

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    // SEO Methods
    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->name;
    }

    public function getMetaDescriptionAttribute($value)
    {
        return $value ?: $this->description;
    }

    public function getUrlAttribute()
    {
        return route('category.show', $this->slug);
    }
}
