<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CatProfileController extends Controller
{
    /**
     * Mostra la scheda dettaglio di un gatto
     */
    public function show($id): View
    {
        // Trova il gatto con i dati dell'associazione
        $cat = Cat::with(['user'])
            ->findOrFail($id);

        // Gatti simili (stessa razza o età simile, max 4)
        $similarCats = Cat::with(['user'])
            ->where('disponibile_adozione', true)
            ->where('id', '!=', $cat->id)
            ->where(function($query) use ($cat) {
                $query->where('razza', $cat->razza)
                      ->orWhereBetween('eta', [$cat->eta - 6, $cat->eta + 6]);
            })
            ->limit(4)
            ->get();

        // Post recenti del gatto (se esistono)
        $recentPosts = Post::with(['user', 'comments.user', 'likes'])
            ->where('cat_id', $cat->id)
            ->active()
            ->recent()
            ->limit(6)
            ->get();

        // Statistiche del gatto
        $daysSinceArrival = $cat->created_at ? floor($cat->created_at->diffInDays(now())) : 0;
        $hoursSinceArrival = $cat->created_at ? floor($cat->created_at->diffInHours(now()) % 24) : 0;
        
        // Formattazione tempo trascorso dall'arrivo
        $arrivalFormatted = '';
        if ($daysSinceArrival > 0) {
            $dayLabel = $daysSinceArrival == 1 ? 'giorno' : 'giorni';
            $arrivalFormatted = $daysSinceArrival . ' ' . $dayLabel;
            
            if ($hoursSinceArrival > 0) {
                $hourLabel = $hoursSinceArrival == 1 ? 'ora' : 'ore';
                $arrivalFormatted .= ' e ' . $hoursSinceArrival . ' ' . $hourLabel;
            }
        } else {
            $hourLabel = $hoursSinceArrival == 1 ? 'ora' : 'ore';
            $arrivalFormatted = $hoursSinceArrival . ' ' . $hourLabel;
        }
        
        $stats = [
            'total_likes' => $cat->likes_count ?? 0,
            'total_posts' => Post::where('cat_id', $cat->id)->active()->count(),
            'days_since_arrival' => $daysSinceArrival,
            'hours_since_arrival' => $hoursSinceArrival,
            'arrival_formatted' => $arrivalFormatted,
        ];

        // Informazioni sui follow (solo per utenti autenticati)
        $isFollowing = false;
        $followersCount = $cat->getFollowersCount();
        $userCanFollow = false;
        
        if (Auth::check()) {
            $user = Auth::user();
            $isFollowing = $user->isFollowingCat($cat);
            $userCanFollow = true;
        }

        // Calcola il numero totale di foto per la galleria
        $totalPhotos = 0;
        if ($cat->galleria_foto && is_array($cat->galleria_foto)) {
            $totalPhotos = count($cat->galleria_foto);
            if ($cat->foto_principale) {
                $totalPhotos++; // Include la foto principale
            }
        } elseif ($cat->foto_principale) {
            $totalPhotos = 1;
        }

        return view('cats.show', compact(
            'cat', 
            'similarCats', 
            'recentPosts', 
            'stats', 
            'totalPhotos',
            'isFollowing',
            'followersCount',
            'userCanFollow'
        ));
    }
}
