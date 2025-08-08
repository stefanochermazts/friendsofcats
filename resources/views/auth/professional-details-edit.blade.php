<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-orange-100 dark:bg-orange-900/20 rounded-lg flex items-center justify-center">
                @if(auth()->user()->role === 'veterinario')
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                    </svg>
                @endif
            </div>
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    {{ __('professional.edit_details') }}
                </h2>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ __('professional.edit_subtitle') }}
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
                    <form method="POST" action="{{ route('professional.details.update') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Nome Studio/Clinica -->
                        <div>
                            <label for="ragione_sociale" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('professional.business_name') }} <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   id="ragione_sociale" 
                                   name="ragione_sociale" 
                                   value="{{ old('ragione_sociale', $user->ragione_sociale) }}"
                                   required
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                                   placeholder="{{ __('professional.business_name_placeholder') }}">
                            @error('ragione_sociale')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Indirizzo -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label for="indirizzo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('professional.address') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="indirizzo" 
                                       name="indirizzo" 
                                       value="{{ old('indirizzo', $user->indirizzo) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="Via Roma, 123">
                                @error('indirizzo')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="citta" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('professional.city') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="citta" 
                                       name="citta" 
                                       value="{{ old('citta', $user->citta) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="Milano">
                                @error('citta')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="cap" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('professional.postal_code') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="cap" 
                                       name="cap" 
                                       value="{{ old('cap', $user->cap) }}"
                                       required
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="20121">
                                @error('cap')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="provincia" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('professional.province') }} <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="provincia" 
                                       name="provincia" 
                                       value="{{ old('provincia', $user->provincia) }}"
                                       required
                                       maxlength="3"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="MI">
                                @error('provincia')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="paese" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('professional.country') }}
                                </label>
                                <input type="text" 
                                       id="paese" 
                                       name="paese" 
                                       value="{{ old('paese', $user->paese) }}"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="Italia">
                                @error('paese')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Contatti -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="telefono" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('professional.phone') }}
                                </label>
                                <input type="tel" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="{{ old('telefono', $user->telefono) }}"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="+39 02 1234567">
                                @error('telefono')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="sito_web" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('professional.website') }}
                                </label>
                                <input type="url" 
                                       id="sito_web" 
                                       name="sito_web" 
                                       value="{{ old('sito_web', $user->sito_web) }}"
                                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                                       placeholder="https://www.studioveterinario.it">
                                @error('sito_web')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Descrizione -->
                        <div>
                            <label for="descrizione" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                {{ __('professional.description') }}
                            </label>
                            <textarea id="descrizione" 
                                      name="descrizione" 
                                      rows="4"
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-orange-500 focus:ring-orange-500"
                                      placeholder="{{ __('professional.description_placeholder') }}">{{ old('descrizione', $user->descrizione) }}</textarea>
                            @error('descrizione')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sezione Foto -->
                        <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4 flex items-center">
                                <svg class="w-5 h-5 text-orange-600 dark:text-orange-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                {{ __('professional.photos_section') }}
                            </h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                                {{ __('professional.photos_section_description') }}
                            </p>

                            <!-- Foto Principale Attuale -->
                            @if($user->foto_principale)
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('professional.current_main_photo') }}
                                </p>
                                <div class="w-32 h-32 bg-gray-100 dark:bg-gray-600 rounded-lg overflow-hidden">
                                    <img src="{{ Storage::url($user->foto_principale) }}" 
                                         alt="{{ __('professional.current_main_photo') }}"
                                         class="w-full h-full object-cover">
                                </div>
                            </div>
                            @endif

                            <!-- Foto Principale -->
                            <div class="mb-6">
                                <label for="foto_principale" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ $user->foto_principale ? __('professional.replace_main_photo') : __('professional.main_photo') }}
                                </label>
                                
                                <!-- Preview foto principale selezionata -->
                                <div id="mainPhotoPreview" class="mb-3 hidden">
                                    <div class="relative inline-block">
                                        <img id="mainPhotoImg" src="" alt="Preview" class="w-24 h-24 object-cover rounded-lg border-2 border-orange-300">
                                        <button type="button" onclick="removeMainPhoto()" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-600">
                                            ×
                                        </button>
                                        <div class="mt-1 text-xs text-gray-600" id="mainPhotoInfo"></div>
                                    </div>
                                </div>

                                <!-- Drag and Drop Area per Foto Principale -->
                                <div class="relative">
                                    <div id="mainPhotoDropZone" 
                                         class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center transition-all duration-200 hover:border-orange-400 dark:hover:border-orange-400 bg-gray-50 dark:bg-gray-700 cursor-pointer">
                                        <div class="flex flex-col items-center space-y-2">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600 dark:text-gray-300" id="mainPhotoText">
                                                {{ $user->foto_principale ? __('professional.drag_drop_replace_photo') : __('professional.drag_drop_main_photo') }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ __('professional.or_click_to_select') }}</p>
                                        </div>
                                        
                                        <input type="file" 
                                               id="foto_principale"
                                               name="foto_principale" 
                                               accept="image/jpeg,image/png,image/webp"
                                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                               onchange="handleMainPhotoSelect(this)">
                                    </div>
                                </div>
                                
                                @error('foto_principale')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="mainPhotoRequirements">
                                    {{ __('professional.photo_requirements') }}
                                </p>
                            </div>

                            <!-- Galleria Foto Attuale -->
                            @if($user->galleria_foto && count($user->galleria_foto) > 0)
                            <div class="mb-4">
                                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('professional.current_gallery') }} ({{ count($user->galleria_foto) }} {{ __('professional.photos') }})
                                </p>
                                <div class="grid grid-cols-4 md:grid-cols-6 gap-2">
                                    @foreach($user->galleria_foto as $index => $foto)
                                    <div class="aspect-square bg-gray-100 dark:bg-gray-600 rounded-lg overflow-hidden">
                                        <img src="{{ Storage::url($foto) }}" 
                                             alt="{{ __('professional.gallery_photo') }} {{ $index + 1 }}"
                                             class="w-full h-full object-cover">
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Preview galleria foto selezionate -->
                            <div id="galleryPreview" class="mb-3 hidden">
                                <p class="text-sm text-blue-600 dark:text-blue-300 mb-2">{{ __('professional.new_photos_selected') }}</p>
                                <div id="galleryPreviewGrid" class="grid grid-cols-4 md:grid-cols-6 gap-2 mb-2"></div>
                                <div class="text-xs text-gray-600" id="galleryInfo"></div>
                            </div>

                            <!-- Galleria Foto -->
                            <div>
                                <label for="galleria_foto" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    {{ __('professional.add_gallery_photos') }}
                                </label>
                                
                                <!-- Drag and Drop Area per Galleria Foto -->
                                <div class="relative">
                                    <div id="galleryDropZone" 
                                         class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center transition-all duration-200 hover:border-orange-400 dark:hover:border-orange-400 bg-gray-50 dark:bg-gray-700 cursor-pointer">
                                        <div class="flex flex-col items-center space-y-2">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-sm text-gray-600 dark:text-gray-300" id="galleryText">
                                                {{ __('professional.drag_drop_gallery') }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ __('professional.or_click_to_select') }}</p>
                                        </div>
                                        
                                        <input type="file" 
                                               id="galleria_foto"
                                               name="galleria_foto[]" 
                                               accept="image/jpeg,image/png,image/webp"
                                               multiple
                                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                               onchange="handleGallerySelect(this)">
                                    </div>
                                </div>
                                
                                @error('galleria_foto.*')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" id="galleryRequirements">
                                    {{ __('professional.gallery_requirements') }}
                                </p>
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 pt-6">
                            <button type="submit" 
                                    class="flex-1 bg-orange-500 hover:bg-orange-600 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                                {{ __('professional.update_details') }}
                            </button>
                            <a href="{{ route('dashboard') }}" 
                               class="flex-1 text-center bg-gray-200 hover:bg-gray-300 dark:bg-gray-600 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-medium py-3 px-6 rounded-lg transition-colors duration-200">
                                {{ __('professional.cancel') }}
                            </a>
                        </div>

                        @if ($errors->any())
                            <div class="mt-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700 rounded-lg">
                                <div class="text-sm text-red-600 dark:text-red-400">
                                    <p class="font-medium mb-2">{{ __('professional.errors_found') }}</p>
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

    @push('scripts')
    <script>
        // Ottieni i limiti di upload dal server
        const MAX_FILE_SIZE_MB = {{ ini_get('upload_max_filesize') ? (int) ini_get('upload_max_filesize') : 2 }};
        const MAX_FILE_SIZE_BYTES = MAX_FILE_SIZE_MB * 1024 * 1024;
        
        let selectedMainPhoto = null;
        let selectedGalleryPhotos = [];

        // Gestione Drag & Drop per foto principale
        const mainPhotoDropZone = document.getElementById('mainPhotoDropZone');
        const mainPhotoInput = document.getElementById('foto_principale');

        mainPhotoDropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            mainPhotoDropZone.classList.add('border-orange-400', 'bg-orange-50', 'dark:bg-orange-900/20');
            document.getElementById('mainPhotoText').textContent = '{{ __('professional.drop_files_here') }}';
        });

        mainPhotoDropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            mainPhotoDropZone.classList.remove('border-orange-400', 'bg-orange-50', 'dark:bg-orange-900/20');
            document.getElementById('mainPhotoText').textContent = '{{ $user->foto_principale ? __('professional.drag_drop_replace_photo') : __('professional.drag_drop_main_photo') }}';
        });

        mainPhotoDropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            mainPhotoDropZone.classList.remove('border-orange-400', 'bg-orange-50', 'dark:bg-orange-900/20');
            document.getElementById('mainPhotoText').textContent = '{{ $user->foto_principale ? __('professional.drag_drop_replace_photo') : __('professional.drag_drop_main_photo') }}';
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                handleMainPhotoFiles([files[0]]);
            }
        });

        // Gestione Drag & Drop per galleria
        const galleryDropZone = document.getElementById('galleryDropZone');
        const galleryInput = document.getElementById('galleria_foto');

        galleryDropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            galleryDropZone.classList.add('border-orange-400', 'bg-orange-50', 'dark:bg-orange-900/20');
            document.getElementById('galleryText').textContent = '{{ __('professional.drop_files_here') }}';
        });

        galleryDropZone.addEventListener('dragleave', (e) => {
            e.preventDefault();
            galleryDropZone.classList.remove('border-orange-400', 'bg-orange-50', 'dark:bg-orange-900/20');
            document.getElementById('galleryText').textContent = '{{ __('professional.drag_drop_gallery') }}';
        });

        galleryDropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            galleryDropZone.classList.remove('border-orange-400', 'bg-orange-50', 'dark:bg-orange-900/20');
            document.getElementById('galleryText').textContent = '{{ __('professional.drag_drop_gallery') }}';
            
            const files = Array.from(e.dataTransfer.files);
            if (files.length > 0) {
                handleGalleryFiles(files);
            }
        });

        function handleMainPhotoSelect(input) {
            if (input.files && input.files.length > 0) {
                handleMainPhotoFiles(Array.from(input.files));
            }
        }

        function handleGallerySelect(input) {
            if (input.files && input.files.length > 0) {
                handleGalleryFiles(Array.from(input.files));
            }
        }

        function handleMainPhotoFiles(files) {
            const file = files[0];
            if (!validateFile(file)) return;

            selectedMainPhoto = file;
            showMainPhotoPreview(file);
            
            // Aggiorna l'input file
            const dt = new DataTransfer();
            dt.items.add(file);
            mainPhotoInput.files = dt.files;
        }

        function handleGalleryFiles(files) {
            const validFiles = files.filter(file => validateFile(file));
            if (validFiles.length === 0) return;

            selectedGalleryPhotos = validFiles;
            showGalleryPreview(validFiles);
            
            // Aggiorna l'input file
            const dt = new DataTransfer();
            validFiles.forEach(file => dt.items.add(file));
            galleryInput.files = dt.files;
        }

        function validateFile(file) {
            // Controllo tipo file
            const allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert(`{{ __('professional.invalid_file_type') }}: ${file.name}\n{{ __('professional.allowed_types') }}: JPEG, PNG, WebP`);
                return false;
            }

            // Controllo dimensione file
            if (file.size > MAX_FILE_SIZE_BYTES) {
                alert(`{{ __('professional.file_too_large') }}: ${file.name}\n{{ __('professional.max_size') }}: ${MAX_FILE_SIZE_MB}MB\n{{ __('professional.current_size') }}: ${(file.size / 1024 / 1024).toFixed(2)}MB`);
                return false;
            }

            return true;
        }

        function showMainPhotoPreview(file) {
            const preview = document.getElementById('mainPhotoPreview');
            const img = document.getElementById('mainPhotoImg');
            const info = document.getElementById('mainPhotoInfo');

            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                info.textContent = `${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }

        function showGalleryPreview(files) {
            const preview = document.getElementById('galleryPreview');
            const grid = document.getElementById('galleryPreviewGrid');
            const info = document.getElementById('galleryInfo');

            grid.innerHTML = '';
            
            files.forEach((file, index) => {
                const div = document.createElement('div');
                div.className = 'relative';
                
                const img = document.createElement('img');
                img.className = 'w-16 h-16 object-cover rounded border-2 border-blue-300';
                
                const removeBtn = document.createElement('button');
                removeBtn.type = 'button';
                removeBtn.className = 'absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600';
                removeBtn.textContent = '×';
                removeBtn.onclick = () => removeGalleryPhoto(index);
                
                div.appendChild(img);
                div.appendChild(removeBtn);
                grid.appendChild(div);

                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            });

            const totalSize = files.reduce((total, file) => total + file.size, 0);
            info.textContent = `${files.length} {{ __('professional.photos') }} (${(totalSize / 1024 / 1024).toFixed(2)} MB {{ __('professional.total') }})`;
            preview.classList.remove('hidden');
        }

        function removeMainPhoto() {
            selectedMainPhoto = null;
            document.getElementById('mainPhotoPreview').classList.add('hidden');
            mainPhotoInput.value = '';
        }

        function removeGalleryPhoto(index) {
            selectedGalleryPhotos.splice(index, 1);
            
            if (selectedGalleryPhotos.length === 0) {
                document.getElementById('galleryPreview').classList.add('hidden');
                galleryInput.value = '';
            } else {
                showGalleryPreview(selectedGalleryPhotos);
                
                // Aggiorna l'input file
                const dt = new DataTransfer();
                selectedGalleryPhotos.forEach(file => dt.items.add(file));
                galleryInput.files = dt.files;
            }
        }

        // Aggiorna i testi dei requisiti con le dimensioni reali del server
        document.getElementById('mainPhotoRequirements').textContent = 
            `{{ __('professional.photo_requirements_dynamic', ['size' => '']) }}`.replace('%size%', MAX_FILE_SIZE_MB + 'MB');
        document.getElementById('galleryRequirements').textContent = 
            `{{ __('professional.gallery_requirements_dynamic', ['size' => '']) }}`.replace('%size%', MAX_FILE_SIZE_MB + 'MB');
    </script>
    @endpush
</x-main-layout>
