<x-main-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                    🐾 CatBook
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Il social network degli amici dei gatti
                </p>
            </div>

            {{-- Create Post Form --}}
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 mb-6">
                <form id="create-post-form" action="{{ route('catbook.posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex space-x-4">
                        {{-- User Avatar --}}
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                                <span class="text-white font-semibold text-sm">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </span>
                            </div>
                        </div>
                        
                        {{-- Post Content --}}
                        <div class="flex-1 space-y-4">
                            <textarea 
                                name="content" 
                                placeholder="Condividi qualcosa sui tuoi gatti... #Adozione #Gatti #Amore"
                                class="w-full h-24 p-3 border border-gray-200 dark:border-gray-600 rounded-lg resize-none focus:ring-2 focus:ring-orange-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                                maxlength="500"></textarea>
                            
                            {{-- Cat Selection & Image Upload --}}
                            <div class="flex flex-wrap items-center gap-4">
                                {{-- Cat Selection --}}
                                <select name="cat_id" class="px-3 py-2 border border-gray-200 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white">
                                    <option value="">Seleziona un gatto (opzionale)</option>
                                    @foreach(auth()->user()->cats as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
                                    @endforeach
                                </select>
                                
                                {{-- Image Upload --}}
                                <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-500 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Foto
                                    <input type="file" name="image" accept="image/*" class="hidden" id="post-image">
                                </label>
                                
                                {{-- Submit Button --}}
                                <button type="submit" class="ml-auto px-6 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg font-medium transition-colors">
                                    Pubblica
                                </button>
                            </div>
                            
                            {{-- Image Preview --}}
                            <div id="image-preview" class="hidden">
                                <img src="" alt="Preview" class="max-w-xs rounded-lg shadow-sm">
                                <button type="button" onclick="removeImage()" class="ml-2 text-red-500 hover:text-red-700">
                                    Rimuovi
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Posts Feed --}}
            <div id="posts-container">
                @include('catbook.partials.posts', compact('posts'))
            </div>

            {{-- Load More Button --}}
            @if($posts->hasMorePages())
                <div class="text-center mt-8">
                    <button 
                        id="load-more-btn" 
                        data-page="{{ $posts->currentPage() + 1 }}"
                        class="px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Carica altri post
                    </button>
                </div>
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
            
            submitBtn.textContent = 'Pubblicando...';
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

        // Load more posts
        document.addEventListener('click', function(e) {
            if (e.target.id === 'load-more-btn') {
                e.preventDefault();
                
                const btn = e.target;
                const page = btn.dataset.page;
                const originalText = btn.textContent;
                
                btn.textContent = 'Caricando...';
                btn.disabled = true;
                
                fetch(`/catbook?page=${page}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Append new posts
                    document.getElementById('posts-container').insertAdjacentHTML('beforeend', data.posts);
                    
                    // Update or remove load more button
                    if (data.hasMore) {
                        btn.dataset.page = parseInt(page) + 1;
                        btn.textContent = originalText;
                        btn.disabled = false;
                    } else {
                        btn.remove();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    btn.textContent = originalText;
                    btn.disabled = false;
                });
            }
        });

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
