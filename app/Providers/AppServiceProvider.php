<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Cat;
use App\Policies\CatPolicy;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Registra la CatPolicy
        Gate::policy(Cat::class, CatPolicy::class);

        // Macro globale per intercettare tutte le traduzioni che restituiscono array
        \Illuminate\Translation\Translator::macro('get', function ($key, $replace = [], $locale = null, $fallback = true) {
            $translation = $this->getFromJson($key, $replace, $locale);
            if (is_array($translation)) {
                \Log::error('[TRADUZIONE ARRAY]', [
                    'key' => $key,
                    'locale' => $locale ?? app()->getLocale(),
                    'result' => $translation,
                    'trace' => (new \Exception())->getTraceAsString(),
                ]);
            }
            return $translation;
        });
    }
}
