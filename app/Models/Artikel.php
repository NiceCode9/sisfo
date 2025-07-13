<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Artikel extends Model
{
    use Sluggable;

    protected $table = 'artikel';
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'featured_image_alt',
        'featured_image_caption',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'og_data',
        'schema_data',
        'category_id',
        'author_id',
        'reading_time',
        'word_count',
        'status',
        'is_featured',
        'is_breaking',
        'published_at',
        'views_count',
        'likes_count',
        'shares_count',
        'comments_count',
        'seo_score',
        'seo_analysis'
    ];

    protected $casts = [
        'og_data' => 'array',
        'schema_data' => 'array',
        'seo_analysis' => 'array',
        'is_featured' => 'boolean',
        'is_breaking' => 'boolean',
        'published_at' => 'datetime',
        'views_count' => 'integer',
        'likes_count' => 'integer',
        'shares_count' => 'integer',
        'comments_count' => 'integer',
        'reading_time' => 'integer',
        'word_count' => 'integer',
        'seo_score' => 'decimal:1'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Kategori::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'artikel_tag', 'article_id', 'tag_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(ArtikelImage::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Komentar::class);
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(Komentar::class)->where('status', 'approved');
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(ArtikelAnalis::class);
    }

    public function relatedArticles(): BelongsToMany
    {
        return $this->belongsToMany(Artikel::class, 'article_related', 'article_id', 'related_article_id')
            ->withPivot('relevance_score')
            ->orderByPivot('relevance_score', 'desc');
    }

    // Scopes
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('is_featured', true);
    }

    public function scopeBreaking(Builder $query): Builder
    {
        return $query->where('is_breaking', true);
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function scopePopular(Builder $query): Builder
    {
        return $query->orderBy('views_count', 'desc');
    }

    public function scopeByCategory(Builder $query, $categorySlug): Builder
    {
        return $query->whereHas('category', function ($q) use ($categorySlug) {
            $q->where('slug', $categorySlug);
        });
    }

    public function scopeByTag(Builder $query, $tagSlug): Builder
    {
        return $query->whereHas('tags', function ($q) use ($tagSlug) {
            $q->where('slug', $tagSlug);
        });
    }

    public function scopeByAuthor(Builder $query, $authorSlug): Builder
    {
        return $query->whereHas('author', function ($q) use ($authorSlug) {
            $q->where('slug', $authorSlug);
        });
    }

    public function scopeSearch(Builder $query, $search): Builder
    {
        return $query->whereRaw("MATCH(title, excerpt, content) AGAINST(? IN NATURAL LANGUAGE MODE)", [$search]);
    }

    // Accessors & Mutators
    public function getUrlAttribute(): string
    {
        return route('article.show', [
            'category' => $this->category->slug,
            'slug' => $this->slug
        ]);
    }

    public function getMetaTitleAttribute($value): string
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value): string
    {
        return $value ?: $this->excerpt;
    }

    public function getReadingTimeAttribute($value): int
    {
        return $value ?: ceil($this->word_count / 200); // 200 words per minute
    }

    public function setContentAttribute($value): void
    {
        $this->attributes['content'] = $value;
        $this->attributes['word_count'] = str_word_count(strip_tags($value));
    }

    public function getFormattedPublishedAtAttribute(): string
    {
        return $this->published_at ? $this->published_at->format('d M Y, H:i') : '';
    }

    public function getTimeAgoAttribute(): string
    {
        return $this->published_at ? $this->published_at->diffForHumans() : '';
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->status === 'published' && $this->published_at <= now();
    }

    // SEO Methods
    public function generateSchemaMarkup(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'NewsArticle',
            'headline' => $this->title,
            'description' => $this->excerpt,
            'image' => $this->featured_image ? url($this->featured_image) : null,
            'datePublished' => $this->published_at->toISOString(),
            'dateModified' => $this->updated_at->toISOString(),
            'author' => [
                '@type' => 'Person',
                'name' => $this->author->name,
                'url' => $this->author->url
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => config('app.name'),
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('images/logo.png')
                ]
            ],
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $this->url
            ],
            'articleSection' => $this->category->name,
            'keywords' => $this->tags->pluck('name')->implode(', '),
            'wordCount' => $this->word_count
        ];
    }

    public function generateOgData(): array
    {
        return [
            'og:type' => 'article',
            'og:title' => $this->meta_title,
            'og:description' => $this->meta_description,
            'og:url' => $this->url,
            'og:image' => $this->featured_image ? url($this->featured_image) : null,
            'og:site_name' => config('app.name'),
            'article:author' => $this->author->name,
            'article:published_time' => $this->published_at->toISOString(),
            'article:modified_time' => $this->updated_at->toISOString(),
            'article:section' => $this->category->name,
            'article:tag' => $this->tags->pluck('name')->toArray()
        ];
    }

    // Methods
    public function incrementViews(): void
    {
        $this->increment('views_count');

        // Update daily analytics
        $today = now()->format('Y-m-d');
        $analytics = $this->analytics()->firstOrCreate(['date' => $today]);
        $analytics->increment('views');
    }

    public function updateSeoScore(): void
    {
        $score = 0;

        // Title length (ideal: 50-60 characters)
        $titleLength = strlen($this->title);
        if ($titleLength >= 50 && $titleLength <= 60) {
            $score += 2;
        } elseif ($titleLength >= 30 && $titleLength <= 70) {
            $score += 1;
        }

        // Meta description length (ideal: 150-160 characters)
        $descLength = strlen($this->meta_description);
        if ($descLength >= 150 && $descLength <= 160) {
            $score += 2;
        } elseif ($descLength >= 120 && $descLength <= 170) {
            $score += 1;
        }

        // Has featured image
        if ($this->featured_image) {
            $score += 1;
        }

        // Has alt text for featured image
        if ($this->featured_image_alt) {
            $score += 1;
        }

        // Content length (ideal: 1000+ words)
        if ($this->word_count >= 1000) {
            $score += 2;
        } elseif ($this->word_count >= 500) {
            $score += 1;
        }

        // Has tags
        if ($this->tags->count() > 0) {
            $score += 1;
        }

        // Has canonical URL
        if ($this->canonical_url) {
            $score += 1;
        }

        $this->update(['seo_score' => $score]);
    }
}
