<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class NewsTranslation extends Model
{
    protected $table = 'news_translations';

    public $timestamps = false;

    protected $fillable = [
        'locale',
        'title',
        'slug',
        'excerpt',
        'body',
        'meta_title',
        'meta_description',
    ];

    public function news(): BelongsTo
    {
        return $this->belongsTo(News::class);
    }

    // Normalizza sempre a stringa se accidentalmente salvati come array
    public function getTitleAttribute($value): string { return is_array($value) ? trim(collect($value)->flatten()->join(' ')) : (string) $value; }
    public function getExcerptAttribute($value): ?string { if ($value===null) return null; return is_array($value) ? trim(collect($value)->flatten()->join(' ')) : (string) $value; }
    public function getBodyAttribute($value): string { return is_array($value) ? trim(collect($value)->flatten()->join(' ')) : (string) $value; }
    public function getMetaTitleAttribute($value): ?string { if ($value===null) return null; return is_array($value) ? trim(collect($value)->flatten()->join(' ')) : (string) $value; }
    public function getMetaDescriptionAttribute($value): ?string { if ($value===null) return null; return is_array($value) ? trim(collect($value)->flatten()->join(' ')) : (string) $value; }

    protected static function booted(): void
    {
        static::saving(function (NewsTranslation $translation): void {
            // Sanitize and normalize scalar values
            $fields = ['title','excerpt','body','meta_title','meta_description','slug','locale'];
            foreach ($fields as $field) {
                $value = $translation->getAttribute($field);
                $translation->setAttribute($field, self::toString($value));
            }

            // Ensure slug
            if (empty($translation->slug) && !empty($translation->title)) {
                $translation->slug = Str::slug($translation->title);
            }

            // Meta fallbacks and limits
            if (empty($translation->meta_title) && !empty($translation->title)) {
                $translation->meta_title = Str::limit(strip_tags((string) $translation->title), 70);
            }
            if (!empty($translation->meta_description)) {
                $translation->meta_description = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $translation->meta_description))), 160);
            } elseif (!empty($translation->excerpt) || !empty($translation->body)) {
                $source = $translation->excerpt ?: $translation->body;
                $translation->meta_description = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags((string) $source))), 160);
            }
        });
    }

    private static function toString($value): string
    {
        if (is_null($value)) {
            return '';
        }
        if (is_array($value)) {
            return trim(collect($value)->flatten()->join(' '));
        }
        // JSON string edge case
        if (is_string($value) && function_exists('json_validate') && json_validate($value)) {
            $decoded = json_decode($value, true);
            if (is_array($decoded)) {
                return trim(collect($decoded)->flatten()->join(' '));
            }
        }
        return (string) $value;
    }
}


