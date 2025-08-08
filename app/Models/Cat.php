<?php

namespace App\Models;

use App\Jobs\SendFollowNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cat extends Model
{
    use HasFactory;

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // Assegna automaticamente una foto placeholder se manca la foto principale
        static::saving(function (Cat $cat) {
            if (empty($cat->foto_principale) || $cat->foto_principale === null) {
                $cat->assignPlaceholderPhoto();
            }
        });
        
        // Assegna anche dopo la creazione se l'ID non era disponibile durante il saving
        static::created(function (Cat $cat) {
            if (empty($cat->foto_principale) || $cat->foto_principale === null) {
                $cat->assignPlaceholderPhoto();
                $cat->saveQuietly(); // Save without triggering events again
            }
        });

        // Invia notifiche ai followers quando il gatto viene aggiornato
        static::updated(function (Cat $cat) {
            $importantFields = [
                'disponibile_adozione', 'stato_salute', 'foto_principale', 
                'galleria_foto', 'peso', 'eta', 'sterilizzazione'
            ];
            
            $changes = [];
            foreach ($importantFields as $field) {
                if ($cat->isDirty($field)) {
                    $changes[$field] = $cat->getOriginal($field);
                }
            }
            
            if (!empty($changes)) {
                SendFollowNotification::dispatchForCatUpdate($cat, $changes);
            }
        });
    }

    protected $fillable = [
        'nome',
        'razza',
        'eta',
        'sesso',
        'peso',
        'colore',
        'stato_sanitario',
        'microchip',
        'numero_microchip',
        'sterilizzazione',
        'vaccinazioni',
        'comportamento',
        'livello_socialita',
        'note_comportamentali',
        'disponibile_adozione',
        'stato',
        'likes_count',
        'last_liked_at',
        'data_arrivo',
        'data_adozione',
        'foto_principale',
        'galleria_foto',
        'user_id', // Chi ha creato/gestisce il gatto
        'associazione_id', // Per associazioni che gestiscono il gatto
    ];

    protected $casts = [
        'eta' => 'integer',
        'peso' => 'decimal:2',
        'sterilizzazione' => 'boolean',
        'disponibile_adozione' => 'boolean',
        'data_arrivo' => 'date',
        'data_adozione' => 'date',
        'vaccinazioni' => 'array',
        'galleria_foto' => 'array',
    ];

    /**
     * Relazione con l'utente che gestisce il gatto
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relazione con l'associazione (se gestito da associazione)
     */
    public function associazione(): BelongsTo
    {
        return $this->belongsTo(User::class, 'associazione_id');
    }

    /**
     * Scope per gatti disponibili per adozione
     */
    public function scopeDisponibiliAdozione($query)
    {
        return $query->where('disponibile_adozione', true)
                    ->whereNull('data_adozione');
    }

    /**
     * Scope per gatti già adottati
     */
    public function scopeAdottati($query)
    {
        return $query->where('disponibile_adozione', false)
                    ->whereNotNull('data_adozione');
    }

    /**
     * Scope per filtro per razza
     */
    public function scopeRazza($query, $razza)
    {
        return $query->where('razza', $razza);
    }

    /**
     * Scope per filtro per età
     */
    public function scopeEta($query, $etaMin = null, $etaMax = null)
    {
        if ($etaMin) {
            $query->where('eta', '>=', $etaMin);
        }
        if ($etaMax) {
            $query->where('eta', '<=', $etaMax);
        }
        return $query;
    }

    /**
     * Scope per livello di socialità
     */
    public function scopeSocialita($query, $livello)
    {
        return $query->where('livello_socialita', $livello);
    }

    /**
     * Calcola l'età in formato leggibile
     */
    public function getEtaFormattataAttribute(): string
    {
        if (!$this->eta) {
            return 'N/A';
        }
        
        try {
            if ($this->eta < 12) {
                return $this->eta . ' ' . trans_choice('cats.months', $this->eta);
            }
            
            $anni = intval($this->eta / 12);
            $mesi = $this->eta % 12;
            
            if ($mesi === 0) {
                return $anni . ' ' . trans_choice('cats.years', $anni);
            }
            
            return $anni . ' ' . trans_choice('cats.years', $anni) . ' ' . __('cats.and') . ' ' . $mesi . ' ' . trans_choice('cats.months', $mesi);
        } catch (\Exception $e) {
            // Fallback se le traduzioni falliscono
            if ($this->eta < 12) {
                return $this->eta . ' ' . ($this->eta == 1 ? 'mese' : 'mesi');
            }
            
            $anni = intval($this->eta / 12);
            $mesi = $this->eta % 12;
            
            if ($mesi === 0) {
                return $anni . ' ' . ($anni == 1 ? 'anno' : 'anni');
            }
            
            return $anni . ' ' . ($anni == 1 ? 'anno' : 'anni') . ' e ' . $mesi . ' ' . ($mesi == 1 ? 'mese' : 'mesi');
        }
    }

    /**
     * Get stato sterilizzazione in formato leggibile
     */
    public function getSterilizzazioneTestoAttribute(): string
    {
        return $this->sterilizzazione ? 'Sterilizzato' : 'Non sterilizzato';
    }

    /**
     * Assegna una foto placeholder casuale al gatto
     */
    public function assignPlaceholderPhoto(): void
    {
        $placeholderPhotos = [
            'cats/placeholders/cat-placeholder-1.svg',
            'cats/placeholders/cat-placeholder-2.svg', 
            'cats/placeholders/cat-placeholder-3.svg',
            'cats/placeholders/cat-placeholder-4.svg',
            'cats/placeholders/cat-placeholder-5.svg',
        ];
        
        // Verifica che i file placeholder esistano, altrimenti usa un fallback
        $validPlaceholders = array_filter($placeholderPhotos, function($photo) {
            return file_exists(storage_path('app/public/' . $photo));
        });
        
        if (empty($validPlaceholders)) {
            // Fallback se non ci sono placeholder disponibili
            \Log::warning('Nessun placeholder disponibile per il gatto ID: ' . ($this->id ?? 'nuovo'));
            return;
        }
        
        // Sceglie una foto placeholder in base all'ID del gatto per mantenere coerenza
        // Se il gatto non ha ancora un ID (creazione), usa il nome come seed per la casualità
        if ($this->id) {
            $index = $this->id % count($validPlaceholders);
        } elseif ($this->nome) {
            $index = crc32($this->nome) % count($validPlaceholders);
        } else {
            $index = array_rand($validPlaceholders);
        }
        
        $this->foto_principale = array_values($validPlaceholders)[$index];
        
        \Log::info("Assegnata foto placeholder al gatto '{$this->nome}' (ID: " . ($this->id ?? 'nuovo') . "): {$this->foto_principale}");
    }

    /**
     * Relazione con i post del gatto
     */
    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class);
    }

    /**
     * Utenti che seguono questo gatto
     */
    public function followers()
    {
        return $this->hasMany(CatFollow::class);
    }

    /**
     * Relazione many-to-many per utenti che seguono questo gatto
     */
    public function followerUsers()
    {
        return $this->belongsToMany(User::class, 'cat_follows')
                    ->withTimestamps()
                    ->withPivot('notifications_enabled');
    }

    /**
     * Verifica se un utente sta seguendo questo gatto
     */
    public function isFollowedBy(User $user): bool
    {
        return $this->followerUsers()->where('user_id', $user->id)->exists();
    }

    /**
     * Ottieni il numero di followers
     */
    public function getFollowersCount(): int
    {
        return $this->followers()->count();
    }

    /**
     * Ottieni i followers con notifiche attive
     */
    public function getNotificationFollowers()
    {
        return $this->followerUsers()->wherePivot('notifications_enabled', true);
    }
}