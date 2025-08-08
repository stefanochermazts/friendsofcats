<x-main-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('dashboard.dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-md">
                            <p class="text-sm text-green-800 dark:text-green-200">
                                {{ session('success') }}
                            </p>
                        </div>
                    @endif

                    @switch(Auth::user()->role)
                        @case('associazione')
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('dashboard.associazione_dashboard') }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400">{{ __('dashboard.associazione_activities') }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.my_cats_title') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['total_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.registered') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.available_title') }}</h4>
                                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['available_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.for_adoption') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.adopted_title') }}</h4>
                                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['adopted_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.successfully') }}</p>
                                    </div>
                                </div>

                                <!-- Link gestione gatti + gatti recenti -->
                                <div class="mt-8 space-y-6">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.quick_actions') }}</h4>
                                        <div class="flex space-x-3">
                                            <a href="{{ route('association.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                {{ __('dashboard.edit_association_details') }}
                                            </a>
                                            <a href="{{ route('user.cats') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition-colors duration-200">
                                                {{ __('dashboard.manage_my_cats') }}
                                            </a>
                                        </div>
                                    </div>

                                    @if($stats['recent_cats']->count() > 0)
                                        <div>
                                            <h5 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">{{ __('dashboard.recent_cats_added') }}</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                @foreach($stats['recent_cats'] as $cat)
                                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="text-2xl">🐱</div>
                                                            <div>
                                                                <h6 class="font-medium text-gray-900 dark:text-gray-100">{{ $cat->nome }}</h6>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                    {{ $cat->razza ?? __('dashboard.breed_not_specified') }} 
                                                                    @if($cat->eta) - {{ $cat->eta_formattata }} @endif
                                                                </p>
                                                                @php
                                                                    // Logica corretta per determinare lo stato del gatto
                                                                    if ($cat->data_adozione) {
                                                                        $statusText = __('dashboard.adopted_status');
                                                                        $statusClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200';
                                                                    } elseif ($cat->disponibile_adozione) {
                                                                        $statusText = __('dashboard.available_status');
                                                                        $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                                                    } elseif (Auth::user()->role === 'proprietario') {
                                                                        $statusText = __('dashboard.owned_status');
                                                                        $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                                                    } else {
                                                                        $statusText = __('dashboard.evaluating_status');
                                                                        $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200';
                                                                    }
                                                                @endphp
                                                                <span class="inline-block px-2 py-1 text-xs rounded-full {{ $statusClass }}">
                                                                    {{ $statusText }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @break

                        @case('volontario')
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('dashboard.volontario_dashboard') }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            {{ __('dashboard.manage_cats_info') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.my_cats_title') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['total_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.registered') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.available_title') }}</h4>
                                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['available_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.for_adoption') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.adopted_title') }}</h4>
                                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['adopted_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.successfully') }}</p>
                                    </div>
                                </div>

                                <!-- Link gestione gatti + gatti recenti -->
                                <div class="mt-8 space-y-6">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.quick_actions') }}</h4>
                                        <div class="flex space-x-3">
                                            <a href="{{ route('volunteer.association.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                {{ __('dashboard.edit_association_details') }}
                                            </a>
                                            <a href="{{ route('user.cats') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition-colors duration-200">
                                                {{ __('dashboard.manage_my_cats') }}
                                            </a>
                                        </div>
                                    </div>

                                    @if($stats['recent_cats']->count() > 0)
                                        <div>
                                            <h5 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">{{ __('dashboard.recent_cats_added') }}</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                @foreach($stats['recent_cats'] as $cat)
                                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="text-2xl">🐱</div>
                                                            <div>
                                                                <h6 class="font-medium text-gray-900 dark:text-gray-100">{{ $cat->nome }}</h6>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                    {{ $cat->razza ?? __('dashboard.breed_not_specified') }} 
                                                                    @if($cat->eta) - {{ $cat->eta_formattata }} @endif
                                                                </p>
                                                                @php
                                                                    // Logica corretta per determinare lo stato del gatto
                                                                    if ($cat->data_adozione) {
                                                                        $statusText = __('dashboard.adopted_status');
                                                                        $statusClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200';
                                                                    } elseif ($cat->disponibile_adozione) {
                                                                        $statusText = __('dashboard.available_status');
                                                                        $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                                                    } elseif (Auth::user()->role === 'proprietario') {
                                                                        $statusText = __('dashboard.owned_status');
                                                                        $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                                                    } else {
                                                                        $statusText = __('dashboard.evaluating_status');
                                                                        $statusClass = 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200';
                                                                    }
                                                                @endphp
                                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                                                                    {{ $statusText }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <div class="text-center py-8">
                                            <div class="text-6xl mb-4">🐱</div>
                                            <h5 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.no_cats_yet') }}</h5>
                                            <p class="text-gray-600 dark:text-gray-400 mb-4">{{ __('dashboard.add_first_cat') }}</p>
                                            <a href="{{ route('user.cats') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors duration-200">
                                                {{ __('dashboard.add_cat') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @break

                        @case('veterinario')
                        @case('toelettatore')
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                                        @if(Auth::user()->role === 'veterinario')
                                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3h10M7 3v18h10V3M7 3a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                                            @if(Auth::user()->role === 'veterinario')
                                                {{ __('dashboard.veterinario_dashboard') }}
                                            @else
                                                {{ __('dashboard.toelettatore_dashboard') }}
                                            @endif
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400">
                                            {{ __('dashboard.manage_cats_info') }}
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.my_cats_title') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['total_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.registered') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.available_title') }}</h4>
                                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['available_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.for_adoption') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.adopted_title') }}</h4>
                                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['adopted_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.successfully') }}</p>
                                    </div>
                                </div>

                                <!-- Link gestione gatti + gatti recenti -->
                                <div class="mt-8 space-y-6">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.quick_actions') }}</h4>
                                        <div class="flex space-x-3">
                                            <a href="{{ route('professional.details.edit') }}" class="inline-flex items-center px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                {{ __('dashboard.edit_professional_details') }}
                                            </a>
                                            <a href="{{ route('user.cats') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition-colors duration-200">
                                                {{ __('dashboard.manage_my_cats') }}
                                            </a>
                                        </div>
                                    </div>

                                    @if($stats['recent_cats']->count() > 0)
                                        <div>
                                            <h5 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">{{ __('dashboard.recent_cats_added') }}</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                @foreach($stats['recent_cats'] as $cat)
                                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="text-2xl">🐱</div>
                                                            <div>
                                                                <h6 class="font-medium text-gray-900 dark:text-gray-100">{{ $cat->nome }}</h6>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                    {{ $cat->razza ?? __('dashboard.breed_not_specified') }} 
                                                                    @if($cat->eta) - {{ $cat->eta_formattata }} @endif
                                                                </p>
                                                                @php
                                                                    // Logica corretta per determinare lo stato del gatto
                                                                    if ($cat->data_adozione) {
                                                                        $statusText = __('dashboard.adopted_status');
                                                                        $statusClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200';
                                                                    } elseif ($cat->disponibile_adozione) {
                                                                        $statusText = __('dashboard.available_status');
                                                                        $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                                                    } elseif (Auth::user()->role === 'proprietario') {
                                                                        $statusText = __('dashboard.owned_status');
                                                                        $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                                                    } else {
                                                                        $statusText = __('dashboard.evaluating_status');
                                                                        $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200';
                                                                    }
                                                                @endphp
                                                                <span class="inline-block px-2 py-1 text-xs rounded-full {{ $statusClass }}">
                                                                    {{ $statusText }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @break

                        @case('proprietario')
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('dashboard.proprietario_dashboard') }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400">{{ __('dashboard.proprietario_activities') }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.my_cats_title') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">{{ $stats['total_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.registered') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.available_title') }}</h4>
                                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $stats['available_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.for_adoption') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">🏠 {{ __('dashboard.given_adoption_title') }}</h4>
                                        <p class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['adopted_cats'] }}</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.given_adoption_desc') }}</p>
                                    </div>
                                </div>

                                <!-- Link gestione gatti + gatti recenti -->
                                <div class="mt-8 space-y-6">
                                    <div class="flex justify-between items-center">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.quick_actions') }}</h4>
                                        <a href="{{ route('user.cats') }}" class="inline-flex items-center px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition-colors duration-200">
                                            {{ __('dashboard.manage_my_cats') }}
                                        </a>
                                    </div>

                                    @if($stats['recent_cats']->count() > 0)
                                        <div>
                                            <h5 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-3">{{ __('dashboard.recent_cats_added') }}</h5>
                                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                                @foreach($stats['recent_cats'] as $cat)
                                                    <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg border">
                                                        <div class="flex items-center space-x-3">
                                                            <div class="text-2xl">🐱</div>
                                                            <div>
                                                                <h6 class="font-medium text-gray-900 dark:text-gray-100">{{ $cat->nome }}</h6>
                                                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                                                    {{ $cat->razza ?? __('dashboard.breed_not_specified') }} 
                                                                    @if($cat->eta) - {{ $cat->eta_formattata }} @endif
                                                                </p>
                                                                @php
                                                                    // Logica corretta per determinare lo stato del gatto
                                                                    if ($cat->data_adozione) {
                                                                        $statusText = __('dashboard.adopted_status');
                                                                        $statusClass = 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200';
                                                                    } elseif ($cat->disponibile_adozione) {
                                                                        $statusText = __('dashboard.available_status');
                                                                        $statusClass = 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200';
                                                                    } elseif (Auth::user()->role === 'proprietario') {
                                                                        $statusText = __('dashboard.owned_status');
                                                                        $statusClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200';
                                                                    } else {
                                                                        $statusText = __('dashboard.evaluating_status');
                                                                        $statusClass = 'bg-gray-100 text-gray-800 dark:bg-gray-600 dark:text-gray-200';
                                                                    }
                                                                @endphp
                                                                <span class="inline-block px-2 py-1 text-xs rounded-full {{ $statusClass }}">
                                                                    {{ $statusText }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @break



                        @case('admin')
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('dashboard.admin_dashboard') }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400">{{ __('dashboard.admin_desc') }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.total_users') }}</h4>
                                        <p class="text-3xl font-bold text-red-600 dark:text-red-400">156</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.registered_users') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.registered_cats') }}</h4>
                                        <p class="text-3xl font-bold text-red-600 dark:text-red-400">89</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.in_system') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.completed_adoptions') }}</h4>
                                        <p class="text-3xl font-bold text-red-600 dark:text-red-400">34</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.this_year') }}</p>
                                    </div>
                                </div>
                                
                                <div class="mt-8">
                                    <a href="/admin" class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg transition-colors duration-200">
                                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ __('dashboard.admin_panel') }}
                                    </a>
                                </div>
                            </div>
                            @break

                        @default
                            <div class="text-center">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                    {{ __('dashboard.unrecognized_role') }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ __('dashboard.contact_admin') }}
                                </p>
                            </div>
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</x-main-layout>
