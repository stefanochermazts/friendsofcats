<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Services\GeocodingService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class PublicAdoptionsController extends Controller
{
    protected $geocodingService;

    public function __construct(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    /**
     * Mostra la vetrina pubblica delle adozioni con card a griglia
     */
    public function index(Request $request)
    {
        try {
            $query = Cat::with(['user'])
                ->where('disponibile_adozione', true)
                ->whereNotNull('foto_principale')
                ->orderBy('created_at', 'desc');

        // Filtri opzionali
        if ($request->filled('razza')) {
            $query->where('razza', $request->razza);
        }

        if ($request->filled('eta_min')) {
            $query->where('eta', '>=', $request->eta_min);
        }

        if ($request->filled('eta_max')) {
            $query->where('eta', '<=', $request->eta_max);
        }

        if ($request->filled('sterilizzazione')) {
            $query->where('sterilizzazione', $request->sterilizzazione === 'true');
        }

        if ($request->filled('livello_socialita')) {
            $query->where('livello_socialita', $request->livello_socialita);
        }

        if ($request->filled('cerca')) {
            $searchTerm = strtolower($request->cerca);
            $query->where(function($q) use ($searchTerm) {
                $q->whereRaw('LOWER(nome) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(razza) LIKE ?', ['%' . $searchTerm . '%'])
                  ->orWhereRaw('LOWER(comportamento) LIKE ?', ['%' . $searchTerm . '%']);
            });
        }

        // Filtro geografico per vicinanza
        $searchLocation = null;
        if ($request->filled('citta') && $request->filled('raggio')) {
            $cityName = $request->citta;
            $radius = (int) $request->raggio;
            
            // Geocodifica la città di ricerca
            $coordinates = $this->geocodingService->getCoordinates($cityName);
            
            if ($coordinates) {
                $searchLocation = [
                    'city' => $cityName,
                    'lat' => $coordinates['latitude'],
                    'lng' => $coordinates['longitude'],
                    'radius' => $radius
                ];
                
                // Query con calcolo distanza usando formula Haversine
                $query->whereHas('user', function($q) use ($coordinates, $radius) {
                    $q->whereNotNull('latitude')
                      ->whereNotNull('longitude')
                      ->whereRaw(
                          "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?",
                          [$coordinates['latitude'], $coordinates['longitude'], $coordinates['latitude'], $radius]
                      );
                });
                
                // Ordina per distanza quando si usa ricerca geografica
                $query = Cat::with(['user'])
                    ->where('disponibile_adozione', true)
                    ->whereNotNull('foto_principale')
                    ->whereHas('user', function($q) use ($coordinates, $radius) {
                        $q->whereNotNull('latitude')
                          ->whereNotNull('longitude')
                          ->whereRaw(
                              "(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) <= ?",
                              [$coordinates['latitude'], $coordinates['longitude'], $coordinates['latitude'], $radius]
                          );
                    })
                    ->select('cats.*')
                    ->selectRaw(
                        "(6371 * acos(cos(radians(?)) * cos(radians(users.latitude)) * cos(radians(users.longitude) - radians(?)) + sin(radians(?)) * sin(radians(users.latitude)))) AS distance",
                        [$coordinates['latitude'], $coordinates['longitude'], $coordinates['latitude']]
                    )
                    ->join('users', 'cats.user_id', '=', 'users.id')
                    ->orderBy('distance', 'asc');
                    
                // Applica gli altri filtri al nuovo query
                if ($request->filled('razza')) {
                    $query->where('cats.razza', $request->razza);
                }
                if ($request->filled('sterilizzazione')) {
                    $query->where('cats.sterilizzazione', $request->sterilizzazione === 'true');
                }
                if ($request->filled('livello_socialita')) {
                    $query->where('cats.livello_socialita', $request->livello_socialita);
                }
                if ($request->filled('cerca')) {
                    $searchTerm = strtolower($request->cerca);
                    $query->where(function($q) use ($searchTerm) {
                        $q->whereRaw('LOWER(cats.nome) LIKE ?', ['%' . $searchTerm . '%'])
                          ->orWhereRaw('LOWER(cats.razza) LIKE ?', ['%' . $searchTerm . '%'])
                          ->orWhereRaw('LOWER(cats.comportamento) LIKE ?', ['%' . $searchTerm . '%']);
                    });
                }
            }
        }

        // Per la vista principale, carica solo i primi 12
        if ($request->ajax()) {
            $cats = $query->paginate(12);
        } else {
            $cats = $query->paginate(12);
        }
        
        // Aggiungi informazioni di distanza ai risultati se disponibili
        if ($searchLocation && $cats->count() > 0) {
            $cats->getCollection()->transform(function ($cat) use ($searchLocation) {
                if ($cat->user && $cat->user->latitude && $cat->user->longitude) {
                    $cat->distance = $this->calculateDistance(
                        $searchLocation['lat'], $searchLocation['lng'],
                        $cat->user->latitude, $cat->user->longitude
                    );
                }
                return $cat;
            });
        }

        // Statistiche per i filtri
        $stats = [
            'total' => Cat::where('disponibile_adozione', true)->count(),
            'breeds' => Cat::where('disponibile_adozione', true)
                          ->whereNotNull('razza')
                          ->distinct()
                          ->pluck('razza')
                          ->sort()
                          ->values(),
            'age_ranges' => [
                'kitten' => Cat::where('disponibile_adozione', true)->where('eta', '<=', 6)->count(),
                'young' => Cat::where('disponibile_adozione', true)->whereBetween('eta', [7, 24])->count(),
                'adult' => Cat::where('disponibile_adozione', true)->whereBetween('eta', [25, 84])->count(),
                'senior' => Cat::where('disponibile_adozione', true)->where('eta', '>', 84)->count(),
            ]
        ];

        // Per richieste AJAX, restituisci solo i dati JSON
        if ($request->ajax()) {
            $catsData = $cats->getCollection()->map(function ($cat) {
                return [
                    'id' => $cat->id,
                    'nome' => $cat->nome,
                    'razza' => $cat->razza,
                    'eta' => $cat->eta,
                    'eta_formattata' => $cat->eta_formattata,
                    'sesso' => $cat->sesso,
                    'colore' => $cat->colore,
                    'sterilizzazione' => $cat->sterilizzazione,
                    'microchip' => $cat->microchip,
                    'numero_microchip' => $cat->numero_microchip,
                    'livello_socialita' => $cat->livello_socialita,
                    'descrizione' => $cat->descrizione,
                    'foto_principale' => $cat->foto_principale,
                    'galleria_foto' => $cat->galleria_foto,
                    'likes_count' => $cat->likes_count,
                    'distance' => $cat->distance ?? null,
                    'user' => $cat->user ? [
                        'id' => $cat->user->id,
                        'name' => $cat->user->name,
                        'ragione_sociale' => $cat->user->ragione_sociale,
                    ] : null
                ];
            });

            return response()->json([
                'cats' => $catsData,
                'pagination' => [
                    'current_page' => $cats->currentPage(),
                    'has_more_pages' => $cats->hasMorePages(),
                    'last_page' => $cats->lastPage(),
                    'total' => $cats->total()
                ]
            ]);
        }

            return view('public.adoptions.index', compact('cats', 'stats', 'searchLocation'));
        } catch (\Exception $e) {
            // Log dell'errore per debug
            \Log::error('Error in PublicAdoptionsController@index: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // Per richieste AJAX, restituisci errore JSON
            if ($request->ajax()) {
                return response()->json([
                    'error' => 'Si è verificato un errore durante il caricamento dei gatti',
                    'cats' => [],
                    'pagination' => [
                        'current_page' => 1,
                        'has_more_pages' => false,
                        'last_page' => 1,
                        'total' => 0
                    ]
                ], 500);
            }
            
            // Per richieste normali, redirect con errore
            return redirect()->route('public.adoptions.index')
                ->with('error', 'Si è verificato un errore durante il caricamento dei gatti');
        }
    }

    /**
     * Mostra i dettagli di un singolo gatto per adozione
     */
    public function show($id): View
    {
        $cat = Cat::with(['user'])
            ->where('disponibile_adozione', true)
            ->findOrFail($id);

        // Gatti simili (stessa razza o età simile)
        $similarCats = Cat::with(['user'])
            ->where('disponibile_adozione', true)
            ->where('id', '!=', $cat->id)
            ->where(function($query) use ($cat) {
                $query->where('razza', $cat->razza)
                      ->orWhereBetween('eta', [$cat->eta - 6, $cat->eta + 6]);
            })
            ->limit(4)
            ->get();

        return view('public.adoptions.show', compact('cat', 'similarCats'));
    }

    /**
     * Restituisce gatti featured per la homepage
     */
    public function featured(): \Illuminate\Http\JsonResponse
    {
        $featuredCats = Cat::with(['user'])
            ->where('disponibile_adozione', true)
            ->whereNotNull('foto_principale')
            ->inRandomOrder()
            ->limit(6)
            ->get()
            ->map(function ($cat) {
                // Aggiungi l'età formattata
                $cat->eta_formattata_display = $cat->eta_formattata;
                return $cat;
            });

        return response()->json($featuredCats);
    }

    /**
     * Calcola la distanza tra due punti geografici usando la formula di Haversine
     */
    private function calculateDistance($lat1, $lng1, $lat2, $lng2): float
    {
        $earthRadius = 6371; // Raggio della Terra in km

        $latFrom = deg2rad($lat1);
        $lngFrom = deg2rad($lng1);
        $latTo = deg2rad($lat2);
        $lngTo = deg2rad($lng2);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lngDelta / 2) * sin($lngDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return round($earthRadius * $c, 1);
    }

    /**
     * API per suggerimenti di città (autocomplete)
     */
    public function suggestCities(Request $request)
    {
        $query = $request->get('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Cerca città dalle associazioni esistenti
        $cities = DB::table('users')
            ->where('role', 'associazione')
            ->whereNotNull('citta')
            ->where('citta', 'like', '%' . $query . '%')
            ->distinct()
            ->pluck('citta')
            ->filter()
            ->values()
            ->take(10);

        return response()->json($cities);
    }

    /**
     * Toggle like/unlike per un gatto
     */
    public function toggleLike(Cat $cat, Request $request)
    {
        try {
            // Identifica il client con IP + User Agent per prevenire spam
            $clientId = md5($request->ip() . $request->userAgent());
            $cacheKey = "cat_like_{$cat->id}_{$clientId}";
            
            // Check se già ha messo like (usando cache per 24h)
            $hasLiked = cache()->has($cacheKey);
            
            if ($hasLiked) {
                // Remove like
                $cat->decrement('likes_count');
                cache()->forget($cacheKey);
                
                return response()->json([
                    'liked' => false,
                    'likes_count' => max(0, $cat->fresh()->likes_count)
                ]);
            } else {
                // Add like
                $cat->increment('likes_count');
                $cat->update(['last_liked_at' => now()]);
                
                // Cache per 24 ore
                cache()->put($cacheKey, true, now()->addDay());
                
                return response()->json([
                    'liked' => true,
                    'likes_count' => $cat->fresh()->likes_count
                ]);
            }
            
        } catch (\Exception $e) {
            return response()->json(['error' => 'Something went wrong'], 500);
        }
    }
}