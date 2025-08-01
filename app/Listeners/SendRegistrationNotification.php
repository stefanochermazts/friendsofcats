<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Mail\RegistrationNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendRegistrationNotification implements ShouldQueue
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
        $adminEmail = config('mail.admin_email');
        
        if (!$adminEmail) {
            return;
        }

        // Ottieni la lingua dall'utente o usa italiano come default
        $locale = $event->user->locale ?? 'it';
        app()->setLocale($locale);

        Mail::to($adminEmail)->send(new RegistrationNotification($event->user));
    }
} 