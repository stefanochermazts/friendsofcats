<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('dashboard.volunteer_association_setup') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('dashboard.volunteer_association_setup_subtitle') }}
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

            <!-- Form -->
            <form method="POST" action="{{ route('volunteer.association.store') }}">
                @csrf

                <!-- Association Selection -->
                <div class="mb-6">
                    <label for="associazione_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        {{ __('dashboard.select_association') }}
                    </label>
                    
                    <select name="associazione_id" id="associazione_id" 
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                        <option value="">{{ __('dashboard.independent_volunteer') }}</option>
                        @foreach($associazioni as $associazione)
                            <option value="{{ $associazione->id }}" {{ old('associazione_id') == $associazione->id ? 'selected' : '' }}>
                                {{ $associazione->ragione_sociale ?? $associazione->name }}
                                @if($associazione->citta)
                                    - {{ $associazione->citta }}
                                @endif
                                @if($associazione->provincia)
                                    ({{ $associazione->provincia }})
                                @endif
                            </option>
                        @endforeach
                    </select>
                    
                    <!-- Messaggio di stato Select2 -->
                    <div id="select2-status" class="mt-2 text-sm text-gray-600 dark:text-gray-400" style="display: none;">
                        🔍 Ricerca avanzata attiva - digita per filtrare le associazioni
                    </div>
                    
                    @error('associazione_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Information Box -->
                <div class="mb-6 p-4 bg-orange-50 dark:bg-orange-900/20 border border-orange-200 dark:border-orange-700 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-orange-600 dark:text-orange-400 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-orange-800 dark:text-orange-200">
                            <p class="font-medium mb-1">{{ __('dashboard.volunteer_options_title') }}</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>{{ __('dashboard.volunteer_with_association') }}</li>
                                <li>{{ __('dashboard.volunteer_independent') }}</li>
                            </ul>
                            <p class="mt-2 text-xs">{{ __('dashboard.volunteer_can_change') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex flex-col space-y-3">
                    <button type="submit" 
                            class="w-full bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                        {{ __('dashboard.continue') }}
                    </button>
                    
                    <a href="{{ route('dashboard') }}" 
                       class="w-full text-center bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-medium py-3 px-4 rounded-lg transition-colors duration-200">
                        {{ __('dashboard.skip_for_now') }}
                    </a>
                </div>

                @if ($errors->any())
                    <div class="mt-4 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
                        <div class="text-sm text-red-600 dark:text-red-400">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <style>
            /* Custom styling per Select2 dark mode */
            .select2-container--default .select2-selection--single {
                height: 42px !important;
                border-radius: 0.5rem !important;
                border: 1px solid #d1d5db !important;
                background-color: white !important;
            }
            
            .dark .select2-container--default .select2-selection--single {
                background-color: #374151 !important;
                border-color: #4b5563 !important;
                color: white !important;
            }
            
            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: 40px !important;
                padding-left: 12px !important;
                color: #1f2937 !important;
            }
            
            .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
                color: white !important;
            }
            
            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 40px !important;
            }
            
            .select2-container--default.select2-container--focus .select2-selection--single {
                border-color: #f97316 !important;
                box-shadow: 0 0 0 1px #f97316 !important;
            }
            
            .select2-dropdown {
                border-radius: 0.5rem !important;
                border: 1px solid #d1d5db !important;
            }
            
            .dark .select2-dropdown {
                background-color: #374151 !important;
                border-color: #4b5563 !important;
            }
            
            .dark .select2-results__option {
                background-color: #374151 !important;
                color: white !important;
            }
            
            .dark .select2-results__option--highlighted {
                background-color: #f97316 !important;
                color: white !important;
            }
            
            .select2-search__field {
                border-radius: 0.375rem !important;
                border: 1px solid #d1d5db !important;
                padding: 8px !important;
            }
            
            .dark .select2-search__field {
                background-color: #4b5563 !important;
                border-color: #6b7280 !important;
                color: white !important;
            }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                console.log('🔧 Inizializzazione Select2...');
                console.log('jQuery disponibile:', typeof jQuery !== 'undefined');
                console.log('Select2 disponibile:', typeof jQuery.fn.select2 !== 'undefined');
                console.log('Elemento trovato:', $('#associazione_id').length);
                
                // Verifica se jQuery e Select2 sono caricati
                if (typeof jQuery === 'undefined') {
                    console.error('❌ jQuery non è caricato!');
                    return;
                }
                
                if (typeof jQuery.fn.select2 === 'undefined') {
                    console.error('❌ Select2 non è caricato!');
                    return;
                }
                
                // Inizializza Select2 per le associazioni
                $('#associazione_id').select2({
                    placeholder: '{{ __("dashboard.search_association_placeholder") }}',
                    allowClear: true,
                    ajax: {
                        url: '{{ route("api.associations.search") }}',
                        dataType: 'json',
                        delay: 300,
                        data: function (params) {
                            return {
                                search: params.term,
                                page: params.page || 1
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;
                            
                            return {
                                results: data.data.map(function(association) {
                                    return {
                                        id: association.id,
                                        text: association.ragione_sociale + 
                                              (association.citta ? ' - ' + association.citta : '') +
                                              (association.provincia ? ' (' + association.provincia + ')' : '')
                                    };
                                }),
                                pagination: {
                                    more: data.has_more_pages
                                }
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 2,
                    language: {
                        inputTooShort: function() {
                            return '{{ __("dashboard.select2_min_chars") }}';
                        },
                        searching: function() {
                            return '{{ __("dashboard.select2_searching") }}';
                        },
                        noResults: function() {
                            return '{{ __("dashboard.select2_no_results") }}';
                        },
                        loadingMore: function() {
                            return '{{ __("dashboard.select2_loading_more") }}';
                        }
                    },
                    templateResult: function(association) {
                        if (association.loading) {
                            return '{{ __("dashboard.select2_searching") }}';
                        }
                        
                        if (!association.id) {
                            return association.text;
                        }
                        
                        var parts = association.text.split(' - ');
                        var name = parts[0];
                        var location = parts[1] || '';
                        
                        var $result = $('<div class="select2-result-association">' +
                            '<div class="font-medium text-gray-900 dark:text-gray-100">' + name + '</div>' +
                            (location ? '<div class="text-sm text-gray-600 dark:text-gray-400">📍 ' + location + '</div>' : '') +
                            '</div>');
                        
                        return $result;
                    },
                    templateSelection: function(association) {
                        if (!association.id || association.id === '') {
                            return '{{ __("dashboard.independent_volunteer") }}';
                        }
                        return association.text.split(' - ')[0];
                    }
                });
                
                console.log('✅ Select2 inizializzato con successo!');
                
                // Mostra messaggio di stato
                $('#select2-status').show();
                
                // Pre-carica l'associazione selezionata se c'è un valore old
                @if(old('associazione_id'))
                    $('#associazione_id').trigger('change');
                @endif
            });
        </script>
    @endpush
</x-main-layout>
