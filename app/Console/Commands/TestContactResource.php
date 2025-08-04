<?php

namespace App\Console\Commands;

use App\Models\Contact;
use Illuminate\Console\Command;

class TestContactResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:contact-resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test del ContactResource di Filament creando alcuni contatti di esempio';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('🧪 Test del ContactResource di Filament...');

        // Crea alcuni contatti di esempio
        $contacts = [
            [
                'name' => 'Mario Rossi',
                'email' => 'mario.rossi@example.com',
                'subject' => 'Informazioni su adozione gatto',
                'message' => 'Buongiorno, sarei interessato ad adottare un gatto. Potreste fornirmi maggiori informazioni sui gatti disponibili?',
                'status' => 'new',
            ],
            [
                'name' => 'Laura Bianchi',
                'email' => 'laura.bianchi@example.com',
                'subject' => 'Volontariato',
                'message' => 'Ciao, vorrei offrirmi come volontaria per aiutare i gatti in cerca di casa. Come posso iniziare?',
                'status' => 'read',
                'read_at' => now()->subHours(2),
            ],
            [
                'name' => 'Giuseppe Verdi',
                'email' => 'giuseppe.verdi@example.com',
                'subject' => 'Donazione per sterilizzazioni',
                'message' => 'Salve, vorrei fare una donazione specifica per le sterilizzazioni dei gatti randagi. Quali sono le modalità?',
                'status' => 'replied',
            ],
            [
                'name' => 'Anna Neri',
                'email' => 'anna.neri@example.com',
                'subject' => 'Gatto smarrito',
                'message' => 'Il mio gatto è scomparso ieri sera. È un gatto grigio con gli occhi verdi. Avete ricevuto segnalazioni?',
                'status' => 'new',
            ],
        ];

        $createdCount = 0;
        
        foreach ($contacts as $contactData) {
            $existing = Contact::where('email', $contactData['email'])->first();
            
            if (!$existing) {
                Contact::create($contactData);
                $createdCount++;
                $this->line("✅ Creato contatto: {$contactData['name']} ({$contactData['email']})");
            } else {
                $this->line("⚠️  Contatto già esistente: {$contactData['name']} ({$contactData['email']})");
            }
        }

        $this->newLine();
        $this->info("📊 Statistiche contatti:");
        $this->table(
            ['Stato', 'Conteggio'],
            [
                ['Nuovi', Contact::where('status', 'new')->count()],
                ['Letti', Contact::where('status', 'read')->count()],
                ['Risposti', Contact::where('status', 'replied')->count()],
                ['Totali', Contact::count()],
            ]
        );

        if ($createdCount > 0) {
            $this->newLine();
            $this->info("✨ Creati {$createdCount} nuovi contatti di esempio.");
        }

        $this->newLine();
        $this->info('🎯 Puoi ora visitare l\'area admin di Filament per vedere i contatti:');
        $this->line('   🌐 URL: ' . url('/admin/contacts'));
        $this->line('   📧 Le nuove richieste appariranno con badge rosso nel menu di navigazione');

        return Command::SUCCESS;
    }
}