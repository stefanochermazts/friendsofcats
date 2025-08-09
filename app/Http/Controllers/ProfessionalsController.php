<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\GeocodingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfessionalsController extends Controller
{
    public function __construct(private GeocodingService $geocodingService)
    {
    }
    /**
     * Display the professionals directory page.
     */
    public function index(Request $request): View
    {
        $query = User::query()
            ->whereIn('role', ['veterinario', 'toelettatore'])
            ->where('professional_details_completed', true)
            ->whereNotNull('ragione_sociale');

        $searchLocation = null;

        if ($request->filled('citta') && $request->filled('raggio')) {
            $cityName = $request->string('citta')->toString();
            $radius = (int) $request->get('raggio', 50);

            $coordinates = $this->geocodingService->getCoordinates($cityName);

            if ($coordinates) {
                $searchLocation = [
                    'city' => $cityName,
                    'lat' => $coordinates['latitude'],
                    'lng' => $coordinates['longitude'],
                    'radius' => $radius,
                ];

                $query = User::query()
                    ->whereIn('role', ['veterinario', 'toelettatore'])
                    ->where('professional_details_completed', true)
                    ->whereNotNull('ragione_sociale')
                    ->whereNotNull('latitude')
                    ->whereNotNull('longitude')
                    ->select('users.*')
                    ->selectRaw(
                        "(6371 * acos(cos(radians(?)) * cos(radians(users.latitude)) * cos(radians(users.longitude) - radians(?)) + sin(radians(?)) * sin(radians(users.latitude)))) AS distance",
                        [$coordinates['latitude'], $coordinates['longitude'], $coordinates['latitude']]
                    )
                    ->whereRaw(
                        "(6371 * acos(cos(radians(?)) * cos(radians(users.latitude)) * cos(radians(users.longitude) - radians(?)) + sin(radians(?)) * sin(radians(users.latitude)))) <= ?",
                        [$coordinates['latitude'], $coordinates['longitude'], $coordinates['latitude'], $radius]
                    )
                    ->orderBy('distance', 'asc');
            } else {
                // Se la geocodifica fallisce, fallback ad ordine alfabetico
                $query->orderBy('ragione_sociale');
            }
        } else {
            $query->orderBy('ragione_sociale');
        }

        $professionals = $query->paginate(12)->appends($request->query());

        return view('professionals.index', compact('professionals', 'searchLocation'));
    }

    /**
     * SEO: Lista professionisti filtrati per città via slug
     */
    public function byCity(string $citySlug, Request $request): \Illuminate\Http\RedirectResponse
    {
        $normalizedSlug = strtolower(urldecode($citySlug));
        $city = \DB::table('users')
            ->whereIn('role', ['veterinario', 'toelettatore'])
            ->whereNotNull('citta')
            ->select('citta')
            ->distinct()
            ->get()
            ->map(fn($r) => (string) $r->citta)
            ->first(function ($name) use ($normalizedSlug) {
                $slug = strtolower(str_replace([' '], ['-'], $name));
                return $slug === $normalizedSlug;
            });

        if (!$city) {
            abort(404);
        }

        $params = array_merge($request->query(), [
            'citta' => $city,
            'raggio' => $request->get('raggio', 50),
        ]);
        return redirect()->route('professionals.index', $params);
    }

    /**
     * Elenco di tutte le città per professionisti con conteggi
     */
    public function cities(): View
    {
        $professionalCityCounts = \DB::table('users')
            ->whereIn('role', ['veterinario', 'toelettatore'])
            ->whereNotNull('citta')
            ->groupBy('citta')
            ->orderBy('citta')
            ->selectRaw('citta, COUNT(id) as total')
            ->pluck('total', 'citta');

        return view('professionals.cities', [
            'professionalCityCounts' => $professionalCityCounts,
        ]);
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