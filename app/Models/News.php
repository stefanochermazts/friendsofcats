<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'locale',
        'title',
        'slug',
        'excerpt',
        'body',
        'cover_image',
        'is_published',
        'published_at',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
    ];

    public static function generateSlug(string $title): string
    {
        return Str::slug($title);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)
            ->where(function (Builder $q) {
                $q->whereNull('published_at')
                  ->orWhere('published_at', '<=', now());
            });
    }

    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderByDesc('published_at')->orderByDesc('id');
    }

    public function scopeInLocale(Builder $query, string $locale): Builder
    {
        return $query->where('locale', $locale);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(NewsTranslation::class);
    }

    public function taxonomies(): BelongsToMany
    {
        return $this->belongsToMany(Taxonomy::class, 'news_taxonomy');
    }

    public function hasTranslation(string $locale): bool
    {
        return $this->translations->contains('locale', $locale);
    }

    public function translation(string $locale): ?NewsTranslation
    {
        return $this->translations->firstWhere('locale', $locale);
    }

    protected static function booted(): void
    {
        static::saving(function (News $news): void {
            if ($news->is_published && is_null($news->published_at)) {
                $news->published_at = now();
            }
            if (empty($news->slug) && !empty($news->title)) {
                $news->slug = Str::slug($news->title);
            }

            // Defaults SEO: se non forniti, genera automaticamente titolo/meta description puliti
            if (empty($news->meta_title) && !empty($news->title)) {
                $news->meta_title = Str::limit(strip_tags((string) $news->title), 70);
            }
            if (empty($news->meta_description)) {
                $source = $news->excerpt ?: $news->body ?: '';
                $news->meta_description = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $source))), 160);
            } else {
                // Normalizza comunque la descrizione per evitare HTML
                $news->meta_description = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $news->meta_description))), 160);
            }
        });
    }
}


