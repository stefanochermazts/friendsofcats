<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Mail\RegistrationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRegistrationNotification // Rimuovo ShouldQueue per invio immediato
{
    // use InteractsWithQueue;

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
        // Previeni invio duplicato nella stessa sessione
        $sessionKey = 'admin_notification_sent_' . $event->user->id;
        if (session()->has($sessionKey)) {
            return;
        }

        $adminEmail = config('mail.admin_email');
        
        if (!$adminEmail) {
            return;
        }

        // Ottieni la lingua dall'utente o usa italiano come default
        $locale = $event->user->locale ?? 'it';
        app()->setLocale($locale);

        Mail::to($adminEmail)->send(new RegistrationNotification($event->user));
        
        // Marca come inviata per prevenire duplicati
        session()->put($sessionKey, true);
    }
} 