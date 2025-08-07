<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;

class UserDashboardController extends Controller
{
    /**
     * Mostra il dashboard dell'utente con statistiche sui gatti
     */
    public function index()
    {
        $userId = auth()->id();
        
        $user = auth()->user();
        
        // Per i proprietari, i gatti "adottati" sono quelli che erano in adozione e ora hanno data_adozione
        // Per associazioni/rifugi, i gatti "adottati" sono quelli dati in adozione ad altri
        if ($user->role === 'proprietario') {
            $adoptedCats = Cat::where('user_id', $userId)
                            ->whereNotNull('data_adozione')
                            ->count();
        } else {
            // Per associazioni: gatti che erano disponibili e ora sono adottati
            $adoptedCats = Cat::where('user_id', $userId)
                            ->where('disponibile_adozione', false)
                            ->whereNotNull('data_adozione')
                            ->count();
        }
        
        $stats = [
            'total_cats' => Cat::where('user_id', $userId)->count(),
            'available_cats' => Cat::where('user_id', $userId)->where('disponibile_adozione', true)->count(),
            'adopted_cats' => $adoptedCats,
            'recent_cats' => Cat::where('user_id', $userId)->latest()->take(3)->get(),
        ];
        
        return view('dashboard', compact('stats'));
    }

    /**
     * Mostra la pagina di gestione gatti
     */
    public function cats()
    {
        // Verifica che l'utente possa accedere alla gestione gatti
        if (auth()->user()->role === 'admin') {
            return redirect()->route('filament.admin.pages.dashboard')
                ->with('warning', 'Gli amministratori accedono ai gatti dall\'area admin.');
        }

        return view('user.cats');
    }
}