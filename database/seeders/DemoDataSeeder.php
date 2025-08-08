<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\Models\Cat;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $password = 'Password123!';
        $now = now();

        $this->ensureCatPlaceholders();

        // Città italiane con coordinate indicative (lat, lon, provincia, CAP)
        $cities = [
            ['citta' => 'Roma', 'provincia' => 'RM', 'cap' => '00100', 'lat' => 41.9028, 'lon' => 12.4964],
            ['citta' => 'Milano', 'provincia' => 'MI', 'cap' => '20100', 'lat' => 45.4642, 'lon' => 9.1900],
            ['citta' => 'Torino', 'provincia' => 'TO', 'cap' => '10100', 'lat' => 45.0703, 'lon' => 7.6869],
            ['citta' => 'Napoli', 'provincia' => 'NA', 'cap' => '80100', 'lat' => 40.8518, 'lon' => 14.2681],
            ['citta' => 'Palermo', 'provincia' => 'PA', 'cap' => '90100', 'lat' => 38.1157, 'lon' => 13.3613],
            ['citta' => 'Firenze', 'provincia' => 'FI', 'cap' => '50100', 'lat' => 43.7696, 'lon' => 11.2558],
            ['citta' => 'Bologna', 'provincia' => 'BO', 'cap' => '40100', 'lat' => 44.4949, 'lon' => 11.3426],
            ['citta' => 'Venezia', 'provincia' => 'VE', 'cap' => '30100', 'lat' => 45.4408, 'lon' => 12.3155],
            ['citta' => 'Genova', 'provincia' => 'GE', 'cap' => '16100', 'lat' => 44.4056, 'lon' => 8.9463],
            ['citta' => 'Bari', 'provincia' => 'BA', 'cap' => '70100', 'lat' => 41.1171, 'lon' => 16.8719],
            ['citta' => 'Cagliari', 'provincia' => 'CA', 'cap' => '09100', 'lat' => 39.2238, 'lon' => 9.1217],
            ['citta' => 'Verona', 'provincia' => 'VR', 'cap' => '37100', 'lat' => 45.4384, 'lon' => 10.9916],
            ['citta' => 'Padova', 'provincia' => 'PD', 'cap' => '35100', 'lat' => 45.4064, 'lon' => 11.8768],
            ['citta' => 'Trieste', 'provincia' => 'TS', 'cap' => '34100', 'lat' => 45.6495, 'lon' => 13.7768],
            ['citta' => 'Perugia', 'provincia' => 'PG', 'cap' => '06100', 'lat' => 43.1107, 'lon' => 12.3908],
        ];

        $cityIndex = 0;
        $useCity = function () use (&$cities, &$cityIndex) {
            $city = $cities[$cityIndex % count($cities)];
            $cityIndex++;
            return $city;
        };

        // Helper per creare utente idempotente
        $createUser = function (string $role, int $i, ?array $city = null, ?int $associazioneId = null) use ($password, $now) {
            $slug = Str::slug($role);
            $email = "seed+{$slug}{$i}@catfriends.test";

            $existing = User::where('email', $email)->first();
            if ($existing) {
                return $existing;
            }

            $name = ucfirst($role) . " Demo {$i}";

            $user = new User();
            $user->name = $name;
            $user->email = $email;
            $user->password = Hash::make($password);
            $user->email_verified_at = $now;
            $user->role = $role;
            $user->locale = 'it';
            $user->paese = 'Italia';

            if ($city) {
                $user->citta = $city['citta'];
                $user->provincia = $city['provincia'];
                $user->cap = $city['cap'];
                $user->latitude = $city['lat'];
                $user->longitude = $city['lon'];
                $user->indirizzo = 'Via Demo, 1';
            }

            if ($role === 'associazione') {
                $user->ragione_sociale = "Associazione {$i} Amici dei Gatti";
                $user->association_details_completed = true;
            }

            if (in_array($role, ['veterinario', 'toelettatore'], true)) {
                $user->ragione_sociale = ucfirst($role) . " {$i}";
                $user->professional_details_completed = true;
                $user->sito_web = 'https://example.com/' . $slug . $i;
            }

            if ($role === 'volontario' && $associazioneId) {
                $user->associazione_id = $associazioneId;
            }

            $user->save();
            return $user;
        };

        // 5 associazioni in città distinte
        $associazioni = [];
        for ($i = 1; $i <= 5; $i++) {
            $associazioni[] = $createUser('associazione', $i, $useCity());
        }

        // 5 veterinari in città distinte (diverse anche dalle associazioni perché il pool si muove avanti)
        $veterinari = [];
        for ($i = 1; $i <= 5; $i++) {
            $veterinari[] = $createUser('veterinario', $i, $useCity());
        }

        // 5 toelettatori in città distinte
        $toelettatori = [];
        for ($i = 1; $i <= 5; $i++) {
            $toelettatori[] = $createUser('toelettatore', $i, $useCity());
        }

        // 5 proprietari (città qualsiasi dal pool)
        $proprietari = [];
        for ($i = 1; $i <= 5; $i++) {
            $proprietari[] = $createUser('proprietario', $i, $useCity());
        }

        // 5 volontari, assegnati a rotazione alle associazioni
        for ($i = 1; $i <= 5; $i++) {
            $assoc = $associazioni[($i - 1) % count($associazioni)];
            $createUser('volontario', $i, $useCity(), $assoc->id);
        }

        // 15 gatti per ogni associazione (idempotente: crea solo se meno di 15 esistenti marcati demo)
        foreach ($associazioni as $assocIdx => $associazione) {
            $existingDemoCats = Cat::where('associazione_id', $associazione->id)
                ->where('nome', 'like', 'DemoCat %')
                ->count();

            $toCreate = max(0, 15 - $existingDemoCats);
            for ($c = 1; $c <= $toCreate; $c++) {
                $this->createDemoCat($associazione, $assocIdx * 100 + $c);
            }
        }

        // Fix: assegna placeholder ai gatti senza foto_principale
        Cat::whereNull('foto_principale')->chunkById(200, function ($cats) {
            foreach ($cats as $cat) {
                $cat->assignPlaceholderPhoto();
                $cat->saveQuietly();
            }
        });
    }

    private function ensureCatPlaceholders(): void
    {
        $disk = Storage::disk('public');
        $base = 'cats/placeholders/';
        $svgs = [
            'cat-placeholder-1.svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400"><rect width="100%" height="100%" fill="#FFE4E6"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial" font-size="48" fill="#DB2777">🐱</text></svg>',
            'cat-placeholder-2.svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400"><rect width="100%" height="100%" fill="#E0F2FE"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial" font-size="48" fill="#0369A1">🐾</text></svg>',
            'cat-placeholder-3.svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400"><rect width="100%" height="100%" fill="#ECFCCB"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial" font-size="48" fill="#15803D">😺</text></svg>',
            'cat-placeholder-4.svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400"><rect width="100%" height="100%" fill="#FEF9C3"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial" font-size="48" fill="#A16207">🐈</text></svg>',
            'cat-placeholder-5.svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="400" height="400"><rect width="100%" height="100%" fill="#EDE9FE"/><text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" font-family="Arial" font-size="48" fill="#6D28D9">🧶</text></svg>',
        ];

        foreach ($svgs as $file => $content) {
            $path = $base . $file;
            if (!$disk->exists($path)) {
                $disk->put($path, $content);
            }
        }
    }

    private function createDemoCat(User $associazione, int $seq): void
    {
        $sex = rand(0, 1) === 1 ? 'maschio' : 'femmina';
        $etaMesi = rand(2, 120);
        $peso = rand(200, 600) / 100; // 2.00 - 6.00 kg
        $socialitaOptions = ['basso', 'medio', 'alto'];
        $socialita = $socialitaOptions[array_rand($socialitaOptions)];
        $razze = ['Europeo', 'Siamese', 'Maine Coon', 'Persiano', 'Bengala'];
        $colori = ['nero', 'bianco', 'tigrato', 'rosso', 'grigio'];

        Cat::create([
            'nome' => 'DemoCat ' . $seq,
            'razza' => $razze[array_rand($razze)],
            'eta' => $etaMesi,
            'sesso' => $sex,
            'peso' => $peso,
            'colore' => $colori[array_rand($colori)],
            'stato_sanitario' => 'In buone condizioni generali',
            'microchip' => (bool) rand(0, 1),
            'numero_microchip' => rand(0, 1) ? 'IT' . rand(100000, 999999) : null,
            'sterilizzazione' => (bool) rand(0, 1),
            'vaccinazioni' => ['trivalente'],
            'comportamento' => 'Socievole e giocherellone',
            'livello_socialita' => $socialita,
            'note_comportamentali' => null,
            'disponibile_adozione' => true,
            'data_arrivo' => now()->subDays(rand(5, 200))->toDateString(),
            'data_adozione' => null,
            'foto_principale' => null, // verrà assegnata automaticamente se mancante
            'galleria_foto' => [],
            'user_id' => $associazione->id,
            'associazione_id' => $associazione->id,
        ]);
    }
} 