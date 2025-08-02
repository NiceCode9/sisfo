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

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['title', 'category.name']
            ]
        ];
    }

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'category_id');
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
        return $this->hasMany(Komentar::class, 'article_id');
    }

    public function approvedComments(): HasMany
    {
        return $this->hasMany(Komentar::class, 'article_id')->where('status', 'approved');
    }

    public function analytics(): HasMany
    {
        return $this->hasMany(ArtikelAnalis::class, 'article_id');
    }

    public function relatedArticles(): BelongsToMany
    {
        return $this->belongsToMany(Artikel::class, 'artikel_related', 'article_id', 'related_article_id')
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
        return route('artikel.artikel.show', $this->slug);
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

    // public function updateSeoScore(): void
    // {
    //     $score = 0;

    //     // Title length (ideal: 50-60 characters)
    //     $titleLength = strlen($this->title);
    //     if ($titleLength >= 50 && $titleLength <= 60) {
    //         $score += 2;
    //     } elseif ($titleLength >= 30 && $titleLength <= 70) {
    //         $score += 1;
    //     }

    //     // Meta description length (ideal: 150-160 characters)
    //     $descLength = strlen($this->meta_description);
    //     if ($descLength >= 150 && $descLength <= 160) {
    //         $score += 2;
    //     } elseif ($descLength >= 120 && $descLength <= 170) {
    //         $score += 1;
    //     }

    //     // Has featured image
    //     if ($this->featured_image) {
    //         $score += 1;
    //     }

    //     // Has alt text for featured image
    //     if ($this->featured_image_alt) {
    //         $score += 1;
    //     }

    //     // Content length (ideal: 1000+ words)
    //     if ($this->word_count >= 1000) {
    //         $score += 2;
    //     } elseif ($this->word_count >= 500) {
    //         $score += 1;
    //     }

    //     // Has tags
    //     if ($this->tags->count() > 0) {
    //         $score += 1;
    //     }

    //     // Has canonical URL
    //     if ($this->canonical_url) {
    //         $score += 1;
    //     }

    //     $this->update(['seo_score' => $score]);
    // }

    public function updateSeoScore(): void
    {
        $score = 0;
        $maxScore = 10; // Total 10 poin untuk kemudahan perhitungan

        // 1. Title length (ideal: 30-60 characters) - 2 points
        $titleLength = strlen($this->title);
        if ($titleLength >= 30 && $titleLength <= 60) {
            $score += 2;
        } elseif ($titleLength >= 20 && $titleLength <= 80) {
            $score += 1;
        }

        // 2. Meta description length (ideal: 120-160 characters) - 2 points
        $metaDesc = $this->meta_description ?: $this->excerpt;
        $descLength = strlen($metaDesc);
        if ($descLength >= 120 && $descLength <= 160) {
            $score += 2;
        } elseif ($descLength >= 100 && $descLength <= 180) {
            $score += 1;
        }

        // 3. Has featured image - 1 point
        if ($this->featured_image) {
            $score += 1;
        }

        // 4. Has alt text for featured image - 1 point
        if ($this->featured_image && $this->featured_image_alt) {
            $score += 1;
        }

        // 5. Content length (ideal: 300+ words) - 2 points
        if ($this->word_count >= 300) {
            $score += 2;
        } elseif ($this->word_count >= 150) {
            $score += 1;
        }

        // 6. Has tags - 1 point
        if ($this->tags()->count() > 0) {
            $score += 1;
        }

        // 7. Has canonical URL - 1 point
        if ($this->canonical_url) {
            $score += 1;
        }

        // Convert to percentage (0-100)
        $scorePercentage = ($score / $maxScore) * 100;

        // Store SEO analysis details
        $analysis = [
            'score' => $scorePercentage,
            'details' => [
                'title_length' => $titleLength,
                'title_optimal' => $titleLength >= 30 && $titleLength <= 60,
                'meta_desc_length' => $descLength,
                'meta_desc_optimal' => $descLength >= 120 && $descLength <= 160,
                'has_featured_image' => !empty($this->featured_image),
                'has_image_alt' => !empty($this->featured_image_alt),
                'word_count' => $this->word_count,
                'word_count_optimal' => $this->word_count >= 300,
                'has_tags' => $this->tags()->count() > 0,
                'has_canonical' => !empty($this->canonical_url),
            ],
            'suggestions' => $this->generateSeoSuggestions($scorePercentage)
        ];

        $this->update([
            'seo_score' => $scorePercentage,
            'seo_analysis' => $analysis
        ]);
    }

    private function generateSeoSuggestions(float $score): array
    {
        $suggestions = [];

        // Title suggestions
        $titleLength = strlen($this->title);
        if ($titleLength < 30) {
            $suggestions[] = 'Judul terlalu pendek. Ideal: 30-60 karakter';
        } elseif ($titleLength > 60) {
            $suggestions[] = 'Judul terlalu panjang. Ideal: 30-60 karakter';
        }

        // Meta description suggestions
        $metaDesc = $this->meta_description ?: $this->excerpt;
        $descLength = strlen($metaDesc);
        if ($descLength < 120) {
            $suggestions[] = 'Meta description terlalu pendek. Ideal: 120-160 karakter';
        } elseif ($descLength > 160) {
            $suggestions[] = 'Meta description terlalu panjang. Ideal: 120-160 karakter';
        }

        // Image suggestions
        if (!$this->featured_image) {
            $suggestions[] = 'Tambahkan gambar unggulan untuk meningkatkan SEO';
        } elseif (!$this->featured_image_alt) {
            $suggestions[] = 'Tambahkan alt text untuk gambar unggulan';
        }

        // Content suggestions
        if ($this->word_count < 300) {
            $suggestions[] = 'Konten terlalu pendek. Minimal 300 kata untuk SEO optimal';
        }

        // Tags suggestions
        if ($this->tags()->count() === 0) {
            $suggestions[] = 'Tambahkan tag untuk meningkatkan kategorisasi';
        }

        // Canonical URL suggestions
        if (!$this->canonical_url) {
            $suggestions[] = 'Tambahkan canonical URL untuk mencegah duplicate content';
        }

        return $suggestions;
    }

    // Accessor untuk SEO score status
    public function getSeoStatusAttribute(): string
    {
        if ($this->seo_score >= 80) {
            return 'excellent';
        } elseif ($this->seo_score >= 60) {
            return 'good';
        } else {
            return 'poor';
        }
    }

    // Accessor untuk SEO suggestions
    public function getSeoSuggestionsAttribute(): array
    {
        return $this->seo_analysis['suggestions'] ?? [];
    }
}
