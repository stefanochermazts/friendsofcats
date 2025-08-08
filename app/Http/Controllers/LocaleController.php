<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LocaleController extends Controller
{
    /**
     * Cambia la lingua dell'applicazione
     */
    public function changeLocale(Request $request, $locale)
    {
        $supportedLocales = ['it', 'en', 'de', 'fr', 'es', 'sl'];
        
        if (in_array($locale, $supportedLocales)) {
            Session::put('locale', $locale);
        }
        
        // Se l'utente è sul CatBook e cambia lingua, rimuovi il filtro "all_languages"
        // per mostrare automaticamente i post nella nuova lingua
        $referer = $request->header('referer');
        if ($referer && str_contains($referer, '/catbook')) {
            $url = parse_url($referer);
            if (isset($url['query'])) {
                parse_str($url['query'], $params);
                unset($params['all_languages']); // Rimuovi il parametro all_languages
                
                $newQuery = http_build_query($params);
                $redirectUrl = $url['path'] . ($newQuery ? '?' . $newQuery : '');
                
                return redirect($redirectUrl);
            }
        }
        
        return redirect()->back();
    }
} 