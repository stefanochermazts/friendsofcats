<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        {{-- Benvenuto --}}
        <div class="col-span-1 lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">
                        Benvenuto in FriendsOfCats Admin
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Gestisci la piattaforma dedicata ai gatti e alla loro comunità.
                    </p>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-lg">
                            <h3 class="font-semibold text-orange-800 dark:text-orange-200">Gestione Utenti</h3>
                            <p class="text-sm text-orange-600 dark:text-orange-400">Gestisci tutti gli utenti della piattaforma</p>
                        </div>
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <h3 class="font-semibold text-blue-800 dark:text-blue-200">Gestione Gatti</h3>
                            <p class="text-sm text-blue-600 dark:text-blue-400">Gestisci le schede dei gatti</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg">
                            <h3 class="font-semibold text-green-800 dark:text-green-200">Adozioni</h3>
                            <p class="text-sm text-green-600 dark:text-green-400">Gestisci le adozioni</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Azioni Rapide --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Azioni Rapide
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('filament.admin.resources.users.create') }}" 
                       class="flex items-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg hover:bg-orange-100 dark:hover:bg-orange-900/30 transition-colors">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-orange-800 dark:text-orange-200">Nuovo Utente</p>
                            <p class="text-xs text-orange-600 dark:text-orange-400">Registra un nuovo utente</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('filament.admin.resources.users.index') }}" 
                       class="flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-blue-800 dark:text-blue-200">Gestione Utenti</p>
                            <p class="text-xs text-blue-600 dark:text-blue-400">Visualizza tutti gli utenti</p>
                        </div>
                    </a>

                    <a href="{{ route('filament.admin.resources.cats.index') }}" 
                       class="flex items-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-purple-800 dark:text-purple-200">Gestione Gatti</p>
                            <p class="text-xs text-purple-600 dark:text-purple-400">Visualizza tutti i gatti</p>
                        </div>
                    </a>

                    <a href="{{ route('filament.admin.resources.cats.create') }}" 
                       class="flex items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800 dark:text-green-200">Nuovo Gatto</p>
                            <p class="text-xs text-green-600 dark:text-green-400">Aggiungi un nuovo gatto</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        {{-- Statistiche Recenti --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">
                    Statistiche Recenti
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Utenti registrati oggi</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ \App\Models\User::whereDate('created_at', today())->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Utenti questa settimana</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ \App\Models\User::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">Utenti questo mese</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ \App\Models\User::whereMonth('created_at', now()->month)->count() }}
                        </span>
                    </div>
                    <hr class="my-3 border-gray-200 dark:border-gray-600">
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">🐱 Gatti totali</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ \App\Models\Cat::count() }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">💖 Disponibili per adozione</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ \App\Models\Cat::where('disponibile_adozione', true)->count() }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">✅ Già adottati</span>
                        <span class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ \App\Models\Cat::whereNotNull('data_adozione')->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page> 