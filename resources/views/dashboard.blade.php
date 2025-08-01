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
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.cats_for_adoption') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">12</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.available') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.active_volunteers') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">8</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.available') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.adoptions_this_month') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">5</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.completed') }}</p>
                                    </div>
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
                                        <p class="text-gray-600 dark:text-gray-400">{{ __('dashboard.volontario_activities') }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.active_assignments') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">3</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.in_progress') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.volunteer_hours') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">24</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.this_month') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">{{ __('dashboard.cats_followed') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">7</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.currently') }}</p>
                                    </div>
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
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.my_cats') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">2</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.registered') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.upcoming_visits') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">1</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.scheduled') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.saved_memories') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">15</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.special_moments') }}</p>
                                    </div>
                                </div>
                            </div>
                            @break

                        @case('veterinario')
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('dashboard.veterinario_dashboard') }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400">{{ __('dashboard.veterinario_activities') }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.patients_today') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">8</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.scheduled_visits') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.pending_reports') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">3</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.to_complete') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.cats_followed_vet') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">45</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.regular') }}</p>
                                    </div>
                                </div>
                            </div>
                            @break

                        @case('toelettatore')
                            <div class="space-y-6">
                                <div class="flex items-center space-x-3">
                                    <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM7 3h10M7 3v18h10V3M7 3a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V5a2 2 0 00-2-2"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ __('dashboard.toelettatore_dashboard') }}</h3>
                                        <p class="text-gray-600 dark:text-gray-400">{{ __('dashboard.toelettatore_activities') }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.appointments_today') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">6</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.scheduled_appointments') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.loyal_clients') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">28</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.regular_clients') }}</p>
                                    </div>
                                    <div class="bg-white dark:bg-gray-700 p-6 rounded-lg border border-gray-200 dark:border-gray-600">
                                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">{{ __('dashboard.completed_services') }}</h4>
                                        <p class="text-3xl font-bold text-orange-600 dark:text-orange-400">12</p>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">{{ __('dashboard.this_month_services') }}</p>
                                    </div>
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
