<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            Log::warning('AdminMiddleware: unauthenticated access', [
                'path' => $request->path(),
                'ip' => $request->ip(),
                'user_id' => null,
            ]);
            return redirect()->to('/admin/login');
        }
        // Superadmin fallback via ENV (lista email separata da virgola) - case-insensitive
        $superAdmins = array_map('strtolower', array_filter(array_map('trim', explode(',', (string) env('FILAMENT_SUPERADMIN_EMAILS', '')))));
        $user = auth()->user();
        $email = strtolower((string) $user->email);
        if ($user->isAdmin() || in_array($email, $superAdmins, true)) {
            return $next($request);
        }

        Log::warning('AdminMiddleware: forbidden (not admin)', [
            'path' => $request->path(),
            'ip' => $request->ip(),
            'user_id' => $user->id,
            'user_email' => $user->email,
            'user_role' => $user->role,
            'super_admins' => $superAdmins,
        ]);
        abort(403, 'Accesso negato. Solo gli amministratori possono accedere a questa sezione.');

        return $next($request);
    }
}
