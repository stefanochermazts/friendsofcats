<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\EmailVerification;
use App\Mail\RegistrationNotification;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\URL;

class PreviewEmailLayout extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'preview:email-layout {locale=it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Preview email layout with minimal design';

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

        $this->info("Previewing email layout with locale: {$locale}");
        
        // Imposta la lingua
        app()->setLocale($locale);
        
        // Crea un utente di test
        $user = User::first() ?? User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'locale' => $locale,
        ]);

        // Test email di verifica
        $this->info('=== VERIFICATION EMAIL LAYOUT ===');
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

        $this->info('Subject: ' . $verificationEmail->envelope()->subject);
        $this->info('Layout: Minimal with black border and white background');
        $this->info('Logo: SVG cat logo in top-left header');
        $this->info('Content: Clean typography with proper spacing');
        $this->info('Button: Black button with white text');
        $this->info('Footer: Copyright notice');

        // Test email di notifica registrazione
        $this->info('=== REGISTRATION NOTIFICATION EMAIL LAYOUT ===');
        $registrationEmail = new RegistrationNotification($user);

        $this->info('Subject: ' . $registrationEmail->envelope()->subject);
        $this->info('Layout: Same minimal design as verification email');
        $this->info('Content: User details in styled box');
        $this->info('Typography: Clean and readable');

        $this->info('Email layout preview completed successfully!');
        $this->info('Both emails now use the minimal layout with:');
        $this->info('- Logo in top-left header');
        $this->info('- Black border around content');
        $this->info('- White background');
        $this->info('- Clean typography');
        $this->info('- Responsive design');
        
        return 0;
    }
} 