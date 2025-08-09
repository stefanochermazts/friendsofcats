<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Taxonomy extends Model
{
    protected $fillable = [
        'slug', 'name', 'description', 'meta_title', 'meta_description',
    ];

    public function news(): BelongsToMany
    {
        return $this->belongsToMany(News::class, 'news_taxonomy');
    }
}


