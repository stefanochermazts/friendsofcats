<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Forza sempre il locale italiano come default
        $locale = 'it';
        
        // Controlla se c'è un parametro locale nella URL
        if ($request->has('locale') && in_array($request->get('locale'), ['it', 'en', 'de', 'fr', 'es', 'sl'])) {
            $locale = $request->get('locale');
        }
        // Altrimenti controlla se c'è una lingua salvata in sessione
        elseif ($request->hasSession() && $request->session()->has('locale') && in_array($request->session()->get('locale'), ['it', 'en', 'de', 'fr', 'es', 'sl'])) {
            $locale = $request->session()->get('locale');
        }
        
        // Imposta la lingua per l'applicazione
        App::setLocale($locale);
        if ($request->hasSession()) {
            $request->session()->put('locale', $locale);
        }
        
        // Debug: log del locale per verificare che funzioni
        \Log::info('SetLocale middleware: Setting locale to ' . $locale . ' for URL: ' . $request->url());
        
        return $next($request);
    }
} 