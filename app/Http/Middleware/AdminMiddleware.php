<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Permetti sempre l'accesso alle pagine di auth Filament
        if ($request->is('admin/login') || $request->is('admin/logout') || $request->is('admin/password*')) {
            return $next($request);
        }

        // Verifica autenticazione, reindirizza al login
        if (!auth()->check()) {
            return redirect()->to('/admin/login');
        }
        // Verifica che l'utente abbia il ruolo admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Accesso negato. Solo gli amministratori possono accedere a questa sezione.');
        }

        return $next($request);
    }
}
