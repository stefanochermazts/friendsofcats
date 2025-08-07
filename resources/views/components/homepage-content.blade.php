{{-- Homepage Main Content --}}
<main class="min-h-screen">
    {{-- Hero Section --}}
    <section class="relative py-24 sm:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                {{-- Content --}}
                <div class="text-center lg:text-left">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-6xl">
                        {{ __('platform_for_cats') }}
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300 max-w-3xl lg:max-w-none mx-auto">
                        {{ __('platform_description') }}
                    </p>
                    <div class="mt-10 flex items-center justify-center lg:justify-start gap-x-6">
                        <a href="{{ route('register') }}" 
                           class="rounded-lg bg-orange-500 px-6 py-3 text-base font-semibold text-white shadow-sm hover:bg-orange-600 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-orange-500 transition-colors duration-200">
                            {{ __('get_started') }}
                        </a>
                        <a href="#features" 
                           class="text-base font-semibold leading-6 text-gray-900 dark:text-white hover:text-orange-500 dark:hover:text-orange-400 transition-colors duration-200">
                            {{ __('key_features') }}
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
                
                {{-- Hero Image Placeholder --}}
                <div class="relative">
                    <div class="aspect-square w-full max-w-md mx-auto lg:max-w-lg">
                        <div class="w-full h-full bg-gradient-to-br from-orange-100 to-orange-200 dark:from-orange-900/20 dark:to-orange-800/20 rounded-2xl border-2 border-dashed border-orange-300 dark:border-orange-600 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-orange-400 dark:text-orange-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm font-medium text-orange-600 dark:text-orange-400">
                                    {{ __('hero_image_placeholder') }}
                                </p>
                                <p class="text-xs text-orange-500 dark:text-orange-500 mt-1">
                                    {{ __('recommended_size') }}: 600x600px
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Mission Section --}}
    <section class="py-24 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ __('our_mission') }}
                </h2>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
                    {{ __('mission_description') }}
                </p>
            </div>
        </div>
    </section>

    {{-- Featured Cats Section --}}
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ __('adoptions.featured_cats') }}
                </h2>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                    {{ __('adoptions.subtitle') }}
                </p>
            </div>
            
            <!-- Container per gatti caricati dinamicamente -->
            <div id="featured-cats-container" class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Skeleton loading cards -->
                    @for($i = 0; $i < 6; $i++)
                        <div class="featured-cat-skeleton animate-pulse">
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
                                <!-- Skeleton foto -->
                                <div class="aspect-[4/3] bg-gray-200 dark:bg-gray-600"></div>
                                
                                <!-- Skeleton contenuto -->
                                <div class="p-4 space-y-3">
                                    <div class="h-5 bg-gray-200 dark:bg-gray-600 rounded w-3/4"></div>
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
            
            <!-- CTA per vedere tutti i gatti -->
            <div class="text-center mt-12">
                <a href="{{ route('public.adoptions.index') }}" 
                   class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors duration-200">
                    {{ __('adoptions.view_all_cats') }}
                    <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Target Audience Section --}}
    <section id="audience" class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ __('who_we_serve') }}
                </h2>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                    {{ __('platform_description') }}
                </p>
            </div>
            
            <div class="mt-20 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                {{-- Associations --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                        {{ __('associations') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('associations_desc') }}
                    </p>
                </div>

                {{-- Cat Owners --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                        {{ __('cat_owners') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('cat_owners_desc') }}
                    </p>
                </div>

                {{-- Veterinarians --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                        {{ __('veterinarians') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('veterinarians_desc') }}
                    </p>
                </div>

                {{-- Volunteers --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                        {{ __('volunteers') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('volunteers_desc') }}
                    </p>
                </div>

                {{-- Donors --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                        {{ __('donors') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('donors_desc') }}
                    </p>
                </div>

                {{-- Groomers --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl p-8 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center mb-6">
                        <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-3">
                        {{ __('groomers') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('groomers_desc') }}
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Features Section --}}
    <section id="features" class="py-24 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                    {{ __('key_features') }}
                </h2>
                <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                    {{ __('exclusively_cats') }}
                </p>
            </div>
            
            <div class="mt-20 grid grid-cols-1 gap-12 lg:grid-cols-2">
                <div class="space-y-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ __('cat_management') }}
                        </h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">
                            {{ __('cat_management_desc') }}
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ __('adoption_platform') }}
                        </h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">
                            {{ __('adoption_platform_desc') }}
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ __('health_registry') }}
                        </h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">
                            {{ __('health_registry_desc') }}
                        </p>
                    </div>
                </div>
                
                <div class="space-y-8">
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ __('volunteer_workflow') }}
                        </h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">
                            {{ __('volunteer_workflow_desc') }}
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ __('memorial_section') }}
                        </h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">
                            {{ __('memorial_section_desc') }}
                        </p>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ __('community_feed') }}
                        </h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">
                            {{ __('community_feed_desc') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Why Choose Us Section --}}
    <section class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center mb-20">
                {{-- Content --}}
                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        {{ __('why_choose_us') }}
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600 dark:text-gray-300">
                        {{ __('focus_description') }}
                    </p>
                </div>
                
                {{-- Why Choose Us Image Placeholder --}}
                <div class="relative">
                    <div class="aspect-video w-full max-w-md mx-auto lg:max-w-lg">
                        <div class="w-full h-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 rounded-2xl border-2 border-dashed border-gray-300 dark:border-gray-600 flex items-center justify-center">
                            <div class="text-center">
                                <svg class="w-16 h-16 text-gray-400 dark:text-gray-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">
                                    {{ __('why_choose_image_placeholder') }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                                    {{ __('recommended_size') }}: 800x450px
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('complete_solution') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('complete_solution_desc') }}
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('expert_team') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        {{ __('expert_team_desc') }}
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('multilingual_support') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        6 lingue supportate
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('secure_gdpr') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Conformità GDPR
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="bg-orange-500 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white sm:text-4xl">
                {{ __('join_community') }}
            </h2>
            <p class="mt-4 text-lg text-orange-100">
                {{ __('join_community_desc') }}
            </p>
            <div class="mt-8">
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-orange-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400 transition-colors duration-200">
                    {{ __('get_started') }}
                </a>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Carica i gatti in evidenza tramite AJAX
    fetch('{{ route("api.featured-cats") }}')
        .then(response => response.json())
        .then(cats => {
            const container = document.getElementById('featured-cats-container');
            
            if (cats.length > 0) {
                // Sostituisci skeleton con vere card gatti
                container.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        ${cats.map(cat => `
                            <div class="group">
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                                    <!-- Foto -->
                                    <div class="aspect-[4/3] bg-gray-200 dark:bg-gray-600 overflow-hidden">
                                        <img src="/storage/${cat.foto_principale}" 
                                             alt="${cat.nome}"
                                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="hidden w-full h-full items-center justify-center text-6xl">🐱</div>
                                    </div>

                                    <!-- Informazioni -->
                                    <div class="p-4 space-y-3">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                                            ${cat.nome}
                                        </h3>

                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <span class="font-medium">${cat.eta_formattata_display || cat.eta + ' mesi'}</span>
                                            </p>
                                            ${cat.razza ? `<p class="text-sm text-gray-600 dark:text-gray-400">${cat.razza}</p>` : ''}
                                        </div>

                                        <div class="flex flex-wrap gap-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                                {{ __('adoptions.adoptable') }}
                                            </span>
                                            ${cat.sterilizzazione ? `
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                                                    {{ __('adoptions.sterilized') }}
                                                </span>
                                            ` : ''}
                                        </div>

                                        <!-- CTA -->
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 space-y-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                                            <a href="/adoptions/${cat.id}" 
                                               class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                                                {{ __('adoptions.discover_more') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
            } else {
                // Nessun gatto disponibile
                container.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🐱</div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                            {{ __('adoptions.no_cats_found') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('adoptions.no_cats_message') }}
                        </p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Errore nel caricamento dei gatti:', error);
            
            // Mostra messaggio di errore
            const container = document.getElementById('featured-cats-container');
            container.innerHTML = `
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">😿</div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        Errore nel caricamento
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Non è stato possibile caricare i gatti in evidenza.
                    </p>
                </div>
            `;
        });
});
</script>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('multilingual_support') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        6 lingue supportate
                    </p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-orange-100 dark:bg-orange-900/20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">
                        {{ __('secure_gdpr') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300">
                        Conformità GDPR
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="bg-orange-500 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-white sm:text-4xl">
                {{ __('join_community') }}
            </h2>
            <p class="mt-4 text-lg text-orange-100">
                {{ __('join_community_desc') }}
            </p>
            <div class="mt-8">
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-orange-500 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-400 transition-colors duration-200">
                    {{ __('get_started') }}
                </a>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Carica i gatti in evidenza tramite AJAX
    fetch('{{ route("api.featured-cats") }}')
        .then(response => response.json())
        .then(cats => {
            const container = document.getElementById('featured-cats-container');
            
            if (cats.length > 0) {
                // Sostituisci skeleton con vere card gatti
                container.innerHTML = `
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        ${cats.map(cat => `
                            <div class="group">
                                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 overflow-hidden transition-all duration-300 group-hover:shadow-lg group-hover:-translate-y-1">
                                    <!-- Foto -->
                                    <div class="aspect-[4/3] bg-gray-200 dark:bg-gray-600 overflow-hidden">
                                        <img src="/storage/${cat.foto_principale}" 
                                             alt="${cat.nome}"
                                             class="w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300"
                                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                        <div class="hidden w-full h-full items-center justify-center text-6xl">🐱</div>
                                    </div>

                                    <!-- Informazioni -->
                                    <div class="p-4 space-y-3">
                                        <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 group-hover:text-orange-600 dark:group-hover:text-orange-400 transition-colors">
                                            ${cat.nome}
                                        </h3>

                                        <div class="space-y-1">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                <span class="font-medium">${cat.eta_formattata_display || cat.eta + ' mesi'}</span>
                                            </p>
                                            ${cat.razza ? `<p class="text-sm text-gray-600 dark:text-gray-400">${cat.razza}</p>` : ''}
                                        </div>

                                        <div class="flex flex-wrap gap-1">
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300">
                                                {{ __('adoptions.adoptable') }}
                                            </span>
                                            ${cat.sterilizzazione ? `
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/20 dark:text-blue-300">
                                                    {{ __('adoptions.sterilized') }}
                                                </span>
                                            ` : ''}
                                        </div>

                                        <!-- CTA -->
                                        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 space-y-2 pt-2 border-t border-gray-100 dark:border-gray-700">
                                            <a href="/adoptions/${cat.id}" 
                                               class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white py-2 px-4 rounded-lg font-medium transition-colors">
                                                {{ __('adoptions.discover_more') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `).join('')}
                    </div>
                `;
            } else {
                // Nessun gatto disponibile
                container.innerHTML = `
                    <div class="text-center py-12">
                        <div class="text-6xl mb-4">🐱</div>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                            {{ __('adoptions.no_cats_found') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('adoptions.no_cats_message') }}
                        </p>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('Errore nel caricamento dei gatti:', error);
            
            // Mostra messaggio di errore
            const container = document.getElementById('featured-cats-container');
            container.innerHTML = `
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">😿</div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">
                        Errore nel caricamento
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Non è stato possibile caricare i gatti in evidenza.
                    </p>
                </div>
            `;
        });
});
</script>