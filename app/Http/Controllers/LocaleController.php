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
        $supportedLocales = ['it', 'en', 'de', 'fr', 'es'];
        
        if (in_array($locale, $supportedLocales)) {
            Session::put('locale', $locale);
        }
        
        return redirect()->back();
    }
} 