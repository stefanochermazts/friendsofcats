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
        // Permetti sempre l'accesso alla pagina di login
        if ($request->is('admin/login')) {
            return $next($request);
        }

        // Verifica che l'utente sia autenticato e abbia il ruolo admin
        if (!auth()->check() || !auth()->user()->isAdmin()) {
            abort(403, 'Accesso negato. Solo gli amministratori possono accedere a questa sezione.');
        }

        return $next($request);
    }
}
