<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Taxonomy;
use Illuminate\Contracts\View\View;

class TaxonomyController extends Controller
{
    public function show(string $slug): View
    {
        $taxonomy = Taxonomy::query()->where('slug', $slug)->firstOrFail();
        // Override name/description with localized strings if available
        $taxonomy->name = trans('taxonomy.' . $slug . '.label');
        $taxonomy->description = trans('taxonomy.' . $slug . '.description');

        $locale = app()->getLocale();
        $news = $taxonomy->news()
            ->with('translations')
            ->published()
            ->recent()
            ->get()
            ->filter(fn($n) => $n->hasTranslation($locale) || $n->locale === $locale)
            ->map(function ($n) use ($locale) {
                $t = $n->translation($locale);
                if ($t) {
                    $n->title = $t->title;
                    $n->excerpt = $t->excerpt;
                    $n->slug = $t->slug;
                }
                return $n;
            });

        return view('news.taxonomy', compact('taxonomy', 'news'));
    }
}


