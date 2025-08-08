<x-main-layout>
    <div class="bg-white dark:bg-gray-900 min-h-screen">
        <!-- Hero Section -->
        <div class="bg-gradient-to-r from-blue-50 to-green-50 dark:from-gray-800 dark:to-gray-800 py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:grid lg:grid-cols-3 lg:gap-8 items-start">
                    
                    <!-- Foto Principale -->
                    <div class="lg:col-span-1 mb-8 lg:mb-0">
                        <div class="aspect-square bg-white dark:bg-gray-700 rounded-2xl shadow-lg overflow-hidden">
                            @if($professional->foto_principale)
                                <img src="{{ Storage::url($professional->foto_principale) }}" 
                                     alt="{{ $professional->ragione_sociale }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-600 dark:to-gray-700">
                                    @if($professional->role === 'veterinario')
                                        <svg class="w-24 h-24 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-24 h-24 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                        </svg>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Informazioni Principali -->
                    <div class="lg:col-span-2">
                        <!-- Badge e Nome -->
                        <div class="mb-6">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mb-4
                                {{ $professional->role === 'veterinario' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($professional->role === 'veterinario')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                                    @endif
                                </svg>
                                {{ __('professionals.' . $professional->role) }}
                            </span>
                            
                            <h1 class="text-4xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                                {{ $professional->ragione_sociale }}
                            </h1>
                        </div>

                        <!-- Informazioni di Contatto -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Indirizzo -->
                            <div class="flex items-start space-x-3 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                <div class="flex-shrink-0">
                                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">
                                        {{ __('professionals.address') }}
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400">
                                        {{ $professional->indirizzo }}<br>
                                        {{ $professional->cap }} {{ $professional->citta }}
                                        @if($professional->provincia) ({{ $professional->provincia }}) @endif
                                        @if($professional->paese && $professional->paese !== 'Italia')<br>{{ $professional->paese }}@endif
                                    </p>
                                    @if($professional->latitude && $professional->longitude)
                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $professional->latitude }},{{ $professional->longitude }}" 
                                       target="_blank"
                                       class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 mt-2">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                        </svg>
                                        {{ __('professionals.view_on_maps') }}
                                    </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Contatti -->
                            <div class="space-y-4">
                                @if($professional->telefono)
                                <div class="flex items-center space-x-3 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">
                                            {{ __('professionals.phone') }}
                                        </h3>
                                        <a href="tel:{{ $professional->telefono }}" 
                                           class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                            {{ $professional->telefono }}
                                        </a>
                                    </div>
                                </div>
                                @endif

                                @if($professional->sito_web)
                                <div class="flex items-center space-x-3 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">
                                            {{ __('professionals.website') }}
                                        </h3>
                                        <a href="{{ $professional->sito_web }}" 
                                           target="_blank"
                                           class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 break-all">
                                            {{ $professional->sito_web }}
                                        </a>
                                    </div>
                                </div>
                                @endif

                                @if($professional->email)
                                <div class="flex items-center space-x-3 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                                    <div class="flex-shrink-0">
                                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-1">
                                            {{ __('professionals.contact_request') }}
                                        </h3>
                                        <div class="flex items-center gap-3">
                                            <a href="mailto:{{ $professional->email }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400">
                                                {{ $professional->email }}
                                            </a>
                                            <a href="{{ route('contact', ['professional_id' => $professional->id, 'professional_name' => $professional->ragione_sociale]) }}"
                                               class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-sm">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 15a2 2 0 01-2 2H7l-4 4V5a2 2 0 012-2h14a2 2 0 012 2z" />
                                                </svg>
                                                {{ __('professionals.write_message') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descrizione e Galleria -->
        <div class="py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                
                @if($professional->descrizione)
                <!-- Descrizione Servizi -->
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                        {{ __('professionals.services_description') }}
                    </h2>
                    <div class="bg-white dark:bg-gray-800 rounded-xl p-8 shadow-lg">
                        <p class="text-lg text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $professional->descrizione }}
                        </p>
                    </div>
                </div>
                @endif

                @if(count($allPhotos) > 1)
                <!-- Galleria Foto -->
                <div class="mb-12">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                        {{ __('professionals.photo_gallery') }}
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($allPhotos as $index => $foto)
                        <div class="aspect-square bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden cursor-pointer hover:opacity-90 transition-opacity relative group"
                             onclick="openProfessionalGallery({{ $professional->id }}, {{ json_encode($allPhotos) }}, {{ $index }})">
                            <img src="{{ Storage::url($foto) }}" 
                                 alt="{{ $professional->ragione_sociale }} - {{ __('professionals.photo') }} {{ $index + 1 }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                            <div class="hidden w-full h-full items-center justify-center text-4xl">📷</div>
                            
                            @if($index === 0 && $professional->foto_principale)
                            <div class="absolute top-2 left-2 bg-blue-500 text-white text-xs px-2 py-1 rounded-full font-medium opacity-0 group-hover:opacity-100 transition-opacity">
                                {{ __('professionals.main_photo') }}
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-3 text-center">
                        {{ __('professionals.click_to_view_fullsize') }}
                    </p>
                </div>
                @endif

                <!-- Azioni -->
                <div class="text-center">
                    <a href="{{ route('professionals.index') }}" 
                       class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 rounded-lg text-base font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        {{ __('professionals.back_to_directory') }}
                    </a>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal Gallery -->
    <div id="professionalGalleryModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center">
        <div class="relative max-w-4xl max-h-full p-4">
            <button onclick="closeProfessionalGallery()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            
            <img id="professionalGalleryImage" src="" alt="" class="max-w-full max-h-full object-contain">
            
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-black bg-opacity-50 text-white px-4 py-2 rounded-lg">
                <span id="professionalImageCounter">1 / 1</span>
            </div>

            <button onclick="previousProfessionalImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <button onclick="nextProfessionalImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white hover:text-gray-300">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>
        </div>
    </div>

    @push('scripts')
    <script>
        let currentProfessionalImages = [];
        let currentProfessionalIndex = 0;

        function openProfessionalGallery(professionalId, images, startIndex = 0) {
            currentProfessionalImages = images;
            currentProfessionalIndex = startIndex;
            
            document.getElementById('professionalGalleryModal').classList.remove('hidden');
            updateProfessionalGalleryImage();
        }

        function closeProfessionalGallery() {
            document.getElementById('professionalGalleryModal').classList.add('hidden');
        }

        function previousProfessionalImage() {
            currentProfessionalIndex = (currentProfessionalIndex - 1 + currentProfessionalImages.length) % currentProfessionalImages.length;
            updateProfessionalGalleryImage();
        }

        function nextProfessionalImage() {
            currentProfessionalIndex = (currentProfessionalIndex + 1) % currentProfessionalImages.length;
            updateProfessionalGalleryImage();
        }

        function updateProfessionalGalleryImage() {
            const image = document.getElementById('professionalGalleryImage');
            const counter = document.getElementById('professionalImageCounter');
            
            image.src = `/storage/${currentProfessionalImages[currentProfessionalIndex]}`;
            counter.textContent = `${currentProfessionalIndex + 1} / ${currentProfessionalImages.length}`;
        }

        // Keyboard navigation
        document.addEventListener('keydown', function(e) {
            const modal = document.getElementById('professionalGalleryModal');
            if (!modal.classList.contains('hidden')) {
                if (e.key === 'Escape') {
                    closeProfessionalGallery();
                } else if (e.key === 'ArrowLeft') {
                    previousProfessionalImage();
                } else if (e.key === 'ArrowRight') {
                    nextProfessionalImage();
                }
            }
        });

        // Close modal on background click
        document.getElementById('professionalGalleryModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeProfessionalGallery();
            }
        });
    </script>
    @endpush
</x-main-layout>
