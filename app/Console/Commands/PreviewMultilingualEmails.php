<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\EmailVerification;
use App\Mail\RegistrationNotification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class PreviewMultilingualEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'preview:multilingual-emails {locale=it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preview multilingual emails with different locales';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $locale = $this->argument('locale');
        
        if (!in_array($locale, ['it', 'en', 'fr', 'de', 'es'])) {
            $this->error('Locale must be one of: it, en, fr, de, es');
            return 1;
        }

        $this->info("Previewing emails with locale: {$locale}");
        
        // Imposta la lingua
        app()->setLocale($locale);
        
        // Crea un utente di test
        $user = User::first() ?? User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'locale' => $locale,
        ]);

        // Test email di verifica
        $this->info('Previewing verification email...');
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        $verificationEmail = new EmailVerification(
            verificationUrl: $verificationUrl,
            userName: $user->name
        );

        // Mostra il contenuto dell'email di verifica
        $this->info('=== VERIFICATION EMAIL ===');
        $this->info('Subject: ' . $verificationEmail->envelope()->subject);
        $this->info('Content preview:');
        $this->info('Welcome: ' . __('emails.verification.welcome', ['app_name' => config('app.name')]));
        $this->info('Greeting: ' . __('emails.verification.greeting', ['name' => $user->name]));
        $this->info('Message: ' . __('emails.verification.message'));
        $this->info('Button: ' . __('emails.verification.verify_button'));

        // Test email di notifica registrazione
        $this->info('Previewing registration notification email...');
        $registrationEmail = new RegistrationNotification($user);

        // Mostra il contenuto dell'email di notifica
        $this->info('=== REGISTRATION NOTIFICATION EMAIL ===');
        $this->info('Subject: ' . $registrationEmail->envelope()->subject);
        $this->info('Content preview:');
        $this->info('Title: ' . __('emails.registration_notification.title'));
        $this->info('Subtitle: ' . __('emails.registration_notification.subtitle', ['app_name' => config('app.name')]));
        $this->info('User Details: ' . __('emails.registration_notification.user_details'));
        $this->info('Name: ' . __('emails.registration_notification.name'));
        $this->info('Email: ' . __('emails.registration_notification.email'));
        $this->info('Success: ' . __('emails.registration_notification.success_message'));

        $this->info('Email preview completed successfully!');
        
        return 0;
    }
} 