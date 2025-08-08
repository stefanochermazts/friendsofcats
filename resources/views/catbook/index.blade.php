<x-main-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-1 sm:px-4 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                    🐾 {{ __('catbook.title') }}
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    {{ __('catbook.subtitle') }}
                </p>
                
                {{-- Language Filter Controls --}}
                <div class="mt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
                    <div class="inline-flex items-center px-3 py-1 bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 rounded-full text-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path>
                        </svg>
                        <span id="language-indicator">
                            @if(request('all_languages'))
                                {{ __('catbook.all_languages') }}
                            @else
                                {{ __('catbook.showing_language') }}: {{ strtoupper(app()->getLocale()) }}
                            @endif
                        </span>
                    </div>
                    
                    <button 
                        onclick="toggleLanguageFilter()"
                        class="px-3 py-1 text-sm bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-full hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
                    >
                        <span id="toggle-text">
                            @if(request('all_languages'))
                                {{ __('catbook.filter_description') }}
                            @else
                                {{ __('catbook.show_all_languages') }}
                            @endif
                        </span>
                    </button>
                </div>
            </div>

            {{-- Create Post Form --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-3 sm:p-6 mb-4 sm:mb-6">
                <form id="create-post-form" action="{{ route('catbook.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="space-y-4">
                        {{-- User Info & Language Header --}}
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                {{-- User Avatar --}}
                                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </span>
                                </div>
                                {{-- Language indicator --}}
                                <div class="inline-flex items-center px-2 py-1 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400 rounded text-xs font-medium">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                    </svg>
                                    {{ __('catbook.posting_in') }}: {{ strtoupper(app()->getLocale()) }}
                                </div>
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('catbook.post_language_note') }}
                            </div>
                        </div>
                        
                        {{-- Full-width Textarea --}}
                        <textarea 
                            name="content" 
                            placeholder="{{ __('catbook.post_placeholder') }}"
                            class="w-full h-24 p-3 border border-gray-200 dark:border-gray-600 rounded-lg resize-none focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                            maxlength="500"></textarea>
                        
                        {{-- Full-width Controls Row --}}
                        <div class="flex flex-col sm:flex-row gap-3 sm:items-center">
                            {{-- Cat Selection - Full width on mobile --}}
                            <select name="cat_id" class="flex-1 px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                <option value="">{{ __('catbook.select_cat_optional') }}</option>
                                @foreach(auth()->user()->cats as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                @endforeach
                            </select>
                            
                            {{-- Image Upload & Submit Row --}}
                            <div class="flex gap-3">
                                <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    {{ __('catbook.photo') }}
                                    <input type="file" name="image" accept="image/*" class="hidden" id="post-image">
                                </label>
                                
                                <button type="submit" class="px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors">
                                    {{ __('catbook.publish') }}
                                </button>
                            </div>
                        </div>
                        
                        {{-- Image Preview --}}
                        <div id="image-preview" class="hidden">
                            <img src="" alt="Preview" class="max-w-xs rounded-lg shadow-sm">
                            <button type="button" onclick="removeImage()" class="ml-2 text-red-500 hover:text-red-700">
                                {{ __('catbook.remove') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Posts Feed --}}
            <div id="posts-container">
                @include('catbook.partials.posts', compact('posts'))
            </div>

            {{-- Infinite Scroll Loading Indicator --}}
            @if($posts->hasMorePages())
                <div id="infinite-scroll-loading" class="hidden flex justify-center items-center py-8">
                    <div class="flex items-center space-x-3 text-gray-600 dark:text-gray-400">
                        <svg class="animate-spin w-5 h-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm">{{ __('catbook.loading_more_posts') }}</span>
                    </div>
                </div>
                <!-- Invisible trigger for infinite scroll -->
                <div id="infinite-scroll-trigger" data-page="{{ $posts->currentPage() + 1 }}"></div>
            @endif
        </div>
    </div>

    {{-- JavaScript --}}
    <script>
        // Image preview
        document.getElementById('post-image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('image-preview');
                    const img = preview.querySelector('img');
                    img.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });

        function removeImage() {
            document.getElementById('post-image').value = '';
            document.getElementById('image-preview').classList.add('hidden');
        }

        // Create post form submission
        document.getElementById('create-post-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.textContent = '{{ __("catbook.loading") }}';
            submitBtn.disabled = true;
            
            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reset form
                    this.reset();
                    removeImage();
                    
                    // Add new post to feed
                    const postsContainer = document.getElementById('posts-container');
                    postsContainer.insertAdjacentHTML('afterbegin', data.post);
                    
                    // Show success message
                    showNotification('Post pubblicato con successo!', 'success');
                } else {
                    showNotification('Errore nella pubblicazione del post', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Errore nella pubblicazione del post', 'error');
            })
            .finally(() => {
                submitBtn.textContent = originalText;
                submitBtn.disabled = false;
            });
        });

        // Infinite Scroll for posts
        const infiniteScrollTrigger = document.getElementById('infinite-scroll-trigger');
        const infiniteScrollLoading = document.getElementById('infinite-scroll-loading');
        let isLoadingPosts = false;
        
        if (infiniteScrollTrigger) {
            // Create Intersection Observer for infinite scroll
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !isLoadingPosts) {
                        loadMorePosts();
                    }
                });
            }, {
                rootMargin: '100px' // Trigger 100px before the element comes into view
            });
            
            observer.observe(infiniteScrollTrigger);
            
            function loadMorePosts() {
                if (isLoadingPosts) return;
                
                isLoadingPosts = true;
                const page = infiniteScrollTrigger.dataset.page;
                
                // Show loading indicator
                infiniteScrollLoading.classList.remove('hidden');
                
                // Build URL with current filters
                const currentUrl = new URL(window.location);
                currentUrl.searchParams.set('page', page);
                
                fetch(currentUrl.toString(), {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Append new posts
                    document.getElementById('posts-container').insertAdjacentHTML('beforeend', data.posts);
                    
                    // Update trigger or remove if no more pages
                    if (data.hasMore) {
                        infiniteScrollTrigger.dataset.page = parseInt(page) + 1;
                    } else {
                        // No more pages, remove trigger and show completion message
                        observer.unobserve(infiniteScrollTrigger);
                        infiniteScrollTrigger.remove();
                        infiniteScrollLoading.innerHTML = '<div class="text-center text-gray-500 dark:text-gray-400 text-sm py-4">{{ __("catbook.all_posts_loaded") }}</div>';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    infiniteScrollLoading.innerHTML = '<div class="text-center text-red-500 text-sm py-4">Errore nel caricamento</div>';
                })
                .finally(() => {
                    isLoadingPosts = false;
                    infiniteScrollLoading.classList.add('hidden');
                });
            }
        }

        // Language filter toggle
        function toggleLanguageFilter() {
            const currentUrl = new URL(window.location);
            const isShowingAll = currentUrl.searchParams.has('all_languages');
            
            if (isShowingAll) {
                currentUrl.searchParams.delete('all_languages');
            } else {
                currentUrl.searchParams.set('all_languages', '1');
            }
            
            // Reload page with new filter
            window.location.href = currentUrl.toString();
        }

        // Utility function for notifications
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            } text-white`;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            // Remove after 3 seconds
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
</x-main-layout>
