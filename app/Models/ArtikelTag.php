<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtikelTag extends Model
{
    protected $table = 'artikel_tag';

    protected $fillable = [
        'article_id',
        'tag_id'
    ];

    public function artikel(): BelongsTo
    {
        return $this->belongsTo(Artikel::class, 'article_id');
    }

    public function tag(): BelongsTo
    {
        return $this->belongsTo(Tag::class, 'tag_id');
    }
}
