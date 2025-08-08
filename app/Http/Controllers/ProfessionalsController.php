<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;

class ProfessionalsController extends Controller
{
    /**
     * Display the professionals directory page.
     */
    public function index(): View
    {
        $professionals = User::whereIn('role', ['veterinario', 'toelettatore'])
            ->where('professional_details_completed', true)
            ->whereNotNull('ragione_sociale')
            ->orderBy('ragione_sociale')
            ->paginate(12);

        return view('professionals.index', compact('professionals'));
    }

    /**
     * Display a specific professional's profile.
     */
    public function show(User $professional): View
    {
        // Verify that this is actually a professional
        if (!in_array($professional->role, ['veterinario', 'toelettatore']) || 
            !$professional->professional_details_completed) {
            abort(404);
        }

        // Get all photos for the gallery
        $allPhotos = [];
        if ($professional->foto_principale) {
            $allPhotos[] = $professional->foto_principale;
        }
        if ($professional->galleria_foto && is_array($professional->galleria_foto)) {
            $allPhotos = array_merge($allPhotos, $professional->galleria_foto);
        }

        return view('professionals.show', compact('professional', 'allPhotos'));
    }
}