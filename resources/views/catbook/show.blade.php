<x-main-layout>
    {{-- Open Graph Meta Tags --}}
    <x-slot name="meta">
        <meta property="og:title" content="Post di {{ $post->user->name }} su FriendsOfCats" />
        <meta property="og:description" content="{{ Str::limit(strip_tags($post->content), 200) }}" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{ route('catbook.post', $post->id) }}" />
        @if($post->image)
            <meta property="og:image" content="{{ Storage::url($post->image) }}" />
            <meta property="og:image:width" content="1200" />
            <meta property="og:image:height" content="630" />
        @endif
        <meta property="og:site_name" content="FriendsOfCats" />
        
        {{-- Twitter Card --}}
        <meta name="twitter:card" content="summary_large_image" />
        <meta name="twitter:title" content="Post di {{ $post->user->name }} su FriendsOfCats" />
        <meta name="twitter:description" content="{{ Str::limit(strip_tags($post->content), 200) }}" />
        @if($post->image)
            <meta name="twitter:image" content="{{ Storage::url($post->image) }}" />
        @endif
        {{-- SEO standard --}}
        <meta name="description" content="{{ Str::limit(strip_tags($post->content), 160) }}">
        <meta name="keywords" content="{{ __('seo.global_keywords') }}">
    </x-slot>

    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Back Button --}}
            <div class="mb-6">
                <a href="{{ route('catbook.index') }}" 
                   class="inline-flex items-center text-orange-500 hover:text-orange-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Torna al CatBook
                </a>
            </div>

            {{-- Single Post --}}
            @include('catbook.partials.single-post', compact('post'))

            {{-- Call to Action --}}
            <div class="bg-orange-50 dark:bg-orange-900/20 rounded-lg p-6 text-center">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                    Ti piace questo post?
                </h2>
                <p class="text-gray-600 dark:text-gray-400 mb-4">
                    Unisciti alla community di FriendsOfCats e condividi le tue storie sui gatti!
                </p>
                @guest
                    <div class="space-x-4">
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors">
                            Registrati ora
                        </a>
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center px-6 py-3 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                            Accedi
                        </a>
                    </div>
                @else
                    <a href="{{ route('catbook.index') }}" 
                       class="inline-flex items-center px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white font-medium rounded-lg transition-colors">
                        Vai al CatBook
                    </a>
                @endguest
            </div>
        </div>
    </div>
</x-main-layout>
