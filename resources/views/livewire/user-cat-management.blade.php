@use('Illuminate\Support\Facades\Storage')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
        <!-- Header -->
        <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        {{ __('cats.my_cats') }}
                    </h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">
                        {{ __('cats.manage_cats_description') }}
                    </p>
                </div>
                <button 
                    wire:click="openModal" 
                    class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                >
                    {{ __('cats.add_cat') }}
                </button>
            </div>
        </div>

        <!-- Filtri e Ricerca -->
        <div class="p-6 bg-gray-50 dark:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('cats.search_by_name') }}
                    </label>
                    <input 
                        type="text" 
                        wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('cats.search_placeholder') }}"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                    >
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('cats.breed_filter') }}
                    </label>
                    <select 
                        wire:model.live="filterRazza"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                    >
                        <option value="">{{ __('cats.all_breeds') }}</option>
                        @foreach($razze as $razza)
                            <option value="{{ $razza }}">{{ $razza }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        {{ __('cats.availability_filter') }}
                    </label>
                    <select 
                        wire:model.live="filterDisponibile"
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                    >
                        <option value="">{{ __('cats.all_status') }}</option>
                        <option value="1">{{ __('cats.available_for_adoption') }}</option>
                        <option value="0">{{ __('cats.not_available') }}</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Griglia Gatti -->
        <div class="p-6">
            @if($cats->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($cats as $cat)
                        <div wire:key="cat-{{ $cat->id }}" class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden border border-gray-200 dark:border-gray-600 hover:shadow-lg transition-shadow">
                            <!-- Foto Principale e Galleria -->
                            @php 
                                $totalPhotos = $this->getTotalPhotos($cat);
                                $allPhotos = $this->getAllPhotos($cat);
                            @endphp
                            <div class="aspect-square bg-gray-200 dark:bg-gray-600 flex items-center justify-center overflow-hidden relative {{ $totalPhotos > 0 ? 'cursor-pointer' : '' }}"
                                 @if($totalPhotos > 0) onclick="openGallery({{ $cat->id }}, {{ json_encode($allPhotos) }})" @endif>
                                @if($cat->foto_principale)
                                    <img src="{{ Storage::url($cat->foto_principale) }}" alt="{{ $cat->nome }}" 
                                         class="w-full h-full object-cover object-top" 
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                    <div class="text-6xl hidden">🐱</div>
                                @else
                                    <div class="text-7xl">🐱</div>
                                @endif
                                
                                <!-- Indicatore numero foto -->
                                @if($totalPhotos > 0)
                                    <div class="absolute top-2 right-2 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded-full">
                                        {{ trans_choice('cats.photos_count', $totalPhotos, ['count' => $totalPhotos]) }}
                                    </div>
                                @endif
                                
                                <!-- Overlay hover per galleria -->
                                @if($totalPhotos > 1)
                                    <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-30 transition-all duration-200 flex items-center justify-center">
                                        <div class="text-white opacity-0 hover:opacity-100 transition-opacity duration-200">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Info Gatto -->
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $cat->nome }}</h3>
                                    @php
                                        $stato = $this->getStatoGatto($cat);
                                    @endphp
                                    <span class="px-2 py-1 text-xs rounded-full {{ $stato['classe'] }}">
                                        {{ $stato['testo'] }}
                                    </span>
                                </div>
                                
                                <div class="space-y-1 text-sm text-gray-600 dark:text-gray-300 mb-4">
                                    @if($cat->razza)
                                        <p><span class="font-medium">🐾 {{ __('cats.breed') }}:</span> {{ $cat->razza }}</p>
                                    @endif
                                    @if($cat->eta)
                                        <p><span class="font-medium">📅 {{ __('cats.age') }}:</span> {{ $cat->eta_formattata }}</p>
                                    @endif
                                    @if($cat->sesso)
                                        <p><span class="font-medium">⚥ {{ __('cats.gender') }}:</span> {{ $cat->sesso === 'maschio' ? '♂ ' . __('cats.male') : '♀ ' . __('cats.female') }}</p>
                                    @endif
                                    <p><span class="font-medium">😺 {{ __('cats.sociality_level') }}:</span> 
                                        @if($cat->livello_socialita === 'basso')
                                            😿 {{ __('cats.low') }}
                                        @elseif($cat->livello_socialita === 'medio')
                                            😸 {{ __('cats.medium') }}
                                        @else
                                            😺 {{ __('cats.high') }}
                                        @endif
                                    </p>
                                    <p><span class="font-medium">🏥 {{ __('cats.sterilization') }}:</span> {{ $cat->sterilizzazione ? '✅ ' . __('cats.yes') : '❌ ' . __('cats.no') }}</p>
                                </div>

                                <!-- Azioni -->
                                <div class="flex space-x-2">
                                    <button 
                                        wire:key="edit-btn-{{ $cat->id }}"
                                        wire:click="openModal({{ $cat->id }})"
                                        class="flex-1 bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded text-sm font-medium transition-colors"
                                    >
                                        ✏️ {{ __('cats.edit') }}
                                    </button>
                                    @php
                                        $isProprietario = $cat->user && $cat->user->role === 'proprietario';
                                    @endphp
                                    
                                    <!-- Select per lo stato -->
                                    <div class="flex-1">
                                        <select 
                                            wire:key="status-select-{{ $cat->id }}"
                                            wire:change="updateStato({{ $cat->id }}, $event.target.value)"
                                            class="w-full bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-gray-100 text-sm rounded focus:ring-blue-500 focus:border-blue-500 p-2"
                                        >
                                            <option value="di_proprieta" {{ $cat->stato === 'di_proprieta' ? 'selected' : '' }}>
                                                {{ __('cats.owned') }}
                                            </option>
                                            <option value="adottabile" {{ $cat->stato === 'adottabile' ? 'selected' : '' }}>
                                                {{ __('cats.available') }}
                                            </option>
                                            <option value="non_adottabile" {{ $cat->stato === 'non_adottabile' ? 'selected' : '' }}>
                                                {{ __('cats.not_available') }}
                                            </option>
                                            <option value="adottato" {{ $cat->stato === 'adottato' ? 'selected' : '' }}>
                                                {{ __('cats.adopted') }}
                                            </option>
                                        </select>
                                    </div>
                                    <button 
                                        wire:key="delete-btn-{{ $cat->id }}"
                                        wire:click="deleteCat({{ $cat->id }})"
                                        wire:confirm="{{ __('cats.confirm_delete') }} {{ $cat->nome }}?"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded text-sm font-medium transition-colors"
                                    >
                                        🗑️
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Paginazione -->
                <div class="mt-6">
                    {{ $cats->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-6xl mb-4">🐱</div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">
                        {{ __('cats.no_cats_found') }}
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        @if($search || $filterRazza || $filterDisponibile !== '')
                            {{ __('cats.try_modifying_filters') }}
                        @else
                            {{ __('cats.add_first_cat') }}
                        @endif
                    </p>
                    @if(!$search && !$filterRazza && $filterDisponibile === '')
                        <button 
                            wire:click="openModal" 
                            class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg font-medium transition-colors"
                        >
                            {{ __('cats.add_first_cat_button') }}
                        </button>
                    @endif
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Form -->
    @if($showModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>
                
                <div class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                    <form wire:submit="save">
                        <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                    {{ $editingCat ? __('cats.edit_cat') . " {$editingCat->nome}" : __('cats.add_cat') }}
                                </h3>
                                <button type="button" wire:click="closeModal" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                    <span class="sr-only">{{ __('cats.close') }}</span>
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Form Grid -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Informazioni Base -->
                                <div class="space-y-4">
                                    <h4 class="font-medium text-gray-900 dark:text-white border-b pb-2">{{ __('cats.basic_info') }}</h4>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.cat_name') }} *</label>
                                        <input type="text" wire:model="nome" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                        @error('nome') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.breed') }}</label>
                                        <select wire:model="razza" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                            <option value="">{{ __('cats.select_breed') }}</option>
                                            @foreach($breedsArray as $key => $breed)
                                                <option value="{{ $key }}">{{ $breed }}</option>
                                            @endforeach
                                        </select>
                                        @error('razza') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.age') }}</label>
                                            <input type="number" wire:model="eta" min="0" max="300" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                            @error('eta') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.gender') }}</label>
                                            <select wire:model="sesso" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                                <option value="">{{ __('cats.select_gender') }}</option>
                                                <option value="maschio">♂ {{ __('cats.male') }}</option>
                                                <option value="femmina">♀ {{ __('cats.female') }}</option>
                                            </select>
                                            @error('sesso') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.weight') }}</label>
                                            <input type="number" wire:model="peso" step="0.1" min="0" max="15" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                            @error('peso') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.color') }}</label>
                                            <input type="text" wire:model="colore" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                            @error('colore') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Stato Sanitario e Comportamento -->
                                <div class="space-y-4">
                                    <h4 class="font-medium text-gray-900 dark:text-white border-b pb-2">{{ __('cats.health_behavior') }}</h4>
                                    
                                    <div class="flex space-x-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="microchip" class="rounded border-gray-300 text-orange-500 focus:border-orange-500 focus:ring-orange-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('cats.microchip') }}</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="sterilizzazione" class="rounded border-gray-300 text-orange-500 focus:border-orange-500 focus:ring-orange-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">{{ __('cats.sterilization') }}</span>
                                        </label>
                                    </div>

                                    @if($microchip)
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.microchip_number') }}</label>
                                            <input type="text" wire:model="numero_microchip" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                            @error('numero_microchip') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    @endif

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.sociality_level_required') }}</label>
                                        <select wire:model="livello_socialita" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500">
                                            <option value="basso">{{ __('cats.low_shy') }}</option>
                                            <option value="medio">{{ __('cats.medium_normal') }}</option>
                                            <option value="alto">{{ __('cats.high_social') }}</option>
                                        </select>
                                        @error('livello_socialita') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.behavior') }}</label>
                                        <textarea wire:model="comportamento" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500" placeholder="{{ __('cats.behavior_description') }}"></textarea>
                                        @error('comportamento') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.health_status') }}</label>
                                        <textarea wire:model="stato_sanitario" rows="2" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500" placeholder="{{ __('cats.health_notes') }}"></textarea>
                                        @error('stato_sanitario') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <label class="flex items-center">
                                            <input type="checkbox" wire:model="disponibile_adozione" class="rounded border-gray-300 text-orange-500 focus:border-orange-500 focus:ring-orange-500">
                                            <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                                {{ __('cats.available_adoption_label') }}
                                                @if(auth()->user()->role === 'proprietario')
                                                    <small class="block text-xs text-gray-500 mt-1">
                                                        {{ __('cats.owner_adoption_note') }}
                                                    </small>
                                                @endif
                                            </span>
                                        </label>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.main_photo') }}</label>
                                        
                                        <!-- Preview foto esistente -->
                                        @if($editingCat && $editingCat->foto_principale)
                                            <div class="mb-3 p-3 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ __('cats.current_photo') }}</p>
                                                <img src="{{ Storage::url($editingCat->foto_principale) }}" 
                                                     alt="{{ __('cats.current_photo') }}" 
                                                     class="w-16 h-16 object-cover rounded-lg border"
                                                     onerror="this.style.display='none'; this.nextElementSibling.style.display='inline-block';">
                                                <span class="hidden text-2xl">🐱</span>
                                            </div>
                                        @endif
                                        
                                        <!-- Preview nuova foto (durante upload) -->
                                        @if($foto_principale)
                                            <div class="mb-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg" wire:loading.remove wire:target="foto_principale">
                                                <p class="text-sm text-blue-600 dark:text-blue-300 mb-2">{{ __('cats.new_photo_selected') }}</p>
                                                <img src="{{ $foto_principale->temporaryUrl() }}" 
                                                     alt="{{ __('cats.new_photo_selected') }}" 
                                                     class="w-16 h-16 object-cover rounded-lg border border-blue-300">
                                            </div>
                                        @endif
                                        
                                        <!-- Loading durante upload -->
                                        <div wire:loading wire:target="foto_principale" class="mb-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                            <p class="text-sm text-yellow-600 dark:text-yellow-300">
                                                {{ __('cats.loading_photo') }}
                                            </p>
                                        </div>
                                        
                                        <!-- Drag and Drop Area per Foto Principale -->
                                        <div class="relative">
                                            <div id="mainPhotoDropZone" 
                                                 class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center transition-all duration-200 hover:border-orange-400 dark:hover:border-orange-400 bg-gray-50 dark:bg-gray-700 cursor-pointer"
                                                 x-data="{ 
                                                     isDragOver: false,
                                                     handleDragOver(e) {
                                                         e.preventDefault();
                                                         this.isDragOver = true;
                                                     },
                                                     handleDragLeave(e) {
                                                         e.preventDefault();
                                                         this.isDragOver = false;
                                                     },
                                                     handleDrop(e) {
                                                         e.preventDefault();
                                                         this.isDragOver = false;
                                                         const files = e.dataTransfer.files;
                                                         if (files.length > 0) {
                                                             const input = document.getElementById('mainPhotoInput');
                                                             input.files = files;
                                                             input.dispatchEvent(new Event('change', { bubbles: true }));
                                                         }
                                                     }
                                                 }"
                                                 x-on:dragover="handleDragOver"
                                                 x-on:dragleave="handleDragLeave"
                                                 x-on:drop="handleDrop"
                                                 :class="{ 'border-orange-400 bg-orange-50 dark:bg-orange-900/20': isDragOver }">
                                                
                                                <div class="flex flex-col items-center space-y-2">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    <p class="text-sm text-gray-600 dark:text-gray-300" x-text="isDragOver ? '{{ __('cats.drop_files_here') }}' : '{{ __('cats.drag_drop_main_photo') }}'"></p>
                                                    <p class="text-xs text-gray-500">{{ __('cats.or_click_to_select') }}</p>
                                                </div>
                                                
                                                <input type="file" 
                                                       id="mainPhotoInput"
                                                       wire:model="foto_principale" 
                                                       accept="image/*" 
                                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ __('cats.supported_formats_dynamic', ['max' => $maxFileSizeMB]) }}
                                        </p>
                                        @error('foto_principale') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

