<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class VolunteerAssociationController extends Controller
{
    /**
     * Mostra la pagina di configurazione associazione per volontari
     */
    public function setup(): View|RedirectResponse
    {
        $user = Auth::user();
        
        // Verifica che l'utente sia un volontario
        if ($user->role !== 'volontario') {
            return redirect()->route('dashboard')
                ->with('error', 'Accesso non autorizzato.');
        }

        // Se ha già configurato l'associazione, reindirizza al dashboard
        if ($user->associazione_id !== null) {
            return redirect()->route('dashboard')
                ->with('info', 'Hai già configurato la tua associazione.');
        }

        // Ottieni tutte le associazioni disponibili
        $associazioni = User::where('role', 'associazione')
                           ->where('association_details_completed', true)
                           ->orderBy('ragione_sociale')
                           ->get();

        return view('auth.volunteer-association-setup', compact('associazioni'));
    }

    /**
     * Salva la configurazione dell'associazione per il volontario
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            
            // Verifica che l'utente sia un volontario
            if ($user->role !== 'volontario') {
                return redirect()->route('dashboard')
                    ->with('error', 'Accesso non autorizzato.');
            }

            $request->validate([
                'associazione_id' => ['nullable', 'exists:users,id'],
            ]);

            // Se è stata selezionata un'associazione, verifica che esista e sia valida
            if ($request->associazione_id) {
                $associazione = User::where('id', $request->associazione_id)
                                  ->where('role', 'associazione')
                                  ->where('association_details_completed', true)
                                  ->first();
                
                if (!$associazione) {
                    return back()->withErrors(['associazione_id' => 'Associazione non valida.']);
                }
            }

            $user->update([
                'associazione_id' => $request->associazione_id,
            ]);

            $message = $request->associazione_id 
                ? 'Associazione collegata con successo!'
                : 'Configurazione completata come volontario indipendente!';

            return redirect()->route('dashboard')
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Errore nel salvataggio dell\'associazione volontario: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Errore nel salvataggio. Riprova.']);
        }
    }

    /**
     * Mostra la pagina di modifica associazione per volontari
     */
    public function edit(): View
    {
        $user = Auth::user();
        
        // Ottieni tutte le associazioni disponibili
        $associazioni = User::where('role', 'associazione')
                           ->where('association_details_completed', true)
                           ->orderBy('ragione_sociale')
                           ->get();

        return view('auth.volunteer-association-edit', compact('associazioni', 'user'));
    }

    /**
     * Aggiorna l'associazione del volontario
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $user = Auth::user();
            
            $request->validate([
                'associazione_id' => ['nullable', 'exists:users,id'],
            ]);

            // Se è stata selezionata un'associazione, verifica che esista e sia valida
            if ($request->associazione_id) {
                $associazione = User::where('id', $request->associazione_id)
                                  ->where('role', 'associazione')
                                  ->where('association_details_completed', true)
                                  ->first();
                
                if (!$associazione) {
                    return back()->withErrors(['associazione_id' => 'Associazione non valida.']);
                }
            }

            $user->update([
                'associazione_id' => $request->associazione_id,
            ]);

            $message = $request->associazione_id 
                ? 'Associazione aggiornata con successo!'
                : 'Ora sei un volontario indipendente!';

            return redirect()->route('dashboard')
                ->with('success', $message);

        } catch (\Exception $e) {
            Log::error('Errore nell\'aggiornamento dell\'associazione volontario: ' . $e->getMessage());
            return back()->withErrors(['general' => 'Errore nell\'aggiornamento. Riprova.']);
        }
    }
}