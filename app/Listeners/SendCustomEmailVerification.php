<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Mail\EmailVerification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class SendCustomEmailVerification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $user = $event->user;
        
        // Ottieni la lingua dall'utente o usa italiano come default
        $locale = $user->locale ?? 'it';
        app()->setLocale($locale);
        
        // Genera l'URL di verifica
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        // Invia la mail di verifica personalizzata
        Mail::to($user->email)->send(new EmailVerification(
            verificationUrl: $verificationUrl,
            userName: $user->name
        ));
    }
} 