<x-main-layout>
    <x-slot name="meta">
        <meta name="keywords" content="{{ __('seo.professionals_keywords') }}">
    </x-slot>
    <x-slot name="header">
        <div class="text-center py-8">
            <div class="max-w-4xl mx-auto">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-100 to-green-100 dark:from-blue-900/30 dark:to-green-900/30 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                
                <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                    {{ __('professionals.directory_title') }}
                </h1>
                <p class="text-xl text-gray-600 dark:text-gray-400 max-w-3xl mx-auto">
                    {{ __('professionals.directory_subtitle') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Filtri Vicinanza -->
            <div class="mb-8 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-sm">
                <div class="p-6">
                    <form method="GET" class="space-y-6">
                        <div>
                            <h4 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3 flex items-center">
                                <svg class="w-5 h-5 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ __('adoptions.location_search') }}
                            </h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ __('adoptions.location_search_help') }}</p>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                                <!-- Città con autocomplete -->
                                <div class="md:col-span-2">
                                    <label for="citta" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Città</label>
                                    <div class="relative">
                                        <input type="text" id="citta" name="citta" value="{{ request('citta') }}" placeholder="{{ __('adoptions.city_placeholder') }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500" autocomplete="off">
                                        <div id="city-suggestions" class="hidden absolute z-20 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto"></div>
                                    </div>
                                </div>

                                <!-- Raggio -->
                                <div>
                                    <label for="raggio" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">{{ __('adoptions.radius') }}</label>
                                    <div class="space-y-2">
                                        <input type="range" id="raggio" name="raggio" min="5" max="200" step="5" value="{{ request('raggio', 50) }}" class="w-full h-2 bg-gray-200 dark:bg-gray-600 rounded-lg appearance-none cursor-pointer range-slider" oninput="document.getElementById('radius-value').textContent = this.value + ' km'" onchange="document.getElementById('radius-value').textContent = this.value + ' km'">
                                        <div class="text-center">
                                            <span id="radius-value" class="text-sm font-medium text-orange-600 dark:text-orange-400">{{ request('raggio', 50) }} km</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if(($searchLocation ?? null))
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

                        <div class="flex justify-end">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors duration-200">
                                {{ __('professionals.apply_filters') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if($professionals->count() > 0)
                <!-- Statistiche -->
                <div class="mb-8 text-center">
                    <div class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 rounded-full shadow-sm border border-gray-200 dark:border-gray-700">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            {{ __('professionals.total_professionals', ['count' => $professionals->total()]) }}
                        </span>
                    </div>
                </div>

                <!-- Griglia Professionisti -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($professionals as $professional)
                        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700">
                            <!-- Foto o Placeholder -->
                            <div class="h-96 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center overflow-hidden">
                                @if($professional->foto_principale)
                                    <img src="{{ Storage::url($professional->foto_principale) }}" 
                                         alt="{{ $professional->ragione_sociale }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="text-center">
                                        @if($professional->role === 'veterinario')
                                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                            </svg>
                                        @endif
                                        <p class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ __('professionals.' . $professional->role) }}
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <!-- Informazioni -->
                            <div class="p-6">
                                <!-- Badge Ruolo -->
                                <div class="mb-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $professional->role === 'veterinario' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' }}">
                                        {{ __('professionals.' . $professional->role) }}
                                    </span>
                                </div>

                                <!-- Nome Studio -->
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2 line-clamp-2">
                                    {{ $professional->ragione_sociale }}
                                </h3>

                                <!-- Indirizzo -->
                                <div class="flex items-start text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="line-clamp-2">
                                        {{ $professional->indirizzo }}, {{ $professional->citta }}
                                        @if($professional->provincia) ({{ $professional->provincia }}) @endif
                                    </span>
                                </div>

                                <!-- Telefono -->
                                @if($professional->telefono)
                                <div class="flex items-center text-sm text-gray-600 dark:text-gray-400 mb-3">
                                    <svg class="w-4 h-4 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span>{{ $professional->telefono }}</span>
                                </div>
                                @endif

                                <!-- Descrizione -->
                                @if($professional->descrizione)
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-3">
                                    {{ $professional->descrizione }}
                                </p>
                                @endif

                                <!-- Gallery indicator -->
                                @if($professional->galleria_foto && count($professional->galleria_foto) > 0)
                                <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-4">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ count($professional->galleria_foto) }} {{ __('professionals.photos') }}
                                </div>
                                @endif

                                <!-- Pulsante Visualizza -->
                                <a href="{{ route('professionals.show', $professional) }}" 
                                   class="w-full inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    {{ __('professionals.view_profile') }}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginazione -->
                @if($professionals->hasPages())
                <div class="mt-12">
                    {{ $professionals->links() }}
                </div>
                @endif

            @else
                <!-- Stato vuoto -->
                <div class="text-center py-16">
                    <div class="w-20 h-20 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        {{ __('professionals.no_professionals') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 max-w-md mx-auto">
                        {{ __('professionals.no_professionals_description') }}
                    </p>
                </div>
            @endif

        </div>
    </div>
</x-main-layout>

@push('scripts')
<script>
    // sincronizza valore raggio
    const radiusInput = document.getElementById('raggio');
    const radiusValue = document.getElementById('radius-value');
    if (radiusInput && radiusValue) {
        radiusInput.addEventListener('input', function() {
            radiusValue.textContent = this.value + ' km';
        });
    }

    // Autocomplete città (riuso endpoint adozioni)
    const cityInput = document.getElementById('citta');
    const suggestions = document.getElementById('city-suggestions');
    let debounceTimer;
    if (cityInput && suggestions) {
        cityInput.addEventListener('input', function() {
            const query = this.value.trim();
            clearTimeout(debounceTimer);
            if (query.length < 2) { suggestions.classList.add('hidden'); return; }
            debounceTimer = setTimeout(() => {
                fetch(`{{ route('api.cities.suggest') }}?q=${encodeURIComponent(query)}`)
                    .then(r => r.json())
                    .then(cities => {
                        if (cities.length > 0) {
                            suggestions.innerHTML = cities.map(city => `<div class=\"px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer city-suggestion\" data-city=\"${city}\">${city}</div>`).join('');
                            suggestions.classList.remove('hidden');
                        } else { suggestions.classList.add('hidden'); }
                    })
                    .catch(() => suggestions.classList.add('hidden'));
            }, 300);
        });

        suggestions.addEventListener('click', function(e) {
            const item = e.target.closest('.city-suggestion');
            if (item) {
                cityInput.value = item.getAttribute('data-city');
                suggestions.classList.add('hidden');
            }
        });
    }
</script>
@endpush
