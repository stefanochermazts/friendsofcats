<?php

namespace App\Models;

use App\Jobs\SendFollowNotification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Invia notifiche ai followers quando viene creato un nuovo post
        static::created(function (Post $post) {
            // Dispatch job per inviare notifiche ai followers
            SendFollowNotification::dispatchForPost($post);
        });
    }

    protected $fillable = [
        'user_id',
        'cat_id',
        'type',
        'content',
        'image',
        'hashtags',
        'likes_count',
        'comments_count',
        'shares_count',
        'is_pinned',
        'is_active',
        'locale'
    ];

    protected $casts = [
        'hashtags' => 'array',
        'is_pinned' => 'boolean',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relazione con l'utente che ha creato il post
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relazione con il gatto del post (opzionale)
     */
    public function cat(): BelongsTo
    {
        return $this->belongsTo(Cat::class);
    }

    /**
     * Relazione con i commenti del post
     */
    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class)->orderBy('created_at', 'desc');
    }

    /**
     * Relazione con i like del post
     */
    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class);
    }

    /**
     * Scope per ottenere solo i post attivi
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope per ottenere i post ordinati cronologicamente
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('is_pinned', 'desc')
                    ->orderBy('created_at', 'desc');
    }

    /**
     * Scope per post di un tipo specifico
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope per post in una lingua specifica
     */
    public function scopeInLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    /**
     * Scope per post nell'area linguistica dell'utente
     * (include anche le lingue "compatibili")
     */
    public function scopeInUserArea($query, $userLocale)
    {
        // Definisce gruppi di lingue compatibili
        $languageGroups = [
            'it' => ['it'],
            'en' => ['en'],
            'de' => ['de'],
            'fr' => ['fr'],
            'es' => ['es'],
            'sl' => ['sl']
        ];
        
        $compatibleLocales = $languageGroups[$userLocale] ?? [$userLocale];
        
        return $query->whereIn('locale', $compatibleLocales);
    }

    /**
     * Verifica se l'utente ha messo like a questo post
     */
    public function isLikedBy($userId): bool
    {
        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Estrae automaticamente gli hashtag dal contenuto
     */
    public function extractHashtags(): array
    {
        preg_match_all('/#([a-zA-Z0-9_]+)/', $this->content, $matches);
        return array_unique($matches[1]);
    }

    /**
     * Metodo per creare post di richiesta adozione automatici
     */
    public static function createAdoptionRequest(Cat $cat): self
    {
        $content = "🏠 Cerco una famiglia amorevole per {$cat->nome}! " .
                   "Questo adorabile {$cat->genere} di {$cat->getEtaFormattataAttribute()} " .
                   "sta aspettando qualcuno che lo ami. " .
                   "#Adozione #CercoFamiglia #GattoSpeciale";

        return self::create([
            'user_id' => $cat->user_id,
            'cat_id' => $cat->id,
            'type' => 'adoption_request',
            'content' => $content,
            'image' => $cat->foto_principale,
            'hashtags' => ['Adozione', 'CercoFamiglia', 'GattoSpeciale'],
            'is_active' => true,
            'locale' => $cat->user->locale ?? 'it' // Per i post automatici, usa la lingua dell'utente proprietario
        ]);
    }
}
