<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div>
                    <!-- Titolo con badge mobile -->
                    <div class="flex items-center space-x-3 sm:space-x-0">
                        <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ __('adoptions.page_title') }}
                        </h1>
                        <!-- Badge visibile solo su mobile -->
                        <span class="sm:hidden inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400">
                            {{ $stats['total'] }} {{ __('adoptions.stats_total') }}
                        </span>
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ __('adoptions.subtitle') }}
                    </p>
                </div>
            </div>
            
            <!-- Badge desktop/tablet in alto a destra -->
            <div class="hidden sm:flex">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-base font-semibold bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400 shadow-sm">
                    {{ $stats['total'] }} {{ __('adoptions.stats_total') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Statistiche per Età -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 sm:gap-3 mb-4">
                <div class="bg-white dark:bg-gray-800 rounded-lg p-2 sm:p-3 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="text-sm sm:text-base font-bold text-green-600 dark:text-green-400">{{ $stats['age_ranges']['kitten'] }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('adoptions.stats_kittens') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-2 sm:p-3 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="text-sm sm:text-base font-bold text-yellow-600 dark:text-yellow-400">{{ $stats['age_ranges']['young'] }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('adoptions.stats_young') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-2 sm:p-3 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="text-sm sm:text-base font-bold text-blue-600 dark:text-blue-400">{{ $stats['age_ranges']['adult'] }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('adoptions.stats_adults') }}</div>
                </div>
                <div class="bg-white dark:bg-gray-800 rounded-lg p-2 sm:p-3 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                    <div class="text-sm sm:text-base font-bold text-purple-600 dark:text-purple-400">{{ $stats['age_ranges']['senior'] }}</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">{{ __('adoptions.stats_seniors') }}</div>
                </div>
            </div>

            <!-- Filtri Collassabili -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 mb-4">
                <!-- Header Filtri -->
                <div class="p-3 sm:p-4 border-b border-gray-100 dark:border-gray-700">
                    <button id="filters-toggle" class="w-full flex items-center justify-between text-left">
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                            <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('adoptions.filters') }}</h3>
                            @if(request()->hasAny(['cerca', 'razza', 'eta_range', 'sterilizzazione', 'livello_socialita', 'citta', 'raggio']))
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-400">
                                    Attivi
                                </span>
                            @endif
                        </div>
                        <svg id="filters-chevron" class="w-5 h-5 text-gray-500 transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>
                </div>
                
                <!-- Contenuto Filtri -->
                <div id="filters-content" class="hidden p-3 sm:p-4">
                
                <form id="filter-form" method="GET" class="space-y-6">
                    <!-- Sezione Ricerca Geografica -->
                    <div class="border-b border-gray-200 dark:border-gray-600 pb-4">
                        <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                            <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            {{ __('adoptions.location_search') }}
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('adoptions.location_search_help') }}</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            <!-- Campo città con autocomplete -->
                            <div class="md:col-span-2">
                                <label for="citta" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Città
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="citta"
                                           name="citta" 
                                           value="{{ request('citta') }}"
                                           placeholder="{{ __('adoptions.city_placeholder') }}"
                                           class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                                           autocomplete="off">
                                    
                                    <!-- Dropdown suggerimenti -->
                                    <div id="city-suggestions" 
                                         class="hidden absolute z-20 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Slider raggio -->
                            <div>
                                <label for="raggio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('adoptions.radius') }}
                                </label>
                                <div class="space-y-2">
                                    <input type="range" 
                                           id="raggio" 
                                           name="raggio" 
                                           min="5" 
                                           max="200" 
                                           step="5"
                                           value="{{ request('raggio', 50) }}"
                                           class="w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-lg appearance-none cursor-pointer range-slider">
                                    <div class="text-center">
                                        <span id="radius-value" class="text-sm font-medium text-orange-600 dark:text-orange-400">
                                            {{ request('raggio', 50) }} km
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Informazioni ricerca attiva -->
                        @if($searchLocation ?? null)
                            <div class="mt-4 p-3 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-700 rounded-lg">
                                <div class="flex items-center text-sm text-orange-800 dark:text-orange-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ __('adoptions.distance_from', ['city' => $searchLocation['city']]) }} - {{ $searchLocation['radius'] }} km
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Filtri Standard -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                        <!-- Ricerca -->
                        <div>
                            <input type="text" 
                                   name="cerca" 
                                   value="{{ request('cerca') }}"
                                   placeholder="{{ __('adoptions.search_placeholder') }}"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                        </div>

                        <!-- Razza -->
                        <div>
                            <select name="razza" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                <option value="">{{ __('adoptions.all_breeds') }}</option>
                                @foreach($stats['breeds'] as $breed)
                                    <option value="{{ $breed }}" {{ request('razza') == $breed ? 'selected' : '' }}>
                                        {{ $breed }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Età -->
                        <div>
                            <select name="eta_range" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                <option value="">{{ __('adoptions.any_age') }}</option>
                                <option value="kitten">{{ __('adoptions.kitten') }}</option>
                                <option value="young">{{ __('adoptions.young') }}</option>
                                <option value="adult">{{ __('adoptions.adult') }}</option>
                                <option value="senior">{{ __('adoptions.senior') }}</option>
                            </select>
                        </div>

                        <!-- Sterilizzazione -->
                        <div>
                            <select name="sterilizzazione" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                <option value="">{{ __('adoptions.any_sterilization') }}</option>
                                <option value="true" {{ request('sterilizzazione') == 'true' ? 'selected' : '' }}>{{ __('adoptions.sterilized_yes') }}</option>
                                <option value="false" {{ request('sterilizzazione') == 'false' ? 'selected' : '' }}>{{ __('adoptions.sterilized_no') }}</option>
                            </select>
                        </div>

                        <!-- Personalità -->
                        <div>
                            <select name="livello_socialita" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                <option value="">{{ __('adoptions.any_personality') }}</option>
                                <option value="basso" {{ request('livello_socialita') == 'basso' ? 'selected' : '' }}>{{ __('adoptions.personality_low') }}</option>
                                <option value="medio" {{ request('livello_socialita') == 'medio' ? 'selected' : '' }}>{{ __('adoptions.personality_medium') }}</option>
                                <option value="alto" {{ request('livello_socialita') == 'alto' ? 'selected' : '' }}>{{ __('adoptions.personality_high') }}</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-lg font-medium transition-colors">
                            {{ __('adoptions.filters') }}
                        </button>
                        <a href="{{ route('public.adoptions.index') }}" class="bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 px-6 py-2 rounded-lg font-medium transition-colors">
                            {{ __('adoptions.clear_filters') }}
                        </a>
                    </div>
                </form>
                </div>
            </div>

            <!-- Griglia Gatti -->
            @if($cats->count() > 0)
                <div id="cats-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    @foreach($cats as $cat)
                        <div class="group">
                            <!-- Card Gatto secondo le specifiche: sfondo bianco, bordo sottile nero, foto 70% -->
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-900 dark:border-gray-600 overflow-hidden transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                                
                                <!-- Foto principale (70% della card) -->
                                <div class="aspect-[4/3] bg-gray-200 dark:bg-gray-600 overflow-hidden relative">
                                    <img src="{{ Storage::url($cat->foto_principale) }}" 
                                         alt="{{ $cat->nome }}"
                                         class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="hidden w-full h-full items-center justify-center text-6xl">🐱</div>
                                    
                                    <!-- Counters -->
                                    <div class="absolute top-2 left-2 right-2 flex justify-between">
                                        <!-- Photo count -->
                                        @php
                                            $photoCount = 1 + (($cat->galleria_foto && is_array($cat->galleria_foto)) ? count($cat->galleria_foto) : 0);
                                        @endphp
                                        <div class="bg-black/50 text-white px-2 py-1 rounded-full text-xs font-medium flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $photoCount }}
                                        </div>
                                        
                                        <!-- Like count -->
                                        <div class="bg-black/50 text-white px-2 py-1 rounded-full text-xs font-medium flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                            <span class="like-count-overlay" data-cat-id="{{ $cat->id }}">{{ $cat->likes_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informazioni gatto (30% della card) -->
                                <div class="p-4 space-y-3">
                                    <!-- Nome del gatto -->
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                                        {{ $cat->nome }}
                                    </h3>

                                    <!-- Età e Razza -->
                                    <div class="space-y-1">
                                        <p class="text-sm text-gray-600 dark:text-gray-400">
                                            <span class="font-medium">{{ $cat->eta_formattata }}</span>
                                        </p>
                                        @if($cat->razza)
                                            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $cat->razza }}</p>
                                        @endif
                                        
                                        <!-- Distanza se ricerca geografica attiva -->
                                        @if(isset($cat->distance))
                                            <p class="text-sm text-orange-600 dark:text-orange-400 font-medium flex items-center">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                </svg>
                                                {{ __('adoptions.km_away', ['distance' => $cat->distance]) }}
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Badge caratteristiche -->
                                    <div class="flex flex-wrap gap-1">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                            {{ __('adoptions.adoptable') }}
                                        </span>
                                        
                                        @if($cat->sterilizzazione)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                                                {{ __('adoptions.sterilized') }}
                                            </span>
                                        @endif
                                        
                                        @if($cat->microchip)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-300">
                                                {{ __('adoptions.microchip') }}
                                            </span>
                                        @endif
                                    </div>

                                    <!-- Call-to-action (sempre visibile) -->
                                    <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                                        <div class="flex space-x-2">
                                            <!-- Scopri di più (3/4 larghezza) -->
                                            <a href="{{ route('cats.show', $cat->id) }}" 
                                               class="flex-1 text-center bg-orange-500 hover:bg-orange-600 text-white py-2 px-3 rounded-lg font-medium transition-colors text-sm">
                                                {{ __('adoptions.discover_more') }}
                                            </a>
                                            
                                            <!-- Like button (1/4 larghezza) -->
                                            <button class="like-button-card flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 hover:border-orange-400 dark:hover:border-orange-400 transition-all duration-200 bg-white dark:bg-gray-700"
                                                    data-cat-id="{{ $cat->id }}"
                                                    title="{{ __('adoptions.add_to_favorites') }}">
                                                <svg class="like-icon w-4 h-4 text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Infinite Scroll Loading Indicator -->
                @if($cats->hasMorePages())
                    <div id="infinite-scroll-loading" class="hidden flex justify-center items-center py-8">
                        <div class="flex items-center space-x-3 text-gray-600 dark:text-gray-400">
                            <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-sm">{{ __('adoptions.loading_more') }}</span>
                        </div>
                    </div>
                    <!-- Invisible trigger for infinite scroll -->
                    <div id="infinite-scroll-trigger" data-current-page="{{ $cats->currentPage() }}" data-has-more="true"></div>
                @endif
            @else
                <!-- Stato vuoto -->
                <div class="text-center py-16">
                    <div class="text-8xl mb-6">🐱</div>
                    <h3 class="text-xl font-medium text-gray-900 dark:text-gray-100 mb-2">
                        {{ __('adoptions.no_cats_found') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-6">
                        {{ __('adoptions.no_cats_message') }}
                    </p>
                    <a href="{{ route('public.adoptions.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors">
                        {{ __('adoptions.clear_filters') }}
                    </a>
                </div>
            @endif
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle Filtri
        const filtersToggle = document.getElementById('filters-toggle');
        const filtersContent = document.getElementById('filters-content');
        const filtersChevron = document.getElementById('filters-chevron');
        
        if (filtersToggle && filtersContent && filtersChevron) {
            // Apri i filtri automaticamente se ci sono filtri attivi
            const hasActiveFilters = {{ request()->hasAny(['cerca', 'razza', 'eta_range', 'sterilizzazione', 'livello_socialita', 'citta', 'raggio']) ? 'true' : 'false' }};
            
            if (hasActiveFilters) {
                filtersContent.classList.remove('hidden');
                filtersChevron.style.transform = 'rotate(180deg)';
            }
            
            filtersToggle.addEventListener('click', function() {
                const isHidden = filtersContent.classList.contains('hidden');
                
                if (isHidden) {
                    filtersContent.classList.remove('hidden');
                    filtersChevron.style.transform = 'rotate(180deg)';
                } else {
                    filtersContent.classList.add('hidden');
                    filtersChevron.style.transform = 'rotate(0deg)';
                }
            });
        }
        // Range slider aggiornamento valore
        const radiusSlider = document.getElementById('raggio');
        const radiusValue = document.getElementById('radius-value');
        
        if (radiusSlider && radiusValue) {
            // Sincronizza il valore iniziale
            radiusValue.textContent = radiusSlider.value + ' km';
            
            // Aggiorna quando l'utente muove lo slider
            radiusSlider.addEventListener('input', function() {
                radiusValue.textContent = this.value + ' km';
            });
        }
        
        // Autocomplete città
        const cityInput = document.getElementById('citta');
        const suggestions = document.getElementById('city-suggestions');
        let debounceTimer;
        
        if (cityInput && suggestions) {
            cityInput.addEventListener('input', function() {
                const query = this.value.trim();
                
                clearTimeout(debounceTimer);
                
                if (query.length < 2) {
                    suggestions.classList.add('hidden');
                    return;
                }
                
                debounceTimer = setTimeout(() => {
                    fetch(`{{ route('api.cities.suggest') }}?q=${encodeURIComponent(query)}`)
                        .then(response => response.json())
                        .then(cities => {
                            if (cities.length > 0) {
                                suggestions.innerHTML = cities.map(city => 
                                    `<div class="px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer city-suggestion" data-city="${city}">
                                        ${city}
                                    </div>`
                                ).join('');
                                suggestions.classList.remove('hidden');
                            } else {
                                suggestions.classList.add('hidden');
                            }
                        })
                        .catch(() => {
                            suggestions.classList.add('hidden');
                        });
                }, 300);
            });
            
            // Click su suggerimento
            suggestions.addEventListener('click', function(e) {
                if (e.target.classList.contains('city-suggestion')) {
                    const city = e.target.getAttribute('data-city');
                    cityInput.value = city;
                    suggestions.classList.add('hidden');
                }
            });
            
            // Nascondi suggerimenti quando si clicca fuori
            document.addEventListener('click', function(e) {
                if (!cityInput.contains(e.target) && !suggestions.contains(e.target)) {
                    suggestions.classList.add('hidden');
                }
            });
            
            // Gestione tasti freccia e enter
            cityInput.addEventListener('keydown', function(e) {
                const items = suggestions.querySelectorAll('.city-suggestion');
                let selected = suggestions.querySelector('.bg-orange-100');
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (selected) {
                        selected.classList.remove('bg-orange-100');
                        const next = selected.nextElementSibling || items[0];
                        next.classList.add('bg-orange-100');
                    } else if (items.length > 0) {
                        items[0].classList.add('bg-orange-100');
                    }
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    if (selected) {
                        selected.classList.remove('bg-orange-100');
                        const prev = selected.previousElementSibling || items[items.length - 1];
                        prev.classList.add('bg-orange-100');
                    }
                } else if (e.key === 'Enter') {
                    e.preventDefault();
                    if (selected) {
                        const city = selected.getAttribute('data-city');
                        cityInput.value = city;
                        suggestions.classList.add('hidden');
                    }
                } else if (e.key === 'Escape') {
                    suggestions.classList.add('hidden');
                }
            });
        }
        
        // Geolocalizzazione (opzionale)
        if (navigator.geolocation) {
            const addGeolocationButton = () => {
                const container = cityInput?.parentElement;
                if (container && !container.querySelector('.geolocation-btn')) {
                    const btn = document.createElement('button');
                    btn.type = 'button';
                    btn.className = 'geolocation-btn absolute right-2 top-1/2 transform -translate-y-1/2 text-orange-500 hover:text-orange-600 p-1';
                    btn.innerHTML = `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    `;
                    btn.title = '{{ __('adoptions.current_location') }}';
                    
                    btn.addEventListener('click', function() {
                        this.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>';
                        
                        navigator.geolocation.getCurrentPosition(
                            (position) => {
                                // Reverse geocoding per ottenere la città
                                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${position.coords.latitude}&lon=${position.coords.longitude}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        const city = data.address?.city || data.address?.town || data.address?.village || '';
                                        if (city) {
                                            cityInput.value = city;
                                        }
                                        btn.innerHTML = `
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        `;
                                    })
                                    .catch(() => {
                                        btn.innerHTML = `
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                        `;
                                    });
                            },
                            () => {
                                btn.innerHTML = `
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                `;
                            }
                        );
                    });
                    
                    container.appendChild(btn);
                }
            };
            
            addGeolocationButton();
        }
        
        // Like functionality per le card della griglia
        console.log('🔍 Initializing like system...');
        const likeButtons = document.querySelectorAll('.like-button-card');
        console.log('Found like buttons:', likeButtons.length);
        
        likeButtons.forEach(button => {
            const catId = button.getAttribute('data-cat-id');
            const likeIcon = button.querySelector('.like-icon');
            
            console.log('Setting up like button for cat ID:', catId);
            
            // Check localStorage per stato iniziale
            const isLiked = localStorage.getItem(`cat_liked_${catId}`) === 'true';
            updateLikeButtonStyle(button, isLiked);
            
            button.addEventListener('click', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                console.log('❤️ Like button clicked for cat ID:', catId);
                
                // Prevent multiple clicks
                this.disabled = true;
                
                try {
                    console.log('🌐 Making API request to:', `/api/cats/${catId}/like`);
                    
                    const response = await fetch(`/api/cats/${catId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin'
                    });
                    
                    console.log('📡 API Response status:', response.status);
                    
                    if (response.ok) {
                        const data = await response.json();
                        
                        // Update UI and localStorage
                        updateLikeButtonStyle(button, data.liked);
                        localStorage.setItem(`cat_liked_${catId}`, data.liked.toString());
                        
                        // Update counter in overlay se presente
                        const likeCounters = document.querySelectorAll(`.like-count-overlay[data-cat-id="${catId}"]`);
                        likeCounters.forEach(counter => {
                            counter.textContent = data.likes_count;
                        });
                        
                    } else {
                        console.error('Failed to toggle like');
                        // Fallback locale
                        const currentlyLiked = localStorage.getItem(`cat_liked_${catId}`) === 'true';
                        const newState = !currentlyLiked;
                        updateLikeButtonStyle(button, newState);
                        localStorage.setItem(`cat_liked_${catId}`, newState.toString());
                    }
                } catch (error) {
                    console.error('Error toggling like:', error);
                    // Fallback locale
                    const currentlyLiked = localStorage.getItem(`cat_liked_${catId}`) === 'true';
                    const newState = !currentlyLiked;
                    updateLikeButtonStyle(button, newState);
                    localStorage.setItem(`cat_liked_${catId}`, newState.toString());
                } finally {
                    this.disabled = false;
                }
            });
        });
        
        function updateLikeButtonStyle(button, isLiked) {
            const icon = button.querySelector('.like-icon');
            
            if (isLiked) {
                // Liked state: filled heart, orange color
                icon.style.fill = '#f59e0b';
                icon.style.color = '#f59e0b';
                button.classList.add('border-orange-400', 'bg-orange-50');
                button.classList.remove('border-gray-300', 'bg-white');
                if (document.documentElement.classList.contains('dark')) {
                    button.classList.add('dark:border-orange-400', 'dark:bg-orange-900/20');
                    button.classList.remove('dark:border-gray-600', 'dark:bg-gray-700');
                }
            } else {
                // Not liked state: outline heart, gray color
                icon.style.fill = 'none';
                icon.style.color = '#9ca3af';
                button.classList.remove('border-orange-400', 'bg-orange-50');
                button.classList.add('border-gray-300', 'bg-white');
                if (document.documentElement.classList.contains('dark')) {
                    button.classList.remove('dark:border-orange-400', 'dark:bg-orange-900/20');
                    button.classList.add('dark:border-gray-600', 'dark:bg-gray-700');
                }
            }
        }

        // Infinite Scroll functionality
        const infiniteScrollTrigger = document.getElementById('infinite-scroll-trigger');
        const infiniteScrollLoading = document.getElementById('infinite-scroll-loading');
        const catsGrid = document.getElementById('cats-grid');
        let isLoading = false;
        
        if (infiniteScrollTrigger) {
            // Create Intersection Observer for infinite scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !isLoading) {
                        loadMoreCats();
                    }
                });
            }, {
                rootMargin: '100px' // Trigger 100px before the element comes into view
            });
            
            observer.observe(infiniteScrollTrigger);
            
            function loadMoreCats() {
                if (isLoading) return;
                
                isLoading = true;
                const currentPage = parseInt(infiniteScrollTrigger.dataset.currentPage);
                const nextPage = currentPage + 1;
                
                // Show loading indicator
                infiniteScrollLoading.classList.remove('hidden');
                
                // Prepara i parametri della richiesta corrente per mantenerli nel load more
                const form = document.getElementById('filter-form');
                const formData = new FormData(form);
                const searchParams = new URLSearchParams();
                
                // Aggiungi tutti i parametri del form
                for (let [key, value] of formData.entries()) {
                    if (value) searchParams.append(key, value);
                }
                
                // Aggiungi il numero di pagina
                searchParams.append('page', nextPage);
                
                // Effettua la richiesta AJAX
                fetch(`{{ route('public.adoptions.index') }}?${searchParams.toString()}`, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Aggiungi i nuovi gatti alla griglia
                    data.cats.forEach(cat => {
                        const catCard = createCatCard(cat);
                        catsGrid.appendChild(catCard);
                    });
                    
                    // Aggiorna il trigger
                    infiniteScrollTrigger.dataset.currentPage = data.pagination.current_page;
                    
                    if (!data.pagination.has_more_pages) {
                        // Non ci sono più pagine, rimuovi il trigger e nascondi loading
                        observer.unobserve(infiniteScrollTrigger);
                        infiniteScrollTrigger.remove();
                        infiniteScrollLoading.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 text-sm py-4">{{ __("adoptions.all_cats_loaded") }}</div>';
                    }
                    
                    // Reinitializza i like buttons per i nuovi gatti
                    initializeLikeButtons();
                })
                .catch(error => {
                    console.error('Errore nel caricamento:', error);
                    infiniteScrollLoading.innerHTML = '<div class="text-center text-red-500 text-sm py-4">Errore nel caricamento</div>';
                })
                .finally(() => {
                    isLoading = false;
                    infiniteScrollLoading.classList.add('hidden');
                });
            }
        }

        // Funzione per creare una card gatto da dati JSON
        function createCatCard(cat) {
            const photoCount = 1 + (cat.galleria_foto ? cat.galleria_foto.length : 0);
            const distance = cat.distance ? `
                <p class="text-sm text-orange-600 dark:text-orange-400 font-medium flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    ${cat.distance} km di distanza
                </p>
            ` : '';
            
            const sterilizzato = cat.sterilizzazione ? `
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                    ✅ Sterilizzato
                </span>
            ` : '';
            
            const microchip = cat.microchip ? `
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800 dark:bg-purple-900/20 dark:text-purple-300">
                    🔘 Microchip
                </span>
            ` : '';
            
            const div = document.createElement('div');
            div.className = 'group';
            div.innerHTML = `
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-900 dark:border-gray-600 overflow-hidden transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                    <div class="aspect-[4/3] bg-gray-200 dark:bg-gray-600 overflow-hidden relative">
                        <img src="${cat.foto_principale ? '/storage/' + cat.foto_principale : ''}" 
                             alt="${cat.nome}"
                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="hidden w-full h-full items-center justify-center text-6xl">🐱</div>
                        
                        <div class="absolute top-2 left-2 right-2 flex justify-between">
                            <div class="bg-black/50 text-white px-2 py-1 rounded-full text-xs font-medium flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                ${photoCount}
                            </div>
                            
                            <div class="bg-black/50 text-white px-2 py-1 rounded-full text-xs font-medium flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span class="like-count-overlay" data-cat-id="${cat.id}">${cat.likes_count || 0}</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 space-y-3">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                            ${cat.nome}
                        </h3>

                        <div class="space-y-1">
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                <span class="font-medium">${cat.eta_formattata}</span>
                            </p>
                            ${cat.razza ? `<p class="text-sm text-gray-600 dark:text-gray-400">${cat.razza}</p>` : ''}
                            ${distance}
                        </div>

                        <div class="flex flex-wrap gap-1">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                🏠 Adottabile
                            </span>
                            ${sterilizzato}
                            ${microchip}
                        </div>

                        <div class="pt-3 border-t border-gray-100 dark:border-gray-700">
                            <div class="flex space-x-2">
                                <a href="/cats/${cat.id}" 
                                   class="flex-1 text-center bg-orange-500 hover:bg-orange-600 text-white py-2 px-3 rounded-lg font-medium transition-colors text-sm">
                                    Scopri di più
                                </a>
                                
                                <button class="like-button-card flex-shrink-0 w-10 h-10 flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600 hover:border-orange-400 dark:hover:border-orange-400 transition-all duration-200 bg-white dark:bg-gray-700"
                                        data-cat-id="${cat.id}"
                                        title="Metti like">
                                    <svg class="like-icon w-4 h-4 text-gray-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            
            return div;
        }

        // Funzione per reinizializzare i like buttons
        function initializeLikeButtons() {
            document.querySelectorAll('.like-button-card').forEach(button => {
                // Rimuovi event listeners esistenti per evitare duplicati
                button.replaceWith(button.cloneNode(true));
            });
            
            // Aggiungi nuovi event listeners
            document.querySelectorAll('.like-button-card').forEach(button => {
                button.addEventListener('click', function() {
                    const catId = this.dataset.catId;
                    // Implementazione del like (usa la stessa logica esistente)
                    toggleLike(catId, this);
                });
            });
        }
    });
    </script>
</x-main-layout>
