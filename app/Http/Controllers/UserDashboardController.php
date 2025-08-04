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
        
        $stats = [
            'total_cats' => Cat::where('user_id', $userId)->count(),
            'available_cats' => Cat::where('user_id', $userId)->where('disponibile_adozione', true)->count(),
            'adopted_cats' => Cat::where('user_id', $userId)->where('disponibile_adozione', false)->count(),
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