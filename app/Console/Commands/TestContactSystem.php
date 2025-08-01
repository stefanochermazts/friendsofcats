<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Mail\ContactConfirmation;
use App\Mail\ContactNotification;
use App\Models\Contact;
use Illuminate\Console\Command;

class TestContactSystem extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:contact-system {locale=it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test contact system with email sending';

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

        $this->info("Testing contact system with locale: {$locale}");
        
        // Imposta la lingua
        app()->setLocale($locale);
        
        // Crea un contatto di test
        $contact = Contact::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'subject' => 'Test Contact Form',
            'message' => 'Questo è un messaggio di test per verificare il sistema di contatto.',
            'status' => 'new',
        ]);
        
        $this->info('=== CONTACT CREATED ===');
        $this->info('ID: ' . $contact->id);
        $this->info('Name: ' . $contact->name);
        $this->info('Email: ' . $contact->email);
        $this->info('Subject: ' . $contact->subject);
        $this->info('Message: ' . $contact->message);
        
        // Test email di conferma
        $this->info('=== TESTING CONFIRMATION EMAIL ===');
        $confirmationEmail = new ContactConfirmation($contact);
        $this->info('Subject: ' . $confirmationEmail->envelope()->subject);
        $this->info('Recipient: ' . $contact->email);
        
        // Test email di notifica admin
        $this->info('=== TESTING ADMIN NOTIFICATION EMAIL ===');
        $notificationEmail = new ContactNotification($contact);
        $this->info('Subject: ' . $notificationEmail->envelope()->subject);
        $this->info('Admin Email: ' . config('mail.admin_email', env('ADMIN_EMAIL')));
        
        $this->info('Contact system test completed successfully!');
        $this->info('Both emails are ready to be sent.');
        
        // Pulisci il contatto di test
        $contact->delete();
        
        return 0;
    }
} 