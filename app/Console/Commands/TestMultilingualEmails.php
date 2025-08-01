<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\EmailVerification;
use App\Mail\RegistrationNotification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class TestMultilingualEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:multilingual-emails {locale=it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test multilingual emails with different locales';

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

        $this->info("Testing emails with locale: {$locale}");
        
        // Imposta la lingua
        app()->setLocale($locale);
        
        // Crea un utente di test
        $user = User::first() ?? User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'locale' => $locale,
        ]);

        // Test email di verifica
        $this->info('Testing verification email...');
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->getKey(),
                'hash' => sha1($user->getEmailForVerification()),
            ]
        );

        Mail::to('test@example.com')->send(new EmailVerification(
            verificationUrl: $verificationUrl,
            userName: $user->name
        ));

        // Test email di notifica registrazione
        $this->info('Testing registration notification email...');
        Mail::to('admin@example.com')->send(new RegistrationNotification($user));

        $this->info('Emails sent successfully!');
        $this->info('Check your mail logs or mailtrap for the emails.');
        
        return 0;
    }
} 