{{-- Homepage Main Content --}}
<main class="min-h-screen">
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-r from-orange-50 to-orange-100 dark:from-gray-900 dark:to-gray-800 py-20 sm:py-32 overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-grid-pattern opacity-5"></div>
        
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Content --}}
                <div class="text-center lg:text-left">
                    <div class="inline-flex items-center bg-orange-100 dark:bg-orange-900/30 text-orange-800 dark:text-orange-200 px-3 py-1 rounded-full text-sm font-medium mb-6">
                        🌍 {{ __('homepage.available_in_6_languages') }}
                    </div>
                    
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl lg:text-7xl">
                        {{ __('homepage.hero_title') }}
                    </h1>
                    
                    <p class="mt-6 text-xl leading-8 text-gray-600 dark:text-gray-300 max-w-3xl lg:max-w-none mx-auto">
                        {{ __('homepage.hero_subtitle') }}
                    </p>
                    
                    {{-- Stats --}}
                    <div class="mt-8 grid grid-cols-3 gap-4 max-w-md mx-auto lg:mx-0">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400" id="hero-cats">0</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('homepage.cats_helped') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400" id="hero-adoptions">0</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('homepage.successful_adoptions') }}</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400" id="hero-languages">6</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">{{ __('homepage.languages') }}</div>
                        </div>
                    </div>
                    
                    {{-- CTA Buttons --}}
                    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('register') }}" 
                           class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-300">
                            🚀 {{ __('homepage.start_journey') }}
                        </a>
                        
                        <a href="{{ route('public.adoptions.index') }}" 
                           class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 font-semibold rounded-xl border-2 border-gray-200 dark:border-gray-600 hover:border-orange-300 dark:hover:border-orange-500 transition-all duration-300">
                            🐱 {{ __('homepage.discover_cats') }}
                        </a>
                    </div>
                </div>
                
                {{-- Hero Visual --}}
                <div class="relative">
                    <div class="aspect-square w-full max-w-lg mx-auto">
                        {{-- Floating Cards --}}
                        <div class="relative w-full h-full">
                            {{-- Main Circle --}}
                            <div class="absolute inset-0 bg-gradient-to-br from-orange-400 to-orange-600 rounded-full opacity-10 animate-pulse"></div>
                            
                            {{-- Feature Cards --}}
                            <div class="absolute top-8 left-8 bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg transform rotate-12 hover:rotate-6 transition-transform duration-500">
                                <div class="text-3xl mb-2">📱</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">CatBook</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('homepage.social_network') }}</div>
                            </div>
                            
                            <div class="absolute top-16 right-4 bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg transform -rotate-12 hover:-rotate-6 transition-transform duration-500">
                                <div class="text-3xl mb-2">🏠</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('homepage.adoptions') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('homepage.find_companion') }}</div>
                            </div>
                            
                            <div class="absolute bottom-8 left-16 bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg transform rotate-6 hover:rotate-3 transition-transform duration-500">
                                <div class="text-3xl mb-2">👥</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('homepage.professionals') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('homepage.vets_groomers') }}</div>
                            </div>
                            
                            <div class="absolute bottom-16 right-8 bg-white dark:bg-gray-800 rounded-xl p-4 shadow-lg transform -rotate-6 hover:-rotate-3 transition-transform duration-500">
                                <div class="text-3xl mb-2">🌍</div>
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ __('homepage.multilingual') }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">6 {{ __('homepage.languages') }}</div>
                            </div>
                            
                            {{-- Center Cat Icon --}}
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="w-32 h-32 bg-orange-500 rounded-full flex items-center justify-center text-6xl shadow-2xl animate-bounce">
                                    🐱
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Core Features Section --}}
    <section class="py-24 bg-white dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ __('homepage.everything_cats_need') }}
                </h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    {{ __('homepage.complete_platform_description') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- CatBook Social --}}
                <div class="group relative bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 cursor-pointer"
                     onclick="window.location.href='{{ route('catbook.index') }}'">
                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                    
                    <div class="w-16 h-16 bg-blue-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-3xl">📱</span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('homepage.catbook_title') }}
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ __('homepage.catbook_description') }}
                    </p>
                    
                    <div class="space-y-2">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-3"></span>
                            {{ __('homepage.catbook_feature_1') }}
                        </div>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-3"></span>
                            {{ __('homepage.catbook_feature_2') }}
                        </div>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 bg-blue-400 rounded-full mr-3"></span>
                            {{ __('homepage.catbook_feature_3') }}
                        </div>
                    </div>
                    
                    <div class="mt-6 inline-flex items-center text-blue-600 dark:text-blue-400 font-medium group-hover:text-blue-700 dark:group-hover:text-blue-300">
                        {{ __('homepage.explore_catbook') }}
                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>

                {{-- Adoptions --}}
                <div class="group relative bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 cursor-pointer"
                     onclick="window.location.href='{{ route('public.adoptions.index') }}'">
                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                    
                    <div class="w-16 h-16 bg-green-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-3xl">🏠</span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('homepage.adoptions_title') }}
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ __('homepage.adoptions_description') }}
                    </p>
                    
                    <div class="space-y-2">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                            {{ __('homepage.adoptions_feature_1') }}
                        </div>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                            {{ __('homepage.adoptions_feature_2') }}
                        </div>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 bg-green-400 rounded-full mr-3"></span>
                            {{ __('homepage.adoptions_feature_3') }}
                        </div>
                    </div>
                    
                    <div class="mt-6 inline-flex items-center text-green-600 dark:text-green-400 font-medium group-hover:text-green-700 dark:group-hover:text-green-300">
                        {{ __('homepage.find_perfect_cat') }}
                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>

                {{-- Professional Network --}}
                <div class="group relative bg-gradient-to-br from-purple-50 to-violet-50 dark:from-purple-900/20 dark:to-violet-900/20 rounded-2xl p-8 hover:shadow-xl transition-all duration-300 hover:-translate-y-2 cursor-pointer"
                     onclick="window.location.href='{{ route('register') }}'">
                    <div class="absolute top-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                        </svg>
                    </div>
                    
                    <div class="w-16 h-16 bg-purple-500 rounded-xl flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                        <span class="text-3xl">👩‍⚕️</span>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('homepage.professionals_title') }}
                    </h3>
                    
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ __('homepage.professionals_description') }}
                    </p>
                    
                    <div class="space-y-2">
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 bg-purple-400 rounded-full mr-3"></span>
                            {{ __('homepage.professionals_feature_1') }}
                        </div>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 bg-purple-400 rounded-full mr-3"></span>
                            {{ __('homepage.professionals_feature_2') }}
                        </div>
                        <div class="flex items-center text-sm text-gray-500 dark:text-gray-400">
                            <span class="w-2 h-2 bg-purple-400 rounded-full mr-3"></span>
                            {{ __('homepage.professionals_feature_3') }}
                        </div>
                    </div>
                    
                    <div class="mt-6 inline-flex items-center text-purple-600 dark:text-purple-400 font-medium group-hover:text-purple-700 dark:group-hover:text-purple-300">
                        {{ __('homepage.join_professionals') }}
                        <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Featured Cats Section --}}
    <section class="py-24 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ __('homepage.cats_waiting_love') }}
                </h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300">
                    {{ __('homepage.cats_waiting_description') }}
                </p>
            </div>
            
            <!-- Container per gatti caricati dinamicamente -->
            <div id="featured-cats-container" class="mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Skeleton loading cards -->
                    @for($i = 0; $i < 6; $i++)
                        <div class="featured-cat-skeleton animate-pulse">
                            <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <!-- Skeleton foto -->
                                <div class="aspect-[4/3] bg-gray-200 dark:bg-gray-600"></div>
                                
                                <!-- Skeleton contenuto -->
                                <div class="p-6 space-y-3">
                                    <div class="h-6 bg-gray-200 dark:bg-gray-600 rounded w-3/4"></div>
                                    <div class="h-4 bg-gray-200 dark:bg-gray-600 rounded w-1/2"></div>
                                    <div class="flex space-x-2">
                                        <div class="h-6 bg-gray-200 dark:bg-gray-600 rounded-full w-16"></div>
                                        <div class="h-6 bg-gray-200 dark:bg-gray-600 rounded-full w-16"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
            
            <!-- Big CTA for Adoptions -->
            <div class="text-center">
                <div class="bg-gradient-to-r from-orange-500 to-pink-500 rounded-2xl p-8 md:p-12">
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-4">
                        {{ __('homepage.ready_adopt_title') }}
                    </h3>
                    <p class="text-orange-100 text-lg mb-8 max-w-2xl mx-auto">
                        {{ __('homepage.ready_adopt_description') }}
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('public.adoptions.index') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-white text-orange-600 font-bold rounded-xl hover:bg-gray-50 transition-all duration-300 transform hover:scale-105">
                            🔍 {{ __('homepage.browse_all_cats') }}
                        </a>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-orange-600 text-white font-bold rounded-xl border-2 border-white hover:bg-orange-700 transition-all duration-300 transform hover:scale-105">
                            ❤️ {{ __('homepage.start_adoption_journey') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Roles & Community Section --}}
    <section class="py-24 bg-white dark:bg-gray-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ __('homepage.join_community_title') }}
                </h2>
                <p class="mt-4 text-lg text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    {{ __('homepage.join_community_description') }}
                </p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                {{-- Cat Owners --}}
                <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-lg transition-shadow">
                    <div class="w-20 h-20 bg-blue-100 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">🏠</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('homepage.cat_owners_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ __('homepage.cat_owners_description') }}
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                        <li>✓ {{ __('homepage.cat_owners_feature_1') }}</li>
                        <li>✓ {{ __('homepage.cat_owners_feature_2') }}</li>
                        <li>✓ {{ __('homepage.cat_owners_feature_3') }}</li>
                    </ul>
                </div>

                {{-- Volunteers --}}
                <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-lg transition-shadow">
                    <div class="w-20 h-20 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">🤝</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('homepage.volunteers_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ __('homepage.volunteers_description') }}
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                        <li>✓ {{ __('homepage.volunteers_feature_1') }}</li>
                        <li>✓ {{ __('homepage.volunteers_feature_2') }}</li>
                        <li>✓ {{ __('homepage.volunteers_feature_3') }}</li>
                    </ul>
                </div>

                {{-- Associations --}}
                <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-lg transition-shadow">
                    <div class="w-20 h-20 bg-purple-100 dark:bg-purple-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">🏢</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('homepage.associations_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ __('homepage.associations_description') }}
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                        <li>✓ {{ __('homepage.associations_feature_1') }}</li>
                        <li>✓ {{ __('homepage.associations_feature_2') }}</li>
                        <li>✓ {{ __('homepage.associations_feature_3') }}</li>
                    </ul>
                </div>

                {{-- Veterinarians --}}
                <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-lg transition-shadow">
                    <div class="w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">👩‍⚕️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('homepage.veterinarians_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ __('homepage.veterinarians_description') }}
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                        <li>✓ {{ __('homepage.veterinarians_feature_1') }}</li>
                        <li>✓ {{ __('homepage.veterinarians_feature_2') }}</li>
                        <li>✓ {{ __('homepage.veterinarians_feature_3') }}</li>
                    </ul>
                </div>

                {{-- Groomers --}}
                <div class="text-center p-6 border border-gray-200 dark:border-gray-700 rounded-xl hover:shadow-lg transition-shadow">
                    <div class="w-20 h-20 bg-yellow-100 dark:bg-yellow-900/30 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl">✂️</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">
                        {{ __('homepage.groomers_title') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 mb-4">
                        {{ __('homepage.groomers_description') }}
                    </p>
                    <ul class="text-sm text-gray-500 dark:text-gray-400 space-y-1">
                        <li>✓ {{ __('homepage.groomers_feature_1') }}</li>
                        <li>✓ {{ __('homepage.groomers_feature_2') }}</li>
                        <li>✓ {{ __('homepage.groomers_feature_3') }}</li>
                    </ul>
                </div>

                {{-- CTA Card --}}
                <div class="text-center p-6 bg-gradient-to-br from-orange-50 to-orange-100 dark:from-orange-900/20 dark:to-orange-800/20 border border-orange-200 dark:border-orange-700 rounded-xl">
                    <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-3xl text-white">🚀</span>
                    </div>
                    <h3 class="text-xl font-bold text-orange-900 dark:text-orange-100 mb-3">
                        {{ __('homepage.ready_to_start') }}
                    </h3>
                    <p class="text-orange-700 dark:text-orange-300 mb-6">
                        {{ __('homepage.choose_your_role') }}
                    </p>
                    <a href="{{ route('register') }}" 
                       class="inline-flex items-center justify-center w-full px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-lg transition-colors">
                        {{ __('homepage.join_now') }}
                    </a>
                </div>
            </div>
        </div>
    </section>



    {{-- Final CTA Section --}}
    <section class="py-24 bg-gradient-to-r from-orange-600 to-pink-600 relative overflow-hidden">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 bg-white/10 bg-grid-pattern"></div>
        
        <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-6">
                {{ __('homepage.final_cta_title') }}
            </h2>
            
            <p class="text-xl text-orange-100 mb-12 max-w-2xl mx-auto">
                {{ __('homepage.final_cta_description') }}
            </p>
            
            <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
                <a href="{{ route('register') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-10 py-5 bg-white text-orange-600 font-bold text-lg rounded-2xl hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 shadow-xl">
                    🚀 {{ __('homepage.start_your_journey') }}
                </a>
                
                <a href="{{ route('public.adoptions.index') }}" 
                   class="w-full sm:w-auto inline-flex items-center justify-center px-10 py-5 bg-orange-700 text-white font-bold text-lg rounded-2xl border-2 border-white hover:bg-orange-800 transition-all duration-300 transform hover:scale-105 shadow-xl">
                    🐱 {{ __('homepage.meet_cats') }}
                </a>
            </div>
            
            <p class="mt-8 text-sm text-orange-200">
                {{ __('homepage.free_to_join') }} • {{ __('homepage.no_hidden_fees') }} • {{ __('homepage.start_immediately') }}
            </p>
        </div>
    </section>
</main>

{{-- CSS for animations and grid pattern --}}
<style>
.bg-grid-pattern {
    background-image: radial-gradient(circle, rgba(255,255,255,0.1) 1px, transparent 1px);
    background-size: 20px 20px;
}

@keyframes countUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-count-up {
    animation: countUp 0.8s ease-out forwards;
}
</style>

{{-- JavaScript for stats counter and featured cats --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load platform statistics from API
    fetch('{{ route("api.platform-stats") }}')
        .then(response => response.json())
        .then(stats => {
            console.log('📊 Statistiche caricate:', stats);
            
            // Animate counters with real data
            setTimeout(() => {
                animateCounter('hero-cats', stats.cats_helped || 0);
                animateCounter('hero-adoptions', stats.successful_adoptions || 0);
                // Languages is always 6
                document.getElementById('hero-languages').textContent = '6';
            }, 500);
        })
        .catch(error => {
            console.error('❌ Errore nel caricamento delle statistiche:', error);
            // Fallback to 0 values
            document.getElementById('hero-cats').textContent = '0';
            document.getElementById('hero-adoptions').textContent = '0';
            document.getElementById('hero-languages').textContent = '6';
        });
    
    // Animate counters
    function animateCounter(elementId, endValue, duration = 2000) {
        const element = document.getElementById(elementId);
        if (!element) {
            console.warn('⚠️ Elemento non trovato:', elementId);
            return;
        }
        
        if (endValue === 0) {
            element.textContent = '0';
            return;
        }
        
        const startValue = 0;
        const increment = endValue / (duration / 16);
        let currentValue = startValue;
        
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= endValue) {
                element.textContent = endValue > 0 ? endValue + '+' : '0';
                clearInterval(timer);
            } else {
                element.textContent = Math.floor(currentValue) + (endValue > 0 ? '+' : '');
            }
        }, 16);
    }
    
    // Load featured cats
    fetch('{{ route("api.featured-cats") }}')
        .then(response => response.json())
        .then(cats => {
            const container = document.getElementById('featured-cats-container');
            
            if (cats.length > 0) {
                container.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        ${cats.map(cat => `
                            <div class="group cursor-pointer" onclick="window.location.href='/cats/${cat.id}'">
                                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 group-hover:shadow-xl group-hover:-translate-y-2">
                                    <!-- Foto -->
                                    <div class="aspect-[4/3] bg-gray-200 dark:bg-gray-600 overflow-hidden">
                                        <img src="/storage/${cat.foto_principale}" 
                                             alt="${cat.nome}"
                                             class="w-full h-full object-cover object-center group-hover:scale-110 transition-transform duration-500"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="hidden w-full h-full items-center justify-center text-6xl bg-gradient-to-br from-orange-100 to-orange-200 dark:from-orange-900/20 dark:to-orange-800/20">🐱</div>
                                    </div>

                                    <!-- Informazioni -->
                                    <div class="p-6 space-y-4">
                                        <div>
                                            <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                                                ${cat.nome}
                                            </h3>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                                ${cat.eta_formattata_display || cat.eta + ' mesi'} ${cat.razza ? '• ' + cat.razza : ''}
                                            </p>
                                        </div>

                                        <div class="flex flex-wrap gap-2">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                                ❤️ {{ __('adoptions.adoptable') }}
                                            </span>
                                            ${cat.sterilizzazione ? `
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                                                    ✅ {{ __('adoptions.sterilized') }}
                                                </span>
                                            ` : ''}
                                        </div>

                                        <!-- Hover CTA -->
                                        <div class="opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-y-2 group-hover:translate-y-0">
                                            <div class="bg-gradient-to-r from-orange-500 to-pink-500 text-white text-center py-3 rounded-lg font-medium">
                                                💕 {{ __('homepage.meet_this_cat') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
            } else {
                container.innerHTML = `
                    <div class="text-center py-16">
                        <div class="text-8xl mb-6">😺</div>
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                            {{ __('homepage.no_cats_yet') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400 mb-8">
                            {{ __('homepage.be_first_add_cat') }}
                        </p>
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors">
                            {{ __('homepage.get_started') }}
                        </a>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Errore nel caricamento dei gatti:', error);
            
            const container = document.getElementById('featured-cats-container');
            container.innerHTML = `
                <div class="text-center py-16">
                    <div class="text-8xl mb-6">😿</div>
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('homepage.loading_error') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        {{ __('homepage.try_again_later') }}
                    </p>
                </div>
            `;
        });
});
</script>