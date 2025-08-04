<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('association.details_title') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('association.details_subtitle') }}
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    
                    @if (session('success'))
                        <div class="mb-6 bg-green-100 dark:bg-green-900/20 border border-green-400 dark:border-green-600 text-green-700 dark:text-green-400 px-4 py-3 rounded">
                            ✅ {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-6 bg-red-100 dark:bg-red-900/20 border border-red-400 dark:border-red-600 text-red-700 dark:text-red-400 px-4 py-3 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="text-center mb-8">
                        <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            {{ __('association.complete_details') }}
                        </h3>
                        <p class="text-gray-600 dark:text-gray-400">
                            {{ __('association.complete_details_desc') }}
                        </p>
                    </div>

                    <form method="POST" action="{{ route('association.details.store') }}" class="space-y-6">
                        @csrf
                        
                        <!-- Informazioni Base -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                {{ __('association.basic_info') }}
                            </h4>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Ragione Sociale -->
                                <div>
                                    <x-input-label for="ragione_sociale" :value="__('association.ragione_sociale')" />
                                    <x-text-input id="ragione_sociale" name="ragione_sociale" type="text" 
                                        class="mt-1 block w-full" 
                                        :value="old('ragione_sociale')" 
                                        required 
                                        autofocus />
                                    <x-input-error :messages="$errors->get('ragione_sociale')" class="mt-2" />
                                </div>

                                <!-- Telefono -->
                                <div>
                                    <x-input-label for="telefono" :value="__('association.telefono')" />
                                    <x-text-input id="telefono" name="telefono" type="tel" 
                                        class="mt-1 block w-full" 
                                        :value="old('telefono')" />
                                    <x-input-error :messages="$errors->get('telefono')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Indirizzo -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                {{ __('association.address_info') }}
                            </h4>
                            
                            <div class="space-y-4">
                                <!-- Indirizzo -->
                                <div>
                                    <x-input-label for="indirizzo" :value="__('association.indirizzo')" />
                                    <x-text-input id="indirizzo" name="indirizzo" type="text" 
                                        class="mt-1 block w-full" 
                                        :value="old('indirizzo')" 
                                        required />
                                    <x-input-error :messages="$errors->get('indirizzo')" class="mt-2" />
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <!-- Città -->
                                    <div>
                                        <x-input-label for="citta" :value="__('association.citta')" />
                                        <x-text-input id="citta" name="citta" type="text" 
                                            class="mt-1 block w-full" 
                                            :value="old('citta')" 
                                            required />
                                        <x-input-error :messages="$errors->get('citta')" class="mt-2" />
                                    </div>

                                    <!-- CAP -->
                                    <div>
                                        <x-input-label for="cap" :value="__('association.cap')" />
                                        <x-text-input id="cap" name="cap" type="text" 
                                            class="mt-1 block w-full" 
                                            :value="old('cap')" 
                                            required />
                                        <x-input-error :messages="$errors->get('cap')" class="mt-2" />
                                    </div>

                                    <!-- Provincia -->
                                    <div>
                                        <x-input-label for="provincia" :value="__('association.provincia')" />
                                        <x-text-input id="provincia" name="provincia" type="text" 
                                            class="mt-1 block w-full" 
                                            :value="old('provincia')" 
                                            required 
                                            maxlength="3" />
                                        <x-input-error :messages="$errors->get('provincia')" class="mt-2" />
                                    </div>
                                </div>

                                <!-- Paese -->
                                <div>
                                    <x-input-label for="paese" :value="__('association.paese')" />
                                    <x-text-input id="paese" name="paese" type="text" 
                                        class="mt-1 block w-full" 
                                        :value="old('paese', 'Italia')" 
                                        required />
                                    <x-input-error :messages="$errors->get('paese')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Informazioni Aggiuntive -->
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-6">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                {{ __('association.additional_info') }}
                            </h4>
                            
                            <div class="space-y-4">
                                <!-- Sito Web -->
                                <div>
                                    <x-input-label for="sito_web" :value="__('association.sito_web')" />
                                    <x-text-input id="sito_web" name="sito_web" type="url" 
                                        class="mt-1 block w-full" 
                                        :value="old('sito_web')" 
                                        placeholder="https://www.example.com" />
                                    <x-input-error :messages="$errors->get('sito_web')" class="mt-2" />
                                </div>

                                <!-- Descrizione -->
                                <div>
                                    <x-input-label for="descrizione" :value="__('association.descrizione')" />
                                    <textarea id="descrizione" name="descrizione" 
                                        class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-orange-500 dark:focus:border-orange-400 focus:ring-orange-500 dark:focus:ring-orange-400 rounded-md shadow-sm" 
                                        rows="4" 
                                        placeholder="{{ __('association.descrizione_placeholder') }}">{{ old('descrizione') }}</textarea>
                                    <x-input-error :messages="$errors->get('descrizione')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <!-- Pulsanti -->
                        <div class="flex items-center justify-end space-x-4">
                            <x-secondary-button type="button" onclick="window.history.back()">
                                {{ __('association.back') }}
                            </x-secondary-button>
                            
                            <x-primary-button>
                                {{ __('association.save_details') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-main-layout> 