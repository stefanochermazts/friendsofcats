<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UpdateExistingUsersLocale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update-locale {locale=it}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing users with a default locale';

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

        $this->info("Updating users with locale: {$locale}");
        
        $updatedCount = User::whereNull('locale')->update(['locale' => $locale]);
        
        $this->info("Updated {$updatedCount} users with locale: {$locale}");
        
        return 0;
    }
} 