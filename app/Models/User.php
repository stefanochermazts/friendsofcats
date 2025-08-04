<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'latitude',
        'longitude',
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
}
