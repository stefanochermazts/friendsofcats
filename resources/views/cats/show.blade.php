<x-main-layout>
    {{-- Open Graph Meta Tags --}}
    <x-slot name="meta">
        <meta property="og:title" content="{{ e($cat->nome) }} - {{ e(__('cats.profile_subtitle')) }} | FriendsOfCats" />
        <meta property="og:description" content="{{ e(__('cats.meet_cat', ['name' => $cat->nome, 'age' => $cat->eta, 'breed' => $cat->razza ?: __('cats.mixed_breed')])) }}" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{ route('cats.show', $cat->id) }}" />
        @if($cat->foto_principale)
            <meta property="og:image" content="{{ Storage::url($cat->foto_principale) }}" />
            <meta property="og:image:width" content="1200" />
            <meta property="og:image:height" content="630" />
            <meta property="og:image:alt" content="{{ e(__('cats.photo_of_cat', ['name' => $cat->nome])) }}" />
        @endif
        <meta property="og:site_name" content="FriendsOfCats" />
        <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" />
        
        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="{{ e($cat->nome) }} - {{ e(__('cats.profile_subtitle')) }}" />
        <meta name="twitter:description" content="{{ e(__('cats.meet_cat', ['name' => $cat->nome, 'age' => $cat->eta, 'breed' => $cat->razza ?: __('cats.mixed_breed')])) }}" />
        @if($cat->foto_principale)
            <meta name="twitter:image" content="{{ Storage::url($cat->foto_principale) }}" />
            <meta name="twitter:image:alt" content="{{ e(__('cats.photo_of_cat', ['name' => $cat->nome])) }}" />
        @endif
        
        {{-- Additional Meta Tags --}}
        <meta name="description" content="{{ e(__('cats.meet_cat', ['name' => $cat->nome, 'age' => $cat->eta, 'breed' => $cat->razza ?: __('cats.mixed_breed')])) }}" />
        <meta name="keywords" content="{{ e(__('cats.seo_keywords', ['name' => $cat->nome, 'breed' => $cat->razza])) }}" />
        <meta name="author" content="{{ e($cat->user ? $cat->user->name : 'FriendsOfCats') }}" />
    </x-slot>

    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                    {{ $cat->nome }}
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('cats.profile_subtitle') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
            <!-- Hero Section con foto principale -->
            <div class="relative w-full h-[400px] bg-gray-200 dark:bg-gray-700 rounded-lg overflow-hidden mb-6">
            @if($cat->foto_principale)
                <img src="{{ Storage::url($cat->foto_principale) }}" 
                     alt="{{ $cat->nome }}"
                     class="w-full h-full object-cover object-center">
            @else
                <div class="w-full h-full flex items-center justify-center text-8xl">🐱</div>
            @endif
            
            <!-- Overlay con informazioni base -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
            <div class="absolute bottom-6 left-6 right-6 text-white">
                <h2 class="text-4xl font-bold mb-2">{{ $cat->nome }}</h2>
                <div class="flex flex-wrap gap-4 text-lg">
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ $cat->eta }} {{ __('cats.months_old') }}
                    </span>
                    @if($cat->razza)
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        {{ $cat->razza }}
                    </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Statistiche Rapide -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-red-600 dark:text-red-400">{{ $stats['total_likes'] }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('cats.total_likes') }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total_posts'] }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('cats.total_posts') }}</div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-lg font-bold text-green-600 dark:text-green-400">{{ $stats['arrival_formatted'] }}</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('cats.days_since_arrival') }}</div>
            </div>
            @if($cat->disponibile_adozione)
            <div class="bg-white dark:bg-gray-800 rounded-lg p-4 text-center shadow-sm border border-gray-100 dark:border-gray-700">
                <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">✨</div>
                <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('cats.available_adoption') }}</div>
            </div>
            @endif
        </div>

        <!-- Follow Section -->
        @if($userCanFollow)
        <div class="flex items-center justify-center gap-6 py-6">
            <button id="followCatBtn" 
                    onclick="toggleCatFollow({{ $cat->id }})"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-sm border {{ $isFollowing ? 'bg-red-50 hover:bg-red-100 dark:bg-red-900/10 dark:hover:bg-red-900/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800' : 'bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/10 dark:hover:bg-blue-900/20 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-800' }}">
                <svg class="w-5 h-5" fill="{{ $isFollowing ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                <span id="followCatText">
                    {{ $isFollowing ? __('cats.unfollow') : __('cats.follow') }}
                </span>
            </button>
            
            <div class="text-center">
                <div class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    <span id="followersCount">{{ $followersCount }}</span>
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    {{ $followersCount == 1 ? __('cats.follower') : __('cats.followers') }}
                </div>
            </div>
        </div>
        @endif

        <!-- Contenuto principale -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonna principale -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Informazioni caratteristiche -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('cats.characteristics') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($cat->genere)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('cats.gender') }}</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                {{ $cat->genere === 'M' ? __('cats.male') : __('cats.female') }}
                            </span>
                        </div>
                        @endif
                        
                        @if($cat->sterilizzato !== null)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('cats.sterilized') }}</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                {{ $cat->sterilizzato ? __('cats.yes') : __('cats.no') }}
                            </span>
                        </div>
                        @endif
                        
                        @if($cat->microchip)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('cats.microchip') }}</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">
                                @if($cat->numero_microchip)
                                    {{ $cat->numero_microchip }}
                                @else
                                    <span class="flex items-center gap-2">
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                        {{ __('cats.yes') }}
                                    </span>
                                @endif
                            </span>
                        </div>
                        @endif
                        
                        @if($cat->colore)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700">
                            <span class="text-gray-600 dark:text-gray-400">{{ __('cats.color') }}</span>
                            <span class="font-medium text-gray-900 dark:text-gray-100">{{ $cat->colore }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Storia del gatto -->
                @if($cat->storia)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('cats.story') }}
                    </h3>
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
                        {{ $cat->storia }}
                    </p>
                </div>
                @endif

                <!-- Salute e Cura -->
                @if($cat->stato_salute || $cat->note_salute || $cat->vaccini || $cat->fiv_felv)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('cats.health') }}
                    </h3>
                    
                    @if($cat->stato_salute)
                    <div class="mb-4">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('cats.health_status') }}</span>
                        <p class="text-gray-900 dark:text-gray-100">{{ $cat->stato_salute }}</p>
                    </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($cat->vaccini !== null)
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full {{ $cat->vaccini ? 'bg-green-500' : 'bg-red-500' }}"></div>
                            <span class="text-gray-700 dark:text-gray-300">
                                {{ $cat->vaccini ? __('cats.vaccinated') : __('cats.not_vaccinated') }}
                            </span>
                        </div>
                        @endif
                        
                        @if($cat->fiv_felv)
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full {{ $cat->fiv_felv === 'negativo' ? 'bg-green-500' : 'bg-yellow-500' }}"></div>
                            <span class="text-gray-700 dark:text-gray-300">
                                FIV/FELV: {{ $cat->fiv_felv }}
                            </span>
                        </div>
                        @endif
                    </div>
                    
                    @if($cat->note_salute)
                    <div class="mt-4">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('cats.health_notes') }}</span>
                        <p class="text-gray-700 dark:text-gray-300">{{ $cat->note_salute }}</p>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Galleria Foto -->
                @php
                    $allPhotos = [];
                    if ($cat->foto_principale) {
                        $allPhotos[] = $cat->foto_principale;
                    }
                    if ($cat->galleria_foto && count($cat->galleria_foto) > 0) {
                        $allPhotos = array_merge($allPhotos, $cat->galleria_foto);
                    }
                    $totalPhotos = count($allPhotos);
                @endphp
                
                @if($totalPhotos > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        📸 {{ __('cats.gallery') }} ({{ $totalPhotos }} {{ __('cats.photos') }})
                    </h3>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($allPhotos as $index => $foto)
                        <div class="aspect-square bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition-opacity relative group"
                             onclick="openCatGallery({{ $cat->id }}, {{ json_encode($allPhotos) }}, {{ $index }})">
                            <img src="{{ Storage::url($foto) }}" 
                                 alt="{{ $cat->nome }} - Foto {{ $index + 1 }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden w-full h-full items-center justify-center text-4xl">🐱</div>
                            
                            @if($index === 0 && $cat->foto_principale)
                            <div class="absolute top-2 left-2 bg-orange-500 text-white text-xs px-2 py-1 rounded-full font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                                {{ __('cats.main_photo') }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 text-center">
                        {{ __('cats.click_to_view_fullsize') }}
                    </p>
                </div>
                @endif

                <!-- Post recenti -->
                @if($recentPosts->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('cats.recent_posts') }}
                    </h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($recentPosts as $post)
                        <div class="border border-gray-200 dark:border-gray-600 rounded-lg p-4">
                            @if($post->image_url)
                            <div class="aspect-video bg-gray-100 dark:bg-gray-700 rounded-lg mb-3 overflow-hidden">
                                <img src="{{ Storage::url($post->image_url) }}" alt="" class="w-full h-full object-cover">
                            </div>
                            @endif
                            <p class="text-gray-700 dark:text-gray-300 text-sm mb-2">
                                {{ Str::limit($post->content, 100) }}
                            </p>
                            <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                                <span>❤️ {{ $post->likes_count }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Informazioni associazione -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('cats.association_info') }}
                    </h3>
                    
                    @if($cat->user)
                    <div class="space-y-4">
                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('cats.contact_name') }}</span>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $cat->user->name }}</p>
                        </div>
                        
                        @if($cat->user->ragione_sociale)
                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('cats.organization') }}</span>
                            <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $cat->user->ragione_sociale }}</p>
                        </div>
                        @endif
                        
                        <!-- Indirizzo completo -->
                        @if($cat->user->indirizzo || $cat->user->citta)
                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('cats.address') }}</span>
                            <div class="text-gray-900 dark:text-gray-100">
                                @if($cat->user->indirizzo)
                                    <p>{{ $cat->user->indirizzo }}</p>
                                @endif
                                @if($cat->user->citta || $cat->user->provincia)
                                    <p>
                                        @if($cat->user->cap){{ $cat->user->cap }} @endif
                                        @if($cat->user->citta){{ $cat->user->citta }}@endif
                                        @if($cat->user->provincia) ({{ $cat->user->provincia }})@endif
                                    </p>
                                @endif
                                @if($cat->user->paese && $cat->user->paese !== 'Italia')
                                    <p>{{ $cat->user->paese }}</p>
                                @endif
                            </div>
                        </div>
                        @endif
                        
                        <!-- Telefono -->
                        @if($cat->user->telefono)
                        <div>
                            <span class="text-sm font-medium text-gray-600 dark:text-gray-400">{{ __('cats.phone') }}</span>
                            <p class="text-gray-900 dark:text-gray-100">
                                <a href="tel:{{ $cat->user->telefono }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $cat->user->telefono }}
                                </a>
                            </p>
                        </div>
                        @endif
                        
                        @if($cat->user->email)
                        <div>
                            <a href="mailto:{{ $cat->user->email }}" 
                               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('cats.contact_association') }}
                            </a>
                        </div>
                        @endif
                        
                        @if($cat->user->citta)
                        <div class="mt-3">
                            <a href="https://www.google.com/maps/search/{{ urlencode(($cat->user->indirizzo ? $cat->user->indirizzo . ', ' : '') . $cat->user->citta . ($cat->user->provincia ? ', ' . $cat->user->provincia : '') . ($cat->user->paese ? ', ' . $cat->user->paese : '')) }}" 
                               target="_blank"
                               class="block w-full text-center bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ __('cats.view_on_maps') }}
                            </a>
                        </div>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Badge e status -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('cats.status') }}
                    </h3>
                    
                    <div class="space-y-3">
                        @if($cat->disponibile_adozione)
                        <div class="flex items-center gap-2 text-green-600 dark:text-green-400">
                            <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                            <span class="font-medium">{{ __('cats.available_for_adoption') }}</span>
                        </div>
                        @endif
                        
                        @if($cat->sterilizzato)
                        <div class="flex items-center gap-2 text-blue-600 dark:text-blue-400">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="font-medium">{{ __('cats.sterilized') }}</span>
                        </div>
                        @endif
                        
                        @if($cat->vaccini)
                        <div class="flex items-center gap-2 text-purple-600 dark:text-purple-400">
                            <div class="w-3 h-3 bg-purple-500 rounded-full"></div>
                            <span class="font-medium">{{ __('cats.vaccinated') }}</span>
                        </div>
                        @endif
                        
                        @if($cat->microchip)
                        <div class="flex items-center gap-2 text-orange-600 dark:text-orange-400">
                            <div class="w-3 h-3 bg-orange-500 rounded-full"></div>
                            <span class="font-medium">{{ __('cats.microchipped') }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Pulsante azione principale -->
                @if($cat->disponibile_adozione)
                <div class="bg-gradient-to-r from-orange-500 to-pink-500 rounded-lg p-6 text-white text-center">
                    <h3 class="text-lg font-bold mb-2">{{ __('cats.interested_adoption') }}</h3>
                    <p class="text-sm mb-4 opacity-90">{{ __('cats.adoption_description') }}</p>
                    @if($cat->user && $cat->user->email)
                    <a href="mailto:{{ $cat->user->email }}?subject=Interesse per adozione di {{ $cat->nome }}" 
                       class="inline-flex items-center gap-2 bg-white text-orange-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                        {{ __('cats.contact_for_adoption') }}
                    </a>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Sezione Condivisione Social -->
        <div class="mb-12">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                    🔗 {{ __('cats.share_cat_profile') }}
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    {{ __('cats.share_description', ['name' => $cat->nome]) }}
                </p>
                
                <div class="flex flex-wrap gap-3">
                    <!-- Facebook -->
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('cats.show', $cat->id)) }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>
                    
                    <!-- Twitter/X -->
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode(__('cats.tweet_text', ['name' => $cat->nome])) }}&url={{ urlencode(route('cats.show', $cat->id)) }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 bg-gray-900 hover:bg-gray-800 text-white px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                        Twitter
                    </a>
                    
                    <!-- WhatsApp -->
                    <a href="https://wa.me/?text={{ urlencode(__('cats.whatsapp_text', ['name' => $cat->nome, 'url' => route('cats.show', $cat->id)])) }}" 
                       target="_blank" 
                       class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.465 3.63"/>
                        </svg>
                        WhatsApp
                    </a>
                    
                    <!-- Copia Link -->
                    <button onclick="copyToClipboard('{{ route('cats.show', $cat->id) }}')" 
                            class="inline-flex items-center gap-2 bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        {{ __('cats.copy_link') }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Gatti simili -->
        @if($similarCats->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                {{ __('cats.similar_cats') }}
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($similarCats as $similarCat)
                <div class="group">
                    <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-900 dark:border-gray-600 overflow-hidden transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                        
                        <!-- Foto principale -->
                        <div class="aspect-[4/3] bg-gray-200 dark:bg-gray-600 overflow-hidden relative">
                            <img src="{{ Storage::url($similarCat->foto_principale) }}" 
                                 alt="{{ $similarCat->nome }}"
                                 class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden w-full h-full items-center justify-center text-6xl">🐱</div>
                        </div>
                        
                        <!-- Contenuto card -->
                        <div class="p-4 space-y-2">
                            <div class="flex items-center justify-between">
                                <h3 class="font-bold text-lg text-gray-900 dark:text-gray-100">{{ $similarCat->nome }}</h3>
                                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $similarCat->eta }}m</span>
                            </div>
                            
                            @if($similarCat->razza)
                            <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $similarCat->razza }}</p>
                            @endif
                            
                            <!-- Badge -->
                            <div class="flex flex-wrap gap-1 pt-2">
                                @if($similarCat->disponibile_adozione)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                    {{ __('cats.adoptable') }}
                                </span>
                                @endif
                                @if($similarCat->sterilizzato)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                                    {{ __('cats.sterilized') }}
                                </span>
                                @endif
                            </div>
                            
                            <!-- Call to action nascosta di default, visibile on hover -->
                            <div class="pt-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                <a href="{{ route('cats.show', $similarCat->id) }}" 
                                   class="block w-full text-center bg-orange-600 hover:bg-orange-700 text-white py-2 rounded-lg text-sm font-medium transition-colors">
                                    {{ __('cats.view_profile') }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
        
        </div>
    </div>

    <!-- Galleria Foto Modal -->
    <div id="catPhotoGallery" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center">
        <div class="relative max-w-6xl max-h-full w-full h-full flex items-center justify-center">
            <!-- Close Button -->
            <button onclick="closeCatGallery()" class="absolute top-6 right-6 text-white hover:text-gray-300 z-10 bg-black bg-opacity-50 rounded-full p-2 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <!-- Photo Container -->
            <div class="relative w-full h-full flex items-center justify-center px-20 py-16">
                <!-- Photo -->
                <img id="catGalleryImage" src="" alt="" class="max-w-full max-h-full object-contain shadow-2xl">
            </div>
            
            <!-- Previous Button -->
            <button id="catPrevBtn" onclick="previousCatPhoto()" class="absolute left-6 top-1/2 transform -translate-y-1/2 text-white hover:text-orange-400 z-10 bg-black bg-opacity-50 rounded-full p-3 transition-all hover:bg-opacity-70 hover:scale-110">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <!-- Next Button -->
            <button id="catNextBtn" onclick="nextCatPhoto()" class="absolute right-6 top-1/2 transform -translate-y-1/2 text-white hover:text-orange-400 z-10 bg-black bg-opacity-50 rounded-full p-3 transition-all hover:bg-opacity-70 hover:scale-110">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            
            <!-- Photo Counter -->
            <div id="catPhotoCounter" class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white text-lg font-medium bg-black bg-opacity-60 px-6 py-3 rounded-full backdrop-blur-sm">
                <span id="catCurrentPhoto">1</span> / <span id="catTotalPhotos">1</span>
            </div>
        </div>
    </div>

    <script>
    let currentCatGallery = [];
    let currentCatPhotoIndex = 0;

    function openCatGallery(catId, photos, startIndex = 0) {
        currentCatGallery = photos.map(photo => '/storage/' + photo);
        currentCatPhotoIndex = startIndex;
        
        document.getElementById('catPhotoGallery').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        
        showCurrentCatPhoto();
        updateCatNavButtons();
    }

    function closeCatGallery() {
        document.getElementById('catPhotoGallery').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function showCurrentCatPhoto() {
        if (currentCatGallery.length > 0) {
            document.getElementById('catGalleryImage').src = currentCatGallery[currentCatPhotoIndex];
            document.getElementById('catCurrentPhoto').textContent = currentCatPhotoIndex + 1;
            document.getElementById('catTotalPhotos').textContent = currentCatGallery.length;
        }
    }

    function updateCatNavButtons() {
        const prevBtn = document.getElementById('catPrevBtn');
        const nextBtn = document.getElementById('catNextBtn');
        
        if (currentCatGallery.length <= 1) {
            prevBtn.style.display = 'none';
            nextBtn.style.display = 'none';
        } else {
            prevBtn.style.display = 'block';
            nextBtn.style.display = 'block';
            
            prevBtn.style.opacity = currentCatPhotoIndex === 0 ? '0.5' : '1';
            nextBtn.style.opacity = currentCatPhotoIndex === currentCatGallery.length - 1 ? '0.5' : '1';
        }
    }

    function previousCatPhoto() {
        if (currentCatPhotoIndex > 0) {
            currentCatPhotoIndex--;
            showCurrentCatPhoto();
            updateCatNavButtons();
        }
    }

    function nextCatPhoto() {
        if (currentCatPhotoIndex < currentCatGallery.length - 1) {
            currentCatPhotoIndex++;
            showCurrentCatPhoto();
            updateCatNavButtons();
        }
    }

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        if (!document.getElementById('catPhotoGallery').classList.contains('hidden')) {
            if (e.key === 'ArrowLeft') {
                previousCatPhoto();
            } else if (e.key === 'ArrowRight') {
                nextCatPhoto();
            } else if (e.key === 'Escape') {
                closeCatGallery();
            }
        }
    });

    // Copy to clipboard function
    function copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(function() {
            // Show success message
            const button = event.target.closest('button');
            const originalText = button.innerHTML;
            button.innerHTML = '<svg class=\'w-5 h-5\' fill=\'none\' stroke=\'currentColor\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M5 13l4 4L19 7\'></path></svg> {{ __("cats.copied") }}';
            button.classList.add('bg-green-600');
            button.classList.remove('bg-gray-600');
            
            setTimeout(() => {
                button.innerHTML = originalText;
                button.classList.remove('bg-green-600');
                button.classList.add('bg-gray-600');
            }, 2000);
        }).catch(function(err) {
            console.error('Could not copy text: ', err);
            alert('{{ __("cats.copy_error") }}');
        });
    }

    // Cat follow/unfollow function
    function toggleCatFollow(catId) {
        const button = document.getElementById('followCatBtn');
        const text = document.getElementById('followCatText');
        const countElement = document.getElementById('followersCount');
        
        // Disable button during request
        button.disabled = true;
        
        fetch(`/follow/cat/${catId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                notifications: true
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update button appearance
                const isNowFollowing = data.is_following;
                
                if (isNowFollowing) {
                    // Following state
                    button.className = 'inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-sm border bg-red-50 hover:bg-red-100 dark:bg-red-900/10 dark:hover:bg-red-900/20 text-red-700 dark:text-red-400 border-red-200 dark:border-red-800';
                    text.textContent = '{{ __("cats.unfollow") }}';
                    button.querySelector('svg').setAttribute('fill', 'currentColor');
                } else {
                    // Not following state
                    button.className = 'inline-flex items-center gap-2 px-6 py-3 rounded-lg font-medium transition-all duration-200 shadow-sm border bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/10 dark:hover:bg-blue-900/20 text-blue-700 dark:text-blue-400 border-blue-200 dark:border-blue-800';
                    text.textContent = '{{ __("cats.follow") }}';
                    button.querySelector('svg').setAttribute('fill', 'none');
                }
                
                // Update followers count
                countElement.textContent = data.followers_count;
                
                // Show success message (optional)
                if (data.message) {
                    // You could show a toast notification here
                    console.log(data.message);
                }
            } else {
                alert(data.error || 'Errore durante l\'operazione');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Errore di connessione');
        })
        .finally(() => {
            button.disabled = false;
        });
    }
    </script>
</x-main-layout>
