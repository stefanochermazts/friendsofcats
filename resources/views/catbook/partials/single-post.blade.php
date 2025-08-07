{{-- Single Post Component --}}
<article class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 mb-6" data-post-id="{{ $post->id }}">
    {{-- Post Header --}}
    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
        <div class="flex items-start space-x-3">
            {{-- User Avatar --}}
            <div class="flex-shrink-0">
                <div class="w-10 h-10 bg-orange-500 rounded-full flex items-center justify-center">
                    <span class="text-white font-semibold text-sm">
                        {{ substr($post->user->name, 0, 1) }}
                    </span>
                </div>
            </div>
            
            {{-- Post Info --}}
            <div class="flex-1 min-w-0">
                <div class="flex items-center space-x-2">
                    <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                        {{ $post->user->name }}
                    </h4>
                    
                    {{-- Post Type Badge --}}
                    @if($post->type === 'adoption_request')
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-200">
                            🏠 Richiesta Adozione
                        </span>
                    @endif
                    
                    {{-- Cat Name --}}
                    @if($post->cat)
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            con {{ $post->cat->nome }}
                        </span>
                    @endif
                </div>
                
                <p class="text-xs text-gray-500 dark:text-gray-400">
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>
            
            {{-- Post Actions Menu --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                    </svg>
                </button>
                
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-700 rounded-md shadow-lg z-10">
                    <div class="py-1">
                        <button onclick="sharePost({{ $post->id }}, 'link')" 
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Copia link
                        </button>
                        <button onclick="sharePost({{ $post->id }}, 'whatsapp')" 
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Condividi su WhatsApp
                        </button>
                        <button onclick="sharePost({{ $post->id }}, 'facebook')" 
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-600">
                            Condividi su Facebook
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Post Content --}}
    <div class="p-4">
        {{-- Text Content --}}
        <div class="text-gray-900 dark:text-white mb-3">
            {!! nl2br(e($post->content)) !!}
        </div>
        
        {{-- Post Image --}}
        @if($post->image)
            <div class="mb-3">
                <img src="{{ Storage::url($post->image) }}" 
                     alt="Post image" 
                     class="w-full max-w-md rounded-lg shadow-sm">
            </div>
        @endif
        
        {{-- Hashtags --}}
        @if($post->hashtags && count($post->hashtags) > 0)
            <div class="flex flex-wrap gap-2 mb-3">
                @foreach($post->hashtags as $hashtag)
                    <a href="{{ route('catbook.hashtag', $hashtag) }}" 
                       class="text-orange-500 hover:text-orange-600 text-sm font-medium">
                        #{{ $hashtag }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
    
    {{-- Post Stats & Actions --}}
    <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-700">
        {{-- Stats --}}
        <div class="flex items-center justify-between text-sm text-gray-500 dark:text-gray-400 mb-3">
            <span>{{ $post->likes_count }} mi piace</span>
            <div class="flex space-x-4">
                <span>{{ $post->comments_count }} commenti</span>
                <span>{{ $post->shares_count }} condivisioni</span>
            </div>
        </div>
        
        {{-- Action Buttons --}}
        <div class="flex items-center justify-between border-t border-gray-100 dark:border-gray-700 pt-3">
            <div class="flex space-x-4">
                {{-- Like Button --}}
                <button onclick="toggleLike({{ $post->id }})" 
                        class="like-btn flex items-center space-x-2 px-3 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors {{ $post->isLikedBy(auth()->id()) ? 'text-red-500' : '' }}">
                    <svg class="w-5 h-5" fill="{{ $post->isLikedBy(auth()->id()) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                    <span>Mi piace</span>
                </button>
                
                {{-- Comment Button --}}
                <button onclick="toggleComments({{ $post->id }})" 
                        class="flex items-center space-x-2 px-3 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <span>Commenta</span>
                </button>
                
                {{-- Share Button --}}
                <button onclick="sharePost({{ $post->id }}, 'link')" 
                        class="flex items-center space-x-2 px-3 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-lg transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                    <span>Condividi</span>
                </button>
            </div>
        </div>
    </div>
    
    {{-- Comments Section --}}
    <div id="comments-section-{{ $post->id }}" class="hidden border-t border-gray-100 dark:border-gray-700">
        {{-- Add Comment Form --}}
        <div class="p-4 border-b border-gray-100 dark:border-gray-700">
            <form onsubmit="addComment(event, {{ $post->id }})" class="flex space-x-3">
                <div class="flex-shrink-0">
                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center">
                        <span class="text-white font-semibold text-xs">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </span>
                    </div>
                </div>
                <div class="flex-1">
                    <textarea name="content" 
                              placeholder="Scrivi un commento..." 
                              class="w-full p-2 border border-gray-200 dark:border-gray-600 rounded-lg resize-none dark:bg-gray-700 dark:text-white"
                              rows="2" maxlength="300"></textarea>
                    <div class="flex justify-end mt-2">
                        <button type="submit" 
                                class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white text-sm rounded-lg transition-colors">
                            Commenta
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        {{-- Comments List --}}
        <div id="comments-list-{{ $post->id }}" class="max-h-96 overflow-y-auto">
            {{-- Comments will be loaded here --}}
        </div>
    </div>
