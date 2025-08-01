<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class AuthLocale
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
        // Forza sempre il locale italiano per le route di autenticazione
        $locale = 'it';
        
        // Imposta la lingua per l'applicazione
        App::setLocale($locale);
        Session::put('locale', $locale);
        
        // Debug: log del locale per verificare che funzioni
        \Log::info('AuthLocale middleware: Forcing locale to ' . $locale . ' for URL: ' . $request->url());
        
        return $next($request);
    }
} 