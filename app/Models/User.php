<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use App\Mail\EmailVerification;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'locale',
        'ragione_sociale',
        'indirizzo',
        'citta',
        'cap',
        'provincia',
        'paese',
        'telefono',
        'descrizione',
        'sito_web',
        'association_details_completed',
        'professional_details_completed',
        'associazione_id',
        'latitude',
        'longitude',
        'foto_principale',
        'galleria_foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'galleria_foto' => 'array',
        ];
    }

    /**
     * Check if the user is an admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if the user has a specific role.
     */
    public function hasRole(string $role): bool
    {
        return $this->role === $role;
    }

    /**
     * Send the email verification notification using our custom template.
     * Overrides Laravel's default to prevent duplicates.
     */
    public function sendEmailVerificationNotification(): void
    {
        // Previeni invio se è già stata inviata una email in questa sessione
        if (session()->has('email_verification_sent_' . $this->id)) {
            return;
        }

        // Ottieni la lingua dall'utente o usa italiano come default
        $locale = $this->locale ?? 'it';
        $originalLocale = app()->getLocale();
        app()->setLocale($locale);
        
        // Genera l'URL di verifica
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $this->getKey(),
                'hash' => sha1($this->getEmailForVerification()),
            ]
        );

        // Invia la mail di verifica personalizzata
        Mail::to($this->email)->send(new EmailVerification(
            verificationUrl: $verificationUrl,
            userName: $this->name
        ));
        
        // Marca come inviata per prevenire duplicati
        session()->put('email_verification_sent_' . $this->id, true);
        
        // Ripristina la lingua originale
        app()->setLocale($originalLocale);
    }

    /**
     * Relazione con i gatti dell'utente
     */
    public function cats()
    {
        return $this->hasMany(\App\Models\Cat::class);
    }

    /**
     * Relazione con i post dell'utente
     */
    public function posts()
    {
        return $this->hasMany(\App\Models\Post::class);
    }

    /**
     * Relazione con i like dell'utente
     */
    public function postLikes()
    {
        return $this->hasMany(\App\Models\PostLike::class);
    }

    /**
     * Relazione con i commenti dell'utente
     */
    public function postComments()
    {
        return $this->hasMany(\App\Models\PostComment::class);
    }

    /**
     * Utenti che questo utente sta seguendo
     */
    public function following()
    {
        return $this->hasMany(UserFollow::class, 'follower_id');
    }

    /**
     * Utenti che seguono questo utente
     */
    public function followers()
    {
        return $this->hasMany(UserFollow::class, 'following_id');
    }

    /**
     * Gatti che questo utente sta seguendo
     */
    public function followedCats()
    {
        return $this->hasMany(CatFollow::class);
    }

    /**
     * Relazione many-to-many per utenti seguiti
     */
    public function followingUsers()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'follower_id', 'following_id')
                    ->withTimestamps()
                    ->withPivot('notifications_enabled');
    }

    /**
     * Relazione many-to-many per followers
     */
    public function followerUsers()
    {
        return $this->belongsToMany(User::class, 'user_follows', 'following_id', 'follower_id')
                    ->withTimestamps()
                    ->withPivot('notifications_enabled');
    }

    /**
     * Relazione many-to-many per gatti seguiti
     */
    public function followingCats()
    {
        return $this->belongsToMany(Cat::class, 'cat_follows')
                    ->withTimestamps()
                    ->withPivot('notifications_enabled');
    }

    /**
     * Verifica se l'utente sta seguendo un altro utente
     */
    public function isFollowing(User $user): bool
    {
        return $this->followingUsers()->where('following_id', $user->id)->exists();
    }

    /**
     * Verifica se l'utente sta seguendo un gatto
     */
    public function isFollowingCat(Cat $cat): bool
    {
        return $this->followingCats()->where('cat_id', $cat->id)->exists();
    }

    /**
     * Segui un utente
     */
    public function followUser(User $user, bool $notifications = true): UserFollow
    {
        return UserFollow::firstOrCreate(
            ['follower_id' => $this->id, 'following_id' => $user->id],
            ['notifications_enabled' => $notifications]
        );
    }

    /**
     * Smetti di seguire un utente
     */
    public function unfollowUser(User $user): bool
    {
        return UserFollow::where('follower_id', $this->id)
                         ->where('following_id', $user->id)
                         ->delete() > 0;
    }

    /**
     * Segui un gatto
     */
    public function followCat(Cat $cat, bool $notifications = true): CatFollow
    {
        return CatFollow::firstOrCreate(
            ['user_id' => $this->id, 'cat_id' => $cat->id],
            ['notifications_enabled' => $notifications]
        );
    }

    /**
     * Smetti di seguire un gatto
     */
    public function unfollowCat(Cat $cat): bool
    {
        return CatFollow::where('user_id', $this->id)
                        ->where('cat_id', $cat->id)
                        ->delete() > 0;
    }

    /**
     * Ottieni conteggi dei follow
     */
    public function getFollowCounts(): array
    {
        return [
            'following_users' => $this->followingUsers()->count(),
            'followers' => $this->followerUsers()->count(),
            'following_cats' => $this->followingCats()->count(),
        ];
    }

    /**
     * Relazione con l'associazione di appartenenza (per volontari)
     */
    public function associazione(): BelongsTo
    {
        return $this->belongsTo(User::class, 'associazione_id');
    }

    /**
     * Relazione con i volontari dell'associazione
     */
    public function volontari(): HasMany
    {
        return $this->hasMany(User::class, 'associazione_id')->where('role', 'volontario');
    }

    /**
     * Verifica se l'utente è collegato a un'associazione
     */
    public function hasAssociazione(): bool
    {
        return $this->associazione_id !== null;
    }

    /**
     * Verifica se l'utente è un volontario con associazione
     */
    public function isVolontarioConAssociazione(): bool
    {
        return $this->role === 'volontario' && $this->hasAssociazione();
    }

    /**
     * Verifica se l'utente è un volontario indipendente
     */
    public function isVolontarioIndipendente(): bool
    {
        return $this->role === 'volontario' && !$this->hasAssociazione();
    }

    /**
     * Relazione con i gatti collegati a questa associazione (tramite associazione_id)
     */
    public function catsAsAssociazione()
    {
        return $this->hasMany(\App\Models\Cat::class, 'associazione_id');
    }
}
