<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\GeocodingService;

class ProfessionalDetailsController extends Controller
{
    protected $geocodingService;

    public function __construct(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    /**
     * Get maximum upload size in KB for validation
     */
    private function getMaxUploadSizeKB(): int
    {
        $size = ini_get('upload_max_filesize');
        $unit = strtolower(substr(trim($size), -1));
        $value = (float) $size;
        
        switch ($unit) {
            case 'g':
                $value *= 1024 * 1024;
                break;
            case 'm':
                $value *= 1024;
                break;
            // 'k' is already KB
        }
        
        return max(1024, (int) round($value)); // Min 1MB
    }

    /**
     * Mostra il form per i dettagli professionali
     */
    public function show(): View|RedirectResponse
    {
        $user = Auth::user();
        
        // Verifica che l'utente sia un veterinario o toelettatore
        if (!in_array($user->role, ['veterinario', 'toelettatore'])) {
            return redirect()->route('dashboard')
                ->with('error', 'Accesso non autorizzato.');
        }

        // Se ha già completato i dettagli, reindirizza al dashboard
        if ($user->professional_details_completed) {
            return redirect()->route('dashboard')
                ->with('info', 'Hai già completato i tuoi dettagli professionali.');
        }

        return view('auth.professional-details');
    }

    /**
     * Salva i dettagli professionali
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            
            // Verifica che l'utente sia un veterinario o toelettatore
            if (!in_array($user->role, ['veterinario', 'toelettatore'])) {
                return redirect()->route('dashboard')
                    ->with('error', 'Accesso non autorizzato.');
            }

            $maxFileSizeKB = $this->getMaxUploadSizeKB();
            
            $request->validate([
                'ragione_sociale' => ['required', 'string', 'max:255'],
                'indirizzo' => ['required', 'string', 'max:255'],
                'citta' => ['required', 'string', 'max:255'],
                'cap' => ['required', 'string', 'max:10'],
                'provincia' => ['required', 'string', 'max:3'],
                'paese' => ['nullable', 'string', 'max:255'],
                'telefono' => ['nullable', 'string', 'max:20'],
                'descrizione' => ['nullable', 'string', 'max:1000'],
                'sito_web' => ['nullable', 'url', 'max:255'],
                'foto_principale' => ['nullable', 'image', 'max:' . $maxFileSizeKB, 'mimes:jpeg,png,webp'],
                'galleria_foto.*' => ['nullable', 'image', 'max:' . $maxFileSizeKB, 'mimes:jpeg,png,webp'],
            ]);

            // Prova a geocodificare l'indirizzo
            $coordinates = null;
            
            try {
                $coordinates = $this->geocodingService->geocodeAddress(
                    $request->indirizzo,
                    $request->citta,
                    $request->provincia,
                    $request->paese ?? 'Italia'
                );
            } catch (\Exception $e) {
                Log::warning('Geocoding fallito per professionista: ' . $e->getMessage());
            }

            $updateData = [
                'ragione_sociale' => $request->ragione_sociale,
                'indirizzo' => $request->indirizzo,
                'citta' => $request->citta,
                'cap' => $request->cap,
                'provincia' => $request->provincia,
                'paese' => $request->paese ?? 'Italia',
                'telefono' => $request->telefono,
                'descrizione' => $request->descrizione,
                'sito_web' => $request->sito_web,
                'professional_details_completed' => true,
                'latitude' => $coordinates['latitude'] ?? null,
                'longitude' => $coordinates['longitude'] ?? null,
            ];

            // Gestione upload foto principale
            if ($request->hasFile('foto_principale')) {
                $updateData['foto_principale'] = $request->file('foto_principale')->store('professionals/main', 'public');
            }

            // Gestione upload galleria foto
            if ($request->hasFile('galleria_foto')) {
                $galleria_foto = [];
                foreach ($request->file('galleria_foto') as $foto) {
                    $galleria_foto[] = $foto->store('professionals/gallery', 'public');
                }
                $updateData['galleria_foto'] = $galleria_foto;
            }

            $user->update($updateData);

            return redirect()->route('dashboard')
                ->with('success', 'Dettagli professionali salvati con successo!');

        } catch (\Exception $e) {
            Log::error('Errore nel salvataggio dei dettagli professionali: ' . $e->getMessage());
            return back()->withInput()->withErrors(['general' => 'Errore nel salvataggio. Riprova.']);
        }
    }

    /**
     * Mostra il form di modifica dei dettagli professionali
     */
    public function edit(): View
    {
        $user = Auth::user();
        return view('auth.professional-details-edit', compact('user'));
    }

    /**
     * Aggiorna i dettagli professionali
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $user = Auth::user();

            $maxFileSizeKB = $this->getMaxUploadSizeKB();

            $request->validate([
                'ragione_sociale' => ['required', 'string', 'max:255'],
                'indirizzo' => ['required', 'string', 'max:255'],
                'citta' => ['required', 'string', 'max:255'],
                'cap' => ['required', 'string', 'max:10'],
                'provincia' => ['required', 'string', 'max:3'],
                'paese' => ['nullable', 'string', 'max:255'],
                'telefono' => ['nullable', 'string', 'max:20'],
                'descrizione' => ['nullable', 'string', 'max:1000'],
                'sito_web' => ['nullable', 'url', 'max:255'],
                'foto_principale' => ['nullable', 'image', 'max:' . $maxFileSizeKB, 'mimes:jpeg,png,webp'],
                'galleria_foto.*' => ['nullable', 'image', 'max:' . $maxFileSizeKB, 'mimes:jpeg,png,webp'],
            ]);

            // Prova a geocodificare l'indirizzo se è cambiato
            $coordinates = null;
            $addressChanged = $user->indirizzo !== $request->indirizzo || 
                            $user->citta !== $request->citta || 
                            $user->provincia !== $request->provincia;
            
            if ($addressChanged) {
                try {
                    $coordinates = $this->geocodingService->geocodeAddress(
                        $request->indirizzo,
                        $request->citta,
                        $request->provincia,
                        $request->paese ?? 'Italia'
                    );
                } catch (\Exception $e) {
                    Log::warning('Geocoding fallito per aggiornamento professionista: ' . $e->getMessage());
                }
            }

            $updateData = [
                'ragione_sociale' => $request->ragione_sociale,
                'indirizzo' => $request->indirizzo,
                'citta' => $request->citta,
                'cap' => $request->cap,
                'provincia' => $request->provincia,
                'paese' => $request->paese ?? 'Italia',
                'telefono' => $request->telefono,
                'descrizione' => $request->descrizione,
                'sito_web' => $request->sito_web,
            ];

            // Gestione upload foto principale
            if ($request->hasFile('foto_principale')) {
                // Elimina la vecchia foto se esiste
                if ($user->foto_principale && \Storage::disk('public')->exists($user->foto_principale)) {
                    \Storage::disk('public')->delete($user->foto_principale);
                }
                $updateData['foto_principale'] = $request->file('foto_principale')->store('professionals/main', 'public');
            }

            // Gestione upload galleria foto - AGGIUNGE alle foto esistenti
            if ($request->hasFile('galleria_foto')) {
                $existingGallery = $user->galleria_foto ?? [];
                $newGallery = [];
                
                foreach ($request->file('galleria_foto') as $foto) {
                    $newGallery[] = $foto->store('professionals/gallery', 'public');
                }
                
                $updateData['galleria_foto'] = array_merge($existingGallery, $newGallery);
            }

            // Aggiungi coordinate solo se geocoding è riuscito
            if ($coordinates) {
                $updateData['latitude'] = $coordinates['latitude'];
                $updateData['longitude'] = $coordinates['longitude'];
            }

            $user->update($updateData);

            return redirect()->route('dashboard')
                ->with('success', 'Dettagli professionali aggiornati con successo!');

        } catch (\Exception $e) {
            Log::error('Errore nell\'aggiornamento dei dettagli professionali: ' . $e->getMessage());
            return back()->withInput()->withErrors(['general' => 'Errore nell\'aggiornamento. Riprova.']);
        }
    }
}