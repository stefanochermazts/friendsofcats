<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TestTranslations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:translations {locale=it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test if translations are loading correctly';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $locale = $this->argument('locale');
        
        $this->info("Testing translations for locale: {$locale}");
        
        // Imposta la lingua
        app()->setLocale($locale);
        
        $this->info('Current locale: ' . app()->getLocale());
        
        // Test percorsi
        $this->info('Lang path: ' . lang_path());
        $this->info('Base path: ' . base_path());
        
        // Test se i file esistono
        $itEmailsPath = lang_path('it/emails.php');
        $enEmailsPath = lang_path('en/emails.php');
        
        $this->info('IT emails file path: ' . $itEmailsPath);
        $this->info('IT emails file exists: ' . (file_exists($itEmailsPath) ? 'YES' : 'NO'));
        $this->info('EN emails file exists: ' . (file_exists($enEmailsPath) ? 'YES' : 'NO'));
        
        // Lista tutti i file nella directory lang/it
        $this->info('Files in lang/it/ directory:');
        $itDir = lang_path('it');
        if (is_dir($itDir)) {
            $files = scandir($itDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $this->info('  - ' . $file);
                }
            }
        } else {
            $this->info('  Directory lang/it/ does not exist!');
        }
        
        // Prova a caricare manualmente le traduzioni
        if (file_exists($itEmailsPath)) {
            $this->info('Loading IT translations manually...');
            $translations = require $itEmailsPath;
            
            $this->info('Verification subject: ' . $translations['verification']['subject']);
            $this->info('Registration title: ' . $translations['registration_notification']['title']);
        }
        
        // Test con la funzione __()
        $this->info('Testing with __() function:');
        $this->info('Verification subject: ' . __('emails.verification.subject', ['app_name' => 'FriendsOfCats']));
        $this->info('Registration title: ' . __('emails.registration_notification.title'));
        
        return 0;
    }
} 