<div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">{{ __('cats.photo_gallery') }}</label>
                                        
                                        <!-- Galleria esistente con possibilità di rimozione -->
                                        @if($editingCat && $editingCat->galleria_foto && count($editingCat->galleria_foto) > 0)
                                            <div class="mb-3 p-3 bg-gray-50 dark:bg-gray-600 rounded-lg">
                                                <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">{{ __('cats.current_gallery') }} ({{ count($editingCat->galleria_foto) }})</p>
                                                <div class="grid grid-cols-6 gap-2">
                                                    @foreach($editingCat->galleria_foto as $index => $foto)
                                                        <div class="relative group">
                                                            <img src="{{ Storage::url($foto) }}" 
                                                                 alt="{{ __('cats.current_gallery') }}" 
                                                                 class="w-12 h-12 object-cover rounded border"
                                                                 onerror="this.style.display='none';">
                                                            
                                                            <!-- Pulsante rimozione -->
                                                            <button type="button"
                                                                    wire:click="removeGalleryPhoto({{ $index }})"
                                                                    class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 hover:bg-red-600 text-white rounded-full text-xs opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center"
                                                                    title="{{ __('cats.remove_photo') }}">
                                                                ×
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Preview nuove foto -->
                                        @if($galleria_foto && count($galleria_foto) > 0)
                                            <div class="mb-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg" wire:loading.remove wire:target="galleria_foto">
                                                <p class="text-sm text-blue-600 dark:text-blue-300 mb-2">{{ __('cats.new_photos_selected') }}</p>
                                                <div class="grid grid-cols-6 gap-2">
                                                    @foreach($galleria_foto as $foto)
                                                        <img src="{{ $foto->temporaryUrl() }}" 
                                                             alt="{{ __('cats.new_photos_selected') }}" 
                                                             class="w-12 h-12 object-cover rounded border border-blue-300">
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Loading durante upload -->
                                        <div wire:loading wire:target="galleria_foto" class="mb-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                                            <p class="text-sm text-yellow-600 dark:text-yellow-300">
                                                {{ __('cats.loading_gallery') }}
                                            </p>
                                        </div>
                                        
                                        <!-- Drag and Drop Area per Galleria Foto -->
                                        <div class="relative">
                                            <div id="galleryDropZone" 
                                                 class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center transition-all duration-200 hover:border-orange-400 dark:hover:border-orange-400 bg-gray-50 dark:bg-gray-700 cursor-pointer"
                                                 x-data="{ 
                                                     isDragOver: false,
                                                     handleDragOver(e) {
                                                         e.preventDefault();
                                                         this.isDragOver = true;
                                                     },
                                                     handleDragLeave(e) {
                                                         e.preventDefault();
                                                         this.isDragOver = false;
                                                     },
                                                     handleDrop(e) {
                                                         e.preventDefault();
                                                         this.isDragOver = false;
                                                         const files = e.dataTransfer.files;
                                                         if (files.length > 0) {
                                                             const input = document.getElementById('galleryInput');
                                                             input.files = files;
                                                             input.dispatchEvent(new Event('change', { bubbles: true }));
                                                         }
                                                     }
                                                 }"
                                                 x-on:dragover="handleDragOver"
                                                 x-on:dragleave="handleDragLeave"
                                                 x-on:drop="handleDrop"
                                                 :class="{ 'border-orange-400 bg-orange-50 dark:bg-orange-900/20': isDragOver }">
                                                
                                                <div class="flex flex-col items-center space-y-2">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                    </svg>
                                                    <p class="text-sm text-gray-600 dark:text-gray-300" x-text="isDragOver ? '{{ __('cats.drop_files_here') }}' : '{{ __('cats.drag_drop_gallery') }}'"></p>
                                                    <p class="text-xs text-gray-500">{{ __('cats.or_click_to_select') }}</p>
                                                </div>
                                                
                                                <input type="file" 
                                                       id="galleryInput"
                                                       wire:model="galleria_foto" 
                                                       accept="image/*" 
                                                       multiple
                                                       class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                            </div>
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ __('cats.gallery_info_dynamic', ['max' => $maxFileSizeMB, 'max_photos' => 10]) }}
                                        </p>
                                        @if($editingCat && $editingCat->galleria_foto && count($editingCat->galleria_foto) > 0)
                                            <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">
                                                💡 {{ __('cats.add_photos_to_gallery') }}
                                            </p>
                                        @endif
                                        @error('galleria_foto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-orange-500 text-base font-medium text-white hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:ml-3 sm:w-auto sm:text-sm">
                                {{ $editingCat ? '💾 ' . __('cats.save') : '➕ ' . __('cats.save') }}
                            </button>
                            <button type="button" wire:click="closeModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm dark:bg-gray-600 dark:text-white dark:border-gray-500 dark:hover:bg-gray-700">
                                ❌ {{ __('cats.cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    <!-- Galleria Foto Modal -->
    <div id="photoGallery" class="hidden fixed inset-0 bg-black bg-opacity-90 z-50 flex items-center justify-center">
        <div class="relative max-w-6xl max-h-full w-full h-full flex items-center justify-center">
            <!-- Close Button -->
            <button onclick="closeGallery()" class="absolute top-6 right-6 text-white hover:text-gray-300 z-10 bg-black bg-opacity-50 rounded-full p-2 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <!-- Photo Container -->
            <div class="relative w-full h-full flex items-center justify-center px-20 py-16">
                <!-- Photo -->
                <img id="galleryImage" src="" alt="" class="max-w-full max-h-full object-contain shadow-2xl">
            </div>
            
            <!-- Previous Button -->
            <button id="prevBtn" onclick="previousPhoto()" class="absolute left-6 top-1/2 transform -translate-y-1/2 text-white hover:text-orange-400 z-10 bg-black bg-opacity-50 rounded-full p-3 transition-all hover:bg-opacity-70 hover:scale-110">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <!-- Next Button -->
            <button id="nextBtn" onclick="nextPhoto()" class="absolute right-6 top-1/2 transform -translate-y-1/2 text-white hover:text-orange-400 z-10 bg-black bg-opacity-50 rounded-full p-3 transition-all hover:bg-opacity-70 hover:scale-110">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
            
            <!-- Photo Counter - Posizionato in basso -->
            <div id="photoCounter" class="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-white text-lg font-medium bg-black bg-opacity-60 px-6 py-3 rounded-full backdrop-blur-sm">
                <span id="currentPhoto">1</span> / <span id="totalPhotos">1</span>
            </div>
        </div>
    </div>

    <!-- Success Messages -->
    @if (session()->has('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            ✅ {{ session('success') }}
        </div>
    @endif
</div>

<script>
let currentGallery = [];
let currentPhotoIndex = 0;

function openGallery(catId, photos) {
    currentGallery = photos.map(photo => '/storage/' + photo);
    currentPhotoIndex = 0;
    
    document.getElementById('photoGallery').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
    
    showCurrentPhoto();
    updateNavButtons();
}

function closeGallery() {
    document.getElementById('photoGallery').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function showCurrentPhoto() {
    if (currentGallery.length > 0) {
        document.getElementById('galleryImage').src = currentGallery[currentPhotoIndex];
        document.getElementById('currentPhoto').textContent = currentPhotoIndex + 1;
        document.getElementById('totalPhotos').textContent = currentGallery.length;
    }
}

function updateNavButtons() {
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    
    if (currentGallery.length <= 1) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
    } else {
        prevBtn.style.display = 'block';
        nextBtn.style.display = 'block';
        
        // Disabilita visivamente i pulsanti quando non utilizzabili
        if (currentPhotoIndex === 0) {
            prevBtn.style.opacity = '0.3';
            prevBtn.style.cursor = 'not-allowed';
        } else {
            prevBtn.style.opacity = '1';
            prevBtn.style.cursor = 'pointer';
        }
        
        if (currentPhotoIndex === currentGallery.length - 1) {
            nextBtn.style.opacity = '0.3';
            nextBtn.style.cursor = 'not-allowed';
        } else {
            nextBtn.style.opacity = '1';
            nextBtn.style.cursor = 'pointer';
        }
    }
}

function previousPhoto() {
    if (currentPhotoIndex > 0) {
        currentPhotoIndex--;
        showCurrentPhoto();
        updateNavButtons();
    }
}

function nextPhoto() {
    if (currentPhotoIndex < currentGallery.length - 1) {
        currentPhotoIndex++;
        showCurrentPhoto();
        updateNavButtons();
    }
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    if (!document.getElementById('photoGallery').classList.contains('hidden')) {
        if (e.key === 'Escape') {
            closeGallery();
        } else if (e.key === 'ArrowLeft') {
            previousPhoto();
        } else if (e.key === 'ArrowRight') {
            nextPhoto();
        }
    }
});

// Click outside to close
document.getElementById('photoGallery').addEventListener('click', function(e) {
    if (e.target === this) {
        closeGallery();
    }
});
</script>