</article>

<script>
// Like functionality
function toggleLike(postId) {
    const button = document.querySelector(`[data-post-id="${postId}"] .like-btn`);
    const svg = button.querySelector('svg');
    const originalText = button.querySelector('span').textContent;
    
    fetch(`/catbook/posts/${postId}/like`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update like button appearance
            if (data.liked) {
                button.classList.add('text-red-500');
                svg.setAttribute('fill', 'currentColor');
            } else {
                button.classList.remove('text-red-500');
                svg.setAttribute('fill', 'none');
            }
            
            // Update likes count
            const statsElement = document.querySelector(`[data-post-id="${postId}"] .flex.items-center.justify-between.text-sm span:first-child`);
            statsElement.textContent = `${data.likes_count} mi piace`;
        }
    })
    .catch(error => console.error('Error:', error));
}

// Comments functionality
function toggleComments(postId) {
    const commentsSection = document.getElementById(`comments-section-${postId}`);
    const commentsList = document.getElementById(`comments-list-${postId}`);
    
    if (commentsSection.classList.contains('hidden')) {
        commentsSection.classList.remove('hidden');
        
        // Load comments if not already loaded
        if (commentsList.children.length === 0) {
            loadComments(postId);
        }
    } else {
        commentsSection.classList.add('hidden');
    }
}

function loadComments(postId) {
    fetch(`/catbook/posts/${postId}/comments`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById(`comments-list-${postId}`).innerHTML = data.comments;
    })
    .catch(error => console.error('Error:', error));
}

function addComment(event, postId) {
    event.preventDefault();
    
    const form = event.target;
    const formData = new FormData(form);
    const submitBtn = form.querySelector('button[type="submit"]');
    const originalText = submitBtn.textContent;
    
    submitBtn.textContent = 'Inviando...';
    submitBtn.disabled = true;
    
    fetch(`/catbook/posts/${postId}/comments`, {
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
            // Add new comment to list
            const commentsList = document.getElementById(`comments-list-${postId}`);
            commentsList.insertAdjacentHTML('beforeend', data.comment);
            
            // Reset form
            form.reset();
            
            // Update comments count
            const statsElement = document.querySelector(`[data-post-id="${postId}"] .flex.space-x-4 span:first-child`);
            statsElement.textContent = `${data.comments_count} commenti`;
            
            // Scroll to new comment
            commentsList.scrollTop = commentsList.scrollHeight;
        }
    })
    .catch(error => console.error('Error:', error))
    .finally(() => {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
    });
}

// Share functionality
function sharePost(postId, platform) {
    fetch(`/catbook/posts/${postId}/share`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({ platform: platform })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (platform === 'link') {
                // Copy to clipboard
                navigator.clipboard.writeText(data.share_url).then(() => {
                    showNotification('Link copiato negli appunti!', 'success');
                });
            } else {
                // Open external share
                window.open(data.share_url, '_blank');
            }
            
            // Update shares count
            const statsElement = document.querySelector(`[data-post-id="${postId}"] .flex.space-x-4 span:last-child`);
            statsElement.textContent = `${data.shares_count} condivisioni`;
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
