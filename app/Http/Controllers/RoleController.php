<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Show the role selection page.
     */
    public function show(): View|RedirectResponse
    {
        // Se l'utente ha già un ruolo valido, reindirizza alla dashboard
        $user = Auth::user();
        $validRoles = ['associazione', 'volontario', 'proprietario', 'veterinario', 'toelettatore', 'admin'];
        
        if ($user->role && in_array($user->role, $validRoles)) {
            return redirect()->route('dashboard');
        }

        return view('auth.role-selection');
    }

    /**
     * Store the selected role.
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'role' => ['required', 'string', 'in:associazione,volontario,proprietario,veterinario,toelettatore'],
            ]);

            $user = Auth::user();
            $user->update([
                'role' => $request->role,
            ]);

            return redirect()->route('dashboard')
                ->with('success', __('dashboard.role_saved_success'));
        } catch (\Exception $e) {
            Log::error('Errore nel salvataggio del ruolo: ' . $e->getMessage());
            return back()->withErrors(['role' => __('dashboard.role_save_error')]);
        }
    }
} 