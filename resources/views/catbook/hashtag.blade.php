<x-main-layout>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">
                    #{{ $hashtag }}
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Tutti i post con questo hashtag
                </p>
                
                {{-- Back to CatBook --}}
                <div class="mt-4">
                    <a href="{{ route('catbook.index') }}" 
                       class="inline-flex items-center text-orange-500 hover:text-orange-600 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Torna al CatBook
                    </a>
                </div>
            </div>

            {{-- Posts Feed --}}
            <div id="posts-container">
                @include('catbook.partials.posts', compact('posts'))
            </div>

            {{-- Load More Button --}}
            @if($posts->hasMorePages())
                <div class="text-center mt-8">
                    <a href="{{ $posts->nextPageUrl() }}" 
                       class="px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        Carica altri post
                    </a>
                </div>
            @endif
        </div>
    </div>
</x-main-layout>
