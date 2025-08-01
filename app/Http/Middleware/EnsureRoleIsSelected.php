<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRoleIsSelected
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
            $validRoles = ['associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore', 'admin'];
            
            // Se l'utente non ha un ruolo o ha un ruolo non valido (tranne admin)
            if (!$user->role || (!in_array($user->role, $validRoles) && $user->role !== 'admin')) {
                return redirect()->route('role.show');
            }
        }

        return $next($request);
    }
} 