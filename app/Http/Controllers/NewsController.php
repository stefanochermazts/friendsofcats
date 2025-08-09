<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $locale = app()->getLocale();

        $news = News::query()
            ->with('translations')
            ->published()
            ->recent()
            ->get()
            ->filter(function (News $n) use ($locale) {
                // Mostra se è tradotta nella lingua corrente o se l'originale è in questa lingua
                return $n->hasTranslation($locale) || $n->locale === $locale;
            })
            ->map(function (News $n) use ($locale) {
                // Usa traduzione se presente, altrimenti l'originale
                $t = $n->translation($locale);
                if ($t) {
                    $n->setRawAttributes(array_merge($n->getAttributes(), [
                        'title' => is_array($t->title) ? implode(' ', $t->title) : $t->title,
                        'excerpt' => is_array($t->excerpt) ? implode(' ', $t->excerpt) : $t->excerpt,
                        'body' => is_array($t->body) ? implode(' ', $t->body) : $t->body,
                        'meta_title' => is_array($t->meta_title) ? implode(' ', $t->meta_title) : $t->meta_title,
                        'meta_description' => is_array($t->meta_description) ? implode(' ', $t->meta_description) : $t->meta_description,
                        'slug' => $t->slug,
                    ]));
                }
                return $n;
            })
            ->values();

        // Pagina manuale (semplice) per la lista costruita in memoria
        $perPage = 12;
        $page = max(1, (int) request('page', 1));
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $news->forPage($page, $perPage)->values(),
            $news->count(),
            $perPage,
            $page,
            ['path' => route('news.index')]
        );
        return view('news.index', ['news' => $paginated]);
    }

    public function show(string $slug): View|RedirectResponse
    {
        $locale = app()->getLocale();

        // Cerca prima una traduzione con questo slug
        $translation = \App\Models\NewsTranslation::query()->where('slug', $slug)->first();
        if ($translation) {
            $news = $translation->news()->with('translations')->first();
            // Forza vista nella lingua della traduzione
            $item = (clone $news);
            $item->setRawAttributes(array_merge($news->getAttributes(), [
                'title' => $this->toString($translation->title),
                'excerpt' => $this->toString($translation->excerpt),
                'body' => $this->toString($translation->body),
                'meta_title' => $this->toString($translation->meta_title),
                'meta_description' => $this->toString($translation->meta_description),
                'slug' => $this->toString($translation->slug),
            ]));
            $this->sanitizeItem($item);
            return view('news.show', compact('item'));
        }

        // Fallback: slug originale sulla tabella principale
        $news = News::query()->published()->where('slug', $slug)->first();
        if (!$news) {
            return redirect()->route('news.index');
        }
        $this->sanitizeItem($news);
        return view('news.show', ['item' => $news]);
    }

    private function toString($value): string
    {
        if (is_null($value)) {
            return '';
        }
        if (is_array($value)) {
            return trim(collect($value)->flatten()->join(' '));
        }
        return (string) $value;
    }

    private function sanitizeItem($item): void
    {
        foreach (['title','excerpt','body','meta_title','meta_description','slug'] as $field) {
            $item->setAttribute($field, $this->toString($item->getAttribute($field)));
        }
    }
}


