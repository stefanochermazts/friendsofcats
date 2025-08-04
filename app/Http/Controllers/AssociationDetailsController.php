<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\GeocodingService;

class AssociationDetailsController extends Controller
{
    private GeocodingService $geocodingService;

    public function __construct(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    /**
     * Show the association details form.
     */
    public function show(): View|RedirectResponse
    {
        $user = Auth::user();
        
        // Se l'utente non è un'associazione, reindirizza alla dashboard
        if ($user->role !== 'associazione') {
            return redirect()->route('dashboard');
        }
        
        // Se l'associazione ha già completato i dettagli, reindirizza alla dashboard
        if ($user->association_details_completed) {
            return redirect()->route('dashboard');
        }

        return view('auth.association-details');
    }

    /**
     * Store the association details.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'ragione_sociale' => ['required', 'string', 'max:255'],
                'indirizzo' => ['required', 'string', 'max:255'],
                'citta' => ['required', 'string', 'max:255'],
                'cap' => ['required', 'string', 'max:10'],
                'provincia' => ['required', 'string', 'max:3'],
                'paese' => ['required', 'string', 'max:255'],
                'telefono' => ['nullable', 'string', 'max:20'],
                'descrizione' => ['nullable', 'string', 'max:1000'],
                'sito_web' => ['nullable', 'url', 'max:255'],
            ]);

            $user = Auth::user();
            
            // Prepara i dati per l'aggiornamento
            $updateData = [
                'ragione_sociale' => $request->ragione_sociale,
                'indirizzo' => $request->indirizzo,
                'citta' => $request->citta,
                'cap' => $request->cap,
                'provincia' => strtoupper($request->provincia),
                'paese' => $request->paese,
                'telefono' => $request->telefono,
                'descrizione' => $request->descrizione,
                'sito_web' => $request->sito_web,
                'association_details_completed' => true,
            ];

            // Tenta la geocodifica dell'indirizzo
            $geocodingResult = $this->geocodingService->geocodeAddress(
                $request->indirizzo,
                $request->citta,
                $request->provincia,
                $request->paese
            );

            if ($geocodingResult) {
                $updateData['latitude'] = $geocodingResult['latitude'];
                $updateData['longitude'] = $geocodingResult['longitude'];
                
                Log::info('Geocodifica riuscita per associazione', [
                    'user_id' => $user->id,
                    'address' => $request->indirizzo,
                    'coordinates' => [
                        'lat' => $geocodingResult['latitude'],
                        'lng' => $geocodingResult['longitude']
                    ],
                    'confidence' => $geocodingResult['confidence'],
                    'formatted_address' => $geocodingResult['formatted_address'],
                ]);
            } else {
                Log::warning('Geocodifica fallita per associazione', [
                    'user_id' => $user->id,
                    'address' => $request->indirizzo,
                    'city' => $request->citta,
                    'province' => $request->provincia,
                ]);
            }

            // Aggiorna i dettagli dell'associazione
            $user->update($updateData);

            $successMessage = __('association.details_saved_success');
            
            // Aggiungi informazione sulla geocodifica se riuscita
            if ($geocodingResult) {
                $successMessage .= ' ' . __('association.geocoding_success');
            }

            return redirect()->route('dashboard')
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            Log::error('Errore nel salvataggio dei dettagli associazione: ' . $e->getMessage());
            return back()->withErrors(['general' => __('association.details_save_error')]);
        }
    }

    /**
     * Show the association edit form.
     */
    public function edit(): View|RedirectResponse
    {
        $user = Auth::user();
        
        // Se l'utente non è un'associazione, reindirizza alla dashboard
        if ($user->role !== 'associazione') {
            return redirect()->route('dashboard');
        }
        
        // Se l'associazione non ha completato i dettagli, reindirizza al form iniziale
        if (!$user->association_details_completed) {
            return redirect()->route('association.details');
        }

        return view('auth.association-edit', compact('user'));
    }

    /**
     * Update the association details.
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'ragione_sociale' => ['required', 'string', 'max:255'],
                'indirizzo' => ['required', 'string', 'max:255'],
                'citta' => ['required', 'string', 'max:255'],
                'cap' => ['required', 'string', 'max:10'],
                'provincia' => ['required', 'string', 'max:3'],
                'paese' => ['required', 'string', 'max:255'],
                'telefono' => ['nullable', 'string', 'max:20'],
                'descrizione' => ['nullable', 'string', 'max:1000'],
                'sito_web' => ['nullable', 'url', 'max:255'],
            ]);

            $user = Auth::user();
            
            // Prepara i dati per l'aggiornamento
            $updateData = [
                'ragione_sociale' => $request->ragione_sociale,
                'indirizzo' => $request->indirizzo,
                'citta' => $request->citta,
                'cap' => $request->cap,
                'provincia' => strtoupper($request->provincia),
                'paese' => $request->paese,
                'telefono' => $request->telefono,
                'descrizione' => $request->descrizione,
                'sito_web' => $request->sito_web,
            ];

            // Tenta la geocodifica dell'indirizzo solo se è cambiato
            $addressChanged = $user->indirizzo !== $request->indirizzo || 
                            $user->citta !== $request->citta || 
                            $user->provincia !== $request->provincia;

            if ($addressChanged) {
                $geocodingResult = $this->geocodingService->geocodeAddress(
                    $request->indirizzo,
                    $request->citta,
                    $request->provincia,
                    $request->paese
                );

                if ($geocodingResult) {
                    $updateData['latitude'] = $geocodingResult['latitude'];
                    $updateData['longitude'] = $geocodingResult['longitude'];
                    
                    Log::info('Geocodifica aggiornata per associazione', [
                        'user_id' => $user->id,
                        'address' => $request->indirizzo,
                        'coordinates' => [
                            'lat' => $geocodingResult['latitude'],
                            'lng' => $geocodingResult['longitude']
                        ],
                        'confidence' => $geocodingResult['confidence'],
                        'formatted_address' => $geocodingResult['formatted_address'],
                    ]);
                } else {
                    Log::warning('Geocodifica fallita per aggiornamento associazione', [
                        'user_id' => $user->id,
                        'address' => $request->indirizzo,
                        'city' => $request->citta,
                        'province' => $request->provincia,
                    ]);
                }
            }

            // Aggiorna i dettagli dell'associazione
            $user->update($updateData);

            $successMessage = __('association.details_updated_success');
            
            // Aggiungi informazione sulla geocodifica se riuscita
            if ($addressChanged && isset($geocodingResult) && $geocodingResult) {
                $successMessage .= ' ' . __('association.geocoding_success');
            }

            return redirect()->route('dashboard')
                ->with('success', $successMessage);
        } catch (\Exception $e) {
            Log::error('Errore nell\'aggiornamento dei dettagli associazione: ' . $e->getMessage());
            return back()->withErrors(['general' => __('association.details_update_error')]);
        }
    }
}
