<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Cat;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SitemapController extends Controller
{
        public function index(): Response
    {
            // Bump chiave cache per forzare rigenerazione dopo fix https
            $xml = Cache::remember('sitemap.v3.xml', now()->addDay(), function () {
            $now = now()->toAtomString();
            $locales = ['it', 'en', 'de', 'fr', 'es', 'sl'];

                // Forza root URL e schema in base a APP_URL, così gli URL risultano sempre correttamente https
                $appUrl = (string) config('app.url');
                if ($appUrl !== '') {
                    URL::forceRootUrl($appUrl);
                    if (Str::startsWith($appUrl, 'https://')) {
                        URL::forceScheme('https');
                    }
                }

            $baseUrls = [
                ['loc' => route('welcome'),                   'changefreq' => 'daily',  'priority' => '0.8', 'lastmod' => $now],
                ['loc' => route('contact'),                   'changefreq' => 'yearly', 'priority' => '0.3', 'lastmod' => $now],
                ['loc' => route('public.adoptions.index'),    'changefreq' => 'daily',  'priority' => '0.7', 'lastmod' => $now],
                ['loc' => route('public.adoptions.cities'),   'changefreq' => 'weekly', 'priority' => '0.5', 'lastmod' => $now],
                ['loc' => route('professionals.index'),       'changefreq' => 'daily',  'priority' => '0.6', 'lastmod' => $now],
                ['loc' => route('professionals.cities'),      'changefreq' => 'weekly', 'priority' => '0.4', 'lastmod' => $now],
                ['loc' => route('news.index'),                'changefreq' => 'daily',  'priority' => '0.6', 'lastmod' => $now],
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

            // News pubblicate (aggiungi fino a 1000), includi slugs tradotti
            $news = \App\Models\News::query()
                ->with('translations')
                ->published()
                ->orderByDesc('published_at')
                ->limit(1000)
                ->get();

            $newsUrls = [];
            foreach ($news as $n) {
                $localesAvailable = $n->translations->pluck('locale')->unique()->values()->all();
                if (empty($localesAvailable)) {
                    $localesAvailable = [$n->locale];
                } else {
                    // Aggiungi sempre la lingua originale all'elenco disponibile
                    if (!in_array($n->locale, $localesAvailable, true)) {
                        $localesAvailable[] = $n->locale;
                    }
                }

                // URL lingua originale
                $newsUrls[] = [
                    'loc' => route('news.show', $n->slug),
                    'changefreq' => 'weekly',
                    'priority' => '0.5',
                    'lastmod' => optional($n->updated_at ?? $n->published_at)->toAtomString() ?? $now,
                    'locales' => $localesAvailable,
                ];

                // URL per ciascuna traduzione
                foreach ($n->translations as $t) {
                    $newsUrls[] = [
                        'loc' => route('news.show', $t->slug),
                        'changefreq' => 'weekly',
                        'priority' => '0.5',
                        'lastmod' => optional($n->updated_at ?? $n->published_at)->toAtomString() ?? $now,
                        'locales' => $localesAvailable,
                    ];
                }
            }

            $urls = array_merge($baseUrls, $adoptionCityUrls, $proCityUrls, $catUrls, $professionalUrls, $newsUrls);

            // Aggiungi hreflang alternates limitati alle lingue disponibili per ciascun URL
            $urls = array_map(function (array $u) use ($locales) {
                $loc = $u['loc'];
                $alternates = [];
                $availableLocales = $u['locales'] ?? $locales; // se specificato, usa solo quelle disponibili

                foreach ($availableLocales as $locale) {
                    if ($locale === 'it') {
                        $alternates[] = [
                            'hreflang' => 'it',
                            'href' => $loc,
                        ];
                    } else {
                        $alternates[] = [
                            'hreflang' => $locale,
                            'href' => self::buildUrlWithLocale($loc, $locale),
                        ];
                    }
                }

                // x-default punta alla versione di default (italiano senza query param)
                $alternates[] = [
                    'hreflang' => 'x-default',
                    'href' => $loc,
                ];

                $u['alternates'] = $alternates;
                return $u;
            }, $urls);

            return view('sitemap.xml', compact('urls'))->render();
        });

            return response($xml, 200)
                ->header('Content-Type', 'application/xml; charset=UTF-8')
                ->header('Cache-Control', 'public, max-age=3600');
    }

    /**
     * Costruisce un URL aggiungendo/sostituendo il parametro di query "locale".
     */
    private static function buildUrlWithLocale(string $url, string $locale): string
    {
        $parts = parse_url($url) ?: [];

        $scheme = $parts['scheme'] ?? '';
        $host = $parts['host'] ?? '';
        $port = isset($parts['port']) ? (':' . $parts['port']) : '';
        $path = $parts['path'] ?? '';
        $fragment = isset($parts['fragment']) ? ('#' . $parts['fragment']) : '';

        $params = [];
        if (isset($parts['query']) && $parts['query'] !== '') {
            parse_str($parts['query'], $params);
        }
        $params['locale'] = $locale;
        $queryString = http_build_query($params);

        $authority = $host !== '' ? ($host . $port) : '';
        $base = $scheme !== '' ? ($scheme . '://' . $authority) : $authority;

        return rtrim($base, '/') . $path . ($queryString ? ('?' . $queryString) : '') . $fragment;
    }
} 