<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap.xml', now()->addDay(), function () {
            $now = now()->toAtomString();

            $baseUrls = [
                ['loc' => route('welcome'),                   'changefreq' => 'daily',  'priority' => '0.8', 'lastmod' => $now],
                ['loc' => route('contact'),                   'changefreq' => 'yearly', 'priority' => '0.3', 'lastmod' => $now],
                ['loc' => route('public.adoptions.index'),    'changefreq' => 'daily',  'priority' => '0.7', 'lastmod' => $now],
                ['loc' => route('public.adoptions.cities'),   'changefreq' => 'weekly', 'priority' => '0.5', 'lastmod' => $now],
                ['loc' => route('professionals.index'),       'changefreq' => 'daily',  'priority' => '0.6', 'lastmod' => $now],
                ['loc' => route('professionals.cities'),      'changefreq' => 'weekly', 'priority' => '0.4', 'lastmod' => $now],
            ];

            // Città adozioni (COALESCE tra proprietario e associazione)
            $adoptionCities = DB::table('cats')
                ->leftJoin('users as u', 'cats.user_id', '=', 'u.id')
                ->leftJoin('users as a', 'cats.associazione_id', '=', 'a.id')
                ->where('cats.disponibile_adozione', true)
                ->selectRaw('COALESCE(u.citta, a.citta) as citta')
                ->whereNotNull(DB::raw('COALESCE(u.citta, a.citta)'))
                ->groupByRaw('COALESCE(u.citta, a.citta)')
                ->pluck('citta')
                ->filter();

            $adoptionCityUrls = $adoptionCities->map(fn ($city) => [
                'loc' => route('public.adoptions.city', ['citySlug' => Str::slug((string) $city)]),
                'changefreq' => 'daily',
                'priority' => '0.5',
                'lastmod' => $now,
            ])->values()->all();

            // Città professionisti
            $proCities = DB::table('users')
                ->whereIn('role', ['veterinario', 'toelettatore'])
                ->whereNotNull('citta')
                ->groupBy('citta')
                ->orderBy('citta')
                ->pluck('citta')
                ->filter();

            $proCityUrls = $proCities->map(fn ($city) => [
                'loc' => route('professionals.city', ['citySlug' => Str::slug((string) $city)]),
                'changefreq' => 'weekly',
                'priority' => '0.4',
                'lastmod' => $now,
            ])->values()->all();

            // Dettagli gatti (adottabili con foto)
            $catUrls = Cat::query()
                ->where('disponibile_adozione', true)
                ->whereNotNull('foto_principale')
                ->orderByDesc('updated_at')
                ->limit(5000)
                ->get(['id', 'updated_at'])
                ->map(fn ($cat) => [
                    'loc' => route('cats.show', $cat->id),
                    'changefreq' => 'daily',
                    'priority' => '0.6',
                    'lastmod' => optional($cat->updated_at)->toAtomString() ?? $now,
                ])->all();

            // Dettagli professionisti
            $professionalUrls = User::query()
                ->whereIn('role', ['veterinario', 'toelettatore'])
                ->where('professional_details_completed', true)
                ->whereNotNull('ragione_sociale')
                ->orderByDesc('updated_at')
                ->limit(5000)
                ->get(['id', 'updated_at'])
                ->map(fn ($u) => [
                    'loc' => route('professionals.show', $u->id),
                    'changefreq' => 'weekly',
                    'priority' => '0.5',
                    'lastmod' => optional($u->updated_at)->toAtomString() ?? $now,
                ])->all();

            $urls = array_merge($baseUrls, $adoptionCityUrls, $proCityUrls, $catUrls, $professionalUrls);

            return view('sitemap.xml', compact('urls'))->render();
        });

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
} 