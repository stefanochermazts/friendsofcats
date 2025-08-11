<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Services\SitemapGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate {--output= : Percorso file rispetto alla root public (default sitemap.xml)}';

    protected $description = 'Genera una sitemap.xml statica e la salva in public/ in modo atomico';

    public function handle(SitemapGenerator $generator): int
    {
        $this->info('Generazione sitemap...');

        $xml = $generator->generateXml();

        $publicPath = public_path();
        $relative = $this->option('output') ?: 'sitemap.xml';
        $targetPath = rtrim($publicPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . ltrim($relative, DIRECTORY_SEPARATOR);

        // Scrittura atomica: file temporaneo + rename
        $tmpPath = $targetPath . '.tmp';
        if (file_put_contents($tmpPath, $xml) === false) {
            $this->error('Impossibile scrivere il file temporaneo: ' . $tmpPath);
            return self::FAILURE;
        }
        if (!@rename($tmpPath, $targetPath)) {
            @unlink($tmpPath);
            $this->error('Impossibile sostituire il file di destinazione: ' . $targetPath);
            return self::FAILURE;
        }

        // Header/permessi a carico del webserver; qui assicuriamo solo i contenuti
        $this->info('Sitemap scritta in: ' . $targetPath);
        return self::SUCCESS;
    }
}


