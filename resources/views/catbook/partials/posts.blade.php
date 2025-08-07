{{-- Posts Loop --}}
@forelse($posts as $post)
    @include('catbook.partials.single-post', compact('post'))
@empty
    <div class="text-center py-12">
        <div class="text-gray-400 dark:text-gray-600 mb-4">
            <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 8h10m0 0V6a2 2 0 00-2-2H9a2 2 0 00-2 2v2m10 0v10a2 2 0 01-2 2H9a2 2 0 01-2-2V8m10 0H7"></path>
            </svg>
        </div>
        <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">
            Nessun post ancora
        </h3>
        <p class="text-gray-600 dark:text-gray-400">
            Sii il primo a condividere qualcosa sui tuoi amici felini!
        </p>
    </div>
@endforelse
