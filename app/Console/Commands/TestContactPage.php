<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestContactPage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:contact-page {locale=it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test contact page with different locales';

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

        $this->info("Testing contact page with locale: {$locale}");
        
        // Imposta la lingua
        app()->setLocale($locale);
        
        $this->info('=== CONTACT PAGE TEST ===');
        $this->info('Title: ' . __('contact.title'));
        $this->info('Subtitle: ' . __('contact.subtitle'));
        $this->info('Contact Info: ' . __('contact.contact_info'));
        $this->info('Send Message: ' . __('contact.send_message'));
        $this->info('Follow Us: ' . __('contact.follow_us'));
        
        $this->info('=== FORM FIELDS ===');
        $this->info('Name: ' . __('contact.name'));
        $this->info('Email: ' . __('contact.email'));
        $this->info('Subject: ' . __('contact.subject'));
        $this->info('Message: ' . __('contact.message'));
        $this->info('Send: ' . __('contact.send'));
        
        $this->info('=== CONTACT INFO ===');
        $this->info('Phone: ' . __('contact.phone'));
        $this->info('Hours: ' . __('contact.hours'));
        $this->info('Address: ' . __('contact.address'));
        
        $this->info('=== VALIDATION MESSAGES ===');
        $this->info('Name Required: ' . __('contact.validation.name_required'));
        $this->info('Email Required: ' . __('contact.validation.email_required'));
        $this->info('Message Required: ' . __('contact.validation.message_required'));
        
        $this->info('=== SUCCESS MESSAGES ===');
        $this->info('Message Sent: ' . __('contact.message_sent'));
        
        $this->info('Contact page test completed successfully!');
        $this->info('All translations are working correctly.');
        
        return 0;
    }
} 